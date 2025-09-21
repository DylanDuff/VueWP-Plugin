<?php
if (!defined('ABSPATH')) exit;

/**
 * Get the option name with prefix
 */
function wp_get_option_name($key)
{
    return WP_PLUGIN_PREFIX . $key;
}

/**
 * Load schema from settings.json
 */
function wp_load_schema()
{
    $schema_file = plugin_dir_path(__DIR__) . 'settings.json';
    return json_decode(file_get_contents($schema_file), true);
}

/**
 * Get default settings from schema merged with saved values
 */
function wp_get_settings()
{
    $schema = wp_load_schema();
    $saved  = get_option(wp_get_option_name('settings'), []);
    $settings = [];

    foreach ($schema as $key => $def) {
        $settings[$key] = $saved[$key] ?? $def['default'];
    }

    return $settings;
}

/**
 * Sanitize settings data based on schema
 */
function wp_sanitize_settings($data)
{
    $schema = wp_load_schema();
    $clean  = [];

    foreach ($schema as $key => $def) {
        $val = $data[$key] ?? $def['default'];
        switch ($def['type']) {
            case 'boolean':
                $clean[$key] = !empty($val);
                break;
            case 'integer':
                $clean[$key] = intval($val);
                break;
            case 'array':
                $clean[$key] = is_array($val) ? array_values($val) : [];
                break;
            case 'string':
            default:
                $clean[$key] = sanitize_text_field($val);
                break;
        }
    }

    return $clean;
}

/**
 * Update settings
 */
function wp_update_settings($data)
{
    $clean = wp_sanitize_settings($data);
    update_option(wp_get_option_name('settings'), $clean);
}

/**
 * Get single setting
 */
function wp_get_setting($key, $default = null)
{
    $settings = wp_get_settings();
    return $settings[$key] ?? $default;
}
