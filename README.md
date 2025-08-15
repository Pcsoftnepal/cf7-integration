# Contact Form 7 Integration

A WordPress plugin that integrates Contact Form 7 with various services.

## Features

- Seamless integration with Contact Form 7
- Sends form data to external services as contacts
- Supports adding contacts to external services lists
- Configurable field mappings
- Custom field support
- Modular framework for easy addon development
- Logging and debugging capabilities
- OAuth 2.0 authentication support
- Klaviyo integration addon

## Installation

1. Upload the plugin files to the `/wp-content/plugins/cf7-integration` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to "Settings" > "Contact Form 7 Integration" to configure the plugin.

## Configuration

### Prerequisites

Before configuring the plugin, you need to set up a service account and create an app in the service developer portal.

### Settings

1. Go to "Settings" > "Contact Form 7 Integration"
2. Enter your service Client ID and Client Secret (obtained from your service app)
3. Click "Connect to service" to authenticate via OAuth
4. Configure field mappings between Contact Form 7 fields and service properties
5. Optionally configure custom field mappings
6. Optionally enable logging for debugging purposes
7. Optionally enable debug mode for detailed error information

## Field Mapping

By default, the plugin maps the following Contact Form 7 fields to service properties:

| Contact Form 7 Field | Service Property |
|---------------------|------------------|
| email               | email            |
| first_name          | firstname        |
| last_name           | lastname         |
| phone               | phone            |
| company             | company          |
| website             | website          |
| address             | address          |
| city                | city             |
| state               | state            |
| zip                 | zip              |
| country             | country          |

Custom field mappings can be configured in the settings page under the "Custom Fields" section.

## Logging

The plugin supports logging for debugging purposes. Enable logging in the settings to capture detailed information about form submissions and API interactions.

## Addons

### Klaviyo

The Klaviyo addon allows you to automatically subscribe users to your Klaviyo lists when they submit Contact Form 7 forms.

#### Configuration

1. Navigate to Settings > CF7 Integration
2. Enter your Klaviyo API key
3. Enter your Klaviyo list ID
4. Save the settings

## Support

For support, please contact the plugin author or submit an issue on the GitHub repository.

## Changelog

### 1.0.0
*   Initial release