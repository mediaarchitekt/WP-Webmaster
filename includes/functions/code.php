<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Code ------------------------------------------------------------------------------- */

/* ## Inject Code
------------------------------------------------------------------ */
  
/* ### Header Scripts */

if ( isset( $wpw_options['code_header_script'] ) && $wpw_options['code_header_script'] ) { 
    
    add_action('wp_head', function() use ( $wpw_options ) { 
        
        // Inject to all or only if user is not logged in
        if ( !isset( $wpw_options['code_limit_injection'] ) || !$wpw_options['code_limit_injection'] || !is_user_logged_in() ) {
        
            echo $wpw_options['code_header_script']; 

        }
    
    } );

}

/* ### Footer Scripts */

if ( isset( $wpw_options['code_footer_script'] ) && $wpw_options['code_footer_script'] ) { 
    
    add_action('wp_footer', function() use ( $wpw_options ) { 
        
        // Inject to all or only if user is not logged in
        if ( !isset( $wpw_options['code_limit_injection'] ) || !$wpw_options['code_limit_injection'] || !is_user_logged_in() ) {
            
            echo $wpw_options['code_footer_script']; 
        
        }

    } );

}

/* ## Clean HTML Code
------------------------------------------------------------------ */

/* ### Remove WP Generator */

if ( isset( $wpw_options['code_remove_wp_generator'] ) && $wpw_options['code_remove_wp_generator'] ) { remove_action( 'wp_head', 'wp_generator' ); }

/* ### Remove WLWManifest link */

if ( isset( $wpw_options['code_remove_wlwmanifest_link'] ) && $wpw_options['code_remove_wlwmanifest_link'] ) { remove_action( 'wp_head', 'wlwmanifest_link' ); }

/* ### Disable XML-RPC interface */

if ( isset( $wpw_options['code_remove_xmlrpc'] ) && $wpw_options['code_remove_xmlrpc'] ) {

    add_filter( 'xmlrpc_methods', function ( $methods ) { return array(); } );
    remove_action('wp_head', 'rsd_link');

    add_filter( 'wp_headers', function ( $headers ) {
        unset( $headers['X-Pingback'] );
        return $headers;
    } );

}

/* ### Remove emoji support */

if ( isset( $wpw_options['code_remove_relational_links'] ) && $wpw_options['code_remove_relational_links'] ) { 

        remove_action( 'wp_head', 'print_emoji_detection_script', 7);
        remove_action( 'wp_print_styles', 'print_emoji_styles');
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );

}