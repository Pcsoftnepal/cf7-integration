<?php
/**
 * Unit tests for ActiveCampaign addon
 * 
 * @package CF7_Integration
 * @subpackage CF7_Integration/addons/activecampaign/tests
 */

// Ensure this file is not accessed directly
if (!defined('WPINC')) {
    die;
}

/**
 * Test ActiveCampaign addon functionality
 */
class Test_ActiveCampaign_Addon extends WP_UnitTestCase {
    
    public function setUp() {
        parent::setUp();
        // Setup test data
    }
    
    /**
     * Test form data mapping
     * 
     * @covers CF7_ActiveCampaign_Data_Mapper::map_form_data_to_contact
     */
    public function test_form_data_mapping() {
        $mapper = new CF7_ActiveCampaign_Data_Mapper();
        $form_data = array(
            'email' => 'test@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '123-456-7890'
        );
        
        $mapped_data = $mapper->map_form_data_to_contact($form_data);
        
        $this->assertEquals('test@example.com', $mapped_data['email']);
        $this->assertEquals('John', $mapped_data['first_name']);
        $this->assertEquals('Doe', $mapped_data['last_name']);
        $this->assertEquals('123-456-7890', $mapped_data['phone']);
    }
    
    /**
     * Test API client initialization
     * 
     * @covers CF7_ActiveCampaign_API_Client::__construct
     */
    public function test_api_client_initialization() {
        $client = new CF7_ActiveCampaign_API_Client();
        $this->assertInstanceOf('CF7_ActiveCampaign_API_Client', $client);
    }
    
    /**
     * Test field mapping functionality
     * 
     * @covers CF7_ActiveCampaign_Data_Mapper::get_field_mapping
     */
    public function test_field_mapping() {
        $mapper = new CF7_ActiveCampaign_Data_Mapper();
        $form_data = array(
            'email' => 'test@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        );
        
        $mapping = $mapper->get_field_mapping($form_data);
        $this->assertArrayHasKey('email', $mapping);
        $this->assertArrayHasKey('firstName', $mapping);
        $this->assertArrayHasKey('lastName', $mapping);
    }
    
    /**
     * Test that addon can be instantiated
     * 
     * @covers CF7_ActiveCampaign_Addon::__construct
     */
    public function test_addon_instantiation() {
        $addon = new CF7_ActiveCampaign_Addon();
        $this->assertInstanceOf('CF7_ActiveCampaign_Addon', $addon);
    }
}