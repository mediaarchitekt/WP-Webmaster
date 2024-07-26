<?php

/**
* Plugin Name: WP Webmaster
* Description: Extends an individual WordPress instance with necessary features and functions.
* Author: media:architekten
* Author URI: https://www.mediaarchitekten.com
* Version: 1.6
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Setup ------------------------------------------------------------------------------- */

/* ## Set variables
------------------------------------------------------------------ */

$wpw_plugin_path = plugin_dir_path(__FILE__);
$wpw_plugin_url = plugin_dir_url(__FILE__);

/* ## Load style sheets for backend
------------------------------------------------------------------ */

add_action('admin_enqueue_scripts', function() {

    global $wpw_plugin_url;
    
    // Register css file 
    wp_enqueue_style( 'wpw_styles', $wpw_plugin_url . 'assets/css/wpw-settings.min.css' );

} );

/* ## Load settings and callbacks in admin menu
------------------------------------------------------------------ */

add_action('admin_menu', function () {

    global $wpw_plugin_path;
    
    // Include settings page
    require_once $wpw_plugin_path . 'includes/settings.php';

    // Include settings callbacks
    require_once $wpw_plugin_path . 'includes/callbacks.php';

    // Include settings sanitizer
    require_once $wpw_plugin_path . 'includes/sanitizer.php';

}, 9);

/* ## Load all the rest
------------------------------------------------------------------ */

// Include crypting routines
require_once $wpw_plugin_path . 'includes/crypter.php';

// Include functions
require_once $wpw_plugin_path . 'includes/functions.php';

?>