# Contact Form 7 to HubSpot Integration

A WordPress plugin that integrates Contact Form 7 with HubSpot to send form submissions to HubSpot contacts.

## Features

- Seamless integration with Contact Form 7
- Sends form data to HubSpot as contacts
- Supports adding contacts to HubSpot lists
- Configurable field mappings
- Custom HubSpot field support
- Logging and debugging capabilities
- OAuth 2.0 authentication support

## Installation

1. Upload the plugin files to the `/wp-content/plugins/cf7-hubspot-integration` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Navigate to "Settings" > "HubSpot Integration" to configure the plugin.

## Configuration

### Prerequisites

Before configuring the plugin, you need to set up a HubSpot account and create an app in the HubSpot developer portal.

### Settings

1. Go to "Settings" > "HubSpot Integration"
2. Enter your HubSpot Client ID and Client Secret (obtained from your HubSpot app)
3. Click "Connect to HubSpot" to authenticate via OAuth
4. Configure field mappings between Contact Form 7 fields and HubSpot properties
5. Optionally configure custom HubSpot field mappings
6. Optionally enable logging for debugging purposes
7. Optionally enable debug mode for detailed error information

## Field Mapping

By default, the plugin maps the following Contact Form 7 fields to HubSpot properties:

| Contact Form 7 Field | HubSpot Property |
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

Custom field mappings can be configured in the settings page under the "Custom HubSpot Fields" section.

## Logging

The plugin supports logging for debugging purposes. Enable logging in the settings to capture detailed information about form submissions and API interactions.

## Support

For support, please contact the plugin author or submit an issue on the GitHub repository.

## Changelog

### 1.0.0
*   Initial release