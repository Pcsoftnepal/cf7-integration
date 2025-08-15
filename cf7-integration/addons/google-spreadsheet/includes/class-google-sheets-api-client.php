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
     * Google Sheets access token
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $access_token    Google Sheets access token
     */
    private $access_token;

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
     * @param    string    $access_token    The access token for Google Sheets
     */
    public function __construct($access_token) {
        $this->access_token = $access_token;
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
        // Validate access token
        if (empty($this->access_token)) {
            return new WP_Error('missing_access_token', 'Google Sheets access token is missing.');
        }

        // Set up the request
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->access_token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ),
            'body' => json_encode($data),
            'timeout' => 30,
        );

        // Send the request
        $response = wp_remote_post($this->api_endpoint . '/' . $spreadsheet_id . '/values/' . $range, $args);

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