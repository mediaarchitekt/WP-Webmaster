<?php 

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * The base configuration for WP Webmaster
 *
 * This file contains the following configurations:
 *
 * * frontend_filter_loop   // Comma separated list of category names not shown in blog loop
 * * login_logo             // URL for custom logo on login page 
 * * login_credits          // Individual Footnote on login page
 * * backend_main_admin     // Email-address of the privileged main admin
 * * brand_widget_title     // Widget title on admin dashboard
 * * brand_widget_message   // Widget content on admin dashboard
 * * brand_footnote         // Individual footnote all over the admin backend
 * * storage_s3_endpoint    // Endpoint of thirdparty providers for S3 
 * 
 * @package WP Webmaster
 */

global $wpw_config;

/** Put all your individual defaults in here */

$wpw_config = array(
    'frontend_filter_cats'  => '',
    'login_logo'            => '',
    'login_credits'         => '',
    'backend_main_admin'    => '',
    'brand_widget_title'    => '',
    'brand_widget_message'  => '',
    'brand_footnote'        => '',
    'storage_s3_endpoint'   => ''
);

?>