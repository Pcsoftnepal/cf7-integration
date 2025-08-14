<?php
/**
 * ActiveCampaign API Client
 * 
 * @package CF7_Integration
 * @subpackage CF7_Integration/addons/activecampaign/includes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ActiveCampaign API Client
 * 
 * Handles communication with the ActiveCampaign API
 */
class CF7_ActiveCampaign_API_Client {
    
    /**
     * ActiveCampaign API URL
     * 
     * @since 1.0.0
     * @var string
     */
    private $api_url = 'https://your-account.api-us1.com';
    
    /**
     * ActiveCampaign API Key
     * 
     * @since 1.0.0
     * @var string
     */
    private $api_key;
    
    /**
     * Initialize the API client
     * 
     * @since 1.0.0
     */
    public function __construct() {
        $this->api_key = get_option('cf7_activecampaign_api_key', '');
        $this->api_url = get_option('cf7_activecampaign_api_url', $this->api_url);
    }
    
    /**
     * Make an API request to ActiveCampaign
     * 
     * @since 1.0.0
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @param string $method HTTP method
     * @return array API response
     */
    public function make_request($endpoint, $data = array(), $method = 'POST') {
        $url = $this->api_url . '/api/3/' . $endpoint;
        
        $args = array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Api_l' => $this->api_key
            ),
            'timeout' => 30,
            'body' => json_encode($data)
        );
        
        switch ($method) {
            case 'GET':
                $url .= '?' . http_build_query($data);
                $response = wp_remote_get($url, $args);
                break;
            case 'POST':
                $response = wp_remote_post($url, $args);
                break;
            case 'PUT':
                $args['method'] = 'PUT';
                $response = wp_remote_request($url, $args);
                break;
            case 'DELETE':
                $args['method'] = 'DELETE';
                $response = wp_remote_request($url, $args);
                break;
            default:
                $response = wp_remote_post($url, $args);
        }
        
        if (is_wp_error($response)) {
            return array('error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }
    
    /**
     * Get all lists from ActiveCampaign
     * 
     * @since 1.0.0
     * @return array Lists
     */
    public function get_lists() {
        return $this->make_request('lists', array(), 'GET');
    }
    
    /**
     * Add a contact to a list
     * 
     * @since 1.0.0
     * @param int $list_id List ID
     * @param array $contact Contact data
     * @return array API response
     */
    public function add_contact_to_list($list_id, $contact) {
        $data = array(
            'contact' => array(
                'email' => $contact['email'],
                'firstName' => $contact['first_name'],
                'lastName' => $contact['last_name'],
                'phone' => $contact['phone']
            )
        );
        
        return $this->make_request("lists/{$list_id}/contacts", $data, 'POST');
    }
    
    /**
     * Get contact by email
     * 
     * @since 1.0.0
     * @param string $email Contact email
     * @return array API response
     */
    public function get_contact_by_email($email) {
        $params = array(
            'email=' . $email
        );
        
        return $this->make_request('contacts?' . implode('&', $params), array(), 'GET');
    }
    
    /**
     * Update an existing contact
     * 
     * @since 1.0.0
     * @param int $contact_id Contact ID
     * @param array $contact Contact data
     * @return array API response
     */
    public function update_contact($contact_id, $contact) {
        $data = array(
            'contact' => array(
                'email' => $contact['email'],
                'firstName' => $contact['first_name'],
                'lastName' => $contact['last_name'],
                'phone' => $contact['phone']
            )
        );
        
        return $this->make_request("contacts/{$contact_id}", $data, 'PUT');
    }
    
    /**
     * Add a tag to a contact
     * 
     * @since 1.0.0
     * @param int $contact_id Contact ID
     * @param int $tag_id Tag ID
     * @return array API response
     */
    public function add_tag_to_contact($contact_id, $tag_id) {
        $data = array(
            'contactTag' => array(
                'contact' => $contact_id,
                'tag' => $tag_id
            )
        );
        
        return $this->make_request('contactTags', $data, 'POST');
    }
}