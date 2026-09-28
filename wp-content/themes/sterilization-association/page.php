<?php

if (!defined('ABSPATH')) {
    exit;
}

global $post;
$page_slug = $post->post_name; 
$template_path = 'pages/page-' . $page_slug;

if (locate_template($template_path . '.php')) {
    get_template_part('pages/page', $page_slug);
} else {
    get_header();
    get_template_part('pages/page', 'default');
    get_footer();
}