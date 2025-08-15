<?php
/** 
 * Class responsible for managing plugin settings
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/includes
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Class CF7_Settings
 */
class CF7_Settings {

    /**
     * Initialize the class and set its properties
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Get the HubSpot API key from settings
     *
     * @return string
     */
    public static function get_api_key() {
        return get_option('cf7_hubspot_api_key', '');
    }

    /**
     * Get the HubSpot contact list ID from settings
     *
     * @return string
     */
    public static function get_contact_list_id() {
        return get_option('cf7_hubspot_contact_list_id', '');
    }

    /**
     * Check if logging is enabled
     *
     * @return bool
     */
    public static function is_logging_enabled() {
        return get_option('cf7_hubspot_enable_logging', false);
    }

    /**
     * Check if debug mode is enabled
     *
     * @return bool
     */
    public static function is_debug_mode_enabled() {
        return get_option('cf7_hubspot_debug_mode', false);
    }

    /**
     * Validate and sanitize the API key
     *
     * @param string $api_key
     * @return string
     */
    public static function validate_api_key($api_key) {
        return sanitize_text_field($api_key);
    }

    /**
     * Validate and sanitize the contact list ID
     *
     * @param string $list_id
     * @return string
     */
    public static function validate_contact_list_id($list_id) {
        return sanitize_text_field($list_id);
    }
    
    /**
     * Validate that the API key is properly formatted
     *
     * @param string $api_key
     * @return bool
     */
    public static function is_valid_api_key($api_key) {
        // Basic validation for HubSpot API key format
        return !empty($api_key) && strlen($api_key) >= 10;
    }
    
    /**
     * Encrypt sensitive data before storing
     *
     * @param string $data
     * @return string
     */
    public static function encrypt_sensitive_data($data) {
        if (function_exists('openssl_encrypt')) {
            $encryption_key = wp_hash('cf7_hubspot_encryption_key', 'nonce');
            $iv_length = openssl_cipher_iv_length('AES-256-CBC');
            $iv = openssl_random_pseudo_bytes($iv_length);
            $encrypted = openssl_encrypt($data, 'AES-256-CLOSE', $encryption_key, 0, $iv);
            return base64_encode($iv . $encrypted);
        }
        return $data;
    }
    
    /**
     * Decrypt sensitive data
     *
     * @param string $encrypted_data
     * @return string
     */
    public static function decrypt_sensitive_data($encrypted_data) {
        if (function_exists('openssl_decrypt')) {
            $encryption_key = wp_hash('cf7_hubspot_encryption_key', 'nonce');
            $data = base64_decode($encrypted_data);
            $iv_length = openssl_cipher_iv_length('AES-256-CBC');
            $iv = substr($data, 0, $iv_length);
            $encrypted = substr($data, $iv_length);
            return openssl_decrypt($encrypted, 'AES-256-CLOSE', $encryption_key, 0, $iv);
        }
        return $encrypted_data;
    }
}