<?php
/**
 * Salesforce integration for Contact Form 7
 *
 * @package    CF7_Salesforce
 * @subpackage CF7_Salesforce/admin
 * @author     Your Name <email@example.com>
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Salesforce integration class
 */
class CF7_Salesforce {

    /**
     * Instance of this class
     */
    protected static $instance = null;

    /**
     * Initialize the plugin
     */
    public function __construct() {
        // Hook into WordPress initialization
        add_action('init', array($this, 'init'));
        
        // Register activation hook
        register_activation_hook(__FILE__, array($this, 'activate'));
        
        // Register deactivation hook
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }

    /**
     * Return the instance of this class
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Load plugin text domain
        load_plugin_textdomain('cf7-salesforce', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        
        // Include required files
        $this->includes();
        
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Add settings link
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
    }

    /**
     * Include required files
     */
    public function includes() {
        // Include API client
        if (file_exists(dirname(__FILE__) . '/includes/api-client.php')) {
            require_once(dirname(__FILE__) . '/includes/api-client.php');
        }
        
        // Include form handler
        if (file_exists(dirname(__FILE__) . '/includes/form-handler.php')) {
            require_once(dirname(__FILE__) . '/includes/form-handler.php');
        }
        
        // Include data mapper
        if (file_exists(dirname(__FILE__) . '/includes/data-mapper.php')) {
            require_once(dirname(__FILE__) . '/includes/data-mapper.php');
        }
        
        // Include OAuth
        if (file_exists(dirname(__FILE__) . '/includes/oauth.php')) {
            require_once(dirname(__FILE__) . '/includes/oauth.php');
        }
        
        // Include settings
        if (file_exists(dirname(__FILE__) . '/includes/settings.php')) {
            require_once(dirname(__FILE__) . '/includes/settings.php');
        }
        
        // Include logger
        if (file_exists(dirname(__FILE__) . '/includes/logger.php')) {
            require_once(dirname(__FILE__) . '/includes/logger.php');
        }
        
        // Include settings page
        if (file_exists(dirname(__FILE__) . '/settings-page.php')) {
            require_once(dirname(__FILE__) . '/settings-page.php');
        }
    }

    /**
     * Activation hook
     */
    public function activate() {
        // Activation logic here
    }

    /**
     * Deactivation hook
     */
    public function deactivate() {
        // Deactivation logic here
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_submenu_page(
            'wpcf7',
            __('Salesforce Settings', 'cf7-salesforce'),
            __('Salesforce', 'cf7-salesforce'),
            'manage_options',
            'cf7-salesforce-settings',
            'cf7_salesforce_settings_page'
        );
    }

    /**
     * Add settings link
     */
    public function add_settings_link($links) {
        $settings_link = '<a href="' . admin_url('admin.php?page=cf7-salesforce-settings') . '">' . __('Settings', 'cf7-salesforce') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}