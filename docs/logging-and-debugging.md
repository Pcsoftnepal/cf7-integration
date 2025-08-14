# Logging and Debugging

This document explains how the Contact Form 7 to HubSpot Integration plugin handles logging and debugging.

## Logging Overview

The plugin implements a comprehensive logging system to help track integration activities and troubleshoot issues. All log entries are written to WordPress's debug log file.

## Log Categories

The plugin generates logs for the following categories:

### 1. Success Logs
- Successful contact creation in HubSpot
- Successful deal creation in HubSpot
- Successful data synchronization

### 2. Warning Logs
- Partial data mapping issues
- Optional field mismatches
- Non-critical API warnings

### 3. Error Logs
- Authentication failures
- Network connectivity issues
- Invalid data formats
- HubSpot API errors
- Configuration issues

## Log File Location

Log files are stored in the standard WordPress debug log location:
```
/wp-content/debug.log
```

## Enabling Debug Mode

To enable detailed logging for troubleshooting:

1. Edit your `wp-config.php` file
2. Add the following lines:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## Log Entry Format

Each log entry follows this format:
```
[YYYY-MM-DD HH:MM:SS] Log category: Message
```

Example:
```
[2023-05-15 14:30:45] INFO: Successfully created HubSpot contact for email: john@example.com
[2023-05-15 14:30:45] ERROR: Failed to create HubSpot contact: Invalid email address
```

## Common Debugging Scenarios

### Scenario 1: Contact Not Created in HubSpot

**Symptoms:**
- Form submits successfully in WordPress
- No contact appears in HubSpot
- No error messages in the form submission

**Troubleshooting Steps:**
1. Check the debug log for error messages
2. Verify HubSpot API key is correctly configured
3. Confirm that required fields are mapped
4. Check if the email address is valid

### Scenario 2: API Authentication Issues

**Symptoms:**
- Error messages indicating authentication failure
- "Invalid API key" or "Access denied" messages

**Troubleshooting Steps:**
1. Regenerate your HubSpot API key
2. Re-enter the key in the plugin settings
3. Save the settings
4. Check the debug log for detailed error information

### Scenario 3: Data Mapping Problems

**Symptoms:**
- Form submissions succeed but data isn't mapped correctly
- Contacts are created but with missing or incorrect information

**Troubleshooting Steps:**
1. Verify that all required HubSpot properties are mapped
2. Confirm that field names in the shortcode match the form field names
3. Check the debug log for mapping warnings
4. Ensure that the form fields contain valid data

## Log Retention

The plugin does not implement automatic log cleanup. Log files should be managed according to your organization's logging policies.

## Viewing Logs

### Method 1: Direct File Access
Navigate to your WordPress installation directory and open the debug.log file.

### Method 2: WordPress Admin Interface
Some hosting providers offer log viewing capabilities through the WordPress admin panel.

### Method 3: Command Line
```bash
tail -f wp-content/debug.log
```

## Log File Permissions

Ensure that the debug.log file has appropriate permissions:
- File should be writable by the web server
- Should not be publicly accessible
- Should be secured with proper file permissions (typically 644 or 666)

## Performance Considerations

The logging system is designed to minimize performance impact:
- Logs are written asynchronously when possible
- Only critical information is logged by default
- Debug logging can be enabled selectively
- Log levels can be adjusted based on needs