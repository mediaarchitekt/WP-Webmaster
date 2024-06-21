<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Setup Callbacks for the options page ------------------------------------------------------------------------------- */

/* ## Email settings
------------------------------------------------------------------ */

/* ### Section Email */

function wpw_email_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['email_enable']) && $wpw_options['email_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[email_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Customize email headers like name and email address for all outgoing messages. These settings can be overwritten by other plugins. Block notfications sent to the main admin, when plugins, themes or the core is updated.</p>';

}

/* ### Email name field */

function wpw_email_name_callback() {

    global $wpw_options;

    echo '<input type="text" size="48" id="wpw_email_name" name="wpw_settings[email_name]" placeholder="WordPress" value="' . esc_attr($wpw_options['email_name']) . '" />';
    echo '<p class="wpw-description">Empty to use the default set to <strong>WordPress</strong>.</p>';
  
}

/* ### Email address field */

function wpw_email_address_callback() {

    global $wpw_options;

    echo '<input type="email" size="48" id="wpw_email_address" name="wpw_settings[email_address]" placeholder="wordpress@' . $_SERVER['HTTP_HOST']  . '" value="' . esc_attr($wpw_options['email_address']) . '" />';
    echo '<p class="wpw-description">Empty to use the default set to <strong>wordpress@' . $_SERVER['HTTP_HOST'] . '</strong>.</p>';

}

/* ### Email updates fields */

function wpw_email_updates_callback() {

    global $wpw_options;
    $field = array(

        'email_updates_plugins' => 'Updated plugins',
        'email_updates_themes'  => 'Updated themes',
        'email_updates_core'    => 'Updated core',
        
    );

    foreach ($field as $function_key => $function_label) {

        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';

    }

}

/* ## SMTP settings
------------------------------------------------------------------ */

/* ### Section SMTP */

function wpw_smtp_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['smtp_enable']) && $wpw_options['smtp_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[smtp_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Send all emails via SMTP. Encryption like SSL or TLS is mandatory. Allow self-signed certificates, server errors and log files for debugging only.</p>';

}
 
/* ### SMTP host field */

function wpw_smtp_host_callback() {

    global $wpw_options;

    echo '<input type="text" size="48" id="wpw_smtp_host" name="wpw_settings[smtp_host]" placeholder="example.com" value="' . esc_attr($wpw_options['smtp_host']) . '" />';
    echo '<p class="wpw-description">Mail server address.</p>';

}

/* ### SMTP user field */

function wpw_smtp_user_callback() {

    global $wpw_options;

    echo '<input type="email" size="48" id="wpw_smtp_user" name="wpw_settings[smtp_user]" placeholder="john@doe.com" value="' . esc_attr($wpw_options['smtp_user']) . '" />';
    echo '<p class="wpw-description">Mostly your email address.</p>';

}

/* ### SMTP password field */

function wpw_smtp_password_callback() {

    global $wpw_options;
    $password = wpw_decrypt_password($wpw_options['smtp_entrance']); 

    echo '<input type="password" size="48" id="wpw_smtp_entrance" name="wpw_settings[smtp_entrance]" placeholder="Op3n5e5aWe" value="' . $password . '" />';
    echo '<p class="wpw-description">Your encrypted password will be saved to the WordPress database.</p>';

}

/* ### SMTP port field */

function wpw_smtp_port_callback() {

    global $wpw_options;

    echo '<input type="number" size="8" id="wpw_smtp_port" name="wpw_settings[smtp_port]" placeholder="25" value="' . esc_attr($wpw_options['smtp_port']) . '" />';
    echo '<p class="wpw-description">For example 465 (SSL), 25 or 587 (TLS).</p>';

}

/* ### SMTP encryption field */

function wpw_smtp_encryption_callback() {

    global $wpw_options;

    echo '<input type="radio" name="wpw_settings[smtp_encryption]" value="ssl" ' . checked($wpw_options['smtp_encryption'], 'ssl', false) . '> SSL &nbsp; 
    <input type="radio" name="wpw_settings[smtp_encryption]" value="tls" ' . checked($wpw_options['smtp_encryption'], 'tls', false) . '> TLS';
    
    echo '<p class="wpw-description">Choose between <strong>SSL</strong> or <strong>TLS & STARTTLS</strong>.</p>';

}

/* ### SMTP debugging fields */

function wpw_smtp_debugging_callback() {

    global $wpw_options;
    global $wpw_plugin_url;
    $field = array(

        'smtp_selfsigned'   => 'Allow self-signed certificate',
        'smtp_debugging'    => 'Show server errors',
        'smtp_logging'      => 'Log to file <a class="wpw-button" href="' . WP_CONTENT_URL . '/wpw-mail.log" target="_blank" rel="noopener" type="text/plain">download</a>'

    );
    
    foreach ($field as $function_key => $function_label) {

        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';

    }

}

/* ## Frontend settings
------------------------------------------------------------------ */

/* ### Section Frontend */

function wpw_frontend_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['frontend_enable']) && $wpw_options['frontend_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[frontend_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Prevent individual defined categories from beeing displayed as blog posts at the frontend.</p>';

}

/* ### Frontend filter categories out of the loop */

function wpw_frontend_filter_cats_callback() {

    global $wpw_options;
    echo '<input type="text" size="48" id="wpw_frontend_filter_cats" name="wpw_settings[frontend_filter_cats]" placeholder="uncategorized" value="' . esc_attr($wpw_options['frontend_filter_cats']) . '" />';
    echo '<p class="wpw-description">Comma separeted list of category slugs.<p>';

}

/* ## Login settings
------------------------------------------------------------------ */

/* ### Section Login */

function wpw_login_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['login_enable']) && $wpw_options['login_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[login_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Setup a custom design for the login page. Choose your own logo above the login form and use credits in the footer beneath. Further styles are found in the assets folder of this plugin.</p>';

}

/* ### Login logo source file */

function wpw_login_logo_callback() {

    global $wpw_options;

    echo '<input type="text" size="48" id="wpw_login_logo" name="wpw_settings[login_logo]" placeholder="' . wp_upload_dir()["url"] . '/favicon.png" value="' . esc_attr($wpw_options['login_logo']) . '" />';
    echo '<p class="wpw-description">Empty for standard WordPress logo and link.</p>';

}

function wpw_login_credits_callback() {

    global $wpw_options;

    echo '<input type="text" size="48" id="wpw_login_credits" name="wpw_settings[login_credits]" placeholder="" value="' . esc_attr($wpw_options['login_credits']) . '" />';
    echo '<p class="wpw-description">HTML allowed. Leave empty for disabling the footer.<p>';

}

function wpw_login_hide_callback() {

    global $wpw_options;

    $checked = isset($wpw_options['login_hide_language']) && $wpw_options['login_hide_language'] ? 'checked' : '';
    echo '<label><input type="checkbox" name="wpw_settings[login_hide_language]" ' . $checked . ' /> Language switch</label><br>';

}

/* ## Backend settings
------------------------------------------------------------------ */

/* ### Section Backend */

function wpw_backend_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['backend_enable']) && $wpw_options['backend_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[backend_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Clean the backend of unnecessary entries in the admin bar and in the admin menu. Hide sensitive settings and update information from all users except the main admin.</p>';

}

/* ### Backend main admin field */

function wpw_backend_main_admin_callback() {

    global $wpw_options;

    echo '<input type="text" size="48" id="wpw_backend_main_admin" name="wpw_settings[backend_main_admin]" placeholder="' . get_bloginfo('admin_email') . '" value="' . esc_attr($wpw_options['backend_main_admin']) . '" />';
    echo '<p class="wpw-description">Specify main admin by email<p>';

}

/* ### Backend hide fields */

function wpw_backend_hide_callback() {

    $field = array(

        'backend_hide_adminbar_items'   => 'Specific items on the admin toolbar <strong>(all users)</strong>',
        'backend_hide_adminbar'         => 'Complete admin toolbar <strong>(except editors and admins)</strong>',
        'backend_hide_menu_settings'    => 'Sensitive settings on the sidebar <strong>(except admins)</strong>',
        'backend_hide_menu_blog'        => 'Blog functionality <strong>(except main admin)</strong>',
        'backend_hide_updates'          => 'Update notifications <strong>(except main admin)</strong>',
        'backend_hide_health'           => 'Site health status <strong>(except main admin)</strong>',
        'backend_hide_wpw_settings'     => 'This settings page <strong>(except main admin)</strong>',

    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {

        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';

    }

}

/* ## Brand settings
------------------------------------------------------------------ */

/* ### Section Brand */

function wpw_brand_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['brand_enable']) && $wpw_options['brand_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[brand_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Creates a individual widget at the admins dashboard for messages to other editors. Furthermore brand the admin backend with a personal footer.</p>';

}

/* ### Display title field */

function wpw_brand_widget_title_callback() {

    global $wpw_options;
    echo '<input size="49" type="text" id="wpw_brand_widget_title" name="wpw_settings[brand_widget_title]" value="' . esc_attr($wpw_options['brand_widget_title']) . '" />';
    echo '<p class="wpw-description">Headline for the dashboard widget. Empty to hide</p>';
      
}

/* ### Display message field */

function wpw_brand_widget_message_callback() {

    global $wpw_options;
    echo '<textarea rows="10" cols="50" id="wpw_brand_widget_message" name="wpw_settings[brand_widget_message]">' .  esc_attr($wpw_options['brand_widget_message']) . '</textarea>';
    echo '<p class="wpw-description">Message for the dashboard widget. Little html like <strong>br</strong>, <strong>p</strong>, <strong>strong</strong>, <strong>a</strong> and <strong>img</strong> are allowed. Empty to hide</p>';
      
}

/* ### Footnote field */

function wpw_brand_footnote_callback() {

    global $wpw_options;
    echo '<input size="49" type="text" id="wpw_brand_footnote" name="wpw_settings[brand_footnote]" value="' . esc_attr($wpw_options['brand_footnote']) . '" />';
    echo '<p class="wpw-description">Custom footer text all over the backend. Little html like <strong>br</strong>, <strong>p</strong>, <strong>strong</strong>, <strong>a</strong> and <strong>img</strong> are allowed. Empty to hide</p>';
  
}

/* ## Media settings
------------------------------------------------------------------ */

/* ### Media section */

function wpw_media_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['media_enable']) && $wpw_options['media_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[media_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Allows admins to upload SVG images and corrects the incorrect display in the media library and frontend. Overrides the upload path for files set in the media settings.</p>';

}

/* ### Media support fields */

function wpw_media_support_callback() {

    $field = array(

        'media_svg_upload'  => 'SVG image upload <strong>(admins only)</strong>',
        'media_svg_images'  => 'SVG images in the media library and frontend',
        'media_per_year'    => 'Manage uploads per year',
        
    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {

        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';

    }

}

/* ### Storage section */

function wpw_storage_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['storage_enable']) && $wpw_options['storage_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[storage_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Enable AWS S3 third party compatibility. Overwrites the default AWS endpoint for compatibility with providers like IONOS or OVHcloud. Human Made Plugin S3 Uploads required.</p>';

}

/* ### Storage S3 endpoint field */

function wpw_storage_s3_endpoint_callback() {

    global $wpw_options;
    echo '<input size="49" type="text" id="wpw_storage_s3_endpoint" name="wpw_settings[storage_s3_endpoint]" value="' . esc_attr($wpw_options['storage_s3_endpoint']) . '" />';
    echo '<p class="wpw-description">Consult your object storage provider for the correct regional url.</p>';

}

/* ### Storage S3 parameter fields */

function wpw_storage_s3_parameter_callback() {

    $field = array(

        'storage_s3_path'     => 'Use path style endpoint',
        'storage_s3_debug'    => 'Debug mode if uploads are failing',
        
    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {

        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';

    }

}

/* ## Security settings
------------------------------------------------------------------ */

/* ### Security section */

function wpw_security_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['security_enable']) && $wpw_options['security_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[security_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Lockdown brute force attacks, disable login with usernames which can be read plain at the authors archives or restrict admin creation to admins only even though editors are setup to create users too.</p>';

}

/* ### Security lockdown fields */

function wpw_security_lockdown_callback() {

    $field = array(
        
        'security_lockdown_bruteforce' => 'Block IPs committing brute force attacks (<strong>24 hours after 3 attempts within 24 hours</strong>)',
        'security_lockdown_logging'    => 'Log to file  <a class="wpw-button" href="' . WP_CONTENT_URL . '/wpw-lock.log" target="_blank" rel="noopener" type="text/plain">download</a>'

    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {
        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';
    }

}

/* ### Security disable fields */

function wpw_security_disable_callback() {

    $field = array(
        
        'security_disable_username_login'   => 'Login via open readable username (<strong>email only</strong>)',
        'security_disable_creating_admins'  => 'Admin creation for editors'

    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {
        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';
    }

}

/* ## Privacy settings
------------------------------------------------------------------ */

/* ### Privacy section */

function wpw_privacy_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['privacy_enable']) && $wpw_options['privacy_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[privacy_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Mask email addresses and phone numbers for spam protection by encoding them with ASCII codes. Extend YouTube links with no-cookie-request and disable Google Fonts.</p>';

}

/* ### Privacy mail fields */

function wpw_privacy_mail_callback() {

    $field = array(

        'privacy_mask_mail_shortcode'   => 'Shortcode for masking emails e.g. <strong>[mask-mail]</strong>',
        'privacy_mask_phone_shortcode'  => 'Shortcode for masking phone numbers e.g. <strong>[mask-phone]</strong>',
        'privacy_encode_mails_numbers'  => 'Filtering the whole site for mail adresses and phone numbers to encode them',

    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {

        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';

    }

}

/* ### Privacy Google fields */

function wpw_privacy_google_callback() {

    $field = array(

        'privacy_nocookie_youtube'  => 'No cookie requests at all embedded YouTube videos',
        'privacy_google_fonts'      => 'Disable all external implemented Google Fonts',

    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {

        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';

    }

}

/* ## Code settings
------------------------------------------------------------------ */

/* ### Code section */

function wpw_code_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['code_enable']) && $wpw_options['code_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[code_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Inject code snippets sitewide into the header or footer and clean the code from unnecessary HTML for performance or security reasons, e.g. disable xmlrpc.php unless you require it for remote publishing or the Jetpack plugin.</p>';
}

/* ### Code header script field */

function wpw_code_header_callback() {

    global $wpw_options;
    echo '<textarea rows="10" cols="50" id="wpw_code_header_script" name="wpw_settings[code_header_script]">' .  esc_attr($wpw_options['code_header_script']) . '</textarea>';
    echo '<p class="wpw-description">Copy & paste any code usually JavaScript or HTML into the head section</p>';
 
}

/* ### Code footer script field */

function wpw_code_footer_callback() {

    global $wpw_options;
    echo '<textarea rows="10" cols="50" id="wpw_code_footer_script" name="wpw_settings[code_footer_script]">' .  esc_attr($wpw_options['code_footer_script']) . '</textarea>';
    echo '<p class="wpw-description">Copy & pase any code usually JavaScript or HTML into the footer section</p>';
 
}

/* ### Code limit injection field */

function wpw_code_limit_injection_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['code_limit_injection']) && $wpw_options['code_limit_injection'] ? 'checked' : '';

    echo '<label><input type="checkbox" name="wpw_settings[code_limit_injection]" ' . $checked . ' /> Do not deploy header or footer scripts to logged in users</label><br>';

}

/* ### Code disable fields */

function wpw_code_disable_callback() {

    $field = array(
        
        'code_remove_wp_generator'       => 'WP Generator with information about installed CMS and current version',
        'code_remove_wlwmanifest_link'   => 'WLW Manifest link, needed to support Windows Live Writer',
        'code_remove_xmlrpc'             => 'XML-RPC interface, pingbacks and the RSD link in header',
        'code_remove_emoij_support'      => 'Emoji support for displaying emoji characters on a website'

    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {
        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';
    }
}

/* ## Developer settings
------------------------------------------------------------------ */

/* ### Developer section */

function wpw_developer_callback() {

    global $wpw_options;
    $checked = isset($wpw_options['developer_enable']) && $wpw_options['developer_enable'] ? 'checked' : '';

    echo '<input type="checkbox" name="wpw_settings[developer_enable]" ' . $checked . ' />';
    echo '<p class="wpw-intro">Options for developing purposes. Not recommended for productive environments.</p>';

}

/* ### Developer enable fields */

function wpw_developer_activate_callback() {
    
    $field = array(

        'developer_hooks_reference' => 'Hooks list at the very bottom of every site with URL attached suffix <strong>?hooks</strong>'

    );

    global $wpw_options;
    foreach ($field as $function_key => $function_label) {
        $checked = isset($wpw_options[$function_key]) && $wpw_options[$function_key] ? 'checked' : '';
        echo '<label><input type="checkbox" name="wpw_settings[' . $function_key . ']" ' . $checked . ' /> ' . $function_label . '</label><br>';
    }

}

?>