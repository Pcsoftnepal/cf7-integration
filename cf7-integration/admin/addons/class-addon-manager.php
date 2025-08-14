<?php
/**
 * Admin functionality for addon management
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/admin/addons
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Addon management class
 */
class CF7_Addon_Manager {
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        // Constructor logic here
    }

    /**
     * Get all available addons
     *
     * @since    1.0.0
     * @return   array                  Available addons
     */
    public static function get_available_addons() {
        $addons = array();
        
        // Get addons from the main plugin
        $main_addons = self::get_main_plugin_addons();
        
        // Get addons from external plugins (if any)
        $external_addons = self::get_external_addons();
        
        // Merge all addons
        $addons = array_merge($main_addons, $external_addons);
        
        return $addons;
    }
    
    /**
     * Get addons from the main plugin
     *
     * @since    1.0.0
     * @return   array                  Available addons from main plugin
     */
    private static function get_main_plugin_addons() {
        $addons = array();
        
        // Check for addons directory
        $addons_dir = plugin_dir_path(__DIR__) . 'addons/';
        
        if (is_dir($addons_dir)) {
            $addon_directories = scandir($addons_dir);
            
            foreach ($addon_directories as $addon_dir) {
                if ($addon_dir !== '.' && $addon_dir !== '..') {
                    $addon_file = $addons_dir . $addon_dir . '/' . $addon_dir . '.php';
                    
                    if (file_exists($addon_file)) {
                        $addons[$addon_dir] = array(
                            'name' => ucfirst($addon_dir),
                            'file' => $addon_file,
                            'active' => self::is_addon_active($addon_dir),
                            'source' => 'main_plugin',
                            'plugin' => 'cf7-integration'
                        );
                    }
                }
            }
        }
        
        return $addons;
    }
    
    /**
     * Get addons from external plugins
     *
     * @since    1.0.0
     * @return   array                  Available addons from external plugins
     */
    private static function get_external_addons() {
        $addons = array();
        
        // Allow external plugins to register their addons
        $external_addons = apply_filters('cf7_integration_external_addons', array());
        
        foreach ($external_addons as $addon_name => $addon_info) {
            $addons[$addon_name] = array(
                'name' => $addon_info['name'],
                'file' => $addon_info['file'],
                'active' => self::is_addon_active($addon_name),
                'source' => 'external_plugin',
                'plugin' => $addon_info['plugin']
            );
        }
        
        return $addons;
    }

    /**
     * Check if an addon is active
     *
     * @since    1.0.0
     * @param    string    $addon_name    The addon name
     * @return   bool                     Whether the addon is active
     */
    public static function is_addon_active($addon_name) {
        $active_addons = get_option('cf7_integration_active_addons', array());
        return in_array($addon_name, $active_addons);
    }

    /**
     * Activate an addon
     *
     * @since    1.0.0
     * @param    string    $addon_name    The addon name
     * @return   bool                     Whether the addon was activated
     */
    public static function activate_addon($addon_name) {
        $active_addons = get_option('cf7_integration_active_addons', array());
        
        if (!in_array($addon_name, $active_addons)) {
            $active_addons[] = $addon_name;
            update_option('cf7_integration_active_addons', $active_addons);
            return true;
        }
        
        return false;
    }

    /**
     * Deactivate an addon
     *
     * @since    1.0.0
     * @param    string    $addon_name    The addon name
     * @return   bool                     Whether the addon was deactivated
     */
    public static function deactivate_addon($addon_name) {
        $active_addons = get_option('cf7_integration_active_addons', array());
        
        $key = array_search($addon_name, $active_addons);
        
        if ($key !== false) {
            unset($active_addons[$key]);
            update_option('cf7_integration_active_addons', array_values($active_addons));
            return true;
        }
        
        return false;
    }
    
    /**
     * Load an addon if it exists and is active
     *
     * @since    1.0.0
     * @param    string    $addon_name    The addon name
     * @return   bool                     Whether the addon was loaded successfully
     */
    public static function load_addon($addon_name) {
        // Check if addon is active
        if (!self::is_addon_active($addon_name)) {
            return false;
        }
        
        // Get addon info
        $addons = self::get_available_addons();
        
        if (!isset($addons[$addon_name])) {
            return false;
        }
        
        $addon_info = $addons[$addon_name];
        
        // Load the addon file
        if (file_exists($addon_info['file'])) {
            require_once $addon_info['file'];
            return true;
        }
        
        return false;
    }
    
    /**
     * Get addon information
     *
     * @since    1.0.0
     * @param    string    $addon_name    The addon name
     * @return   array                    Addon information or false if not found
     */
    public static function get_addon_info($addon_name) {
        $addons = self::get_available_addons();
        return isset($addons[$addon_name]) ? $addons[$addon_name] : false;
    }
    
    /**
     * Get all active addons
     *
     * @since    1.0.0
     * @return   array                    Active addons
     */
    public static function get_active_addons() {
        $all_addons = self::get_available_addons();
        $active_addons = array();
        
        foreach ($all_addons as $addon_name => $addon_info) {
            if ($addon_info['active']) {
                $active_addons[$addon_name] = $addon_info;
            }
        }
        
        return $active_addons;
    }
}