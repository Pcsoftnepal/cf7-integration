<?php
/** 
 * Klaviyo Form Handler
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/klaviyo/includes
 * @author     Your Company <email@example.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Klaviyo Form Handler
 */
class CF7_Klaviyo_Form_Handler {
    
    /**
     * Initialize the plugin
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Process form submission and send data to Klaviyo
     *
     * @since    1.0.0
     * @param    WPCF7_ContactForm    $form    The form object
     * @param    array               $result  The submission result
     */
    public function process_form_submission($form, $result) {
        // Get the form ID
        $form_id = $form->id();
        
        // Get settings for this form
        $api_key = get_option('cf7_klaviyo_api_key', '');
        $list_id = get_option('cf7_klaviyo_list_id', '');
        $enable_logging = get_option('cf7_klaviyo_enable_logging', false);
        
        // Skip if no API key or list ID
        if (empty($api_key) || empty($list_id)) {
            if ($enable_logging) {
                CF7_Integration_Logger::log('Klaviyo integration disabled: Missing API key or list ID.', 'klaviyo');
            }
            return;
        }
        
        // Get form data
        $submission = WPCF7_Submission::get_current();
        if (!$submission) {
            if ($enable_logging) {
                CF7_Integration_Logger::log('No submission data found for form ' . $form_id, 'klaviyo');
            }
            return;
        }
        
        $cf7_data = $submission->get_posted_data();
        
        // Map data to Klaviyo format
        $mapper = new CF7_Klaviyo_Data_Mapper();
        $subscriber_data = $mapper->map_subscriber_data($cf7_data);
        
        // If no email, we can't process
        if (empty($subscriber_data['email'])) {
            if ($enable_logging) {
                CF7_Integration_Logger::log('No email found in form ' . $form_id, 'klaviyo');
            }
            return;
        }
        
        // Send to Klaviyo
        $api_client = new CF7_Klaviyo_API_Client($api_key);
        $response = $api_client->subscribe_to_list($subscriber_data);
        
        // Log response
        if ($enable_logging) {
            if (is_wp_error($response)) {
                CF7_Integration_Logger::log('Klaviyo API error for form ' . $form_id . ': ' . $response->get_error_message(), 'klaviyo');
            } else {
                CF7_Integration_Logger::log('Successfully sent data to Klaviyo for form ' . $form_id, 'klaviyo');
            }
        }
    }
}