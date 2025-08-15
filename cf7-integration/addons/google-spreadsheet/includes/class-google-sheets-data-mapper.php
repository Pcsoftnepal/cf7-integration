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
     * Map form data to Google Sheets format
     *
     * @since    1.0.0
     * @param    array    $form_data    The form data to map
     * @param    array    $mapping      The mapping configuration
     * @return   array    Mapped data ready for Google Sheets
     */
    public function map_form_data($form_data, $mapping) {
        $mapped_data = array();
        
        // Loop through the mapping configuration
        foreach ($mapping as $field_name => $column_header) {
            // Check if the field exists in the form data
            if (isset($form_data[$field_name])) {
                $mapped_data[] = $form_data[$field_name];
            } else {
                // If the field doesn't exist, add an empty cell
                $mapped_data[] = '';
            }
        }
        
        return $mapped_data;
    }
    
    /**
     * Prepare data for Google Sheets
     *
     * @since    1.0.0
     * @param    array    $mapped_data    The mapped data
     * @return   array    Formatted data for Google Sheets
     */
    public function prepare_data_for_sheets($mapped_data) {
        // Google Sheets expects an array of arrays
        return array(
            'values' => array(
                $mapped_data
            )
        );
    }
}