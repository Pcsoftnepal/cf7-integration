# Klaviyo Addon Documentation

## Overview

The Klaviyo addon for Contact Form 7 Integration allows you to seamlessly connect your Contact Form 7 forms with Klaviyo, enabling automatic user subscription to your Klaviyo lists when they submit forms.

## Installation

1. Navigate to the `cf7-integration/addons/klaviyo` directory in your plugin folder
2. Upload the Klaviyo addon files
3. Activate the plugin in WordPress admin panel
4. Configure the plugin settings in Settings > CF7 Integration

## Configuration

### Required Settings

1. **Klaviyo API Key**
   - Obtain your API key from your Klaviyo account
   - This key is required for authenticating requests to the Klaviyo API

2. **Klaviyo List ID**
   - Obtain the list ID from your Klaviyo account
   - This identifies which list users will be subscribed to

3. **Enable Logging (optional)**
   - When enabled, logs will be created to help debug integration issues

## Usage

### Form Setup

When creating a Contact Form 7 form, make sure to include fields that match Klaviyo's expected profile attributes:

- `your-email` - Required for subscription
- `your-first-name` - Optional
- `your-last-name` - Optional
- `your-phone` - Optional

Example form structure:
```
[text* your-email placeholder "Email Address"]
[text your-first-name placeholder "First Name"]
[text your-last-name placeholder "Last Name"]
[phone your-phone placeholder "Phone Number"]
[submit "Subscribe"]
```

### Mapping Fields

The addon automatically maps the following Contact Form 7 fields to Klaviyo profile attributes:
- `your-email` → `email`
- `your-first-name` → `first_name` 
- `your-last-name` → `last_name`
- `your-phone` → `phone_number`

## Logging

When enabled, logging will record:
- Successful subscriptions
- API errors
- Missing data issues
- Any other events related to the Klaviyo integration

Log files can be found in the standard WordPress log directory.

## Troubleshooting

### Common Issues

1. **Missing API Key or List ID**
   - Solution: Ensure you've entered valid credentials in the settings

2. **Subscription Fails**
   - Solution: Check if logging is enabled to see detailed error messages

3. **Missing Email Address**
   - Solution: Ensure your form contains a field named `your-email`

4. **Authentication Errors**
   - Solution: Verify your Klaviyo API key is correct and has the appropriate permissions

## API Reference

### Endpoints

The addon uses the Klaviyo REST API v2 endpoints:
- POST `/api/profile/` - Create or update a profile

### Payload Structure

```json
{
  "data": {
    "type": "profile",
    "attributes": {
      "email": "user@example.com",
      "first_name": "John",
      "last_name": "Doe",
      "phone_number": "+1234567890"
    }
  }
}
```

## Support

If you encounter any issues with the Klaviyo addon, please check the logs first, then contact support or file an issue on our GitHub repository.