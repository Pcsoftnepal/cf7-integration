<?php
/**
 * Framework Admin Class
 * 
 * Handles admin-side functionality for the framework
 * 
 * @package    CF7_Integration
 * @subpackage CF7_Integration/framework
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Framework admin class
 */
class CF7_Framework_Admin {
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Initialize admin functionality
     *
     * @since    1.0.0
     */
    public function init() {
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Add settings link
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
        
        // Handle addon activation/deactivation
        add_action('admin_post_cf7_integration_activate_addon', array($this, 'handle_addon_activation'));
        add_action('admin_post_cf7_integration_deactivate_addon', array($this, 'handle_addon_deactivation'));
    }

    /**
     * Add admin menu
     *
     * @since    1.0.0
     */
    public function add_admin_menu() {
        // Add main menu item
        add_menu_page(
            __('CF7 Integration', 'cf7-integration'),
            __('CF7 Integration', 'cf7-integration'),
            'manage_options',
            'cf7-integration',
            array($this, 'display_settings_page'),
            'dashicons-admin-generic',
            30
        );
    }

    /**
     * Display settings page
     *
     * @since    1.0.0
     */
    public function display_settings_page() {
        // Include settings page template
        include_once plugin_dir_path(__FILE__) . '../admin/partials/settings-page.php';
    }

    /**
     * Add settings link to plugin
     *
     * @since    1.0.0
     */
    public function add_settings_link($links) {
        $settings_link = '<a href="options-general.php?page=cf7-integration">' . __('Settings', 'cf7-integration') . '</a>';
        array_push($links, $settings_link);
        return $links;
    }
    
    /**
     * Handle addon activation
     *
     * @since    1.0.0
     */
    public function handle_addon_activation() {
        if (isset($_POST['addon']) && wp_verify_nonce($_POST['_wpnonce'], 'cf7_integration_activate_addon_' . $_POST['addon'])) {
            CF7_Addon_Manager::activate_addon(sanitize_text_field($_POST['addon']));
            wp_redirect(admin_url('admin.php?page=cf7-integration&activated=true'));
            exit;
        }
    }

    /**
     * Handle addon deactivation
     *
     * @since    1.0.0
     */
    public function handle_addon_deactivation() {
        if (isset($_POST['addon']) && wp_verify_nonce($_POST['_wpnonce'], 'cf7_integration_deactivate_addon_' . $_POST['addon'])) {
            CF7_Addon_Manager::deactivate_addon(sanitize_text_field($_POST['addon']));
            wp_redirect(admin_url('admin.php?page=cf7-integration&deactivated=true'));
            exit;
        }
    }
}