<?php
/**
 * Admin functionality for addon management
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/admin/addons
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Addon management functionality
 */
function cf7_integration_addon_management() {
    // Register settings for addons
    register_setting('cf7_integration_settings_group', 'cf7_integration_active_addons');
    
    // Add addon management section
    add_settings_section(
        'cf7_integration_addon_management',
        __('Addon Management', 'cf7-integration'),
        null,
        'cf7-integration'
    );
    
    // Add addon management field
    add_settings_field(
        'cf7_integration_active_addons',
        __('Active Addons', 'cf7-integration'),
        'cf7_integration_render_addon_management_field',
        'cf7-integration',
        'cf7_integration_addon_management'
    );
}

add_action('admin_init', 'cf7_integration_addon_management');

/**
 * Render addon management field
 *
 * @since    1.0.0
 */
function cf7_integration_render_addon_management_field() {
    $active_addons = get_option('cf7_integration_active_addons', array());
    $available_addons = CF7_Addon_Manager::get_available_addons();
    
    echo '<div class="cf7-addon-management">';
    
    foreach ($available_addons as $addon_name => $addon_info) {
        $is_active = in_array($addon_name, $active_addons);
        $status_text = $is_active ? __('Active', 'cf7-integration') : __('Inactive', 'cf7-integration');
        $status_class = $is_active ? 'active' : 'inactive';
        $source_text = $addon_info['source'] === 'external_plugin' ? __('External Plugin', 'cf7-integration') : __('Main Plugin', 'cf7-integration');
        
        echo '<div class="cf7-addon-item">';
        echo '<div class="cf7-addon-header">';
        echo '<span class="cf7-addon-name">' . esc_html($addon_info['name']) . '</span>';
        echo '<span class="cf7-addon-source">(' . esc_html($source_text) . ')</span>';
        echo '<span class="cf7-addon-status ' . esc_attr($status_class) . '">' . esc_html($status_text) . '</span>';
        echo '</div>';
        
        echo '<div class="cf7-addon-actions">';
        if ($is_active) {
            echo '<a href="' . esc_url(wp_nonce_url(admin_url('admin-post.php?action=cf7_integration_deactivate_addon&addon=' . $addon_name), 'cf7_integration_deactivate_addon_' . $addon_name)) . '" class="button button-secondary">' . __('Deactivate', 'cf7-integration') . '</a>';
        } else {
            echo '<a href="' . esc_url(wp_nonce_url(admin_url('admin-post.php?action=cf7_integration_activate_addon&addon=' . $addon_name), 'cf7_integration_activate_addon_' . $addon_name)) . '" class="button button-primary">' . __('Activate', 'cf7-integration') . '</a>';
        }
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    
    echo '<style>
        .cf7-addon-management {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .cf7-addon-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .cf7-addon-item:last-child {
            border-bottom: none;
        }
        .cf7-addon-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .cf7-addon-name {
            font-weight: bold;
        }
        .cf7-addon-source {
            font-size: 0.9em;
            color: #666;
        }
        .cf7-addon-status.active {
            color: green;
        }
        .cf7-addon-status.inactive {
            color: orange;
        }
        .cf7-addon-actions {
            display: flex;
            gap: 10px;
        }
    </style>';
}

/**
 * Handle addon activation
 *
 * @since    1.0.0
 */
function cf7_integration_handle_addon_activation() {
    if (isset($_POST['action']) && $_POST['action'] === 'cf7_integration_activate_addon' && isset($_POST['addon'])) {
        if (wp_verify_nonce($_POST['_wpnonce'], 'cf7_integration_activate_addon_' . $_POST['addon'])) {
            CF7_Addon_Manager::activate_addon(sanitize_text_field($_POST['addon']));
            wp_redirect(admin_url('admin.php?page=cf7-integration&activated=true'));
            exit;
        }
    }
}

/**
 * Handle addon deactivation
 *
 * @since    1.0.0
 */
function cf7_integration_handle_addon_deactivation() {
    if (isset($_POST['action']) && $_POST['action'] === 'cf7_integration_deactivate_addon' && isset($_POST['addon'])) {
        if (wp_verify_nonce($_POST['_wpnonce'], 'cf7_integration_deactivate_addon_' . $_POST['addon'])) {
            CF7_Addon_Manager::deactivate_addon(sanitize_text_field($_POST['addon']));
            wp_redirect(admin_url('admin.php?page=cf7-integration&deactivated=true'));
            exit;
        }
    }
}

add_action('admin_post_cf7_integration_activate_addon', 'cf7_integration_handle_addon_activation');
add_action('admin_post_cf7_integration_deactivate_addon', 'cf7_integration_handle_addon_deactivation');