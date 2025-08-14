<?php
/** 
 * Class for handling Contact Form 7 form submissions
 *
 * @package    CF7_HubSpot_Integration
 * @subpackage CF7_HubSpot_Integration/includes
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Class CF7_HubSpot_Form_Handler
 */
class CF7_HubSpot_Form_Handler {

    /**
     * Initialize the class and set its properties
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Process form submission and send data to HubSpot
     *
     * @param WPCF7_ContactForm $form
     * @return void
     */
    public function process_form_submission($form) {
        // Check if the form object is valid
        if (!$form || !is_a($form, 'WPCF7_ContactForm')) {
            return;
        }
        
        $form_id = $form->id();
        
        // Check if integration is enabled for this form
        $enabled_forms = get_option('cf7_hubspot_enabled_forms', array());
        if (!in_array($form_id, $enabled_forms)) {
            return;
        }
        
        // Get form data
        $form_data = $this->get_form_data($form);
        
        // Get field mappings for this form
        $field_mappings = get_option('cf7_hubspot_field_mappings_' . $form_id, array());
        
        // Map form fields to HubSpot properties
        $data_mapper = new CF7_HubSpot_Data_Mapper();
        $hubspot_properties = $data_mapper->map_form_fields_to_hubspot_properties($form_data, $field_mappings);
        
        // Sanitize properties
        $hubspot_properties = $data_mapper->sanitize_hubspot_properties($hubspot_properties);
        
        // Validate required properties
        $required_properties = array('email');
        $validation_errors = $data_mapper->validate_required_properties($hubspot_properties, $required_properties);
        
        if (!empty($validation_errors)) {
            // Log validation errors
            $this->log_error('Validation errors: ' . implode(', ', $validation_errors));
            return;
        }
        
        // Send data to HubSpot
        $api_client = new CF7_HubSpot_API_Client();
        $result = $this->send_to_hubspot($hubspot_properties, $form_id);
        
        if (!$result['success']) {
            $this->log_error('HubSpot API error: ' . $result['error']);
        }
    }

    /**
     * Send data to HubSpot
     *
     * @param array $properties
     * @param int $form_id
     * @return array
     */
    private function send_to_hubspot($properties, $form_id) {
        $api_client = new CF7_HubSpot_API_Client();
        $contact_list_id = CF7_HubSpot_Settings::get_contact_list_id();
        
        // Create or update contact
        $contact_result = $api_client->create_or_update_contact($properties);
        
        if (!$contact_result['success']) {
            return $contact_result;
        }
        
        // If we have a contact list ID, add the contact to the list
        if (!empty($contact_list_id)) {
            // For HubSpot v3 API, we extract the email from properties and use it as contact identifier
            $email = isset($properties['email']) ? $properties['email'] : null;
            
            if ($email) {
                // Add to list
                $list_result = $api_client->add_contact_to_list($email, $contact_list_id);
                
                if (!$list_result['success']) {
                    return $list_result;
                }
            }
        }
        
        return array(
            'success' => true,
            'message' => 'Contact successfully sent to HubSpot'
        );
    }

    /**
     * Get form data for processing
     *
     * @param WPCF7_ContactForm $form
     * @return array
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
     * @param string $message
     * @return void
     */
    private function log_error($message) {
        if (CF7_HubSpot_Settings::is_logging_enabled()) {
            $logger = new CF7_HubSpot_Logger();
            $logger->log_error($message);
        }
    }
}