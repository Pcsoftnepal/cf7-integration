<?php
/**
 * ActiveCampaign Data Mapper
 * 
 * @package CF7_Integration
 * @subpackage CF7_Integration/addons/activecampaign/includes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ActiveCampaign Data Mapper
 * 
 * Maps Contact Form 7 field values to ActiveCampaign field values
 */
class CF7_ActiveCampaign_Data_Mapper {
    
    /**
     * Map form data to ActiveCampaign contact data
     * 
     * @since 1.0.0
     * @param array $form_data Form data from Contact Form 7
     * @return array Mapped contact data
     */
    public function map_form_data_to_contact($form_data) {
        $mapped_data = array();
        
        // Map standard fields
        if (isset($form_data['email'])) {
            $mapped_data['email'] = sanitize_email($form_data['email']);
        }
        
        if (isset($form_data['first_name'])) {
            $mapped_data['first_name'] = sanitize_text_field($form_data['first_name']);
        }
        
        if (isset($form_data['last_name'])) {
            $mapped_data['last_name'] = sanitize_text_field($form_data['last_name']);
        }
        
        if (isset($form_data['phone'])) {
            $mapped_data['phone'] = sanitize_text_field($form_data['phone']);
        }
        
        // Map custom fields
        foreach ($form_data as $key => $value) {
            if (strpos($key, 'cf7_') === 0) {
                $mapped_data[str_replace('cf7_', '', $key)] = sanitize_text_field($value);
            }
        }
        
        return $mapped_data;
    }
    
    /**
     * Get ActiveCampaign field mapping
     * 
     * @since 1.0.0
     * @param array $form_data Form data
     * @return array Field mapping
     */
    public function get_field_mapping($form_data) {
        $mapping = array();
        
        // Standard field mappings
        $standard_fields = array(
            'email' => 'email',
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'phone' => 'phone'
        );
        
        foreach ($standard_fields as $cf7_field => $ac_field) {
            if (isset($form_data[$cf7_field])) {
                $mapping[$ac_field] = $form_data[$cf7_field];
            }
        }
        
        return $mapping;
    }
}