<?php
function handle_consult_form_submission() {    
    check_ajax_referer('consult_form_nonce_action', 'nonce');    
    $full_name    = isset($_POST['full_name']) ? sanitize_text_field($_POST['full_name']) : '';
    $email        = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $message      = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $phone_prefix = isset($_POST['phone_prefix']) ? sanitize_text_field($_POST['phone_prefix']) : '';
    $phone_number = isset($_POST['phone_number']) ? sanitize_text_field($_POST['phone_number']) : '';
    $organization = isset($_POST['organization']) ? sanitize_text_field($_POST['organization']) : '';
    $position     = isset($_POST['position']) ? sanitize_text_field($_POST['position']) : '';
    $privacy      = isset($_POST['privacy_agreement']) && $_POST['privacy_agreement'] === '1';    
    if ( empty($full_name) || empty($email) || empty($phone_number) || empty($message) || !$privacy ) {
        wp_send_json_error('Будь ласка, заповніть усі обов\'язкові поля та прийміть політику конфіденційності.');
    }
    if ( ! is_email($email) ) {
        wp_send_json_error('Будь ласка, введіть дійсний email.');
    }
    $full_phone = trim($phone_prefix . ' ' . $phone_number);    
    $post_data = array(
        'post_title'   => wp_strip_all_tags($full_name),
        'post_content' => $message,
        'post_status'  => 'private', 
        'post_type'    => 'messages',
    );
    $post_id = wp_insert_post($post_data);
    if ( $post_id && ! is_wp_error($post_id) ) {
        update_post_meta($post_id, 'email', $email);
        update_post_meta($post_id, 'organization', $organization);
        update_post_meta($post_id, 'position', $position);
        update_post_meta($post_id, 'phone_number', $full_phone);
        update_post_meta($post_id, 'privacy_agreement', 'Погоджено');        
        $admin_email = get_option('admin_email');
        $subject     = 'Нова заявка на консультацію: ' . $full_name;
        $body        = "П.І.Б: $full_name\nEmail: $email\nОрганізація: $organization\nПосада: $position\nТелефон: $full_phone\n\nПовідомлення:\n$message";
        wp_mail($admin_email, $subject, $body);
        wp_send_json_success('Дякуємо! Вашу заявку успішно прийнято.');
    } else {
        wp_send_json_error('Сталася помилка при збереженні. Спробуйте ще раз.');
    }
}
add_action('wp_ajax_send_consult_form', 'handle_consult_form_submission');
add_action('wp_ajax_nopriv_send_consult_form', 'handle_consult_form_submission');