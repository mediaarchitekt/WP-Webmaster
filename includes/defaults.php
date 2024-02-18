<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

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
    'code_header_script'                => '',
    'code_footer_script'                => '',
    'code_limit_injection'              => false,
    'code_remove_wp_generator'          => true,
    'code_remove_wlwmanifest_link'      => true,
    'code_remove_xmlrpc'                => true,
    'code_remove_emoij_support'         => true,
    'developer_enable'                  => false,
    'developer_hooks_reference'         => false
));

?>