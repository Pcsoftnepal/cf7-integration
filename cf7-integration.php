<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * @link              https://github.com/Pcsoftnepal/cf7-integration
 * @since             1.0.0
 * @package           CF7_Integration
 *
 * @wordpress-plugin
 * Plugin Name:       Contact Form 7 Integration
 * Plugin URI:        https://github.com/Pcsoftnepal/cf7-integration
 * Description:       A WordPress plugin that integrates Contact Form 7 with various services.
 * Version:           1.0.0
 * Author:            PCSoftNepal
 * Author URI:        https://github.com/Pcsoftnepal
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf7-integration
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('CF7_INTEGRATION_VERSION', '1.0.0');
define('CF7_INTEGRATION_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CF7_INTEGRATION_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load the framework
require_once CF7_INTEGRATION_PLUGIN_DIR . 'framework/class-framework-base.php';
require_once CF7_INTEGRATION_PLUGIN_DIR . 'framework/class-framework-loader.php';
require_once CF7_INTEGRATION_PLUGIN_DIR . 'framework/class-framework-admin.php';
require_once CF7_INTEGRATION_PLUGIN_DIR . 'framework/class-framework-public.php';
require_once CF7_INTEGRATION_PLUGIN_DIR . 'admin/addons/class-addon-manager.php';
require_once CF7_INTEGRATION_PLUGIN_DIR . 'admin/addons/handlers.php';
require_once CF7_INTEGRATION_PLUGIN_DIR . 'admin/addons/addon-management.php';

/**
 * The core plugin class
 *
 * @since      1.0.0
 * @package    CF7_Integration
 * @subpackage CF7_Integration/includes
 * @author     PCSoftNepal <info@pcsoftnepal.com>
 */
class CF7_Integration {

    /**
     * The loader that's responsible for maintaining and developing plugin's functionalities.
     *
     * @since    1.0.0
     * @access   protected
     * @var      CF7_Loader    $loader    Maintains and develops the plugin's functionalities.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Initialize the plugin.
     *
     * @since    1.0.0
     */
    public function __construct() {
        $this->plugin_name = 'cf7-integration';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since    1.0.0
     */
    private function load_dependencies() {
        // Framework classes are loaded in the framework base class
    }

    /**
     * Define the admin hooks.
     *
     * @since    1.0.0
     */
    private function define_admin_hooks() {
        $admin = new CF7_Framework_Admin();
        $admin->init();
    }

    /**
     * Define the public hooks.
     *
     * @since    1.0.0
     */
    private function define_public_hooks() {
        $public = new CF7_Framework_Public();
        $public->init();
    }

    /**
     * Run the plugin.
     *
     * @since    1.0.0
     */
    public function run() {
        // Initialize the framework
        $framework = new CF7_Framework('cf7-integration', '1.0.0');
        $framework->run();
    }

    /**
     * The name of the plugin.
     *
     * @since    1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The name of the plugin.
     *
     * @since    1.0.0
     * @return    string    The version of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
}

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_cf7_integration() {
    $plugin = new CF7_Integration();
    $plugin->run();
}
run_cf7_integration();

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('CF7_INTEGRATION_VERSION', '1.0.0');
define('CF7_INTEGRATION_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CF7_INTEGRATION_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main plugin class
 */
class CF7_Integration {

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
        require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/oauth/class-cf7-integration-oauth.php';
        require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/api/class-cf7-integration-api-client.php';
        require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/handlers/class-cf7-integration-form-handler.php';
        require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/mappers/class-cf7-integration-data-mapper.php';
        require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/mappers/class-cf7-integration-custom-field-manager.php';
        require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/logger/class-cf7-integration-logger.php';
        require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/settings/class-cf7-integration-settings.php';
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
            __('HubSpot Integration', 'cf7-integration'),
            __('HubSpot Integration', 'cf7-integration'),
            'manage_options',
            'cf7-integration',
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
        if (isset($_GET['page']) && $_GET['page'] === 'cf7-integration' && isset($_GET['oauth_callback'])) {
            // Handle OAuth callback
            if (isset($_GET['code'])) {
                $authorization_code = $_GET['code'];
                $redirect_uri = admin_url('admin.php?page=cf7-integration&oauth_callback=1');
                
                $token_result = CF7_OAuth::exchange_token($authorization_code, $redirect_uri);
                
                if ($token_result['success']) {
                    // Store the access token
                    update_option('cf7_hubspot_access_token', $token_result['access_token']);
                    update_option('cf7_hubspot_refresh_token', $token_result['refresh_token']);
                    
                    // Redirect back to settings page with success message
                    wp_redirect(admin_url('admin.php?page=cf7-integration&settings-updated=true'));
                    exit;
                } else {
                    // Handle error
                    add_action('admin_notices', function() use ($token_result) {
                        echo '<div class="notice notice-error"><p>' . esc_html__('OAuth connection failed:', 'cf7-integration') . ' ' . esc_html($token_result['error']) . '</p></div>';
                    });
                }
            } elseif (isset($_GET['disconnect'])) {
                // Disconnect from HubSpot
                delete_option('cf7_hubspot_access_token');
                delete_option('cf7_hubspot_refresh_token');
                
                // Redirect back to settings page
                wp_redirect(admin_url('admin.php?page=cf7-integration'));
                exit;
            }
        }
    }

    /**
     * Display settings page
     */
    public function settings_page() {
        include_once CF7_INTEGRATION_PLUGIN_DIR . 'admin/partials/settings-page.php';
    }

    /**
     * Handle form submission
     */
    public function handle_form_submission($form, $result) {
        // Instantiate the form handler and process the submission
        $handler = new CF7_Form_Handler();
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

// Run the plugin
$GLOBALS['cf7_integration'] = run_cf7_integration();

// Activation and deactivation hooks
register_activation_hook(__FILE__, array('CF7_Integration', 'activate'));
register_deactivation_hook(__FILE__, array('CF7_Integration', 'deactivate'));

// Include the activation and deactivation methods
require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/class-cf7-integration-activator.php';
require_once CF7_INTEGRATION_PLUGIN_DIR . 'includes/class-cf7-integration-deactivator.php';

// Initialize the plugin
add_action('plugins_loaded', array('CF7_Integration', 'get_instance'));