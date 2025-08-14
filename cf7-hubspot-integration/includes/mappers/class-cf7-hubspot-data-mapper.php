<?php
/**
 * Class for mapping form fields to HubSpot contact properties
 *
 * @package    CF7_HubSpot_Integration
 * @subpackage CF7_HubSpot_Integration/includes
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Class CF7_HubSpot_Data_Mapper
 */
class CF7_HubSpot_Data_Mapper {

    /**
     * Initialize the class and set its properties
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Map form field values to HubSpot contact properties
     *
     * @param array $form_data
     * @param array $field_mappings
     * @return array
     */
    public function map_form_fields_to_hubspot_properties($form_data, $field_mappings = array()) {
        $hubspot_properties = array();
        
        // Default mappings for common fields
        $default_mappings = array(
            'email' => 'email',
            'first_name' => 'firstname',
            'last_name' => 'lastname',
            'phone' => 'phone',
            'company' => 'company',
            'website' => 'website',
            'address' => 'address',
            'city' => 'city',
            'state' => 'state',
            'zip' => 'zip',
            'country' => 'country'
        );
        
        // Merge with custom mappings if provided
        $mappings = !empty($field_mappings) ? $field_mappings : $default_mappings;
        
        foreach ($mappings as $form_field => $hubspot_property) {
            if (isset($form_data[$form_field])) {
                $hubspot_properties[$hubspot_property] = $form_data[$form_field];
            }
        }
        
        return $hubspot_properties;
    }

    /**
     * Sanitize and validate HubSpot properties
     *
     * @param array $properties
     * @return array
     */
    public function sanitize_hubspot_properties($properties) {
        $sanitized_properties = array();
        
        foreach ($properties as $key => $value) {
            // Skip empty values
            if (empty($value)) {
                continue;
            }
            
            // Sanitize the property key (HubSpot property name)
            $sanitized_key = sanitize_key($key);
            
            // Sanitize the property value
            $sanitized_value = is_array($value) ? implode(', ', $value) : sanitize_text_field($value);
            
            $sanitized_properties[$sanitized_key] = $sanitized_value;
        }
        
        return $sanitized_properties;
    }

    /**
     * Get the default field mappings
     *
     * @return array
     */
    public static function get_default_field_mappings() {
        return array(
            'email' => 'email',
            'first_name' => 'firstname',
            'last_name' => 'lastname',
            'phone' => 'phone',
            'company' => 'company',
            'website' => 'website',
            'address' => 'address',
            'city' => 'city',
            'state' => 'state',
            'zip' => 'zip',
            'country' => 'country'
        );
    }

    /**
     * Validate that required properties are present
     *
     * @param array $properties
     * @param array $required_properties
     * @return array
     */
    public function validate_required_properties($properties, $required_properties = array()) {
        $errors = array();
        
        // Default required properties
        if (empty($required_properties)) {
            $required_properties = array('email');
        }
        
        foreach ($required_properties as $property) {
            if (!isset($properties[$property]) || empty($properties[$property])) {
                $errors[] = sprintf(__('Missing required property: %s', 'cf7-hubspot-integration'), $property);
            }
        }
        
        return $errors;
    }
}