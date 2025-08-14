<?php
/**
 * Plugin Name:       Contact Form 7 to HubSpot Integration
 * Description:       Integrates Contact Form 7 with HubSpot to send form submissions to HubSpot contacts.
 * Version:           1.0.0
 * Author:            Your Company
 * Author URI:        https://example.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cf7-hubspot-integration
 * Domain Path:       /languages
 *
 * @package           CF7_HubSpot_Integration
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('CF7_HUBSPOT_INTEGRATION_VERSION', '1.0.0');
define('CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CF7_HUBSPOT_INTEGRATION_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main plugin class
 */
class CF7_HubSpot_Integration {

    /**
     * Instance of this class
     */
    protected static $instance = null;

    /**
     * Initialize the plugin
     */
    public function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin
     */
    private function load_dependencies() {
        // Load required files
        require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/oauth/class-cf7-hubspot-oauth.php';
        require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/api/class-cf7-hubspot-api-client.php';
        require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/handlers/class-cf7-hubspot-form-handler.php';
        require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/mappers/class-cf7-hubspot-data-mapper.php';
        require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/mappers/class-cf7-hubspot-custom-field-manager.php';
        require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/logger/class-cf7-hubspot-logger.php';
        require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/settings/class-cf7-hubspot-settings.php';
    }

    /**
     * Register hooks for admin area
     */
    private function define_admin_hooks() {
        // Hook into admin menu to add settings page
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'settings_init'));
        
        // Handle OAuth callback
        add_action('admin_init', array($this, 'handle_oauth_callback'));
    }

    /**
     * Register hooks for public-facing side
     */
    private function define_public_hooks() {
        // Hook into Contact Form 7 submission
        add_action('wpcf7_submit', array($this, 'handle_form_submission'), 10, 2);
    }

    /**
     * Add settings page to admin menu
     */
    public function add_settings_page() {
        add_options_page(
            __('HubSpot Integration', 'cf7-hubspot-integration'),
            __('HubSpot Integration', 'cf7-hubspot-integration'),
            'manage_options',
            'cf7-hubspot-integration',
            array($this, 'settings_page')
        );
    }

    /**
     * Initialize settings
     */
    public function settings_init() {
        register_setting('cf7_hubspot_integration_settings_group', 'cf7_hubspot_client_id');
        register_setting('cf7_hubspot_integration_settings_group', 'cf7_hubspot_client_secret');
        register_setting('cf7_hubspot_integration_settings_group', 'cf7_hubspot_api_key');
        register_setting('cf7_hubspot_integration_settings_group', 'cf7_hubspot_contact_list_id');
        register_setting('cf7_hubspot_integration_settings_group', 'cf7_hubspot_enable_logging');
        register_setting('cf7_hubspot_integration_settings_group', 'cf7_hubspot_debug_mode');
    }

    /**
     * Handle OAuth callback
     */
    public function handle_oauth_callback() {
        if (isset($_GET['page']) && $_GET['page'] === 'cf7-hubspot-integration' && isset($_GET['oauth_callback'])) {
            // Handle OAuth callback
            if (isset($_GET['code'])) {
                $authorization_code = $_GET['code'];
                $redirect_uri = admin_url('admin.php?page=cf7-hubspot-integration&oauth_callback=1');
                
                $token_result = CF7_HubSpot_OAuth::exchange_token($authorization_code, $redirect_uri);
                
                if ($token_result['success']) {
                    // Store the access token
                    update_option('cf7_hubspot_access_token', $token_result['access_token']);
                    update_option('cf7_hubspot_refresh_token', $token_result['refresh_token']);
                    
                    // Redirect back to settings page with success message
                    wp_redirect(admin_url('admin.php?page=cf7-hubspot-integration&settings-updated=true'));
                    exit;
                } else {
                    // Handle error
                    add_action('admin_notices', function() use ($token_result) {
                        echo '<div class="notice notice-error"><p>' . esc_html__('OAuth connection failed:', 'cf7-hubspot-integration') . ' ' . esc_html($token_result['error']) . '</p></div>';
                    });
                }
            } elseif (isset($_GET['disconnect'])) {
                // Disconnect from HubSpot
                delete_option('cf7_hubspot_access_token');
                delete_option('cf7_hubspot_refresh_token');
                
                // Redirect back to settings page
                wp_redirect(admin_url('admin.php?page=cf7-hubspot-integration'));
                exit;
            }
        }
    }

    /**
     * Display settings page
     */
    public function settings_page() {
        include_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'admin/partials/settings-page.php';
    }

    /**
     * Handle form submission
     */
    public function handle_form_submission($form, $result) {
        // Instantiate the form handler and process the submission
        $handler = new CF7_HubSpot_Form_Handler();
        $handler->process_form_submission($form);
    }

    /**
     * Return the plugin instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

/**
 * Begins execution of the plugin
 */
function run_cf7_hubspot_integration() {
    $plugin = new CF7_HubSpot_Integration();
    return $plugin;
}

// Run the plugin
$GLOBALS['cf7_hubspot_integration'] = run_cf7_hubspot_integration();

// Activation and deactivation hooks
register_activation_hook(__FILE__, array('CF7_HubSpot_Integration', 'activate'));
register_deactivation_hook(__FILE__, array('CF7_HubSpot_Integration', 'deactivate'));

// Include the activation and deactivation methods
require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/class-cf7-hubspot-activator.php';
require_once CF7_HUBSPOT_INTEGRATION_PLUGIN_DIR . 'includes/class-cf7-hubspot-deactivator.php';

// Initialize the plugin
add_action('plugins_loaded', array('CF7_HubSpot_Integration', 'get_instance'));