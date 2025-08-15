<?php
/**
 * Google Sheets API Client
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
 * Google Sheets API Client
 */
class CF7_Google_Sheets_API_Client {
    
    /**
     * Google Sheets API key
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $api_key    Google Sheets API key
     */
    private $api_key;

    /**
     * Google Sheets REST API endpoint
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $api_endpoint    Google Sheets REST API endpoint
     */
    private $api_endpoint;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $api_key    The API key for Google Sheets
     */
    public function __construct($api_key) {
        $this->api_key = $api_key;
        $this->api_endpoint = 'https://sheets.googleapis.com/v4/spreadsheets';
    }

    /**
     * Send data to Google Sheets
     *
     * @since    1.0.0
     * @param    array    $data    Data to send to Google Sheets
     * @param    string   $spreadsheet_id    The Google Sheets ID
     * @param    string   $range    The range in the sheet to update
     * @return   WP_Error|array    Response from Google Sheets API
     */
    public function send_data($data, $spreadsheet_id, $range) {
        // Validate API key
        if (empty($this->api_key)) {
            return new WP_Error('missing_api_key', 'Google Sheets API key is missing.');
        }

        // Set up the request
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ),
            'body' => json_encode($data),
            'timeout' => 30,
        );

        // Send the request
        $response = wp_remote_post($this->api_endpoint . '/' . $spreadsheet_id . '/values/' . $range . '?key=' . $this->api_key, $args);

        // Handle errors
        if (is_wp_error($response)) {
            return $response;
        }

        // Check response code
        $response_code = wp_remote_retrieved_response_code($response);
        if ($response_code >= 400) {
            $response_body = wp_remote_retrieve_body($response);
            return new WP_Error('api_error', 'Google Sheets API error: ' . $response_body);
        }

        // Return successful response
        return json_decode(wp_remote_retrieve_body($response), true);
    }
}