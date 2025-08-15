# Google Spreadsheet Addon

The Google Spreadsheet addon enables you to send form submissions from Contact Form 7 to Google Sheets.

## Features

- Send form data to Google Sheets
- Configure which forms go to which spreadsheets
- Map form fields to spreadsheet columns
- Support for custom ranges
- Logging and error handling

## Setup Instructions

### Prerequisites

Before setting up the Google Spreadsheet addon, you need to:

1. Have a Google account
2. Create a Google Sheet where you want to store the form data
3. Generate a Google Sheets API key

### Creating a Google Sheet

1. Go to [Google Sheets](https://sheets.google.com/)
2. Create a new spreadsheet
3. Note down the Spreadsheet ID from the URL (it's the string between `/d/` and `/edit`)
   
   Example: In `https://docs.google.com/spreadsheets/d/1a2b3c4d5e6f7g8h9i0j/edit#gid=0`, the ID is `1a2b3c4d5e6f7g8h9i0j`

### Generating a Google Sheets API Key

1. Go to the [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google Sheets API
4. Create credentials (API key) for the API
5. Copy the API key for use in the plugin

## Plugin Configuration

1. Navigate to "Contact Form 7" > "Google Spreadsheet Settings"
2. Enter your Google Sheets API key in the "Google Sheets API Key" field
3. Enable the "Enable Google Spreadsheet Integration" checkbox
4. For each Contact Form you want to integrate with Google Sheets:
   - Enable the "Send to Google Sheets" checkbox
   - Enter the Spreadsheet ID
   - Enter the Range (default is "A1")
   - Map your form fields to spreadsheet columns (one per line, format: "form_field_name:sheet_column")

## Field Mapping Format

The field mapping should be in the format: `form_field_name:sheet_column`

Example:
```
your-name:A
your-email:B
subject:C
message:D
```

## Testing

After configuring the plugin, submit a test form to verify that the data is correctly sent to your Google Sheet.

## Troubleshooting

### Common Issues

1. **Data not appearing in Google Sheets**
   - Verify that the Spreadsheet ID is correct
   - Check that the API key is valid
   - Confirm that the form is enabled for Google Sheets integration
   - Ensure the mapping is correct

2. **Authentication Errors**
   - Make sure the API key is correctly entered
   - Confirm that the Google Sheets API is enabled in the Google Cloud Console

3. **Missing Fields in Spreadsheet**
   - Double-check the field mapping format
   - Ensure that the form fields exist in the Contact Form

## Logging

The plugin logs all activities to the WordPress debug log. You can enable debug logging by adding the following to your `wp-config.php` file:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## Support

If you encounter any issues with the Google Spreadsheet addon, please open an issue on the [GitHub repository](https://github.com/pcsoftnepal/cf7-integration/issues).