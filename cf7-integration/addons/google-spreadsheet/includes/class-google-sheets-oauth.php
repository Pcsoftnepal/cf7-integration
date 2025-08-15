<?php
/**
 * Google Sheets OAuth Client
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
 * Google Sheets OAuth Client
 */
class CF7_Google_Sheets_OAuth {
    
    /**
     * Google Sheets API client ID
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $client_id    Google Sheets API client ID
     */
    private $client_id;

    /**
     * Google Sheets API client secret
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $client_secret    Google Sheets API client secret
     */
    private $client_secret;

    /**
     * Google Sheets API redirect URI
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $redirect_uri    Google Sheets API redirect URI
     */
    private $redirect_uri;

    /**
     * Google Sheets API scopes
     *
     * @since    1.0.0
     * @access   private
     * @var      array    $scopes    Google Sheets API scopes
     */
    private $scopes;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param    string    $client_id    The client ID for Google Sheets
     * @param    string    $client_secret    The client secret for Google Sheets
     * @param    string    $redirect_uri    The redirect URI for Google Sheets
     */
    public function __construct($client_id, $client_secret, $redirect_uri) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
        $this->scopes = array(
            'https://www.googleapis.com/auth/spreadsheets',
            'https://www.googleapis.com/auth/drive.file'
        );
    }

    /**
     * Get the authorization URL
     *
     * @since    1.0.0
     * @return   string    Authorization URL
     */
    public function get_authorization_url() {
        $params = array(
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'scope' => implode(' ', $this->scopes),
            'response_type' => 'code',
            'access_type' => 'offline'
        );

        return 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($params);
    }

    /**
     * Get access token from authorization code
     *
     * @since    1.0.0
     * @param    string    $code    Authorization code
     * @return   WP_Error|array    Access token or error
     */
    public function get_access_token($code) {
        $token_url = 'https://oauth2.googleapis.com/token';
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'grant_type' => 'authorization_code',
            'code' => $code
        );

        $args = array(
            'method' => 'POST',
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ),
            'body' => $params,
            'timeout' => 30,
        );

        $response = wp_remote_post($token_url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $response_code = wp_remote_retrieved_response_code($response);
        if ($response_code >= 400) {
            $response_body = wp_remote_retrieve_body($response);
            return new WP_Error('token_error', 'Failed to get access token: ' . $response_body);
        }

        return json_decode(wp_remote_retrieve_body($response), true);
    }

    /**
     * Refresh access token
     *
     * @since    1.0.0
     * @param    string    $refresh_token    Refresh token
     * @return   WP_Error|array    New access token or error
     */
    public function refresh_access_token($refresh_token) {
        $token_url = 'https://oauth2.googleapis.com/token';
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token'
        );

        $args = array(
            'method' => 'POST',
            'headers' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
            ),
            'body' => $params,
            'timeout' => 30,
        );

        $response = wp_remote_post($token_url, $args);

        if (is_wp_error($response)) {
            return $response;
        }

        $response_code = wp_remote_retrieved_response_code($response);
        if ($response_code >= 400) {
            $response_body = wp_remote_retrieve_body($response);
            return new WP_Error('token_error', 'Failed to refresh access token: ' . $response_body);
        }

        return json_decode(wp_remote_retrieve_body($response), true);
    }
}