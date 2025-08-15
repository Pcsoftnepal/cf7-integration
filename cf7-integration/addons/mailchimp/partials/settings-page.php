<?php
/**
 * Mailchimp Settings Page
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/mailchimp/partials
 * @author     PCSoftNepal <info@pcsoftnepal.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Get current settings
$mailchimp_client_id = get_option('cf7_mailchimp_client_id', '');
$mailchimp_client_secret = get_option('cf7_mailchimp_client_secret', '');
$mailchimp_access_token = get_option('cf7_mailchimp_access_token', '');
$mailchimp_list_id = get_option('cf7_mailchimp_list_id', '');
$mailchimp_enable_logging = get_option('cf7_mailchimp_enable_logging', false);

// Check if we have an access token and can connect to Mailchimp
$connected = !empty($mailchimp_access_token);
?>

<div class="wrap">
    <h1>Mailchimp Settings</h1>
    
    <?php if ($connected): ?>
        <div class="notice notice-success">
            <p>You are connected to Mailchimp.</p>
        </div>
    <?php endif; ?>
    
    <form method="post" action="options.php">
        <?php settings_fields('cf7_mailchimp_settings_group'); ?>
        <?php do_settings_sections('cf7_mailchimp_settings_group'); ?>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Mailchimp Client ID</th>
                <td>
                    <input type="text" name="cf7_mailchimp_client_id" value="<?php echo esc_attr($mailchimp_client_id); ?>" />
                    <p class="description">Enter your Mailchimp Client ID. You can find it in your Mailchimp app settings.</p>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Mailchimp Client Secret</th>
                <td>
                    <input type="password" name="cf7_mailchimp_client_secret" value="<?php echo esc_attr($mailchimp_client_secret); ?>" />
                    <p class="description">Enter your Mailchimp Client Secret. You can find it in your Mailchimp app settings.</p>
                </td>
            </tr>
            
            <?php if (!$connected): ?>
            <tr valign="top">
                <td colspan="2">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=cf7-integration&connect_mailchimp=1')); ?>" class="button button-primary">Connect to Mailchimp</a>
                    <p class="description">Click to connect to Mailchimp using OAuth 2.0</p>
                </td>
            </tr>
            <?php else: ?>
            <tr valign="top">
                <td colspan="2">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=cf7-integration&disconnect_mailchimp=1')); ?>" class="button">Disconnect from Mailchimp</a>
                    <p class="description">Disconnect from Mailchimp</p>
                </td>
            </tr>
            <?php endif; ?>
            
            <tr valign="top">
                <th scope="row">Mailchimp List ID</th>
                <td>
                    <input type="text" name="cf7_mailchimp_list_id" value="<?php echo esc_attr($mailchimp_list_id); ?>" />
                    <p class="description">Enter your Mailchimp list ID. You can find it in your Mailchimp list settings.</p>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row">Enable Logging</th>
                <td>
                    <input type="checkbox" name="cf7_mailchimp_enable_logging" value="1" <?php checked($mailchimp_enable_logging, 1); ?> />
                    <label for="cf7_mailchimp_enable_logging">Enable logging for debugging purposes</label>
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div>