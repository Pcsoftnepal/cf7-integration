<?php
/** 
 * Klaviyo Settings Page
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/klaviyo/partials
 * @author     Your Company <email@example.com>
 */

if (!defined('WPINC')) {
    die;
}

// Get current settings
$api_key = get_option('cf7_klaviyo_api_key', '');
$list_id = get_option('cf7_klaviyo_list_id', '');
$enable_logging = get_option('cf7_klaviyo_enable_logging', false);
?>

<div class="wrap">
    <h1><?php _e('Klaviyo Settings', 'cf7-integration'); ?></h1>
    
    <form method="post" action="options.php">
        <?php settings_fields('cf7_klaviyo_settings_group'); ?>
        <?php do_settings_sections('cf7-klaviyo-settings'); ?>
        
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php _e('API Key', 'cf7-integration'); ?></th>
                <td>
                    <input type="text" name="cf7_klaviyo_api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text" />
                    <p class="description"><?php _e('Enter your Klaviyo API key.', 'cf7-integration'); ?></p>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('List ID', 'cf7-integration'); ?></th>
                <td>
                    <input type="text" name="cf7_klaviyo_list_id" value="<?php echo esc_attr($list_id); ?>" class="regular-text" />
                    <p class="description"><?php _e('Enter your Klaviyo list ID.', 'cf7-integration'); ?></p>
                </td>
            </tr>
            
            <tr valign="top">
                <th scope="row"><?php _e('Enable Logging', 'cf7-integration'); ?></th>
                <td>
                    <input type="checkbox" name="cf7_klaviyo_enable_logging" value="1" <?php checked(1, $enable_logging); ?> />
                    <label><?php _e('Enable logging for debugging purposes', 'cf7-integration'); ?></label>
                </td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    </form>
</div>