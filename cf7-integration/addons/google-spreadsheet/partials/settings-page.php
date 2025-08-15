<?php
/**
 * Google Spreadsheet Settings Page
 *
 * @package    CF7_Integration
 * @subpackage CF7_Integration/addons/google-spreadsheet/partials
 * @author     PCSoftNepal <info@pcsoftnepal.com>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Google Spreadsheet Settings Page
 */
function cf7_google_sheets_settings_page() {
    // Check if user is authorized to save options
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    
    // Get the settings
    $settings = get_option('cf7_google_sheets_settings');
    
    // Handle form submission
    if (isset($_POST['cf7_google_sheets_save_settings'])) {
        // Verify nonce
        if (!wp_verify_nonce($_POST['cf7_google_sheets_nonce'], 'cf7_google_sheets_save_settings')) {
            wp_die(__('Security check failed.'));
        }
        
        // Sanitize and save the settings
        $settings = array();
        $settings['api_key'] = sanitize_text_field($_POST['cf7_google_sheets_api_key']);
        $settings['enabled'] = isset($_POST['cf7_google_sheets_enabled']) ? 1 : 0;
        $settings['forms'] = array();
        
        // Save form-specific settings
        if (isset($_POST['cf7_google_sheets_forms'])) {
            foreach ($_POST['cf7_google_sheets_forms'] as $form_id => $form_settings) {
                $settings['forms'][$form_id] = array(
                    'enabled' => isset($form_settings['enabled']) ? 1 : 0,
                    'spreadsheet_id' => sanitize_text_field($form_settings['spreadsheet_id']),
                    'range' => sanitize_text_field($form_settings['range']),
                    'mapping' => array_map('sanitize_text_field', $form_settings['mapping'])
                );
            }
        }
        
        update_option('cf7_google_sheets_settings', $settings);
        echo '<div class="notice notice-success"><p>Settings saved.</p></div>';
    }
    
    // Get all contact forms
    $contact_forms = WPCF7_ContactForm::find();
    ?>
    <div class="wrap">
        <h1>Google Spreadsheet Integration Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('cf7_google_sheets_save_settings', 'cf7_google_sheets_nonce'); ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row">Enable Google Spreadsheet Integration</th>
                    <td>
                        <input type="checkbox" id="cf7_google_sheets_enabled" name="cf7_google_sheets_enabled" value="1" <?php checked(1, isset($settings['enabled']) ? $settings['enabled'] : 0); ?> />
                        <label for="cf7_google_sheets_enabled">Enable integration with Google Sheets</label>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">Google Sheets API Key</th>
                    <td>
                        <input type="text" id="cf7_google_sheets_api_key" name="cf7_google_sheets_api_key" value="<?php echo esc_attr(isset($settings['api_key']) ? $settings['api_key'] : ''); ?>" class="regular-text" />
                        <p class="description">Enter your Google Sheets API key here.</p>
                    </td>
                </tr>
            </table>
            
            <h2>Contact Forms Configuration</h2>
            <p>Configure which forms should be sent to Google Sheets and their settings:</p>
            
            <?php if (empty($contact_forms)): ?>
                <p>No contact forms found.</p>
            <?php else: ?>
                <table class="widefat fixed">
                    <thead>
                        <tr>
                            <th>Form Name</th>
                            <th>Enabled</th>
                            <th>Spreadsheet ID</th>
                            <th>Range</th>
                            <th>Field Mapping</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contact_forms as $form): ?>
                            <?php 
                            $form_id = $form->id();
                            $form_settings = isset($settings['forms'][$form_id]) ? $settings['forms'][$form_id] : array();
                            ?>
                            <tr>
                                <td><?php echo esc_html($form->title()); ?></td>
                                <td>
                                    <input type="checkbox" id="cf7_google_sheets_forms[<?php echo $form_id; ?>][enabled]" name="cf7_google_sheets_forms[<?php echo $form_id; ?>][enabled]" value="1" <?php checked(1, isset($form_settings['enabled']) ? $form_settings['enabled'] : 0); ?> />
                                    <label for="cf7_google_sheets_forms[<?php echo $form_id; ?>][enabled]">Send to Google Sheets</label>
                                </td>
                                <td>
                                    <input type="text" id="cf7_google_sheets_forms[<?php echo $form_id; ?>][spreadsheet_id]" name="cf7_google_sheets_forms[<?php echo $form_id; ?>][spreadsheet_id]" value="<?php echo esc_attr(isset($form_settings['spreadsheet_id']) ? $form_settings['spreadsheet_id'] : ''); ?>" class="regular-text" />
                                </td>
                                <td>
                                    <input type="text" id="cf7_google_sheets_forms[<?php echo $form_id; ?>][range]" name="cf7_google_sheets_forms[<?php echo $form_id; ?>][range]" value="<?php echo esc_attr(isset($form_settings['range']) ? $form_settings['range'] : 'A1'); ?>" class="regular-text" />
                                </td>
                                <td>
                                    <textarea id="cf7_google_sheets_forms[<?php echo $form_id; ?>][mapping]" name="cf7_google_sheets_forms[<?php echo $form_id; ?>][mapping]" rows="3" class="large-text"><?php echo esc_textarea(isset($form_settings['mapping']) ? implode("\n", $form_settings['mapping']) : ''); ?></textarea>
                                    <p class="description">Map form fields to spreadsheet columns (one per line, format: "form_field_name:sheet_column")</p>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            
            <?php submit_button('Save Settings', 'primary'); ?>
        </form>
    </div>
    <?php
}