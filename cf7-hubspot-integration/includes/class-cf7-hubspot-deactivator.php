<?php
/**
 * Fired during plugin deactivation
 *
 * @package    CF7_HubSpot_Integration
 * @subpackage CF7_HubSpot_Integration/includes
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 */
class CF7_HubSpot_Deactivator {

    /**
     * Deactivate the plugin
     *
     * @since    1.0.0
     */
    public static function deactivate() {
        // Cleanup any transients, data, etc. that can be cleaned up
        // No specific cleanup needed for this plugin
    }
}