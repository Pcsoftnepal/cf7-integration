<?php
/**
 * Google Sheets OAuth
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
 * Google Sheets OAuth
 */
class CF7_Google_Sheets_OAuth {
    
    /**
     * Google Sheets OAuth endpoints
     */
    const AUTHORIZATION_URL = 'https://accounts.google.com/o/oauth2/auth';
    const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    
    /**
     * Get the authorization URL for Google Sheets
     *
     * @since    1.0.0
     * @param    string    $redirect_uri    The redirect URI for the OAuth flow
     * @return   string
     */
    public static function get_authorization_url($redirect_uri) {
        $client_id = get_option('cf7_google_sheets_client_id', '');
        
        if (empty($client_id)) {
            return '';
        }
        
        $params = array(
            'client_id' => $client_id,
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/spreadsheets',
            'state' => wp_create_nonce('google_sheets_oauth_state')
        );
        
        return self::AUTHORIZATION_URL . '?' . http_build_query($params);
    }
    
    /**
     * Exchange authorization code for access token
     *
     * @since    1.0.0
     * @param    string    $authorization_code
     * @param    string    $redirect_uri
     * @return   array
     */
    public static function exchange_token($authorization_code, $redirect_uri) {
        $client_id = get_option('cf7_google_sheets_client_id', '');
        $client_secret = get_option('cf7_google_sheets_client_secret', '');
        
        if (empty($client_id) || empty($client_secret)) {
            return array(
                'success' => false,
                'error' => 'Google Sheets client credentials not configured.'
            );
        }
        
        $response = wp_remote_post(self::TOKEN_URL, array(
            'body' => array(
                'grant_type' => 'authorization_code',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'code' => $authorization_code
            )
        ));
        
        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'error' => 'Token exchange failed: ' . $response->get_error_message()
            );
        }
        
        $body = wp_remote_retrieve_body($response);
        $token_data = json_decode($body, true);
        
        if (isset($token_data['error'])) {
            return array(
                'success' => false,
                'error' => 'Token exchange failed: ' . $token_data['error']
            );
        }
        
        return array(
            'success' => true,
            'access_token' => $token_data['access_token'],
            'refresh_token' => $token_data['refresh_token'],
            'expires_in' => $token_data['expires_in']
        );
    }
    
    /**
     * Refresh access token
     *
     * @since    1.0.0
     * @param    string    $refresh_token
     * @return   array
     */
    public static function refresh_token($refresh_token) {
        $client_id = get_option('cf7_google_sheets_client_id', '');
        $client_secret = get_option('cf7_google_sheets_client_secret', '');
        
        if (empty($client_id) || empty($client_secret)) {
            return array(
                'success' => false,
                'error' => 'Google Sheets client credentials not configured.'
            );
        }
        
        $response = wp_remote_post(self::TOKEN_URL, array(
            'body' => array(
                'grant_type' => 'refresh_token',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'refresh_token' => $refresh_token
            )
        ));
        
        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'error' => 'Token refresh failed: ' . $response->get_error_message()
            );
        }
        
        $body = wp_remote_retrieve_body($response);
        $token_data = json_decode($body, true);
        
        if (isset($token_data['error'])) {
            return array(
                'success' => false,
                'error' => 'Token refresh failed: ' . $token_data['error']
            );
        }
        
        return array(
            'success' => true,
            'access_token' => $token_data['access_token'],
            'expires_in' => $token_data['expires_in']
        );
    }
    
    /**
     * Get the redirect URI for OAuth callback
     *
     * @since    1.0.0
     * @return   string
     */
    public static function get_redirect_uri() {
        return admin_url('admin.php?page=cf7-google-spreadsheet-settings&oauth_callback=1');
    }
}