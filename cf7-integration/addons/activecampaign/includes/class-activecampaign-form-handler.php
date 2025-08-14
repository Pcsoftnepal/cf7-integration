<?php
/**
 * ActiveCampaign Form Handler
 * 
 * @package CF7_Integration
 * @subpackage CF7_Integration/addons/activecampaign/includes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ActiveCampaign Form Handler
 * 
 * Handles form submission processing for ActiveCampaign integration
 */
class CF7_ActiveCampaign_Form_Handler {
    
    /**
     * Handle form submission
     * 
     * @since 1.0.0
     * @param object $form Contact Form 7 form object
     * @param array $result Form submission result
     */
    public function process_form_submission($form, $result) {
        // Get the form settings
        $settings = get_option('cf7_activecampaign_settings', array());
        
        // Check if ActiveCampaign integration is enabled for this form
        if (!isset($settings['enabled']) || !$settings['enabled']) {
            return;
        }
        
        // Get form data
        $form_data = $this->get_form_data($form);
        
        // Process the data with ActiveCampaign
        $this->sync_with_activecampaign($form_data, $settings);
    }
    
    /**
     * Get form data from the submitted form
     * 
     * @since 1.0.0
     * @param object $form Contact Form 7 form object
     * @return array Form data
     */
    private function get_form_data($form) {
        $form_data = array();
        
        // Get all posted data
        foreach ($_POST as $key => $value) {
            if ($key !== '_wpcf7' && $key !== '_wpcf7_version' && $key !== '_wpcf7_locale' && $key !== '_wpcf7_isvalid') {
                $form_data[$key] = $value;
            }
        }
        
        return $form_data;
    }
    
    /**
     * Sync form data with ActiveCampaign
     * 
     * @since 1.0.0
     * @param array $form_data Form data
     * @param array $settings Plugin settings
     */
    private function sync_with_activecampaign($form_data, $settings) {
        // Initialize the API client
        $api_client = new CF7_ActiveCampaign_API_Client();
        $data_mapper = new CF7_ActiveCampaign_Data_Mapper();
        
        // Map form data to ActiveCampaign format
        $contact_data = $data_mapper->map_form_data_to_contact($form_data);
        
        // If no email, skip
        if (!isset($contact_data['email']) || empty($contact_data['email'])) {
            return;
        }
        
        try {
            // Check if contact already exists
            $existing_contact = $api_client->get_contact_by_email($contact_data['email']);
            
            if (isset($existing_contact['contacts']) && !empty($existing_contact['contacts'])) {
                // Update existing contact
                $contact_id = $existing_contact['contacts'][0]['id'];
                $api_client->update_contact($contact_id, $contact_data);
            } else {
                // Create new contact
                $list_id = isset($settings['list_id']) ? $settings['list_id'] : '';
                
                if (!empty($list_id)) {
                    $api_client->add_contact_to_list($list_id, $contact_data);
                }
            }
            
            // Add tags if specified
            if (isset($settings['tags']) && !empty($settings['tags'])) {
                $tag_ids = explode(',', $settings['tags']);
                $contact_id = $this->get_contact_id_by_email($contact_data['email']);
                
                if ($contact_id) {
                    foreach ($tag_ids as $tag_id) {
                        $api_client->add_tag_to_contact($contact_id, trim($tag_id));
                    }
                }
            }
            
            // Log successful sync
            $this->log_sync_success($contact_data, 'ActiveCampaign');
            
        } catch (Exception $e) {
            // Log error
            $this->log_sync_error($contact_data, $e->getMessage(), 'ActiveCampaign');
        }
    }
    
    /**
     * Get contact ID by email
     * 
     * @since 1.0.0
     * @param string $email Contact email
     * @return int|bool Contact ID or false if not found
     */
    private function get_contact_id_by_email($email) {
        $api_client = new CF7_ActiveCampaign_API_Client();
        $contact_data = $api_client->get_contact_by_email($email);
        
        if (isset($contact_data['contacts']) && !empty($contact_data['contacts'])) {
            return $contact_data['contacts'][0]['id'];
        }
        
        return false;
    }
    
    /**
     * Log successful sync
     * 
     * @since 1.0.0
     * @param array $contact_data Contact data
     * @param string $service Service name
     */
    private function log_sync_success($contact_data, $service) {
        if (get_option('cf7_activecampaign_enable_logging', false)) {
            $message = sprintf(
                '%s: Successfully synced contact %s with %s',
                date('Y-m-d H:i:s'),
                $contact_data['email'],
                $service
            );
            
            error_log($message);
        }
    }
    
    /**
     * Log sync error
     * 
     * @since 1.0.0
     * @param array $contact_data Contact data
     * @param string $error Error message
     * @param string $service Service name
     */
    private function log_sync_error($contact_data, $error, $service) {
        if (get_option('cf7_activecampaign_enable_logging', false)) {
            $message = sprintf(
                '%s: Failed to sync contact %s with %s: %s',
                date('Y-m-d H:i:s'),
                $contact_data['email'],
                $service,
                $error
            );
            
            error_log($message);
        }
    }
}