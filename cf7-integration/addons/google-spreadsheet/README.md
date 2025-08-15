# Google Spreadsheet Integration for Contact Form 7

This addon allows you to send form submissions from Contact Form 7 to Google Sheets.

## Features

- Send form data to Google Sheets
- Configure which forms go to which spreadsheets
- Map form fields to spreadsheet columns
- Support for custom ranges
- Logging and error handling

## Installation

1. Upload the plugin files to the `/wp-content/plugins/cf7-integration/addons/google-spreadsheet` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to "Contact Form 7" > "Google Spreadsheet Settings" to configure the integration

## Configuration

### Setting up Google Sheets API

1. Go to the [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google Sheets API
4. Create credentials (API key) for the API
5. Copy the API key and enter it in the plugin settings

### Configuring the Plugin

1. Go to "Contact Form 7" > "Google Spreadsheet Settings"
2. Enter your Google Sheets API key
3. Enable the integration
4. Select which forms should be sent to Google Sheets
5. For each enabled form, enter the Spreadsheet ID and Range
6. Map your form fields to spreadsheet columns (one per line, format: "form_field_name:sheet_column")

## Usage

Once configured, all submissions from enabled forms will automatically be sent to the specified Google Sheets.

## Support

For support, please open an issue on the [GitHub repository](https://github.com/pcsoftnepal/cf7-integration/issues).

## Changelog

### 1.0.0
*   Initial release