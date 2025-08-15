# Mailchimp Addon for Contact Form 7 Integration

This addon enables seamless integration between Contact Form 7 and Mailchimp, allowing you to automatically subscribe users to your Mailchimp lists when they submit forms.

## Features

- Automatic subscription to Mailchimp lists
- Customizable field mapping
- Support for merge fields (first name, last name, phone)
- Logging and debugging capabilities
- OAuth 2.0 authentication support (planned)

## Configuration

1. Navigate to Settings > CF7 Integration
2. Enter your Mailchimp API key
3. Enter your Mailchimp list ID
4. Save the settings

## Field Mapping

By default, the plugin maps the following Contact Form 7 fields to Mailchimp merge fields:

| Contact Form 7 Field | Mailchimp Merge Field |
|----------------------|-----------------------|
| your-email           | EMAIL                 |
| your-first-name      | FNAME                 |
| your-last-name       | LNAME                 |
| your-phone           | PHONE                 |

## Logging

The plugin supports logging for debugging purposes. Enable logging in the settings to capture detailed information about form submissions and API interactions.

## Support

For support, please contact the plugin author or submit an issue on the GitHub repository.