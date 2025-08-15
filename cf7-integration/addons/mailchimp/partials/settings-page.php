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
$mailchimp_api_key = get_option('cf7_mailchimp_api_key', '');
$mailchimp_list_id = get_option('cf7_mailchimp_list_id', '');
$mailchimp_enable_logging = get_option('cf7_mailchimp_enable_logging', false);
?>

<div class="wrap">
    <h1>Mailchimp Settings</h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('cf7_mailchimp_settings_group'); ?>
        <?php do_settings_sections('cf7_mailchimp_settings_group'); ?>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Mailchimp API Key</th>
                <td>
                    <input type="text" name="cf7_mailchimp_api_key" value="<?php echo esc_attr($mailchimp_api_key); ?>" />
                    <p class="description">Enter your Mailchimp API key. You can find it in your Mailchimp account settings.</p>
                </td>
            </tr>
            
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