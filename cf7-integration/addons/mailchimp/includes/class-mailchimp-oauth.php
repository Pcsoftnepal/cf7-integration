<?php
/**
 * Mailchimp OAuth Client
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
 * Mailchimp OAuth Client
 */
class CF7_Mailchimp_OAuth {
    
    /**
     * Mailchimp OAuth URL
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $oauth_url    Mailchimp OAuth URL
     */
    private $oauth_url;
    
    /**
     * Mailchimp Client ID
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $client_id    Mailchimp Client ID
     */
    private $client_id;
    
    /**
     * Mailchimp Client Secret
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $client_secret    Mailchimp Client Secret
     */
    private $client_secret;
    
    /**
     * Mailchimp Redirect URI
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $redirect_uri    Mailchimp Redirect URI
     */
    private $redirect_uri;
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $client_id       The Client ID for Mailchimp
     * @param    string    $client_secret   The Client Secret for Mailchimp
     * @param    string    $redirect_uri    The Redirect URI for Mailchimp
     */
    public function __construct($client_id, $client_secret, $redirect_uri) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->oauth_url = 'https://login.mailchimp.com/oauth2';
    }
    
    /**
     * Get the authorization URL
     *
     * @since    1.0.0
     * @return   string    Authorization URL
     */
    public function get_authorization_url() {
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'scope' => 'list:read'
        );
        
        return $this->oauth_url . '/authorize?' . http_build_query($params);
    }
    
    /**
     * Exchange authorization code for access token
     *
     * @since    1.0.0
     * @param    string    $authorization_code    Authorization code
     * @return   array    Token response
     */
    public function exchange_token($authorization_code) {
        $args = array(
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ),
            'body' => array(
                'grant_type' => 'authorization_code',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $authorization_code,
                'redirect_uri' => $this->redirect_uri
            ),
            'timeout' => 30,
        );
        
        $response = wp_remote_post($this->oauth_url . '/token', $args);
        
        if (is_wp_error($response)) {
            return array('success' => false, 'error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $token_data = json_decode($body, true);
        
        if (isset($token_data['error'])) {
            return array('success' => false, 'error' => $token_data['error']);
        }
        
        return array('success' => true, 'access_token' => $token_data['access_token'], 'expires_in' => $token_data['expires_in']);
    }
    
    /**
     * Refresh access token
     *
     * @since    1.0.0
     * @param    string    $refresh_token    Refresh token
     * @return   array    Token response
     */
    public function refresh_token($refresh_token) {
        $args = array(
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ),
            'body' => array(
                'grant_type' => 'refresh_token',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'refresh_token' => $refresh_token
            ),
            'timeout' => 30,
        );
        
        $response = wp_remote_post($this->oauth_url . '/token', $args);
        
        if (is_wp_error($response)) {
            return array('success' => false, 'error' => $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $token_data = json_decode($body, true);
        
        if (isset($token_data['error'])) {
            return array('success' => false, 'error' => $token_data['error']);
        }
        
        return array('success' => true, 'access_token' => $token_data['access_token'], 'expires_in' => $token_data['expires_in']);
    }
}