<?php 

require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/auth.php';
require_once get_template_directory() . '/inc/render_custom_wp_menu.php';
require_once get_template_directory() . '/inc/messages/sending_message.php';
require_once get_template_directory() . '/inc/messages/messages_post_type.php';

function my_custom_theme_menus() {
    register_nav_menus( array(
        'primary' => 'Головне меню (Header)',
        'footer'  => 'Меню у підвалі (Footer)'
    ) );
}
add_action( 'after_setup_theme', 'my_custom_theme_menus' );

function block_wp_admin_for_non_admins() {

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }


    if ( is_admin() ) {
    
        if ( ! current_user_can( 'manage_options' ) ) {
        
            wp_redirect( home_url() );
            exit;
        }
    }
}
add_action( 'admin_init', 'block_wp_admin_for_non_admins' );

function hide_admin_bar_for_non_admins( $show ) {    
    if ( ! current_user_can( 'manage_options' ) ) {
        return false; 
    }
    return $show; 
}
add_filter( 'show_admin_bar', 'hide_admin_bar_for_non_admins' );