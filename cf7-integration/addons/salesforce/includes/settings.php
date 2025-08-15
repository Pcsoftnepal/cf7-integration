<?php
/**
 * Salesforce Settings Manager
 *
 * @package    CF7_Salesforce
 * @subpackage CF7_Salesforce/includes
 * @author     Your Name <email@example.com>
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Salesforce Settings Manager
 */
class CF7_Salesforce_Settings {
    
    /**
     * Instance of this class
     */
    protected static $instance = null;

    /**
     * Plugin settings
     */
    protected $settings;

    /**
     * Constructor
     */
    public function __construct() {
        // Initialize settings
        $this->initialize_settings();
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
     * Initialize settings
     */
    protected function initialize_settings() {
        // Get existing settings or set defaults
        $this->settings = get_option('cf7_salesforce_settings', array(
            'consumer_key' => '',
            'consumer_secret' => '',
            'enable_debug_logging' => false
        ));
    }

    /**
     * Get plugin settings
     */
    public function get_settings() {
        return $this->settings;
    }

    /**
     * Save plugin settings
     */
    public function save_settings($new_settings) {
        $this->settings = array_merge($this->settings, $new_settings);
        update_option('cf7_salesforce_settings', $this->settings);
    }

    /**
     * Get specific setting
     */
    public function get_setting($key, $default = '') {
        return isset($this->settings[$key]) ? $this->settings[$key] : $default;
    }
    
    /**
     * Get all settings
     */
    public function get_all_settings() {
        return $this->settings;
    }
}