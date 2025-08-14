# HubSpot Addon for CF7 Integration

## Overview

The HubSpot addon for CF7 Integration enables seamless integration between Contact Form 7 and HubSpot CRM. This addon allows you to automatically send form submissions to your HubSpot account, creating contacts and tracking conversions.

## Features

- **Automatic Contact Creation**: Creates or updates HubSpot contacts with form submission data
- **Form Mapping**: Maps form fields to HubSpot properties
- **Deal Creation**: Creates deals in HubSpot when specific form conditions are met
- **Custom Property Support**: Supports custom HubSpot properties
- **Error Handling**: Comprehensive error logging and reporting
- **Data Validation**: Validates form data before sending to HubSpot
- **Webhook Integration**: Supports HubSpot webhook notifications

## How It Works

### 1. Form Submission Processing
When a Contact Form 7 form is submitted:
1. The addon intercepts the form submission
2. It validates the form data
3. It maps the form fields to HubSpot properties
4. It sends the data to HubSpot via the HubSpot API

### 2. Contact Management
- Creates new contacts in HubSpot if they don't exist
- Updates existing contacts with new information
- Handles email address conflicts appropriately

### 3. Deal Management
- Creates deals in HubSpot when specific form conditions are met
- Maps form data to deal properties
- Sets deal stage and value based on form inputs

## Installation

1. Install and activate the CF7 Integration plugin
2. Install and activate the HubSpot addon
3. Configure your HubSpot API credentials in the plugin settings
4. Map your form fields to HubSpot properties
5. Save the settings and test the integration

## Configuration

### Required Settings
- **HubSpot API Key**: Your HubSpot API key (found in HubSpot settings)
- **HubSpot Portal ID**: Your HubSpot portal ID
- **Form Field Mappings**: Map Contact Form 7 fields to HubSpot properties

### Optional Settings
- **Enable Debug Mode**: Logs API requests and responses for troubleshooting
- **Contact Creation Mode**: Choose between creating new contacts or updating existing ones
- **Deal Creation**: Enable deal creation based on form submission data

## Field Mapping

The addon supports mapping Contact Form 7 fields to HubSpot properties:

| CF7 Field | HubSpot Property |
|-----------|------------------|
| Name      | firstname, lastname |
| Email     | email |
| Phone     | phone |
| Company   | company |
| Website   | website |

## Usage

### Basic Setup
1. Navigate to the CF7 Integration settings page
2. Select the "HubSpot" addon
3. Enter your HubSpot API credentials
4. Map your form fields to HubSpot properties
5. Save the configuration

### Advanced Usage
- Use conditional logic to determine when to create deals
- Implement custom property mappings for advanced tracking
- Set up webhook notifications for real-time updates

## Troubleshooting

### Common Issues
1. **Authentication Failures**
   - Verify your HubSpot API key is correct
   - Ensure your API key has the necessary permissions

2. **Field Mapping Errors**
   - Check that all required fields are mapped
   - Verify that field names match HubSpot property names

3. **Contact Creation Issues**
   - Confirm that the email field is properly mapped
   - Check for duplicate email addresses in HubSpot

### Logging
Enable debug mode to view detailed logs of API requests and responses. Logs can be found in the WordPress debug log.

## Support

For support with the HubSpot addon, please contact the plugin developers or visit the official documentation site.

## Version History

- **1.0.0**: Initial release with core HubSpot integration
- **1.0.1**: Added support for deal creation
- **1.0.2**: Improved error handling and logging
- **1.0.3**: Enhanced field mapping capabilities