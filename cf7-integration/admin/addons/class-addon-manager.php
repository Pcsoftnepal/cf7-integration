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
                            'active' => self::is_addon_active($addon_dir)
                        );
                    }
                }
            }
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
}