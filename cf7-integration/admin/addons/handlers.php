<?php
/**
 * Handle addon activation and deactivation
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/admin/addons
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

// Add actions for handling addon activation and deactivation
add_action('admin_post_cf7_integration_activate_addon', 'handle_addon_activation_from_admin_post');
add_action('admin_post_cf7_integration_deactivate_addon', 'handle_addon_deactivation_from_admin_post');

function handle_addon_activation_from_admin_post() {
    if (isset($_POST['addon']) && wp_verify_nonce($_POST['_wpnonce'], 'cf7_integration_activate_addon_' . $_POST['addon'])) {
        // Load the addon manager class
        if (!class_exists('CF7_Addon_Manager')) {
            require_once plugin_dir_path(__FILE__) . 'class-addon-manager.php';
        }
        CF7_Addon_Manager::activate_addon(sanitize_text_field($_POST['addon']));
        wp_redirect(admin_url('admin.php?page=cf7-integration&activated=true'));
        exit;
    }
}

function handle_addon_deactivation_from_admin_post() {
    if (isset($_POST['addon']) && wp_verify_nonce($_POST['_wpnonce'], 'cf7_integration_deactivate_addon_' . $_POST['addon'])) {
        // Load the addon manager class
        if (!class_exists('CF7_Addon_Manager')) {
            require_once plugin_dir_path(__FILE__) . 'class-addon-manager.php';
        }
        CF7_Addon_Manager::deactivate_addon(sanitize_text_field($_POST['addon']));
        wp_redirect(admin_url('admin.php?page=cf7-integration&deactivated=true'));
        exit;
    }
}

// For handling addon activation and deactivation from external plugins
function cf7_integration_register_external_addon($addon_name, $addon_info) {
    // This function can be used by external plugins to register their addons
    add_filter('cf7_integration_external_addons', function($addons) use ($addon_name, $addon_info) {
        $addons[$addon_name] = $addon_info;
        return $addons;
    });
}