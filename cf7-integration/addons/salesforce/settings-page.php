<?php
/**
 * Settings page for Salesforce addon
 */
function cf7_salesforce_settings_page() {
    // Check if user is authorized
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    
    // Handle form submission
    if (isset($_POST['submit'])) {
        // Process the form submission
        $consumer_key = sanitize_text_field($_POST['cf7_salesforce_consumer_key']);
        $consumer_secret = sanitize_text_field($_POST['cf7_salesforce_consumer_secret']);
        $enable_debug_logging = isset($_POST['cf7_salesforce_enable_debug_logging']) ? 1 : 0;
        
        update_option('cf7_salesforce_consumer_key', $consumer_key);
        update_option('cf7_salesforce_consumer_secret', $consumer_secret);
        update_option('cf7_salesforce_enable_debug_logging', $enable_debug_logging);
        
        echo '<div class="notice notice-success"><p>Settings saved.</p></div>';
    }
    
    // Get current settings
    $consumer_key = get_option('cf7_salesforce_consumer_key', '');
    $consumer_secret = get_option('cf7_salesforce_consumer_secret', '');
    $enable_debug_logging = get_option('cf7_salesforce_enable_debug_logging', false);
    ?>
    <div class="wrap">
        <h1>Salesforce Settings</h1>
        <form method="post" action="">
            <?php settings_fields('cf7_salesforce_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Consumer Key</th>
                    <td><input type="text" name="cf7_salesforce_consumer_key" value="<?php echo esc_attr($consumer_key); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Consumer Secret</th>
                    <td><input type="password" name="cf7_salesforce_consumer_secret" value="<?php echo esc_attr($consumer_secret); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable Debug Logging</th>
                    <td><input type="checkbox" name="cf7_salesforce_enable_debug_logging" value="1" <?php checked(1, $enable_debug_logging, true); ?> /> Enable debug logging for Salesforce integration</td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}