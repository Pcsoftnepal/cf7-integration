# Salesforce Addon for CF7 Integration

This addon enables integration between Contact Form 7 and Salesforce, allowing form submissions to be sent directly to your Salesforce instance.

## Features

- OAuth 2.0 authentication with Salesforce
- Mapping of Contact Form 7 fields to Salesforce fields
- Support for various Salesforce objects (Leads, Contacts, Accounts)
- Comprehensive logging for troubleshooting
- Easy configuration through WordPress admin panel

## Installation

1. Upload the `cf7-salesforce` plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to "Contact Form 7" → "Salesforce Settings"
4. Enter your Salesforce Consumer Key and Consumer Secret
5. Click "Save Changes"

## Configuration

### Authentication

To configure the Salesforce addon, you'll need to:

1. Create a Connected App in your Salesforce org
2. Note the Consumer Key and Consumer Secret from the Connected App
3. Enter these credentials in the plugin settings

### Field Mapping

The addon supports mapping of Contact Form 7 fields to Salesforce fields. Common mappings include:

- First Name → FirstName
- Last Name → LastName
- Email → Email
- Phone → Phone
- Company → Company

## Usage

Once configured, any Contact Form 7 form that has the Salesforce integration enabled will automatically send submissions to your Salesforce instance.

## Troubleshooting

### Common Issues

1. **Authentication Failures**: Ensure your Consumer Key and Secret are correct
2. **Field Mapping Errors**: Verify that all required Salesforce fields are mapped
3. **API Limit Exceeded**: Check your Salesforce API limits

### Logging

Enable debug logging in the plugin settings to capture detailed information about the integration process. Logs can be found in the WordPress debug log.

## Support

For support, please contact the plugin developer or file an issue on the GitHub repository.

## Changelog

### 1.0.0
- Initial release