# Addon Management System Documentation

## Overview

The addon management system is a core component of the CF7 Integration plugin that allows administrators to manage third-party addons within the plugin. This system provides a clean and secure way to enable or disable functionality modules.

## Features

1. **Addon Discovery**: Automatically discovers available addons in the `/addons/` directory
2. **Activation/Deactivation**: Simple click interface to activate or deactivate addons
3. **Status Tracking**: Clear indication of which addons are currently active
4. **Security**: Uses WordPress nonces for secure operations
5. **Styling**: Clean, user-friendly interface that matches WordPress admin aesthetics
6. **Extensibility**: Designed to be easily extended for future addon types

## Implementation Details

### File Structure

```
cf7-integration/
├── admin/
│   └── addons/
│       ├── class-addon-manager.php
│       ├── handlers.php
│       └── addon-management.php
```

### Addon Manager Class
**File**: `cf7-integration/admin/addons/class-addon-manager.php`

The addon manager class provides core functionality for managing addons:

```php
class CF7_Addon_Manager {
    public static function get_available_addons() // Retrieves all available addons
    public static function is_addon_active($addon_name) // Checks if addon is active
    public static function activate_addon($addon_name) // Activates an addon
    public static function deactivate_addon($addon_name) // Deactivates an addon
}
```

### Handlers
**File**: `cf7-integration/admin/addons/handlers.php`

Manages the POST requests for addon activation and deactivation:
- Handles addon activation via `cf7_integration_activate_addon`
- Handles addon deactivation via `cf7_integration_deactivate_addon`
- Implements security with WordPress nonces

### Addon Management Interface
**File**: `cf7-integration/admin/addons/addon-management.php`

Renders the addon management section in the WordPress admin:
- Displays available addons
- Shows activation status
- Provides activate/deactivate buttons
- Includes CSS styling for the interface

## Usage

### Accessing the Addon Management System

1. Navigate to the WordPress admin dashboard
2. Go to the CF7 Integration settings page (typically under "Settings")
3. Find the "Addon Management" section
4. View all available addons
5. Click "Activate" or "Deactivate" as needed

### Adding New Addons

To add a new addon to the system:

1. Create a new directory in `/cf7-integration/addons/` with the addon name
2. Place the addon's main PHP file in that directory
3. The addon will automatically appear in the management interface
4. Administrators can then activate or deactivate the addon as needed

## Security Considerations

- All addon management operations use WordPress nonces for security
- Input data is properly sanitized before processing
- Only administrators with appropriate permissions can manage addons
- All operations are logged through WordPress' built-in logging mechanisms

## Best Practices

1. Always test addon activation/deactivation in a staging environment
2. Keep addon files secure and up-to-date
3. Document any custom addon functionality for future maintenance
4. Regularly review active addons to ensure they're still needed
5. Follow WordPress coding standards for all addon development

## Troubleshooting

### Common Issues

1. **Addons Not Appearing**: Ensure the addon directory structure is correct and the main addon file exists
2. **Activation Failures**: Check that the addon file is properly formatted and contains the required plugin headers
3. **Permission Issues**: Verify that the web server has proper permissions to read addon files
4. **Security Errors**: Confirm that all operations use valid nonces

### Support

For support with the addon management system, please contact the plugin developers or consult the official documentation.

## Version History

- **1.0.0**: Initial release with core addon management functionality