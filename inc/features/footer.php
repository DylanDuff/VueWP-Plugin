<?php
if (!defined('ABSPATH')) exit;

function wp_feature_footer_init()
{
    $settings = wp_get_settings();

    if (!empty($settings['custom_footer_enabled'])) {
        add_filter('update_footer', 'wp_feature_footer_text', 10, 2);
    }
}

function wp_feature_footer_text($text, $footer_type)
{
    $settings = wp_get_settings();
    return $settings['custom_footer_text'] ?? $text;
}

add_action('admin_init', 'wp_feature_footer_init');
