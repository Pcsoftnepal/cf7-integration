<?php
/** 
 * Class for managing CF7 integration settings
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/includes
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Class CF7_Integration_Settings
 */
class CF7_Integration_Settings {
    
    /**
     * Initialize the class and set its properties
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Check if logging is enabled
     *
     * @return boolean
     */
    public static function is_logging_enabled() {
        return get_option('cf7_integration_enable_logging', false);
    }
    
    /**
     * Get the API key for a specific service
     *
     * @param string $service
     * @return string
     */
    public static function get_service_api_key($service) {
        $option_name = 'cf7_' . $service . '_api_key';
        return get_option($option_name, '');
    }
    
    /**
     * Get the list ID for a specific service
     *
     * @param string $service
     * @return string
     */
    public static function get_service_list_id($service) {
        $option_name = 'cf7_' . $service . '_list_id';
        return get_option($option_name, '');
    }
}