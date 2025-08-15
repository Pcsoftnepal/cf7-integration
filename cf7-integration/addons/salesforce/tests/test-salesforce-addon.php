<?php
/**
 * Test file for Salesforce addon
 * 
 * This file tests the basic functionality of the Salesforce addon
 */

// Ensure this is called from WordPress
if (!defined('WPINC')) {
    die;
}

// Test if the Salesforce plugin is loaded
if (!class_exists('CF7_Salesforce')) {
    echo "Salesforce plugin is not loaded correctly.";
    return;
}

// Test the main plugin class
$salesforce = CF7_Salesforce::get_instance();
echo "Salesforce plugin loaded successfully.<br>";

// Test settings
$settings = CF7_Salesforce_Settings::get_instance();
echo "Settings class loaded successfully.<br>";

// Test OAuth
$oauth = CF7_Salesforce_OAuth::get_instance();
echo "OAuth class loaded successfully.<br>";

// Test API client
$api_client = new CF7_Salesforce_API_Client();
echo "API client loaded successfully.<br>";

// Test form handler
$form_handler = new CF7_Salesforce_Form_Handler();
echo "Form handler loaded successfully.<br>";

// Test data mapper
$data_mapper = new CF7_Salesforce_Data_Mapper();
echo "Data mapper loaded successfully.<br>";

// Test logger
$logger = CF7_Salesforce_Logger::get_logger();
echo "Logger loaded successfully.<br>";

echo "All tests completed!";
?>