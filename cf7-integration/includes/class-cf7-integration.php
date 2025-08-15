<?php
/**
 * Main plugin file for CF7 Integration
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration
 * @author     PCSoftNepal <info@pcsoftnepal.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('CF7_INTEGRATION_VERSION', '1.0.0');

/**
 * The core plugin class
 *
 * @link       https://www.pcsoftnepal.com
 * @since      1.0.0
 *
 * @package    CF7_Integration
 */
class CF7_Integration {
    
    /**
     * The unique identifier of the plugin
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin
     */
    protected $plugin_name;

    /**
     * The current version of the plugin
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin
     */
    protected $version;

    /**
     * The list of available addons
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $available_addons    List of available addons
     */
    protected $available_addons;

    /**
     * Initialize the plugin class
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->plugin_name = 'cf7-integration';
        $this->version = CF7_INTEGRATION_VERSION;
        
        // Initialize the available addons
        $this->available_addons = array();
        
        // Add the Google Spreadsheet addon
        $this->available_addons['google-spreadsheet'] = array(
            'name' => 'Google Spreadsheet',
            'file' => plugin_dir_path(__FILE__) . 'addons/google-spreadsheet/google-spreadsheet.php',
            'description' => 'Send form submissions to Google Sheets'
        );
        
        // Add the Mailchimp addon
        $this->available_addons['mailchimp'] = array(
            'name' => 'Mailchimp',
            'file' => plugin_dir_path(__FILE__) . 'addons/mailchimp/mailchimp.php',
            'description' => 'Send form submissions to Mailchimp'
        );
        
        // Add the Klaviyo addon
        $this->available_addons['klaviyo'] = array(
            'name' => 'Klaviyo',
            'file' => plugin_dir_path(__FILE__) . 'addons/klaviyo/klaviyo.php',
            'description' => 'Send form submissions to Klaviyo'
        );
        
        // Add the ActiveCampaign addon
        $this->available_addons['activecampaign'] = array(
            'name' => 'ActiveCampaign',
            'file' => plugin_dir_path(__FILE__) . 'addons/activecampaign/activecampaign.php',
            'description' => 'Send form submissions to ActiveCampaign'
        );
        
        // Add the Salesforce addon
        $this->available_addons['salesforce'] = array(
            'name' => 'Salesforce',
            'file' => plugin_dir_path(__FILE__) . 'addons/salesforce/salesforce.php',
            'description' => 'Send form submissions to Salesforce'
        );
    }

    /**
     * Load the required dependencies for this plugin
     *
     * @since    1.0.0
     */
    public function load_dependencies() {
        // Load the required dependencies for the addons
        foreach ($this->available_addons as $addon) {
            if (file_exists($addon['file'])) {
                require_once $addon['file'];
            }
        }
    }

    /**
     * Register all of the hooks related to the plugin functionality
     *
     * @since    1.0.0
     */
    public function register_hooks() {
        // Hook into the main plugin initialization
        add_action('cf7_integration_init', array($this, 'init'));
        
        // Hook into admin menu to add settings page
        add_action('admin_menu', array($this, 'add_settings_page'));
    }

    /**
     * Initialize the plugin functionality
     *
     * @since    1.0.0
     */
    public function init() {
        // Load the required dependencies
        $this->load_dependencies();
        
        // Initialize the addons
        foreach ($this->available_addons as $addon) {
            if (file_exists($addon['file'])) {
                // Initialize the addon
                $addon_class = str_replace('-', '_', $addon['name']);
                $addon_instance = new $addon_class();
            }
        }
    }

    /**
     * Add settings page to admin menu
     *
     * @since    1.0.0
     */
    public function add_settings_page() {
        add_submenu_page(
            'wpcf7',
            'Google Spreadsheet Settings',
            'Google Spreadsheet Settings',
            'manage_options',
            'cf7-google-spreadsheet-settings',
            'cf7_google_sheets_settings_page'
        );
        
        // Add Salesforce settings page
        add_submenu_page(
            'wpcf7',
            'Salesforce Settings',
            'Salesforce Settings',
            'manage_options',
            'cf7-salesforce-settings',
            'cf7_salesforce_settings_page'
        );
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to uniquely register the various hooks that occur within the plugin.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the current version of the plugin
     *
     * @since     1.0.0
     * @return    string    The current version of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * The list of available addons
     *
     * @since     1.0.0
     * @return    array    The list of available addons.
     */
    public function get_available_addons() {
        return $this->available_addons;
    }
}