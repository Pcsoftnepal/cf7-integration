<?php
/**
 * ActiveCampaign addon for CF7 Integration
 * 
 * @package CF7_Integration
 * @subpackage CF7_Integration/addons/activecampaign
 */

// Don't call this file directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main ActiveCampaign addon class
 * 
 * @package CF7_Integration
 * @subpackage CF7_Integration/addons/activecampaign
 */
class CF7_ActiveCampaign_Addon {
    
    /**
     * Initialize the addon
     * 
     * @since 1.0.0
     */
    public function __construct() {
        // Load addon-specific files
        $this->load_files();
        
        // Hook into the main plugin
        $this->init_hooks();
    }
    
    /**
     * Load addon-specific files
     * 
     * @since 1.0.0
     */
    private function load_files() {
        $addon_dir = plugin_dir_path(__FILE__);
        
        // Load addon-specific classes
        require_once $addon_dir . 'includes/class-activecampaign-api-client.php';
        require_once $addon_dir . 'includes/class-activecampaign-form-handler.php';
        require_once $addon_dir . 'includes/class-activecampaign-data-mapper.php';
    }
    
    /**
     * Initialize hooks for the addon
     * 
     * @since 1.0.0
     */
    private function init_hooks() {
        // Hook into main plugin functionality
        add_action('cf7_integration_after_load', array($this, 'initialize_addon'));
    }
    
    /**
     * Initialize the addon functionality
     * 
     * @since 1.0.0
     */
    public function initialize_addon() {
        // Initialize the ActiveCampaign integration
        $api_client = new CF7_ActiveCampaign_API_Client();
        $data_mapper = new CF7_ActiveCampaign_Data_Mapper();
        $form_handler = new CF7_ActiveCampaign_Form_Handler();
        
        // Hook into the main plugin
        add_action('cf7_integration_process_form_submission', array($form_handler, 'process_form_submission'), 10, 2);
    }
}

// Initialize the addon
new CF7_ActiveCampaign_Addon();