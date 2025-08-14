<?php
/**
 * Fired during plugin activation
 *
 * @package    CF7_HubSpot_Integration
 * @subpackage CF7_HubSpot_Integration/includes
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 */
class CF7_HubSpot_Activator {

    /**
     * Activate the plugin
     *
     * @since    1.0.0
     */
    public static function activate() {
        // Create default settings
        $default_settings = array(
            'cf7_hubspot_api_key' => '',
            'cf7_hubspot_contact_list_id' => '',
            'cf7_hubspot_enable_logging' => 'on',
            'cf7_hubspot_debug_mode' => ''
        );
        
        foreach ($default_settings as $option => $value) {
            add_option($option, $value);
        }
        
        // Create empty arrays for form-specific settings
        add_option('cf7_hubspot_enabled_forms', array());
        add_option('cf7_hubspot_form_field_mappings', array());
    }
}