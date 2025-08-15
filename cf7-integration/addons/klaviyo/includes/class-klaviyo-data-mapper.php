<?php
/**
 * Klaviyo Data Mapper
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/klaviyo/includes
 * @author     Your Company <email@example.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Klaviyo Data Mapper
 */
class CF7_Klaviyo_Data_Mapper {

    /**
     * Map CF7 form data to Klaviyo format
     *
     * @since    1.0.0
     * @param    array    $cf7_data    CF7 form submission data
     * @param    array    $mapping     Field mapping configuration
     * @return   array                 Mapped data for Klaviyo
     */
    public static function map_data($cf7_data, $mapping) {
        $mapped_data = array();

        // Process field mappings
        foreach ($mapping as $cf7_field => $klaviyo_field) {
            if (isset($cf7_data[$cf7_field])) {
                $mapped_data[$klaviyo_field] = $cf7_data[$cf7_field];
            }
        }

        // Handle special cases
        if (isset($cf7_data['your-email'])) {
            $mapped_data['email'] = $cf7_data['your-email'];
        }

        if (isset($cf7_data['your-first-name'])) {
            $mapped_data['first_name'] = $cf7_data['your-first-name'];
        }

        if (isset($cf7_data['your-last-name'])) {
            $mapped_data['last_name'] = $cf7_data['your-last-name'];
        }

        return $mapped_data;
    }

    /**
     * Map CF7 form data to Klaviyo subscriber data
     *
     * @since    1.0.0
     * @param    array    $cf7_data    CF7 form submission data
     * @return   array                 Mapped subscriber data for Klaviyo
     */
    public static function map_subscriber_data($cf7_data) {
        $subscriber_data = array();

        // Map email
        if (isset($cf7_data['your-email'])) {
            $subscriber_data['email'] = $cf7_data['your-email'];
        }

        // Map first name
        if (isset($cf7_data['your-first-name'])) {
            $subscriber_data['first_name'] = $cf7_data['your-first-name'];
        }

        // Map last name
        if (isset($cf7_data['your-last-name'])) {
            $subscriber_data['last_name'] = $cf7_data['your-last-name'];
        }

        // Map phone number
        if (isset($cf7_data['your-phone'])) {
            $subscriber_data['phone_number'] = $cf7_data['your-phone'];
        }

        return $subscriber_data;
    }
}