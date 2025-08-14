<?php
/** 
 * Display the settings page
 *
 * @package    CF7_HubSpot_Integration
 * @subpackage CF7_HubSpot_Integration/admin/partials
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

?><div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <?php if (isset($_GET['settings-updated'])): ?>
        <div class="notice notice-success">
            <p><?php _e('Settings saved.', 'cf7-hubspot-integration'); ?></p>
        </div>
    <?php endif; ?>
    
    <form action="options.php" method="post">
        <?php settings_fields('cf7_hubspot_integration_settings_group'); ?>
        <?php do_settings_sections('cf7-hubspot-integration'); ?>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row">HubSpot Authorization</th>
                <td>
                    <?php
                    $client_id = get_option('cf7_hubspot_client_id', '');
                    $client_secret = get_option('cf7_hubspot_client_secret', '');
                    
                    if (empty($client_id) || empty($client_secret)) : ?>
                        <p class="description">Please enter your HubSpot Client ID and Client Secret in the fields below to enable authorization.</p>
                        <p><strong>Client ID:</strong> <input type="text" name="cf7_hubspot_client_id" value="<?php echo esc_attr($client_id); ?>" /></p>
                        <p><strong>Client Secret:</strong> <input type="password" name="cf7_hubspot_client_secret" value="<?php echo esc_attr($client_secret); ?>" /></p>
                        <p class="description">These credentials can be obtained from your HubSpot developer portal.</p>
                    <?php else : ?>
                        <?php
                        // Check if we have a stored access token
                        $access_token = get_option('cf7_hubspot_access_token', '');
                        if (empty($access_token)) : ?>
                            <a href="<?php echo esc_url(CF7_HubSpot_OAuth::get_authorization_url(CF7_HubSpot_OAuth::get_redirect_uri())); ?>" class="button button-primary">Connect to HubSpot</a>
                            <p class="description">Click to connect your HubSpot account</p>
                        <?php else : ?>
                            <p class="description">Connected to HubSpot successfully!</p>
                            <p><a href="<?php echo esc_url(admin_url('admin.php?page=cf7-hubspot-integration&disconnect=1')); ?>" class="button">Disconnect</a></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Default Contact List ID', 'cf7-hubspot-integration'); ?></th>
                <td>
                    <input type="text" name="cf7_hubspot_contact_list_id" value="<?php echo esc_attr(get_option('cf7_hubspot_contact_list_id')); ?>" class="regular-text" />
                    <p class="description"><?php _e('Enter the default HubSpot contact list ID to subscribe contacts to.', 'cf7-hubspot-integration'); ?></p>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Custom HubSpot Fields', 'cf7-hubspot-integration'); ?></th>
                <td>
                    <p class="description"><?php _e('Configure custom field mappings between Contact Form 7 and HubSpot.', 'cf7-hubspot-integration'); ?></p>
                    <table class="widefat">
                        <thead>
                            <tr>
                                <th><?php _e('Contact Form 7 Field', 'cf7-hubspot-integration'); ?></th>
                                <th><?php _e('HubSpot Property', 'cf7-hubspot-integration'); ?></th>
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
                    <p class="description"><?php _e('Map Contact Form 7 fields to custom HubSpot properties.', 'cf7-hubspot-integration'); ?></p>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Enable Logging', 'cf7-hubspot-integration'); ?></th>
                <td>
                    <input type="checkbox" name="cf7_hubspot_enable_logging" value="on" <?php checked('on', get_option('cf7_hubspot_enable_logging')); ?> />
                    <label><?php _e('Enable detailed logging for debugging purposes', 'cf7-hubspot-integration'); ?></label>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Debug Mode', 'cf7-hubspot-integration'); ?></th>
                <td>
                    <input type="checkbox" name="cf7_hubspot_debug_mode" value="on" <?php checked('on', get_option('cf7_hubspot_debug_mode')); ?> />
                    <label><?php _e('Enable debug mode for additional logging', 'cf7-hubspot-integration'); ?></label>
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div>