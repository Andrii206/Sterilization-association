<?php

if (!defined('ABSPATH')) {
    exit;
}
function handle_custom_ajax_login() {
    
    check_ajax_referer('auth_nonce', 'security');

    $login_input = isset($_POST['log_username']) ? sanitize_text_field(trim($_POST['log_username'])) : '';
    $password    = isset($_POST['log_password']) ? (string) $_POST['log_password'] : '';

    if (empty($login_input) || empty($password)) {
        wp_send_json_error('Будь ласка, заповніть усі поля.');
    }

    
    $user = wp_authenticate($login_input, $password);

    
    if (is_wp_error($user)) {
        wp_send_json_error('Невірний логін або пароль.');
    }

    
    $status = get_user_meta($user->ID, 'account_status', true);
    if ($status === 'pending') {
        wp_send_json_error('Ваш email ще не підтверджено. Перевірте поштову скриньку.');
    }

    
    wp_set_current_user($user->ID, $user->user_login);
    wp_set_auth_cookie($user->ID, true);
    do_action('wp_login', $user->user_login, $user);

    wp_send_json_success('Успішний вхід! Перенаправлення...');
}
add_action('wp_ajax_custom_login', 'handle_custom_ajax_login');
add_action('wp_ajax_nopriv_custom_login', 'handle_custom_ajax_login');






function handle_custom_ajax_register() {
    
    check_ajax_referer('auth_nonce', 'security');

    $email            = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $password         = isset($_POST['reg_password']) ? (string) $_POST['reg_password'] : '';
    $password_confirm = isset($_POST['reg_password_confirm']) ? (string) $_POST['reg_password_confirm'] : '';
    $full_name        = isset($_POST['full_name']) ? sanitize_text_field(trim($_POST['full_name'])) : '';
    $organization     = isset($_POST['organization']) ? sanitize_text_field(trim($_POST['organization'])) : '';
    $position         = isset($_POST['position']) ? sanitize_text_field(trim($_POST['position'])) : '';
    $phone_prefix     = isset($_POST['phone_prefix']) ? sanitize_text_field(trim($_POST['phone_prefix'])) : '';
    $phone_number     = isset($_POST['phone_number']) ? sanitize_text_field(trim($_POST['phone_number'])) : '';

    if (empty($email) || empty($password) || empty($full_name)) {
        wp_send_json_error('Заповніть обов\'язкові поля.');
    }

    if (!is_email($email)) {
        wp_send_json_error('Вкажіть коректну адресу електронної пошти.');
    }

    if (strlen($password) < 8) {
        wp_send_json_error('Пароль має містити щонайменше 8 символів.');
    }

    if ($password !== $password_confirm) {
        wp_send_json_error('Паролі не збігаються.');
    }

    if (email_exists($email)) {
        wp_send_json_error('Ця електронна адреса вже використовується.');
    }

    
    $username_base = sanitize_user(current(explode('@', $email)), true);
    $username      = empty($username_base) ? 'user_' . wp_generate_password(6, false) : $username_base;

    if (username_exists($username)) {
        $username .= '_' . wp_rand(100, 9999);
    }

    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error('Не вдалося створити обліковий запис. Спробуйте пізніше.');
    }

    
    wp_update_user([
        'ID'           => $user_id,
        'display_name' => $full_name,
    ]);

    update_user_meta($user_id, 'first_name', $full_name);
    update_user_meta($user_id, 'organization', $organization);
    update_user_meta($user_id, 'position', $position);
    update_user_meta($user_id, 'phone_number', trim($phone_prefix . ' ' . $phone_number));

    
    $raw_token   = bin2hex(random_bytes(32));
    $hashed_token = hash('sha256', $raw_token);
    $expires_at   = time() + 86400; 

    update_user_meta($user_id, 'account_status', 'pending');
    update_user_meta($user_id, 'activation_key_hash', $hashed_token);
    update_user_meta($user_id, 'activation_key_expires', $expires_at);

    
    $activation_url = add_query_arg([
        'action' => 'verify_email',
        'key'    => $raw_token,
        'uid'    => $user_id,
    ], home_url('/'));

    $site_name = get_bloginfo('name');
    $subject   = sprintf('Підтвердження реєстрації — %s', $site_name);
    $message   = "Вітаємо, {$full_name}!\n\n"
               . "Будь ласка, підтвердіть ваш Email за посиланням:\n"
               . "{$activation_url}\n\n"
               . "Посилання дійсне протягом 24 годин. Після підтвердження ви зможете увійти в кабінет.";

    wp_mail($email, $subject, $message);

    wp_send_json_success('Реєстрація успішна! На вашу пошту надіслано лист для активації.');
}
add_action('wp_ajax_custom_register', 'handle_custom_ajax_register');
add_action('wp_ajax_nopriv_custom_register', 'handle_custom_ajax_register');






function check_email_verification() {
    if (
        isset($_GET['action']) && $_GET['action'] === 'verify_email' &&
        isset($_GET['key']) && isset($_GET['uid'])
    ) {
        $user_id   = (int) $_GET['uid'];
        $raw_key   = sanitize_text_field($_GET['key']);

        $saved_hash = get_user_meta($user_id, 'activation_key_hash', true);
        $expires_at = (int) get_user_meta($user_id, 'activation_key_expires', true);
        $status     = get_user_meta($user_id, 'account_status', true);

        
        $is_token_valid = !empty($saved_hash) && hash_equals($saved_hash, hash('sha256', $raw_key));
        $is_not_expired = $expires_at > time();

        if ($status === 'pending' && $is_token_valid && $is_not_expired) {
            $user = get_user_by('id', $user_id);

            if (!$user) {
                wp_die('Користувача не знайдено в системі.', 'Помилка', ['response' => 404]);
            }

            
            update_user_meta($user_id, 'account_status', 'active');
            delete_user_meta($user_id, 'activation_key_hash');
            delete_user_meta($user_id, 'activation_key_expires');

            
            wp_clear_auth_cookie();                             
            wp_set_current_user($user_id, $user->user_login);   
            wp_set_auth_cookie($user_id, true);                 
            do_action('wp_login', $user->user_login, $user);    

            
            $redirect_url = add_query_arg('verified', 'success', home_url('/'));
            
            

            wp_safe_redirect($redirect_url);
            exit;
        }

        wp_die(
            'Помилка активації: недійсне чи застаріле посилання, або акаунт уже було активовано раніше.',
            'Помилка активації',
            ['response' => 403]
        );
    }
}
add_action('init', 'check_email_verification');
