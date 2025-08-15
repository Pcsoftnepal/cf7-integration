<?php
/**
 * Salesforce Data Mapper
 *
 * @package    CF7_Salesforce
 * @subpackage CF7_Salesforce/includes
 * @author     Your Name <email@example.com>
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Salesforce Data Mapper
 */
class CF7_Salesforce_Data_Mapper {

    /**
     * Map form fields to Salesforce fields
     */
    public function map_fields($form_data, $mapping_rules) {
        $mapped_data = array();
        
        foreach ($mapping_rules as $cf7_field => $salesforce_field) {
            if (isset($form_data[$cf7_field])) {
                $mapped_data[$salesforce_field] = $form_data[$cf7_field];
            }
        }
        
        return $mapped_data;
    }

    /**
     * Validate Salesforce field mapping
     */
    public function validate_mapping($mapping_rules) {
        // In a real implementation, this would validate that required fields are mapped correctly
        // and that the mapping follows Salesforce field requirements
        
        // For now, we'll just return true
        return true;
    }
    
    /**
     * Get standard Salesforce field mappings
     */
    public function get_standard_mappings() {
        return array(
            'first_name' => 'FirstName',
            'last_name' => 'LastName', 
            'email' => 'Email',
            'phone' => 'Phone',
            'company' => 'Company',
            'title' => 'Title',
            'website' => 'Website'
        );
    }
}