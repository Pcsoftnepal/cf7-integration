<?php
/**
 * Display the settings page
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/admin/partials
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <?php if (isset($_GET['settings-updated'])): ?>
        <div class="notice notice-success">
            <p><?php _e('Settings saved.', 'cf7-integration'); ?></p>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['activated'])): ?>
        <div class="notice notice-success">
            <p><?php _e('Addon activated successfully.', 'cf7-integration'); ?></p>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['deactivated'])): ?>
        <div class="notice notice-success">
            <p><?php _e('Addon deactivated successfully.', 'cf7-integration'); ?></p>
        </div>
    <?php endif; ?>
    
    <form action="options.php" method="post">
        <?php settings_fields('cf7_integration_settings_group'); ?>
        <?php do_settings_sections('cf7-integration'); ?>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Integration Authorization</th>
                <td>
                    <?php
                    $client_id = get_option('cf7_hubspot_client_id', '');
                    $client_secret = get_option('cf7_hubspot_client_secret', '');
                    
                    if (empty($client_id) || empty($client_secret)) : ?>
                        <p class="description">Please enter your service Client ID and Client Secret in the fields below to enable authorization.</p>
                        <p><strong>Client ID:</strong> <input type="text" name="cf7_hubspot_client_id" value="<?php echo esc_attr($client_id); ?>" /></p>
                        <p><strong>Client Secret:</strong> <input type="password" name="cf7_hubspot_client_secret" value="<?php echo esc_attr($client_secret); ?>" /></p>
                        <p class="description">These credentials can be obtained from your service developer portal.</p>
                    <?php else : ?>
                        <?php
                        // Check if we have a stored access token
                        $access_token = get_option('cf7_hubspot_access_token', '');
                        if (empty($access_token)) : ?>
                            <a href="<?php echo esc_url(CF7_OAuth::get_authorization_url(CF7_OAuth::get_redirect_uri())); ?>" class="button button-primary">Connect to Service</a>
                            <p class="description">Click to connect your service account</p>
                        <?php else : ?>
                            <p class="description">Connected to service successfully!</p>
                            <p><a href="<?php echo esc_url(admin_url('admin.php?page=cf7-integration&disconnect=1')); ?>" class="button">Disconnect</a></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Default Contact List ID', 'cf7-integration'); ?></th>
                <td>
                    <input type="text" name="cf7_hubspot_contact_list_id" value="<?php echo esc_attr(get_option('cf7_hubspot_contact_list_id')); ?>" class="regular-text" />
                    <p class="description"><?php _e('Enter the default service contact list ID to subscribe contacts to.', 'cf7-integration'); ?></p>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Custom Fields Mappings', 'cf7-integration'); ?></th>
                <td>
                    <p class="description"><?php _e('Configure custom field mappings between Contact Form 7 and service.', 'cf7-integration'); ?></p>
                    <table class="widefat">
                        <thead>
                            <tr>
                                <th><?php _e('Contact Form 7 Field', 'cf7-integration'); ?></th>
                                <th><?php _e('Service Property', 'cf7-integration'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="cf7_hubspot_custom_field_1" value="<?php echo esc_attr(get_option('cf7_hubspot_custom_field_1', '')); ?>" placeholder="e.g. custom_field_1" /></td>
                                <td><input type="text" name="cf7_hubspot_custom_field_1_mapping" value="<?php echo esc_attr(get_option('cf7_hubspot_custom_field_1_mapping', '')); ?>" placeholder="e.g. custom_field_1" /></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="cf7_hubspot_custom_field_2" value="<?php echo esc_attr(get_option('cf7_hubspot_custom_field_2', '')); ?>" placeholder="e.g. custom_field_2" /></td>
                                <td><input type="text" name="cf7_hubspot_custom_field_2_mapping" value="<?php echo esc_attr(get_option('cf7_hubspot_custom_field_2_mapping', '')); ?>" placeholder="e.g. custom_field_2" /></td>
                            </tr>
                            <tr>
                                <td><input type="text" name="cf7_hubspot_custom_field_3" value="<?php echo esc_attr(get_option('cf7_hubspot_custom_field_3', '')); ?>" placeholder="e.g. custom_field_3" /></td>
                                <td><input type="text" name="cf7_hubspot_custom_field_3_mapping" value="<?php echo esc_attr(get_option('cf7_hubspot_custom_field_3_mapping', '')); ?>" placeholder="e.g. custom_field_3" /></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="description"><?php _e('Map Contact Form 7 fields to custom service properties.', 'cf7-integration'); ?></p>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Enable Logging', 'cf7-integration'); ?></th>
                <td>
                    <input type="checkbox" name="cf7_hubspot_enable_logging" value="on" <?php checked('on', get_option('cf7_hubspot_enable_logging')); ?> />
                    <label><?php _e('Enable detailed logging for debugging purposes', 'cf7-integration'); ?></label>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Debug Mode', 'cf7-integration'); ?></th>
                <td>
                    <input type="checkbox" name="cf7_hubspot_debug_mode" value="on" <?php checked('on', get_option('cf7_hubspot_debug_mode')); ?> />
                    <label><?php _e('Enable debug mode for additional logging', 'cf7-integration'); ?></label>
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
    
    <!-- Addon Management Section -->
    <hr>
    <h2><?php _e('Addon Management', 'cf7-integration'); ?></h2>
    <p><?php _e('Manage your installed addons:', 'cf7-integration'); ?></p>
    
    <?php
    // Load the addon manager class
    if (!class_exists('CF7_Addon_Manager')) {
        require_once plugin_dir_path(__FILE__) . '../addons/class-addon-manager.php';
    }
    
    $active_addons = get_option('cf7_integration_active_addons', array());
    $available_addons = CF7_Addon_Manager::get_available_addons();
    ?>
    
    <div class="cf7-addon-management">
        <?php foreach ($available_addons as $addon_name => $addon_info): ?>
            <div class="cf7-addon-item">
                <div class="cf7-addon-header">
                    <span class="cf7-addon-name"><?php echo esc_html($addon_info['name']); ?></span>
                    <span class="cf7-addon-status <?php echo in_array($addon_name, $active_addons) ? 'active' : 'inactive'; ?>">
                        <?php echo in_array($addon_name, $active_addons) ? __('Active', 'cf7-integration') : __('Inactive', 'cf7-integration'); ?>
                    </span>
                </div>
                
                <div class="cf7-addon-actions">
                    <?php if (in_array($addon_name, $active_addons)): ?>
                        <a href="<?php echo wp_nonce_url(admin_url('admin-post.php?action=cf7_integration_deactivate_addon&addon=' . $addon_name), 'cf7_integration_deactivate_addon_' . $addon_name); ?>" class="button button-secondary"><?php _e('Deactivate', 'cf7-integration'); ?></a>
                    <?php else: ?>
                        <a href="<?php echo wp_nonce_url(admin_url('admin-post.php?action=cf7_integration_activate_addon&addon=' . $addon_name), 'cf7_integration_activate_addon_' . $addon_name); ?>" class="button button-primary"><?php _e('Activate', 'cf7-integration'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <style>
        .cf7-addon-management {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .cf7-addon-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .cf7-addon-item:last-child {
            border-bottom: none;
        }
        .cf7-addon-header {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }
        .cf7-addon-name {
            font-weight: bold;
        }
        .cf7-addon-status.active {
            color: green;
        }
        .cf7-addon-status.inactive {
            color: orange;
        }
        .cf7-addon-actions {
            display: flex;
            gap: 10px;
        }
    </style>
</div>