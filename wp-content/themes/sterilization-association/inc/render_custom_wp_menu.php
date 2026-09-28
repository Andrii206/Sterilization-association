<?php

function render_custom_wp_menu($menu_id)
{

    $menu_items = wp_get_nav_menu_items($menu_id);

    if (!$menu_items) {
        return;
    }


    $menu_tree = array();
    foreach ($menu_items as $item) {
        $menu_tree[$item->menu_item_parent][] = $item;
    }



    $render_level = function ($parent_id) use (&$render_level, &$menu_tree) {

        if (empty($menu_tree[$parent_id])) return;

        foreach ($menu_tree[$parent_id] as $item) {

            $has_children = isset($menu_tree[$item->ID]);

            if ($has_children) {

                echo '<div class="custom-dropdown">';
                echo '<a href="' . esc_url($item->url) . '" class="dropdown-trigger">';
                echo esc_html($item->title);
                echo ' <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" /></svg>';
                echo '</a>';

                echo '<div class="dropdown-menu">';

                $render_level($item->ID);
                echo '</div>';
                echo '</div>';
            } else {

                echo '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
            }
        }
    };


    $render_level(0);
}
