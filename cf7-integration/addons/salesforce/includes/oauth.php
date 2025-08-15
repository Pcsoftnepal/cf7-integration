<?php
/**
 * Salesforce OAuth Implementation
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
 * Salesforce OAuth Implementation
 */
class CF7_Salesforce_OAuth {
    
    /**
     * Instance of this class
     */
    protected static $instance = null;

    /**
     * Salesforce consumer key
     */
    protected $consumer_key;

    /**
     * Salesforce consumer secret
     */
    protected $consumer_secret;

    /**
     * Salesforce redirect URI
     */
    protected $redirect_uri;

    /**
     * Constructor
     */
    public function __construct() {
        // Initialize OAuth settings
        $this->initialize_oauth();
    }

    /**
     * Return the instance of this class
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Initialize OAuth settings
     */
    protected function initialize_oauth() {
        // Get settings from the plugin
        $settings = CF7_Salesforce_Settings::get_instance();
        $this->consumer_key = $settings->get_setting('salesforce_consumer_key');
        $this->consumer_secret = $settings->get_setting('salesforce_consumer_secret');
        $this->redirect_uri = admin_url('admin.php?page=cf7-salesforce-settings');
    }

    /**
     * Generate authorization URL
     */
    public function get_authorization_url() {
        $auth_url = 'https://login.salesforce.com/services/oauth2/authorize';
        
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->consumer_key,
            'redirect_uri' => $this->redirect_uri,
            'scope' => 'full'
        );
        
        return add_query_arg($params, $auth_url);
    }

    /**
     * Handle OAuth callback
     */
    public function handle_callback($code) {
        $token_url = 'https://login.salesforce.com/services/oauth2/token';
        
        $args = array(
            'body' => array(
                'grant_type' => 'authorization_code',
                'client_id' => $this->consumer_key,
                'client_secret' => $this->consumer_secret,
                'redirect_uri' => $this->redirect_uri,
                'code' => $code
            )
        );
        
        $response = wp_remote_post($token_url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $token_data = json_decode($body, true);
        
        if (isset($token_data['access_token'])) {
            // Store the tokens in WordPress options
            update_option('cf7_salesforce_access_token', $token_data['access_token']);
            update_option('cf7_salesforce_refresh_token', $token_data['refresh_token']);
            update_option('cf7_salesforce_token_expires', time() + $token_data['expires_in']);
            
            return true;
        }
        
        return false;
    }

    /**
     * Refresh access token
     */
    public function refresh_token() {
        $refresh_token = get_option('cf7_salesforce_refresh_token');
        if (!$refresh_token) {
            return false;
        }
        
        $token_url = 'https://login.salesforce.com/services/oauth2/token';
        
        $args = array(
            'body' => array(
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'client_id' => $this->consumer_key,
                'client_secret' => $this->consumer_secret
            )
        );
        
        $response = wp_remote_post($token_url, $args);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $token_data = json_decode($body, true);
        
        if (isset($token_data['access_token'])) {
            // Update the tokens in WordPress options
            update_option('cf7_salesforce_access_token', $token_data['access_token']);
            update_option('cf7_salesforce_token_expires', time() + $token_data['expires_in']);
            
            return true;
        }
        
        return false;
    }

    /**
     * Get access token
     */
    public function get_access_token() {
        $access_token = get_option('cf7_salesforce_access_token');
        $expires = get_option('cf7_salesforce_token_expires');
        
        // Check if token is expired
        if ($expires && time() > $expires) {
            // Token is expired, try to refresh it
            $this->refresh_token();
            $access_token = get_option('cf7_salesforce_access_token');
        }
        
        return $access_token;
    }

    /**
     * Authorize user with Salesforce
     */
    public function authorize() {
        $auth_url = $this->get_authorization_url();
        wp_redirect($auth_url);
        exit;
    }
}