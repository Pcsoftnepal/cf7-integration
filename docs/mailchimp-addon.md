# Mailchimp Addon Documentation

## Overview

The Mailchimp addon for Contact Form 7 Integration allows you to seamlessly connect your Contact Form 7 forms with Mailchimp lists. When users submit a form, their information is automatically added to your Mailchimp mailing list.

## Installation

1. Install and activate the Contact Form 7 Integration plugin
2. Navigate to the Mailchimp addon settings page
3. Enter your Mailchimp Client ID and Client Secret
4. Connect to Mailchimp using OAuth 2.0
5. Select your Mailchimp list ID
6. Configure field mappings as needed

## Configuration

### Client ID and Client Secret

To get your Mailchimp API credentials:
1. Log into your Mailchimp account
2. Go to Account > Extras > API keys
3. Click "Create App" to create a new app
4. Enter the app name and description
5. In the "OAuth 2.0" section, enter the redirect URI: `http://yourdomain.com/wp-admin/admin.php?page=cf7-integration`
6. Copy the Client ID and Client Secret and paste them into the plugin settings

### List ID

To get your Mailchimp List ID:
1. Log into your Mailchimp account
2. Go to Lists > Your List
3. Click "Settings" > "List name and defaults"
4. Copy the List ID from the URL (it's in the format `xxxxxxxxx`)

## Field Mapping

By default, the plugin maps the following Contact Form 7 fields to Mailchimp merge fields:

| Contact Form 7 Field | Mailchimp Merge Field |
|----------------------|-----------------------|
| your-email           | EMAIL                 |
| your-first-name      | FNAME                 |
| your-last-name       | LNAME                 |
| your-phone           | PHONE                 |

You can customize these mappings in the plugin settings.

## Logging

The plugin supports logging for debugging purposes. Enable logging in the settings to capture detailed information about form submissions and API interactions.

## Troubleshooting

### Common Issues

1. **Authentication Failed**: Make sure your Client ID and Client Secret are correct
2. **List Not Found**: Verify that your List ID is correct and the list exists in your Mailchimp account
3. **Missing Email Address**: Ensure that the email field in your form is named `your-email`

### Support

If you encounter any issues, please submit a bug report on the GitHub repository or contact the plugin author.