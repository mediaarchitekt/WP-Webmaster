<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Setup options page ------------------------------------------------------------------------------- */

/* ## Adds navigation item under settings and inner tabs
------------------------------------------------------------------ */

add_action('admin_menu', 'wpw_settings_menu');
function wpw_settings_menu(){

    // Settings page
    add_options_page(
        'WP Webmaster',           // Title of settingspage
        'WP Webmaster',           // Display name at the menu
        'manage_options',           // Rights for display
        'wp-webmaster',           // Slug
        'wpw_settings_page'         // function callback for the content
    );

}

/* ## Define settings page
------------------------------------------------------------------ */

function wpw_settings_page(){ ?>

    <div class="wrap">

        <h2>WP Webmaster</h2>

        <form method="post" action="options.php">
            <?php

            // Ausgabe der WordPress Einstellungsfelder
            settings_fields('wpw_settings_group');

            do_settings_sections('wpw-email-page');
            echo '<hr>';

            do_settings_sections('wpw-smtp-page');
            echo '<hr>';

            do_settings_sections('wpw-login-page');
            echo '<hr>';

            do_settings_sections('wpw-backend-page');
            echo '<hr>';

            do_settings_sections('wpw-brand-page');
            echo '<hr>';

            do_settings_sections('wpw-media-page');
            echo '<hr>';

            do_settings_sections('wpw-storage-page');
            echo '<hr>';

            do_settings_sections('wpw-security-page');
            echo '<hr>';

            do_settings_sections('wpw-privacy-page');
            echo '<hr>';

            do_settings_sections('wpw-code-page');
            echo '<hr>';

            do_settings_sections('wpw-developer-page');
            
            submit_button('Save Changes', 'primary', 'save_changes');
            
            ?>
        </form>

        <div class="wpw-button-forms">

            <!-- Reset form for deleting all settings -->
            <form method="post" action="">
                
                <button type="submit" class="button button-secondary" name="wpw_reset_options">Reset all Options</button>

                <?php if (isset($_POST['wpw_reset_options'])) {

                    delete_option( 'wpw_settings' ); 
                    echo '<div class="notice notice-success"><p>All settings will be reset.</p></div>';
                    echo '<meta http-equiv="refresh" content="2">';

                } ?>

            </form>

            <!-- Delete all log files -->
            <form method="post" action="">
                
                <button type="submit" class="button button-secondary" name="wpw_delete_logs">Delete all Logs</button>

                <?php if (isset($_POST['wpw_delete_logs'])) {

                    $filename = WP_CONTENT_DIR . '/wpw-mail.log';
 
                    if (file_exists($filename)) {
                        if (unlink($filename)) { echo '<div class="notice notice-success"><p>Mail log file deleted.</p></div>'; }
                        else { echo '<div class="notice notice-success"><p>Could not delete mail log file.</p></div>'; }
                    } else { echo '<div class="notice notice-success"><p>Nothing to delete.</p></div>'; }

                } ?>

            </form>

            <!-- Test form for sending mails -->
            <form method="post" action="">

                <button type="submit" class="button button-secondary" name="wpw_test_mail">Send Test Mail</button>

                <?php if (isset($_POST['wpw_test_mail'])) {

                    global $wpw_options;

                    // Pick the right recipient depending on the settings
                    if ( isset( $wpw_options['backend_enable'] ) && !empty( $wpw_options['backend_enable'] ) ) { $recipient = 'Test Recipient <' . $wpw_options['backend_main_admin'] . '>'; }
                    else { $recipient = 'Test Recipient <' . get_bloginfo('admin_email') . '>'; }

                    $subject        = "Test Email";
                    $message_body   = "This is a test email.";

                    if (wp_mail($recipient, $subject, $message_body)) { echo '<div class="notice notice-success"><p>The test email was sent successfully.</p></div>'; }
                    else { echo '<div class="notice notice-success"><p>An error occurred while sending the test email.</p></div>'; }

                } ?>

            </form>

        </div>

    </div>

<?php }

/* ## Initialize settings fields
------------------------------------------------------------------ */

add_action('admin_init', 'wpw_settings_init');
function wpw_settings_init(){

    /* ### Retrieve the default values */

    global $wpw_plugin_path;
    require_once $wpw_plugin_path . 'includes/defaults.php';

    /* ### Register new settings group */

    register_setting(
        'wpw_settings_group',           // Group name, must be unique
        'wpw_settings',                 // Option name
        'wpw_settings_sanitize'         // Sanitization callback
    );

    /* ### Emails */

    add_settings_section(
        'wpw_email_section',            // Section ID
        'Emails',                       // Section headline
        'wpw_email_callback',           // Callback function for output
        'wpw-email-page'                // Page where to display the section
    );

    add_settings_field(
        'wpw_email_name_field',         // Field ID
        'Senders name',                 // Field description
        'wpw_email_name_callback',      // Callback for field output
        'wpw-email-page',               // Page where to display the field
        'wpw_email_section'             // Section ID
    );

    add_settings_field(
        'wpw_email_address_field',
        'Senders address',
        'wpw_email_address_callback',
        'wpw-email-page',
        'wpw_email_section'
    );

    add_settings_field(
        'wpw_email_updates_field',
        'Stop notifications about',
        'wpw_email_updates_callback',
        'wpw-email-page',
        'wpw_email_section'
    );

    /* ### SMTP */

    add_settings_section(
        'wpw_smtp_section',
        'SMTP',
        'wpw_smtp_callback',
        'wpw-smtp-page'
    );

    add_settings_field(
        'wpw_smtp_host_field',
        'Host name',
        'wpw_smtp_host_callback',
        'wpw-smtp-page',
        'wpw_smtp_section'
    );

    add_settings_field(
        'wpw_smtp_user_field',
        'User name',
        'wpw_smtp_user_callback',
        'wpw-smtp-page',
        'wpw_smtp_section'
    );

    add_settings_field(
        'wpw_smtp_password_field',
        'Password',
        'wpw_smtp_password_callback',
        'wpw-smtp-page',
        'wpw_smtp_section'
    );

    add_settings_field(
        'wpw_smtp_port_field',
        'Port number',
        'wpw_smtp_port_callback',
        'wpw-smtp-page',
        'wpw_smtp_section'
    );

    add_settings_field(
        'wpw_smtp_encryption_field',
        'Encryption',
        'wpw_smtp_encryption_callback',
        'wpw-smtp-page',
        'wpw_smtp_section'
    );

    add_settings_field(
        'wpw_smtp_debugging_field',
        'Error handling',
        'wpw_smtp_debugging_callback',
        'wpw-smtp-page',
        'wpw_smtp_section'
    );

    /* ### Login */

    add_settings_section(
        'wpw_login_section',
        'Login',
        'wpw_login_callback',
        'wpw-login-page'
    );
    
    add_settings_field(
        'wpw_login_logo_field',
        'Logo',
        'wpw_login_logo_callback',
        'wpw-login-page',
        'wpw_login_section'
    );

    add_settings_field(
        'wpw_login_credits_field',
        'Credits',
        'wpw_login_credits_callback',
        'wpw-login-page',
        'wpw_login_section'
    );

    add_settings_field(
        'wpw_login_hide_field',
        'Hide',
        'wpw_login_hide_callback',
        'wpw-login-page',
        'wpw_login_section'
    );

    /* ### Backend */

    add_settings_section(
        'wpw_backend_section',
        'Backend',
        'wpw_backend_callback',
        'wpw-backend-page'
    );
    
    add_settings_field(
        'wpw_backend_main_admin_field',
        'Main admin',
        'wpw_backend_main_admin_callback',
        'wpw-backend-page',
        'wpw_backend_section'
    );

    add_settings_field(
        'wpw_backend_hide_field',
        'Hide',
        'wpw_backend_hide_callback',
        'wpw-backend-page',
        'wpw_backend_section'
    );

    /* ### Brand */

    add_settings_section(
        'wpw_brand_section',
        'Branding',
        'wpw_brand_callback',
        'wpw-brand-page'
    );
    
     add_settings_field(
        'wpw_brand_widget_title_field',
        'Widget title',
        'wpw_brand_widget_title_callback',
        'wpw-brand-page',
        'wpw_brand_section'
    );

    add_settings_field(
        'wpw_brand_widget_message_field',
        'Widget message',
        'wpw_brand_widget_message_callback',
        'wpw-brand-page',
        'wpw_brand_section'
    );

    add_settings_field(
        'wpw_brand_footnote_field',
        'Footnote',
        'wpw_brand_footnote_callback',
        'wpw-brand-page',
        'wpw_brand_section'
    );

    /* ### Media Library */

    add_settings_section(
        'wpw_media_section',
        'Media library',
        'wpw_media_callback',
        'wpw-media-page'
    );
    
     add_settings_field(
        'wpw_media_support_field',
        'Support',
        'wpw_media_support_callback',
        'wpw-media-page',
        'wpw_media_section'
    );

    /* ### Object Storage */

    add_settings_section(
        'wpw_storage_section',
        'Object storage',
        'wpw_storage_callback',
        'wpw-storage-page'
    );

    add_settings_field(
        'wpw_storage_s3_endpoint_field',
        'S3 endpoint',
        'wpw_storage_s3_endpoint_callback',
        'wpw-storage-page',
        'wpw_storage_section'
    );

    add_settings_field(
        'wpw_storage_s3_parameter_field',
        'S3 parameter',
        'wpw_storage_s3_parameter_callback',
        'wpw-storage-page',
        'wpw_storage_section'
    );

    /* ### Security */

    add_settings_section(
        'wpw_security_section',
        'Security',
        'wpw_security_callback',
        'wpw-security-page'
    );
    
    add_settings_field(
        'wpw_security_disable_field',
        'Disable',
        'wpw_security_disable_callback',
        'wpw-security-page',
        'wpw_security_section'
    );

    /* ### Privacy */

    add_settings_section(
        'wpw_privacy_section',
        'Privacy',
        'wpw_privacy_callback',
        'wpw-privacy-page'
    );
    
    add_settings_field(
        'wpw_privacy_mail_field',
        'Contact data',
        'wpw_privacy_mail_callback',
        'wpw-privacy-page',
        'wpw_privacy_section'
    );

    add_settings_field(
        'wpw_privacy_google_field',
        'Google',
        'wpw_privacy_google_callback',
        'wpw-privacy-page',
        'wpw_privacy_section'
    );

    /* ### Code */

    add_settings_section(
        'wpw_code_section',
        'Code',
        'wpw_code_callback',
        'wpw-code-page'
    );
    
    add_settings_field(
        'wpw_code_header_field',
        'Header script',
        'wpw_code_header_callback',
        'wpw-code-page',
        'wpw_code_section'
    );

    add_settings_field(
        'wpw_code_footer_field',
        'Footer script',
        'wpw_code_footer_callback',
        'wpw-code-page',
        'wpw_code_section'
    );

    add_settings_field(
        'wpw_code_limit_field',
        'Limit injection',
        'wpw_code_limit_injection_callback',
        'wpw-code-page',
        'wpw_code_section'
    );

    add_settings_field(
        'wpw_code_disable_field',
        'Disable',
        'wpw_code_disable_callback',
        'wpw-code-page',
        'wpw_code_section'
    );

    /* ### Developer */

    add_settings_section(
        'wpw_developer_section',
        'Development',
        'wpw_developer_callback',
        'wpw-developer-page'
    );
    

    add_settings_field(
        'wpw_developer_field',
        'Activate',
        'wpw_developer_activate_callback',
        'wpw-developer-page',
        'wpw_developer_section'
    );
    
}