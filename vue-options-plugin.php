<?php

/**
 * Plugin Name: Vue Options Plugin
 * Description: Vue-powered WP settings page
 * Version: 1.0
 * Author: You
 */

if (!defined('ABSPATH')) exit;

add_action('admin_menu', function () {
    add_menu_page(
        'Vue Options',
        'Vue Options',
        'manage_options',
        'vue-options',
        function () {
            echo '<div id="vue-options-app"></div>';
        },
        'dashicons-admin-generic',
        65
    );
});

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'toplevel_page_vue-options') return;

    $url = plugin_dir_url(__FILE__) . 'dist/';
    wp_enqueue_script('vue-options-js', $url . 'app.js', [], null, true);
    wp_enqueue_style('vue-options-css', $url . 'style.css');

    // Pass ajax URL and nonce to Vue app
    wp_localize_script('vue-options-js', 'VueOptionsData', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('vue_options_nonce')
    ]);
});


// Register AJAX endpoint for getting settings
add_action('wp_ajax_get_vue_options', function () {
    check_ajax_referer('vue_options_nonce');

    $settings = get_option('vue_options_settings', []);
    wp_send_json_success($settings);
});

// Register AJAX endpoint for saving settings
add_action('wp_ajax_save_vue_options', function () {
    check_ajax_referer('vue_options_nonce');

    $data = json_decode(file_get_contents('php://input'), true);

    if (!is_array($data)) {
        wp_send_json_error(['message' => 'Invalid data']);
    }

    update_option('vue_options_settings', $data);
    wp_send_json_success(['message' => 'Settings saved']);
});

//Set Defaults upon activation
// register_activation_hook(__FILE__, function () {
//     if (get_option('vue_options_settings') === false) {
//         add_option('vue_options_settings', ['example' => 'default value']);
//     }
// });
