<?php
/**
 * Unit tests for Salesforce addon
 */

// Ensure this is called from WordPress
if (!defined('WPINC')) {
    die;
}

// Include WordPress bootstrap
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

// Test the Salesforce addon functionality
class SalesforceAddonTest {
    
    public function run_tests() {
        echo "<h2>Salesforce Addon Tests</h2>";
        
        // Test 1: Plugin initialization
        $this->test_plugin_initialization();
        
        // Test 2: Settings functionality
        $this->test_settings();
        
        // Test 3: OAuth functionality
        $this->test_oauth();
        
        // Test 4: API client
        $this->test_api_client();
        
        // Test 5: Form handler
        $this->test_form_handler();
        
        // Test 6: Data mapper
        $this->test_data_mapper();
        
        // Test 7: Logger
        $this->test_logger();
    }
    
    private function test_plugin_initialization() {
        echo "<h3>Testing Plugin Initialization</h3>";
        if (class_exists('CF7_Salesforce')) {
            echo "<p style='color: green;'>✓ Plugin class exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Plugin class does not exist</p>";
        }
    }
    
    private function test_settings() {
        echo "<h3>Testing Settings</h3>";
        if (class_exists('CF7_Salesforce_Settings')) {
            $settings = CF7_Salesforce_Settings::get_instance();
            echo "<p style='color: green;'>✓ Settings class exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Settings class does not exist</p>";
        }
    }
    
    private function test_oauth() {
        echo "<h3>Testing OAuth</h3>";
        if (class_exists('CF7_Salesforce_OAuth')) {
            $oauth = CF7_Salesforce_OAuth::get_instance();
            echo "<p style='color: green;'>✓ OAuth class exists</p>";
        } else {
            echo "<p style='color: red;'>✗ OAuth class does not exist</p>";
        }
    }
    
    private function test_api_client() {
        echo "<h3>Testing API Client</h3>";
        if (class_exists('CF7_Salesforce_API_Client')) {
            $api = new CF7_Salesforce_API_Client();
            echo "<p style='color: green;'>✓ API client class exists</p>";
        } else {
            echo "<p style='color: red;'>✗ API client class does not exist</p>";
        }
    }
    
    private function test_form_handler() {
        echo "<h3>Testing Form Handler</h3>";
        if (class_exists('CF7_Salesforce_Form_Handler')) {
            $handler = new CF7_Salesforce_Form_Handler();
            echo "<p style='color: green;'>✓ Form handler class exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Form handler class does not exist</p>";
        }
    }
    
    private function test_data_mapper() {
        echo "<h3>Testing Data Mapper</h3>";
        if (class_exists('CF7_Salesforce_Data_Mapper')) {
            $mapper = new CF7_Salesforce_Data_Mapper();
            echo "<p style='color: green;'>✓ Data mapper class exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Data mapper class does not exist</p>";
        }
    }
    
    private function test_logger() {
        echo "<h3>Testing Logger</h3>";
        if (class_exists('CF7_Salesforce_Logger')) {
            $logger = CF7_Salesforce_Logger::get_logger();
            echo "<p style='color: green;'>✓ Logger class exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Logger class does not exist</p>";
        }
    }
}

// Run the tests if this file is accessed directly
if (basename(__FILE__) == basename($_SERVER["PHP_SELF"])) {
    $test = new SalesforceAddonTest();
    $test->run_tests();
}
?>