<?php
if (!defined('ABSPATH')) exit;

/**
 * Save settings via AJAX
 */
add_action('wp_ajax_' . WP_PLUGIN_PREFIX . 'save_settings', function () {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], WP_PLUGIN_PREFIX . 'nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    // Get submitted settings
    $data = $_POST['settings'] ?? [];
    $data = is_array($data) ? $data : [];

    // Sanitize and save
    wp_update_settings($data);

    wp_send_json_success(['settings' => wp_get_settings()]);
});

/**
 * Get settings via AJAX
 */
add_action('wp_ajax_' . WP_PLUGIN_PREFIX . 'get_settings', function () {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], WP_PLUGIN_PREFIX . 'nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    wp_send_json_success(['settings' => wp_get_settings()]);
});
