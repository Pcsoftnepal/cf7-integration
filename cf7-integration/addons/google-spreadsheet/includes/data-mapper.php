<?php
/**
 * Google Sheets Data Mapper
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
 * Google Sheets Data Mapper
 */
class CF7_Google_Sheets_Data_Mapper {
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Map form field values to Google Sheets columns
     *
     * @since    1.0.0
     * @param    array    $form_data    The form data
     * @param    array    $field_mappings    The field mappings
     * @return   array
     */
    public function map_form_fields_to_google_sheets_columns($form_data, $field_mappings = array()) {
        $mapped_data = array();
        
        // Default mappings for common fields
        $default_mappings = array(
            'email' => 'Email',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'phone' => 'Phone',
            'company' => 'Company',
            'website' => 'Website',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zip' => 'Zip',
            'country' => 'Country'
        );
        
        // Merge with custom mappings if provided
        $mappings = !empty($field_mappings) ? $field_mappings : $default_mappings;
        
        foreach ($mappings as $form_field => $column_header) {
            if (isset($form_data[$form_field])) {
                $mapped_data[$column_header] = $form_data[$form_field];
            }
        }
        
        return $mapped_data;
    }

    /**
     * Sanitize and validate Google Sheets data
     *
     * @since    1.0.0
     * @param    array    $data    The data to sanitize
     * @return   array
     */
    public function sanitize_google_sheets_data($data) {
        $sanitized_data = array();
        
        foreach ($data as $key => $value) {
            // Skip empty values
            if (empty($value)) {
                continue;
            }
            
            // Sanitize the key (column header)
            $sanitized_key = sanitize_text_field($key);
            
            // Sanitize the value
            $sanitized_value = is_array($value) ? implode(', ', $value) : sanitize_text_field($value);
            
            $sanitized_data[$sanitized_key] = $sanitized_value;
        }
        
        return $sanitized_data;
    }
}