<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Email ------------------------------------------------------------------------------- */

/* ## Email Settings
------------------------------------------------------------------ */

if ( isset( $wpw_options['email_name'] ) && !empty( $wpw_options['email_name'] ) ) {
    
    add_filter( 'wp_mail_from_name', function( $email_name ) use ( $wpw_options ) { return $wpw_options['email_name']; } );

}

/* ### Change the default System email address */

if ( isset( $wpw_options['email_address'] ) && !empty( $wpw_options['email_address'] ) ) {

    add_filter( 'wp_mail_from', function( $email_address ) use ( $wpw_options ) { return $wpw_options['email_address']; } );

}

/* ### Disable emails notifications */

if ( isset( $wpw_options['email_updates_core'] ) && !empty( $wpw_options['email_updates_core'] ) ) add_filter( 'auto_core_update_send_email', '__return_false' ); 
if ( isset( $wpw_options['email_updates_plugins'] ) && !empty( $wpw_options['email_updates_plugins'] ) ) add_filter( 'auto_plugin_update_send_email', '__return_false' );
if ( isset( $wpw_options['email_updates_themes'] ) && !empty( $wpw_options['email_updates_themes'] ) ) add_filter( 'auto_theme_update_send_email', '__return_false' );
