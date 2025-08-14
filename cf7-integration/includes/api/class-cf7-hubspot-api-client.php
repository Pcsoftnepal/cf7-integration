<?php
/** 
 * Class for handling HubSpot API communications
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/includes
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Class CF7_API_Client
 */
class CF7_API_Client {

    /**
     * HubSpot API base URL
     */
    const BASE_URL = 'https://api.hubapi.com';

    /**
     * HubSpot API version
     */
    const API_VERSION = 'v3';

    /**
     * Initialize the class and set its properties
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Get the HubSpot API endpoint URL
     *
     * @param string $endpoint
     * @return string
     */
    private function get_endpoint_url($endpoint) {
        return self::BASE_URL . '/' . self::API_VERSION . '/' . ltrim($endpoint, '/');
    }

    /**
     * Send data to HubSpot API
     *
     * @param string $endpoint
     * @param array $data
     * @param string $method
     * @return array
     */
    public function send_request($endpoint, $data = array(), $method = 'POST') {
        $api_key = CF7_Settings::get_api_key();
        
        if (empty($api_key)) {
            return array(
                'success' => false,
                'error' => 'HubSpot API key is not configured.'
            );
        }

        $url = $this->get_endpoint_url($endpoint);
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
            ),
            'timeout' => 30,
        );

        if (!empty($data)) {
            $args['body'] = json_encode($data);
        }

        // Perform the HTTP request
        $response = wp_remote_request($url, array_merge($args, array('method' => $method)));

        // Handle errors
        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'error' => 'HTTP request failed: ' . $response->get_error_message()
            );
        }

        // Check response code
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);

        if ($response_code >= 400) {
            return array(
                'success' => false,
                'error' => 'HubSpot API error (' . $response_code . '): ' . $response_body
            );
        }

        // Try to decode JSON response
        $decoded_response = json_decode($response_body, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return array(
                'success' => false,
                'error' => 'Invalid JSON response from HubSpot: ' . json_last_error_msg()
            );
        }

        return array(
            'success' => true,
            'data' => $decoded_response
        );
    }

    /**
     * Create or update a contact in HubSpot (using v3 API)
     *
     * @param array $contact_data
     * @return array
     */
    public function create_or_update_contact($contact_data) {
        // For HubSpot v3 API, we need to use the correct endpoint
        $endpoint = '/crm/v3/objects/contacts';
        $data = array(
            'properties' => $contact_data
        );
        return $this->send_request($endpoint, $data, 'POST');
    }

    /**
     * Add a contact to a HubSpot list
     *
     * @param string $email
     * @param string $list_id
     * @return array
     */
    public function add_contact_to_list($email, $list_id) {
        // For HubSpot v3 API, we need to use the correct endpoint
        $endpoint = '/marketing/v3/subscriptions/contacts/' . $list_id . '/subscribers';
        $data = array(
            'email' => $email
        );
        return $this->send_request($endpoint, $data, 'POST');
    }

    /**
     * Test the HubSpot API connection
     *
     * @return array
     */
    public function test_connection() {
        $endpoint = '/account-information/v3/details';
        $response = $this->send_request($endpoint, array(), 'GET');
        
        if ($response['success']) {
            return array(
                'success' => true,
                'message' => 'Connection to HubSpot API successful'
            );
        } else {
            return array(
                'success' => false,
                'message' => 'Connection to HubSpot API failed: ' . $response['error']
            );
        }
    }
}