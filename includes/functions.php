<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Functions ------------------------------------------------------------------------------- */

/* ## Set variables
------------------------------------------------------------------ */

// Read options from database
$wpw_options = get_option('wpw_settings');

/* ## Emails
------------------------------------------------------------------ */

/* ### Include email functions */

if ( isset( $wpw_options['email_enable'] ) && !empty( $wpw_options['email_enable'] ) ) {

    require_once $wpw_plugin_path . 'includes/functions/email.php';

}

/* ## SMTP
------------------------------------------------------------------ */

/* ### Include smtp functions */

if ( isset( $wpw_options['smtp_enable'] ) && !empty( $wpw_options['smtp_enable'] ) ) {

    require_once $wpw_plugin_path . 'includes/functions/smtp.php';

}

/* ## Frontend
------------------------------------------------------------------ */

/* ### Frontend tweaks */

if ( isset( $wpw_options['frontend_enable'] ) && !empty( $wpw_options['frontend_enable'] ) ) {

    require_once $wpw_plugin_path . 'includes/functions/frontend.php';

}

/* ## Login
------------------------------------------------------------------ */

/* ### Customize login page */

if ( isset( $wpw_options['login_enable'] ) && !empty( $wpw_options['login_enable'] ) ) {

    require_once $wpw_plugin_path . 'includes/functions/login.php';

}

/* ## Backend
------------------------------------------------------------------ */

/* ### Backend Cleanup */

if ( isset( $wpw_options['backend_enable'] ) && !empty( $wpw_options['backend_enable'] ) ) {

    require_once $wpw_plugin_path . 'includes/functions/backend.php';

}

/* ## Brand
------------------------------------------------------------------ */

/* ### Customize admin dashboard and footer */

if ( isset( $wpw_options['brand_enable'] ) && !empty( $wpw_options['brand_enable'] ) ) {

    require_once $wpw_plugin_path . 'includes/functions/brand.php';

}

/* ## Media 
------------------------------------------------------------------ */

/* ### Media library settings */

if ( isset( $wpw_options['media_enable'] ) && !empty( $wpw_options['media_enable'] ) ) {

    require_once $wpw_plugin_path . 'includes/functions/media.php';

}

/* ## Storage 
------------------------------------------------------------------ */

/* ## Overwrite the default AWS S3 endpoint for third party compatibility */

if ( isset( $wpw_options['storage_enable'] ) && $wpw_options['storage_enable'] ) {
    
    require_once $wpw_plugin_path . 'includes/functions/storage.php';

}

/* ## Security
------------------------------------------------------------------ */

/* ## Login settings and user creation */

if ( isset( $wpw_options['security_enable'] ) && $wpw_options['security_enable'] ) {

    require_once $wpw_plugin_path . 'includes/functions/security.php';

}

/* ## Privacy
------------------------------------------------------------------ */

/* ## Masks sensitive data against scrapers and others */

if ( isset( $wpw_options['privacy_enable'] ) && $wpw_options['privacy_enable'] ) {

    require_once $wpw_plugin_path . 'includes/functions/privacy.php';

}

/* ## Code
------------------------------------------------------------------ */

/* ## Masks sensitive data against scrapers and others */

if ( isset( $wpw_options['code_enable'] ) && $wpw_options['code_enable'] ) {
    
    require_once $wpw_plugin_path . 'includes/functions/code.php';

}

/* ## Developer
------------------------------------------------------------------ */

/* ### Display hooks reference */

if ( isset( $wpw_options['developer_enable'] ) && $wpw_options['developer_enable'] ) {

    require_once $wpw_plugin_path . 'includes/functions/developer.php';
    
}
