<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Sanitize settings ------------------------------------------------------------------------------- */

function wpw_settings_sanitize($input){

    global $wpw_encryption_key;
    $sanitized_input = array();
    $keep_tags = array( 
        'br'            => array(),
        'p'             => array(),
        'strong'        => array(),
        'a'             => array( 
            'href'      => array(), 
            'title'     => array(),
            'target'    => array(),
            'rel'       => array(),
        ),
        'img'           => array(
            'src'       => array(),
        ),
    );

    /* ## Text fields
    ------------------------------------------------------------------ */

    // Sanitize System email name and address
    if(isset($input['email_name'])){ $sanitized_input['email_name'] = sanitize_text_field($input['email_name']); }
    if(isset($input['email_address'])){ $sanitized_input['email_address'] = sanitize_email($input['email_address']); }

    // Sanitize SMTP host, user, entrance, encryption, port
    if(isset($input['smtp_host'])){ $sanitized_input['smtp_host'] = sanitize_text_field($input['smtp_host']); }
    if(isset($input['smtp_user'])){ $sanitized_input['smtp_user'] = sanitize_text_field($input['smtp_user']); }
    if(isset($input['smtp_entrance'])){ $sanitized_input['smtp_entrance'] = wpw_encrypt_password($input['smtp_entrance']); }
    if(isset($input['smtp_encryption'])){ $sanitized_input['smtp_encryption'] = sanitize_text_field($input['smtp_encryption']); }
    if(isset($input['smtp_port'])){ $sanitized_input['smtp_port'] = sanitize_text_field($input['smtp_port']); }

    // Sanitize categories for frontend loop
    if(isset($input['frontend_filter_cats'])){ $sanitized_input['frontend_filter_cats'] = sanitize_text_field($input['frontend_filter_cats']); }

    // Sanitize Login logo
    if(isset($input['login_logo']) && !empty($input['login_logo'])){ $sanitized_input['login_logo'] = sanitize_text_field($input['login_logo']); }
    else { $sanitized_input['login_logo'] = get_bloginfo('url') . '/wp-admin/images/wordpress-logo.svg'; }

    if(isset($input['login_credits'])){ $sanitized_input['login_credits'] = wp_kses( $input['login_credits'], $keep_tags ); }

    // Sanitize email-address of main admin
    if(isset($input['backend_main_admin']) && !empty($input['backend_main_admin'])){ $sanitized_input['backend_main_admin'] = sanitize_email($input['backend_main_admin']); } 
    else { $sanitized_input['backend_main_admin'] = get_bloginfo('admin_email'); }

    // Sanitize brand settings
    if(isset($input['brand_widget_title'])){ $sanitized_input['brand_widget_title'] = sanitize_text_field($input['brand_widget_title']); }
    if(isset($input['brand_widget_message'])){ $sanitized_input['brand_widget_message'] = wp_kses( $input['brand_widget_message'], $keep_tags ); }
    if(isset($input['brand_footnote'])){ $sanitized_input['brand_footnote'] = wp_kses( $input['brand_footnote'], $keep_tags ); }

    // Sanitize S3 endpoint title
    if(isset($input['storage_s3_endpoint'])){ $sanitized_input['storage_s3_endpoint'] = sanitize_text_field($input['storage_s3_endpoint']); }

    // Sanitize header & footer scripts
    if(isset($input['code_header_script'])){ $sanitized_input['code_header_script'] = $input['code_header_script']; }
    if(isset($input['code_footer_script'])){ $sanitized_input['code_footer_script'] = $input['code_footer_script']; }

    /* ## Checkboxes
    ------------------------------------------------------------------ */

    // Sanitize Funktionen
    $functions = array(
        'email_enable',
        'email_updates_plugins',
        'email_updates_themes',
        'email_updates_core',
        'smtp_enable',
        'smtp_selfsigned',
        'smtp_debugging',
        'smtp_logging',
        'frontend_enable',
        'frontend_cf7_popup',
        'frontend_mediacontext_off',
        'login_enable',
        'login_hide_language',
        'backend_enable',
        'backend_hide_adminbar_items',
        'backend_hide_adminbar',
        'backend_hide_menu_settings',
        'backend_hide_menu_blog',
        'backend_hide_updates',
        'backend_hide_health',
        'backend_hide_wpw_settings',
        'brand_enable',
        'media_enable',
        'media_svg_upload',
        'media_svg_images',
        'media_per_year',
        'storage_enable',
        'storage_s3_path',
        'storage_s3_debug',
        'security_enable',
        'security_lockdown_bruteforce',
        'security_lockdown_logging',
        'security_disable_username_login',
        'security_disable_creating_admins',
        'privacy_enable',
        'privacy_mask_mail_shortcode',
        'privacy_mask_phone_shortcode',
        'privacy_encode_mails_numbers',
        'privacy_nocookie_youtube',
        'privacy_google_fonts',
        'code_enable',
        'code_limit_injection',
        'code_remove_wp_generator',
        'code_remove_wlwmanifest_link',
        'code_remove_xmlrpc',
        'code_remove_emoij_support',
        'developer_enable',
        'developer_hooks_reference'
    );

    foreach ($functions as $function) {
        $sanitized_input[$function] = isset($input[$function]) && $input[$function] ? true : false;
    }

    return $sanitized_input;

}