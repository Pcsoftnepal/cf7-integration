<?php
/**
 * Mailchimp API Client
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/mailchimp/includes
 * @author     PCSoftNepal <info@pcsoftnepal.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Mailchimp API Client
 */
class CF7_Mailchimp_API_Client {
    
    /**
     * Mailchimp API key
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $api_key    Mailchimp API key
     */
    private $api_key;

    /**
     * Mailchimp REST API endpoint
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $api_endpoint    Mailchimp REST API endpoint
     */
    private $api_endpoint;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $api_key    The API key for Mailchimp
     */
    public function __construct($api_key) {
        $this->api_key = $api_key;
        $this->api_endpoint = $this->get_api_endpoint();
    }

    /**
     * Get the API endpoint based on the API key
     *
     * @since    1.0.0
     * @return   string    API endpoint URL
     */
    private function get_api_endpoint() {
        // Extract the server prefix from the API key
        $key_parts = explode('-', $this->api_key);
        $server_prefix = isset($key_parts[1]) ? $key_parts[1] : 'us1';
        
        return 'https://' . $server_prefix . '.api.mailchimp.com/3.0';
    }

    /**
     * Send data to Mailchimp
     *
     * @since    1.0.0
     * @param    array    $data    Data to send to Mailchimp
     * @return   WP_Error|array    Response from Mailchimp API
     */
    public function send_data($data) {
        // Validate API key
        if (empty($this->api_key)) {
            return new WP_Error('missing_api_key', 'Mailchimp API key is missing.');
        }

        // Set up the request
        $args = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode('user:' . $this->api_key),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ),
            'body' => json_encode($data),
            'timeout' => 30,
        );

        // Send the request
        $response = wp_remote_post($this->api_endpoint . '/lists/', $args);

        // Handle errors
        if (is_wp_error($response)) {
            return $response;
        }

        // Check response code
        $response_code = wp_remote_retrieved_response_code($response);
        if ($response_code >= 400) {
            $response_body = wp_remote_retrieve_body($response);
            return new WP_Error('api_error', 'Mailchimp API error: ' . $response_body);
        }

        // Return successful response
        return json_decode(wp_remote_retrieve_body($response), true);
    }

    /**
     * Subscribe a user to a list
     *
     * @since    1.0.0
     * @param    array    $subscriber_data    Subscriber data
     * @param    string   $list_id            The Mailchimp list ID
     * @return   WP_Error|array                 Response from Mailchimp API
     */
    public function subscribe_to_list($subscriber_data, $list_id) {
        // Validate required fields
        if (empty($subscriber_data['email'])) {
            return new WP_Error('missing_email', 'Email is required for subscription.');
        }

        // Construct the payload
        $payload = array(
            'email_address' => $subscriber_data['email'],
            'status' => 'subscribed',
            'merge_fields' => array()
        );

        // Add additional attributes if provided
        if (isset($subscriber_data['first_name'])) {
            $payload['merge_fields']['FNAME'] = $subscriber_data['first_name'];
        }
        if (isset($subscriber_data['last_name'])) {
            $payload['merge_fields']['LNAME'] = $subscriber_data['last_name'];
        }
        if (isset($subscriber_data['phone'])) {
            $payload['merge_fields']['PHONE'] = $subscriber_data['phone'];
        }

        // Send to Mailchimp
        $response = $this->send_data($payload);
        
        return $response;
    }
}