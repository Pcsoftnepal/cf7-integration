# CF7 Integration Plugin - Framework Enhancements

## Overview

This document outlines the enhancements made to the CF7 Integration plugin framework to support addons from different plugins. The improvements allow for better extensibility and integration with external plugins.

## Key Enhancements

### 1. Enhanced Addon Manager

The `CF7_Addon_Manager` class has been significantly enhanced to support:

- **Multi-source addon detection**: Distinguishes between addons from the main plugin and external plugins
- **Source identification**: Clearly indicates whether an addon comes from the main plugin or an external plugin
- **Improved addon loading**: Better handling of addon loading with proper error checking
- **Enhanced information retrieval**: Provides detailed information about each addon

### 2. Support for External Plugins

The framework now supports addons from external plugins through:

- A filter hook `cf7_integration_external_addons` that allows external plugins to register their addons
- Properly structured addon registration with source identification
- Consistent API for managing external addons

### 3. Updated Admin Interface

The addon management interface now displays:

- Addon name
- Addon source (main plugin or external plugin)
- Current activation status
- Action buttons for activation/deactivation

## How to Create an External Addon

External plugins can now register their addons with the CF7 Integration plugin by following these steps:

1. **Register the addon** using the `cf7_integration_external_addons` filter:
```php
add_filter('cf7_integration_external_addons', function($addons) {
    $addons['my-external-addon'] = array(
        'name' => 'My External Addon',
        'file' => plugin_dir_path(__FILE__) . 'my-addon/my-addon.php',
        'plugin' => 'my-external-plugin'
    );
    return $addons;
});
```

2. **Create the addon file** that implements the addon functionality:
```php
<?php
// This file should be in the external plugin's directory structure
// and implement the addon's functionality
```

## Usage Examples

### For Main Plugin Addons
```php
// The main plugin addons are automatically detected and managed
// No special setup is required for addons in the main plugin directory
```

### For External Plugin Addons
```php
// In an external plugin's main file:
add_filter('cf7_integration_external_addons', function($addons) {
    $addons['my-external-addon'] = array(
        'name' => 'My External Addon',
        'file' => plugin_dir_path(__FILE__) . 'addons/my-external-addon/my-external-addon.php',
        'plugin' => 'my-external-plugin'
    );
    return $addons;
});
```

## Benefits

1. **Enhanced Extensibility**: External plugins can now contribute addons to the CF7 Integration ecosystem
2. **Clear Separation**: Easy distinction between main plugin addons and external addons
3. **Improved Maintainability**: Better-structured code that's easier to maintain and extend
4. **Consistent API**: Unified interface for managing addons regardless of their source
5. **Future-Proof**: The architecture supports future enhancements and additional plugin integrations

## Version History

- **1.0.0**: Initial implementation of enhanced addon management
- **1.0.1**: Added support for external addons and improved documentation