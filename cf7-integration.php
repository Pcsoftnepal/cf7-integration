<?php
/**
 * Plugin Name: CF7 Integration
 * Description: Integrates Contact Form 7 with various services like Mailchimp, Klaviyo, ActiveCampaign, and Google Sheets
 * Version: 1.0.0
 * Author: PCSoftNepal
 * Author URI: https://www.pcsoftnepal.com
 * License: GPL2
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin constants
define('CF7_INTEGRATION_VERSION', '1.0.0');

// Include the main plugin class
require_once plugin_dir_path(__FILE__) . 'cf7-integration.php';

// Initialize the plugin
$cf7_integration = new CF7_Integration();

// Hook into the main plugin initialization
add_action('cf7_integration_init', array($cf7_integration, 'init'));

// Register activation hook
register_activation_hook(__FILE__, array($cf7_integration, 'activate'));

// Register deactivation hook
register_deactivation_hook(__FILE__, array($cf7_integration, 'deactivate'));