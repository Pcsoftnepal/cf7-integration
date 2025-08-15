<?php
/**
 * Test file for Klaviyo addon functionality
 * 
 * This file tests the core functionality of the Klaviyo addon
 */

// Ensure we're in the right environment
if (!defined('ABSPATH')) {
    exit;
}

// Test if the Klaviyo addon is loaded
if (!class_exists('CF7_Klaviyo_Integration')) {
    echo "Error: Klaviyo addon class not found.";
    exit;
}

// Test if the required classes exist
if (!class_exists('CF7_Klaviyo_API_Client')) {
    echo "Error: Klaviyo API client class not found.";
    exit;
}

if (!class_exists('CF7_Klaviyo_Data_Mapper')) {
    echo "Error: Klaviyo data mapper class not found.";
    exit;
}

if (!class_exists('CF7_Klaviyo_Form_Handler')) {
    echo "Error: Klaviyo form handler class not found.";
    exit;
}

echo "All Klaviyo addon components are properly loaded!\n";

// Test basic functionality
$api_key = 'test_api_key';
$client = new CF7_Klaviyo_API_Client($api_key);
echo "Klaviyo API client instantiated successfully.\n";

// Test data mapping
$mapper = new CF7_Klaviyo_Data_Mapper();
$test_data = [
    'your-email' => 'test@example.com',
    'your-first-name' => 'Test',
    'your-last-name' => 'User'
];
$mapped_data = $mapper->map_subscriber_data($test_data);
echo "Data mapping test: ";
print_r($mapped_data);

echo "\nKlaviyo addon test completed successfully!";