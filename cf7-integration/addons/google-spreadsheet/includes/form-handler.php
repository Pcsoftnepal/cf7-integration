<?php
/**
 * Google Sheets Form Handler
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/google-spreadsheet/includes
 * @author     PCSoftNepal <info@pcsoftnepal.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Google Sheets Form Handler
 */
class CF7_Google_Sheets_Form_Handler {
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Process form submission and send data to Google Sheets
     *
     * @since    1.0.0
     * @param    WPCF7_ContactForm    $form    The form object
     * @param    array               $result  The submission result
     * @return   void
     */
    public function process_form_submission($form, $result) {
        // Check if the form object is valid
        if (!$form || !is_a($form, 'WPCF7_ContactForm')) {
            return;
        }
        
        $form_id = $form->id();
        
        // Check if integration is enabled for this form
        $enabled_forms = get_option('cf7_google_sheets_forms', array());
        if (!in_array($form_id, $enabled_forms)) {
            return;
        }
        
        // Get form data
        $form_data = $this->get_form_data($form);
        
        // Get the Google Sheets settings
        $api_key = get_option('cf7_google_sheets_api_key', '');
        $spreadsheet_id = get_option('cf7_google_sheets_spreadsheet_id', '');
        $range = get_option('cf7_google_sheets_range', 'Sheet1!A:A');
        
        // Validate settings
        if (empty($api_key) || empty($spreadsheet_id)) {
            return;
        }
        
        // Prepare data for Google Sheets
        $data = array(
            'values' => array(
                array_values($form_data)
            )
        );
        
        // Send data to Google Sheets
        $api_client = new CF7_Google_Sheets_API_Client($api_key);
        $response = $api_client->send_data($data, $spreadsheet_id, $range);
        
        // Handle response
        if (is_wp_error($response)) {
            // Log error
            $this->log_error('Google Sheets API error: ' . $response->get_error_message());
        } else {
            // Log success
            $this->log_info('Data successfully sent to Google Sheets');
        }
    }

    /**
     * Get form data for processing
     *
     * @since    1.0.0
     * @param    WPCF7_ContactForm    $form    The form object
     * @return   array
     */
    private function get_form_data($form) {
        $form_data = array();
        
        // Get the submission object from the form
        $submission = WPCF7_Submission::get_current();
        
        if ($submission) {
            $posted_data = $submission->get_posted_data();
            
            foreach ($posted_data as $key => $value) {
                $form_data[$key] = $value;
            }
        }
        
        return $form_data;
    }

    /**
     * Log an error message
     *
     * @since    1.0.0
     * @param    string    $message    The error message
     * @return   void
     */
    private function log_error($message) {
        if (get_option('cf7_google_sheets_enable_logging', false)) {
            $logger = new CF7_Integration_Logger();
            $logger->log_error($message);
        }
    }

    /**
     * Log an info message
     *
     * @since    1.0.0
     * @param    string    $message    The info message
     * @return   void
     */
    private function log_info($message) {
        if (get_option('cf7_google_sheets_enable_logging', false)) {
            $logger = new CF7_Integration_Logger();
            $logger->log_info($message);
        }
    }
}