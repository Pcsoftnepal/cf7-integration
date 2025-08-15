<?php
/** 
 * Klaviyo API Client
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
 * Klaviyo API Client
 */
class CF7_Klaviyo_API_Client {
    
    /**
     * Klaviyo API key
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $api_key    Klaviyo API key
     */
    private $api_key;

    /**
     * Klaviyo REST API endpoint
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $api_endpoint    Klaviyo REST API endpoint
     */
    private $api_endpoint;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $api_key    The API key for Klaviyo
     */
    public function __construct($api_key) {
        $this->api_key = $api_key;
        $this->api_endpoint = 'https://a.klaviyo.com/api';
    }

    /**
     * Send data to Klaviyo
     *
     * @since    1.0.0
     * @param    array    $data    Data to send to Klaviyo
     * @return   WP_Error|array    Response from Klaviyo API
     */
    public function send_data($data) {
        // Validate API key
        if (empty($this->api_key)) {
            return new WP_Error('missing_api_key', 'Klaviyo API key is missing.');
        }

        // Set up the request
        $args = array(
            'headers' => array(
                'Authorization' => 'Klaviyo-Header ' . $this->api_key,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ),
            'body' => json_encode($data),
            'timeout' => 30,
        );

        // Send the request
        $response = wp_remote_post($this->api_endpoint . '/profile/', $args);

        // Handle errors
        if (is_wp_error($response)) {
            return $response;
        }

        // Check response code
        $response_code = wp_remote_retrieved_response_code($response);
        if ($response_code >= 400) {
            $response_body = wp_remote_retrieve_body($response);
            return new WP_Error('api_error', 'Klaviyo API error: ' . $response_body);
        }

        // Return successful response
        return json_decode(wp_remote_retrieve_body($response), true);
    }

    /**
     * Subscribe a user to a list
     *
     * @since    1.0.0
     * @param    array    $subscriber_data    Subscriber data
     * @return   WP_Error|array                 Response from Klaviyo API
     */
    public function subscribe_to_list($subscriber_data) {
        // Validate required fields
        if (empty($subscriber_data['email'])) {
            return new WP_Error('missing_email', 'Email is required for subscription.');
        }

        // Construct the payload
        $payload = array(
            'data' => array(
                'type' => 'profile',
                'attributes' => array(
                    'email' => $subscriber_data['email'],
                )
            )
        );

        // Add additional attributes if provided
        if (isset($subscriber_data['first_name'])) {
            $payload['data']['attributes']['first_name'] = $subscriber_data['first_name'];
        }
        if (isset($subscriber_data['last_name'])) {
            $payload['data']['attributes']['last_name'] = $subscriber_data['last_name'];
        }
        if (isset($subscriber_data['phone_number'])) {
            $payload['data']['attributes']['phone_number'] = $subscriber_data['phone_number'];
        }

        // Send to Klaviyo
        return $this->send_data($payload);
    }
}