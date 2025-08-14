# ActiveCampaign Addon for CF7 Integration

## Overview

The ActiveCampaign addon for CF7 Integration enables seamless integration between Contact Form 7 and ActiveCampaign. This addon allows you to automatically send form submissions to your ActiveCampaign account, creating or updating contacts and managing subscriptions.

## Features

- **Automatic Contact Creation**: Creates or updates ActiveCampaign contacts with form submission data
- **Form Field Mapping**: Maps Contact Form 7 fields to ActiveCampaign properties
- **List Subscription**: Subscribes contacts to specified ActiveCampaign lists
- **Tag Management**: Adds custom tags to contacts for segmentation
- **Error Handling**: Comprehensive error logging and reporting
- **Data Validation**: Validates form data before sending to ActiveCampaign
- **Webhook Integration**: Supports ActiveCampaign webhook notifications
- **Debug Mode**: Detailed logging for troubleshooting

## How It Works

### 1. Form Submission Processing
When a Contact Form 7 form is submitted:
1. The addon intercepts the form submission
2. It validates the form data
3. It maps the form fields to ActiveCampaign properties
4. It sends the data to ActiveCampaign via the ActiveCampaign API

### 2. Contact Management
- Creates new contacts in ActiveCampaign if they don't exist
- Updates existing contacts with new information
- Handles email address conflicts appropriately

### 3. List Management
- Subscribes contacts to specified ActiveCampaign lists
- Manages contact preferences and subscription status

## Installation

1. Install and activate the CF7 Integration plugin
2. Install and activate the ActiveCampaign addon
3. Configure your ActiveCampaign API credentials in the plugin settings
4. Map your form fields to ActiveCampaign properties
5. Save the settings and test the integration

## Configuration

### Required Settings
- **ActiveCampaign API Key**: Your ActiveCampaign API key (found in ActiveCampaign settings)
- **ActiveCampaign API URL**: Your ActiveCampaign API URL (usually ends with .api-us1.com)
- **ActiveCampaign List ID**: The list ID to subscribe contacts to
- **Form Field Mappings**: Map Contact Form 7 fields to ActiveCampaign properties

### Optional Settings
- **Enable Debug Mode**: Logs API requests and responses for troubleshooting
- **Enable Logging**: Enables detailed logging of sync operations
- **Contact Creation Mode**: Choose between creating new contacts or updating existing ones
- **Tag Management**: Add custom tags to contacts for segmentation

## Field Mapping

The addon supports mapping Contact Form 7 fields to ActiveCampaign properties:

| CF7 Field | ActiveCampaign Property |
|-----------|-------------------------|
| Name      | firstName, lastName |
| Email     | email |
| Phone     | phone |
| Company   | company |
| Website   | website |

## Usage

### Basic Setup
1. Navigate to the CF7 Integration settings page
2. Select the "ActiveCampaign" addon
3. Enter your ActiveCampaign API credentials
4. Map your form fields to ActiveCampaign properties
5. Save the configuration

### Advanced Usage
- Use conditional logic to determine when to subscribe to lists
- Implement custom property mappings for advanced tracking
- Set up webhook notifications for real-time updates

## Troubleshooting

### Common Issues
1. **Authentication Failures**
   - Verify your ActiveCampaign API key is correct
   - Ensure your API key has the necessary permissions

2. **Field Mapping Errors**
   - Check that all required fields are mapped
   - Verify that field names match ActiveCampaign property names

3. **Contact Creation Issues**
   - Confirm that the email field is properly mapped
   - Check for duplicate email addresses in ActiveCampaign

### Logging
Enable debug mode to view detailed logs of API requests and responses. Logs can be found in the WordPress debug log.

## Testing

### Unit Tests

The ActiveCampaign addon includes unit tests to ensure proper functionality:

#### Test Suite Structure
```
tests/
├── unit-tests/
│   └── test-activecampaign-addon.php
```

#### Sample Test Cases
```php
<?php
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
     */
    public function test_api_client_initialization() {
        $client = new CF7_ActiveCampaign_API_Client();
        $this->assertInstanceOf('CF7_ActiveCampaign_API_Client', $client);
    }
}
```

### Running Tests
To run the unit tests, execute the following command in your terminal:
```bash
cd /path/to/wp-content/plugins/cf7-integration
phpunit tests/unit-tests/test-activecampaign-addon.php
```

## Support

For support with the ActiveCampaign addon, please contact the plugin developers or visit the official documentation site.

## Version History

- **1.0.0**: Initial release with core ActiveCampaign integration
- **1.0.1**: Added support for list subscription and tagging
- **1.0.2**: Improved error handling and logging
- **1.0.3**: Enhanced field mapping capabilities
- **1.0.4**: Added unit testing framework