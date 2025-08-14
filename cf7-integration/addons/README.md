# CF7 Integration Addons

This directory contains all available addons for the CF7 Integration plugin.

## Addon Structure

Each addon follows the standard WordPress plugin structure:

```
addons/
├── addon-name/
│   ├── addon-name.php          # Main addon file
│   ├── includes/               # Include files for the addon
│   │   ├── class-addon-class.php
│   │   └── ...
│   └── templates/              # Template files (if any)
```

## Available Addons

### HubSpot Integration
- **Location**: `addons/hubspot/`
- **Main File**: `addons/hubspot/hubspot.php`
- **Includes**: `addons/hubspot/includes/`

## Creating New Addons

To create a new addon:

1. Create a new directory in the `addons/` folder
2. Create a main addon file that loads the necessary components
3. Place all addon-specific files in the `includes/` subdirectory
4. Ensure proper naming conventions are followed
5. Register the addon with the main plugin

## Naming Conventions

- All addon files should follow the naming convention: `class-addon-name.php`
- All addon directories should be lowercase with hyphens
- All addon files should be properly namespaced or use class prefixes