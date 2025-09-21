<?php

/**
 * Plugin Name: WP Plugin Boilerplate
 * Description: A boilerplate plugin with VueJS and dynamic settings.json schema
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) exit;


// Default plugin prefix

// Load prefix from settings.json
$schema_file = plugin_dir_path(__FILE__) . 'settings.json';
$schema = json_decode(file_get_contents($schema_file), true);
$prefix = isset($schema['prefix']['default']) ? $schema['prefix']['default'] : 'wpst_';
if (!defined('WP_PLUGIN_PREFIX')) {
    define('WP_PLUGIN_PREFIX', $prefix);
}

require_once plugin_dir_path(__FILE__) . 'inc/settings.php';
require_once plugin_dir_path(__FILE__) . 'inc/ajax.php';

// Register admin menu
add_action('admin_menu', function () {
    add_menu_page(
        'Plugin Boilerplate',
        'Plugin Boilerplate',
        'manage_options',
        'wp-plugin-boilerplate',
        function () {
            echo '<div id="wp-plugin-boilerplate"></div>';
        },
        'dashicons-admin-generic',
        65
    );
});

// Enqueue Vue app
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'toplevel_page_wp-plugin-boilerplate') return;

    wp_enqueue_script(
        'wp-plugin-boilerplate-js',
        plugin_dir_url(__FILE__) . 'assets/js/main.js',
        [],
        '1.0',
        true
    );

    wp_localize_script('wp-plugin-boilerplate-js', 'VueOptionsData', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce(WP_PLUGIN_PREFIX . 'nonce'),
        'settings' => wp_get_settings(),
    ]);
});

// Set defaults on activation
register_activation_hook(__FILE__, function () {
    if (get_option(wp_get_option_name('settings')) === false) {
        update_option(wp_get_option_name('settings'), wp_get_settings());
    }
});

// Load all features dynamically
$features_dir = plugin_dir_path(__FILE__) . 'inc/features/';
foreach (glob($features_dir . '*.php') as $feature_file) {
    require_once $feature_file;
}
