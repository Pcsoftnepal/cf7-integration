<?php
/**
 * Mailchimp Form Handler
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/mailchimp/includes
 * @author     PCSoftNepal <info@pcsoftnepal.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Mailchimp Form Handler
 */
class CF7_Mailchimp_Form_Handler {
    
    /**
     * Initialize the plugin
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Process form submission and send data to Mailchimp
     *
     * @since    1.0.0
     * @param    WPCF7_ContactForm    $form    The form object
     * @param    array               $result  The submission result
     */
    public function process_form_submission($form, $result) {
        // Get the form ID
        $form_id = $form->id();
        
        // Get settings for this form
        $access_token = get_option('cf7_mailchimp_access_token', '');
        $list_id = get_option('cf7_mailchimp_list_id', '');
        $enable_logging = get_option('cf7_mailchimp_enable_logging', false);
        
        // Skip if no access token or list ID
        if (empty($access_token) || empty($list_id)) {
            if ($enable_logging) {
                CF7_Integration_Logger::log('Mailchimp integration disabled: Missing access token or list ID.', 'mailchimp');
            }
            return;
        }
        
        // Get form data
        $submission = WPCF7_Submission::get_current();
        if (!$submission) {
            if ($enable_logging) {
                CF7_Integration_Logger::log('No submission data found for form ' . $form_id, 'mailchimp');
            }
            return;
        }
        
        $cf7_data = $submission->get_posted_data();
        
        // Map data to Mailchimp format
        $mapper = new CF7_Mailchimp_Data_Mapper();
        $subscriber_data = $mapper->map_subscriber_data($cf7_data);
        
        // If no email, we can't process
        if (empty($subscriber_data['email'])) {
            if ($enable_logging) {
                CF7_Integration_Logger::log('No email found in form ' . $form_id, 'mailchimp');
            }
            return;
        }
        
        // Send to Mailchimp
        $api_client = new CF7_Mailchimp_API_Client($access_token);
        $response = $api_client->subscribe_to_list($subscriber_data, $list_id);
        
        // Log response
        if ($enable_logging) {
            if (is_wp_error($response)) {
                CF7_Integration_Logger::log('Mailchimp API error for form ' . $form_id . ': ' . $response->get_error_message(), 'mailchimp');
            } else {
                CF7_Integration_Logger::log('Successfully sent data to Mailchimp for form ' . $form_id, 'mailchimp');
            }
        }
    }
}