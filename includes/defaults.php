<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $wpw_plugin_path;
global $wpw_options;

// Get blog infos
$wpw_site_name              = get_bloginfo('name');
$wpw_site_url               = get_bloginfo('url');
$wpw_site_host              = str_replace(array('https://', 'http://', 'www.'), '', $wpw_site_url);
$wpw_email_address          = 'info@' . $wpw_site_host;
$wpw_login_logo             = $wpw_site_url . '/wp-admin/images/wordpress-logo.svg';
$wpw_login_credits          = '&copy; ' . $wpw_site_name;
$wpw_backend_main_admin     = get_bloginfo('admin_email');

// Default options array
$wpw_default_options = array(
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
    'smtp_debugging'                    => 0,
    'smtp_logging'                      => false,
    'frontend_enable'                   => false,
    'frontend_filter_cats'              => '',
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
    'brand_widget_title'                => '',
    'brand_widget_message'              => '',
    'brand_footnote'                    => '',
    'media_enable'                      => false,
    'media_svg_upload'                  => true,
    'media_svg_images'                  => true,
    'media_per_year'                    => true,
    'storage_enable'                    => false,
    'storage_s3_endpoint'               => '',
    'storage_s3_path'                   => false,
    'storage_s3_debug'                  => false,
    'security_enable'                   => false,
    'security_lockdown_bruteforce'      => true,
    'security_lockdown_logging'         => true,
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
);

// Load config file if exists for individual settings
include_once $wpw_plugin_path . 'wpw-config.php';

// Merge with $wpw_config from external configuration file (overwriting defaults)
if (isset($wpw_config) && is_array($wpw_config)) { $wpw_default_options = array_merge($wpw_default_options, $wpw_config); }

// Merge with current options from database
$wpw_current_options = get_option('wpw_settings', array());
$wpw_options = array_merge($wpw_default_options, $wpw_current_options);

?>