<?php
/**
 * Plugin Framework Base Class
 * 
 * This is the base class for the plugin framework that will allow for addons
 * 
 * @package    CF7_Integration
 * @subpackage CF7_Integration/framework
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Main plugin framework class
 */
class CF7_Framework {
    
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
     * The plugin directory path.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_dir    The plugin directory path.
     */
    protected $plugin_dir;

    /**
     * The plugin directory URL.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_url    The plugin directory URL.
     */
    protected $plugin_url;

    /**
     * Initialize the framework
     *
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->plugin_dir = plugin_dir_path(__FILE__);
        $this->plugin_url = plugin_dir_url(__FILE__);
    }

    /**
     * Register all of the hooks related to the plugin.
     *
     * @since    1.0.0
     */
    public function run() {
        // Hook into WordPress
        add_action('plugins_loaded', array($this, 'init_framework'));
    }

    /**
     * Initialize the framework
     *
     * @since    1.0.0
     */
    public function init_framework() {
        // Load framework classes
        $this->load_framework_classes();
        
        // Load addons
        $this->load_addons();
    }

    /**
     * Load framework classes
     *
     * @since    1.0.0
     */
    protected function load_framework_classes() {
        // Framework base classes
        require_once $this->plugin_dir . 'class-framework-loader.php';
        require_once $this->plugin_dir . 'class-framework-admin.php';
        require_once $this->plugin_dir . 'class-framework-public.php';
    }

    /**
     * Load addons
     *
     * @since    1.0.0
     */
    protected function load_addons() {
        // Check for addons directory
        $addons_dir = $this->plugin_dir . '../addons/';
        
        if (is_dir($addons_dir)) {
            $addons = scandir($addons_dir);
            
            foreach ($addons as $addon) {
                if ($addon !== '.' && $addon !== '..') {
                    $addon_path = $addons_dir . $addon . '/' . $addon . '.php';
                    
                    if (file_exists($addon_path)) {
                        require_once $addon_path;
                    }
                }
            }
        }
    }

    /**
     * Get the plugin name
     *
     * @since    1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * Get the plugin version
     *
     * @since    1.0.0
     * @return    string    The version of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * Get the plugin directory path
     *
     * @since    1.0.0
     * @return    string    The directory path of the plugin.
     */
    public function get_plugin_dir() {
        return $this->plugin_dir;
    }

    /**
     * Get the plugin directory URL
     *
     * @since    1.0.0
     * @return    string    The directory URL of the plugin.
     */
    public function get_plugin_url() {
        return $this->plugin_url;
    }
}