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
            
            submit_button();
            
            ?>
        </form>
                
        <form method="post" action="">
            
            <button type="submit" class="button button-secondary" name="wpw_reset_options">Reset all Options</button>

            <?php if (isset($_POST['wpw_reset_options'])) {

                delete_option( 'wpw_settings' ); 
                echo '<div class="notice notice-success"><p>All settings will be reset.</p></div>';
                echo '<meta http-equiv="refresh" content="2">';

            } ?>

        </form>

    </div>

<?php }

/* ## Initialize settings fields
------------------------------------------------------------------ */

add_action('admin_init', 'wpw_settings_init');
function wpw_settings_init(){

    // Get blog infos
    $wpw_site_name          = get_bloginfo('name');
    $wpw_site_url           = get_bloginfo('url');
    $wpw_site_host          = str_replace(array('https://', 'http://', 'www.'), '', $wpw_site_url);
    $wpw_email_address      = 'info@' . $wpw_site_host;
    $wpw_login_logo         = $wpw_site_url . '/wp-admin/images/wordpress-logo.svg';
    $wpw_login_credits      = '&copy; ' . $wpw_site_name;
    $wpw_backend_main_admin = get_bloginfo('admin_email');

    // Overwrite defaults with individual setting from config file
    global $wpw_config;
    if ( isset($wpw_config['login_logo']) && $wpw_config['login_logo'] ) { $wpw_login_logo = $wpw_config['login_logo']; }
    if ( isset($wpw_config['login_credits']) && $wpw_config['login_credits'] ) { $wpw_login_credits  = $wpw_config['login_credits']; }
    if ( isset($wpw_config['backend_main_admin']) && $wpw_config['backend_main_admin'] ) { $wpw_backend_main_admin  = $wpw_config['backend_main_admin']; }
    if ( isset($wpw_config['brand_widget_title']) && $wpw_config['brand_widget_title'] ) { $wpw_brand_widget_title  = $wpw_config['brand_widget_title']; }
    if ( isset($wpw_config['brand_widget_message']) && $wpw_config['brand_widget_message'] ) { $wpw_brand_widget_message  = $wpw_config['brand_widget_message']; }
    if ( isset($wpw_config['brand_footnote']) && $wpw_config['brand_footnote'] ) { $wpw_brand_footnote  = $wpw_config['brand_footnote']; }
    if ( isset($wpw_config['storage_s3_endpoint']) && $wpw_config['storage_s3_endpoint'] ) { $wpw_storage_s3_endpoint  = $wpw_config['storage_s3_endpoint']; }

    // Retrieve options from database
    global $wpw_options;
    $wpw_options = get_option('wpw_settings', array(
        'email_enable'                      => false,
        'email_name'                        => $wpw_site_name,
        'email_address'                     => $wpw_email_address,
        'email_updates_core'                => true,
        'email_updates_plugins'             => true,
        'email_updates_themes'              => true,
        'smtp_enable'                       => false,
        'smtp_host'                         => $wpw_site_host,
        'smtp_user'                         => $wpw_email_address,
        'smtp_entrance'                     => 'vjbVlU9xyb/AVGn7NOPtb01KZUt3TTlEWDZPWmJuY2R4emxXVExtY3VLZzBNelZKUGV1K3JjS2JNVEV4UDJWWUpwSWNJV2Z4S1RWbGVINXlnMlBmTVFGb0ZaQ0xPWW9IL0twRUpIN1NlL3hyWW5hWm1mL3hvaWZsSFNIVmtjVEcycEFsYTdqOGpNS1JLd2hLeld4TVNpV3VidTI1b1JJUkdUQlFjUT09',
        'smtp_port'                         => '465',
        'smtp_encryption'                   => 'ssl',
        'smtp_selfsigned'                   => false,
        'smtp_debuglevel'                   => 0,
        'login_enable'                      => false,
        'login_logo'                        => $wpw_login_logo,
        'login_credits'                     => $wpw_login_credits,
        'login_hide_language'               => true,
        'backend_enable'                    => false,
        'backend_main_admin'                => $wpw_backend_main_admin,
        'backend_hide_adminbar_items'       => true,
        'backend_hide_adminbar'             => true,
        'backend_hide_menu_settings'        => true,
        'backend_hide_menu_blog'            => false,
        'backend_hide_updates'              => true,
        'backend_hide_health'               => true,
        'backend_hide_wpw_settings'         => true,
        'brand_enable'                      => false,
        'brand_widget_title'                => $wpw_brand_widget_title,
        'brand_widget_message'              => $wpw_brand_widget_message,
        'brand_footnote'                    => $wpw_brand_footnote,
        'media_enable'                      => false,
        'media_svg_upload'                  => true,
        'media_svg_images'                  => true,
        'media_per_year'                    => true,
        'storage_enable'                    => false,
        'storage_s3_endpoint'               => $wpw_storage_s3_endpoint,
        'storage_s3_path'                   => false,
        'storage_s3_debug'                  => false,
        'security_enable'                   => false,
        'security_disable_username_login'   => false,
        'security_disable_creating_admins'  => false,
        'privacy_enable'                    => false,
        'privacy_mask_mail_shortcode'       => false,
        'privacy_mask_phone_shortcode'      => false,
        'privacy_encode_mails_numbers'      => true,
        'privacy_nocookie_youtube'          => true,
        'privacy_google_fonts'              => true,
        'code_enable'                       => false,
        'code_remove_wp_generator'          => true,
        'code_remove_wlwmanifest_link'      => true,
        'code_remove_xmlrpc'                => true,
        'code_remove_emoij_support'         => true,
        'developer_enable'                  => false,
        'developer_hooks_reference'         => false
    ));

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
        'Main Admin',
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
        'wpw_brand_widget_title',
        'Widget Title',
        'wpw_brand_widget_title_callback',
        'wpw-brand-page',
        'wpw_brand_section'
    );

    add_settings_field(
        'wpw_brand_widget_message',
        'Widget Message',
        'wpw_brand_widget_message_callback',
        'wpw-brand-page',
        'wpw_brand_section'
    );

    add_settings_field(
        'wpw_brand_footnote',
        'Footnote',
        'wpw_brand_footnote_callback',
        'wpw-brand-page',
        'wpw_brand_section'
    );

    /* ### Media Library */

    add_settings_section(
        'wpw_media_section',
        'Media Library',
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
        'Object Storage',
        'wpw_storage_callback',
        'wpw-storage-page'
    );

    add_settings_field(
        'wpw_storage_s3_endpoint_field',
        'S3 Endpoint',
        'wpw_storage_s3_endpoint_callback',
        'wpw-storage-page',
        'wpw_storage_section'
    );

    add_settings_field(
        'wpw_storage_s3_parameter_field',
        'S3 Parameter',
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
        'wpw_privacy_mail',
        'Contact data',
        'wpw_privacy_mail_callback',
        'wpw-privacy-page',
        'wpw_privacy_section'
    );

    add_settings_field(
        'wpw_privacy_google',
        'Google',
        'wpw_privacy_google_callback',
        'wpw-privacy-page',
        'wpw_privacy_section'
    );

    /* ### Code */

    add_settings_section(
        'wpw_code_section',
        'HTML Code',
        'wpw_code_callback',
        'wpw-code-page'
    );
    

    add_settings_field(
        'wpw_code',
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
        'wpw_developer',
        'Activate',
        'wpw_developer_activate_callback',
        'wpw-developer-page',
        'wpw_developer_section'
    );
    
}