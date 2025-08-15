# Klaviyo Addon for Contact Form 7 Integration

This addon enables integration between Contact Form 7 and Klaviyo, allowing you to automatically subscribe users to your Klaviyo lists when they submit forms.

## Features

- Automatic user subscription to Klaviyo lists
- Mapping of form fields to Klaviyo profile attributes
- Logging support for debugging
- Support for email, first name, last name, and phone number fields

## Requirements

- WordPress 5.0 or higher
- Contact Form 7 5.0 or higher
- Klaviyo API key
- Klaviyo list ID

## Installation

1. Upload the Klaviyo addon folder to the `/wp-content/plugins/cf7-integration/addons/klaviyo` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings > CF7 Integration to configure your Klaviyo API key and list ID

## Configuration

After activating the plugin, go to Settings > CF7 Integration and configure the following settings:

- **Klaviyo API Key**: Your Klaviyo API key
- **Klaviyo List ID**: The ID of the list you want to subscribe users to
- **Enable Logging**: Enable/disable logging for debugging purposes

## Usage

1. Create or edit a Contact Form 7 form
2. Configure the form to include fields that match your Klaviyo profile attributes (email, first name, last name, phone number)
3. Submit the form to test the integration

## Support

For support, please contact us at support@example.com or file an issue on our GitHub repository.