<?php

function sterilization_association_connections()
{
    wp_enqueue_style('main_css', get_template_directory_uri() . '/assets/css/main.css');
    wp_enqueue_script('translate-js', get_template_directory_uri() . '/assets/js/translate.js', [], '1.0.0', true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', [], '1.0.0', true);
    wp_enqueue_script('contact_form-js', get_template_directory_uri() . '/assets/js/contact_form.js', [], '1.0.0', true);
    wp_localize_script('contact_form-js', 'wpStaticData', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('consult_form_nonce_action'),
    ));
    wp_localize_script('main-js', 'auth_data', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('auth_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'sterilization_association_connections');
