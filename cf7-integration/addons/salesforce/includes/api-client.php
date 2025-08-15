<?php
/**
 * Salesforce API Client
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
 * Salesforce API Client
 */
class CF7_Salesforce_API_Client {

    /**
     * Salesforce instance
     */
    protected $salesforce;

    /**
     * OAuth instance
     */
    protected $oauth;

    /**
     * Constructor
     */
    public function __construct() {
        // Initialize the Salesforce connection
        $this->initialize_salesforce();
    }

    /**
     * Initialize Salesforce connection
     */
    protected function initialize_salesforce() {
        // Get OAuth instance
        $this->oauth = CF7_Salesforce_OAuth::get_instance();
        
        // Check if we have valid tokens
        $access_token = $this->oauth->get_access_token();
        if (!$access_token) {
            // Redirect to OAuth authorization if no valid token
            $this->oauth->authorize();
        }
    }

    /**
     * Make API request to Salesforce
     */
    public function make_request($endpoint, $method = 'GET', $data = array()) {
        $access_token = $this->oauth->get_access_token();
        if (!$access_token) {
            return new WP_Error('no_token', 'No valid access token available.');
        }

        $url = 'https://na52.salesforce.com/services/data/v58.0/' . $endpoint;
        
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ),
            'method' => $method,
        );

        if (!empty($data)) {
            $args['body'] = json_encode($data);
        }

        $response = wp_remote_request($url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body, true);
    }

    /**
     * Get Salesforce instance
     */
    public function get_salesforce() {
        return $this->salesforce;
    }
    
    /**
     * Get OAuth instance
     */
    public function get_oauth() {
        return $this->oauth;
    }
}