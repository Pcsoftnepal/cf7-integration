<?php
/**
 * Google Spreadsheet integration for Contact Form 7
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/google-spreadsheet
 * @author     PCSoftNepal <info@pcsoftnepal.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Google Spreadsheet integration class
 */
class CF7_Google_Spreadsheet_Integration {
    
    /**
     * Initialize the plugin
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Hook into the main plugin initialization
        add_action('cf7_integration_init', array($this, 'init'));
    }
    
    /**
     * Initialize the plugin functionality
     *
     * @since    1.0.0
     */
    public function init() {
        // Load required files
        $this->load_dependencies();
        
        // Hook into form submission
        add_action('wpcf7_POST_SEND', array($this, 'handle_form_submission'), 10, 2);
    }
    
    /**
     * Load the required dependencies for this plugin
     *
     * @since    1.0.0
     */
    private function load_dependencies() {
        // Load the Google Sheets API client
        require_once plugin_dir_path(__FILE__) . 'includes/class-google-sheets-api-client.php';
        
        // Load the Google Sheets data mapper
        require_once plugin_dir_path(__FILE__) . 'includes/class-google-sheets-data-mapper.php';
        
        // Load the Google Sheets form handler
        require_once plugin_dir_path(__FILE__) . 'includes/class-google-sheets-form-handler.php';
    }
    
    /**
     * Handle form submission
     *
     * @since    1.0.0
     * @param    WPCF7_ContactForm    $form    The form object
     * @param    array               $result  The submission result
     */
    public function handle_form_submission($form, $result) {
        // Instantiate the form handler and process the submission
        $handler = new CF7_Google_Sheets_Form_Handler();
        $handler->process_form_submission($form, $result);
    }
    
    /**
     * Register activation hook
     *
     * @since    1.0.0
     */
    public static function activate() {
        // Activation logic here
    }
    
    /**
     * Register deactivation hook
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        // Deactivation logic here
    }
}