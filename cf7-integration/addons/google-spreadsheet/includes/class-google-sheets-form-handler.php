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
     * Process form submission
     *
     * @since    1.0.0
     * @param    WPCF7_ContactForm    $form    The form object
     * @param    array               $result  The submission result
     */
    public function process_form_submission($form, $result) {
        // Get the form settings
        $settings = get_option('cf7_google_sheets_settings');
        
        // Check if the form is configured for Google Sheets
        if (empty($settings) || !isset($settings['enabled']) || !$settings['enabled']) {
            return;
        }
        
        // Get the form ID
        $form_id = $form->id();
        
        // Check if this form is enabled for Google Sheets
        if (isset($settings['forms'][$form_id]) && !$settings['forms'][$form_id]['enabled']) {
            return;
        }
        
        // Get the Google Sheets configuration for this form
        $spreadsheet_id = isset($settings['forms'][$form_id]['spreadsheet_id']) ? $settings['forms'][$form_id]['spreadsheet_id'] : '';
        $range = isset($settings['forms'][$form_id]['range']) ? $settings['forms'][$form_id]['range'] : 'A1';
        $access_token = isset($settings['access_token']) ? $settings['access_token'] : '';
        
        // Validate the configuration
        if (empty($spreadsheet_id) || empty($access_token)) {
            // Log error
            error_log('Google Sheets integration error: Spreadsheet ID or access token is missing for form ' . $form_id);
            return;
        }
        
        // Get the form data
        $form_data = $_POST;
        
        // Remove unnecessary fields
        unset($form_data['_wpcf7']);
        unset($form_data['_wpcf7_version']);
        unset($form_data['_wpcf7_locale']);
        unset($form_data['_wpcf7_unit_tag']);
        unset($form_data['_wpnonce']);
        
        // Get the mapping configuration
        $mapping = isset($settings['forms'][$form_id]['mapping']) ? $settings['forms'][$form_id]['mapping'] : array();
        
        // Map the form data to Google Sheets format
        $data_mapper = new CF7_Google_Sheets_Data_Mapper();
        $mapped_data = $data_mapper->map_form_data($form_data, $mapping);
        
        // Prepare data for Google Sheets
        $prepared_data = $data_mapper->prepare_data_for_sheets($mapped_data);
        
        // Send data to Google Sheets
        $api_client = new CF7_Google_Sheets_API_Client($access_token);
        $response = $api_client->send_data($prepared_data, $spreadsheet_id, $range);
        
        // Log the response
        if (is_wp_error($response)) {
            error_log('Google Sheets integration error: ' . $response->get_error_message());
        } else {
            error_log('Google Sheets integration success: Data sent to spreadsheet ' . $spreadsheet_id);
        }
    }
}