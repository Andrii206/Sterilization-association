<?php

function register_messages_post_type() {
    $labels = array(
        'name'               => 'Заявки',
        'singular_name'      => 'Заявка',
        'menu_name'          => 'Заявки з форми',
        'add_new'            => 'Додати нову',
        'add_new_item'       => 'Додати нову заявку',
        'edit_item'          => 'Редагувати заявку',
        'new_item'           => 'Нова заявка',
        'view_item'          => 'Переглянути',
        'search_items'       => 'Шукати заявки',
        'not_found'          => 'Заявок не знайдено',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false, 
        'show_ui'            => true,  
        'has_archive'        => false,
        'menu_icon'          => 'dashicons-email-alt', 
        'supports'           => array('title', 'editor'), 
    );

    register_post_type('messages', $args);
}
add_action('init', 'register_messages_post_type');

function add_messages_fields_metabox() {
    add_meta_box(
        'messages_details_box',         
        'Контактні дані заявника',      
        'render_messages_fields_box',   
        'messages',                     
        'normal',                       
        'high'                          
    );
}
add_action('add_meta_boxes', 'add_messages_fields_metabox');

function render_messages_fields_box($post) {
    $email             = get_post_meta($post->ID, 'email', true);
    $organization      = get_post_meta($post->ID, 'organization', true);
    $position          = get_post_meta($post->ID, 'position', true);
    $phone_number      = get_post_meta($post->ID, 'phone_number', true);    
    $privacy_agreement = get_post_meta($post->ID, 'privacy_agreement', true);

    ?>
    <style>
        .msg-meta-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .msg-meta-table th, .msg-meta-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .msg-meta-table th { width: 25%; font-weight: 600; color: #1e293b; background: #f8fafc; }
        .msg-meta-table td { color: #334155; font-size: 14px; }
        .msg-meta-value-empty { color: #94a3b8; font-style: italic; }
        
        .status-badge-success { 
            display: inline-block; 
            padding: 4px 10px; 
            background-color: #dcfce7; 
            color: #15803d; 
            border-radius: 4px; 
            font-weight: 600; 
            font-size: 12px;
            border: 1px solid #bbf7d0;
        }
    </style>

    <table class="msg-meta-table">
        <tr>
            <th>Електронна адреса:</th>
            <td>
                <?php if (!empty($email)) : ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                <?php else : ?>
                    <span class="msg-meta-value-empty">не вказано</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Номер телефону:</th>
            <td>
                <?php if (!empty($phone_number)) : ?>
                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone_number)); ?>">
                        <?php echo esc_html($phone_number); ?>
                    </a>
                <?php else : ?>
                    <span class="msg-meta-value-empty">не вказано</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th>Організація:</th>
            <td><?php echo !empty($organization) ? esc_html($organization) : '<span class="msg-meta-value-empty">не вказано</span>'; ?></td>
        </tr>
        <tr>
            <th>Посада:</th>
            <td><?php echo !empty($position) ? esc_html($position) : '<span class="msg-meta-value-empty">не вказано</span>'; ?></td>
        </tr>
        <tr>
            <th>Умови використання:</th>
            <td>
                <?php if ($privacy_agreement === 'Погоджено') : ?>
                    <span class="status-badge-success">✓ Підтверджено користувачем</span>
                <?php else : ?>
                    <span class="msg-meta-value-empty">дані відсутні (стара заявка)</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <?php
}



