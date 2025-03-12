<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Security ------------------------------------------------------------------------------- */

/* ## Login lockdown
------------------------------------------------------------------ */

/* Credits to https://phppot.com/wordpress/how-to-limit-login-attempts-in-wordpress/ */

/* ### Check for Brute Force Attacks */

if ( isset( $wpw_options['security_lockdown_bruteforce'] ) && $wpw_options['security_lockdown_bruteforce'] ) {

    /* ### Lockdown when more the 3 times failed */

    add_filter( 'authenticate', function( $user, $username, $password ) {

        $ip = $_SERVER['REMOTE_ADDR'];

        if ( get_transient( 'wpw_attempted_login_' . $ip ) ) {
        
            $datas = get_transient( 'wpw_attempted_login_' . $ip );

            if ( $datas['tried'] >= 3 ) {
        
                $until = get_option( '_transient_timeout_' . 'wpw_attempted_login_' . $ip );
                $time = time_to_go( $until );
                return new WP_Error( 'too_many_tried',  sprintf( __( 'You have reached the authentication limit, try again in %1$s.' ) , $time ) );

            }

        }

        return $user;

    }, 30, 3 ); 

    /* ### Check for failed login attempts */

    add_action( 'wp_login_failed', function ( $username ) {

        $ip = $_SERVER['REMOTE_ADDR'];

        if ( get_transient( 'wpw_attempted_login_' . $ip ) ) {

            $datas = get_transient( 'wpw_attempted_login_' . $ip );
            $datas['tried']++;

            if ( $datas['tried'] <= 3 ) { set_transient( 'wpw_attempted_login_' . $ip, $datas , 86400 ); } // Expiration of counting failed logins in seconds (86400s = 24h)

        } else {
            
            $datas = array(
                'tried'     => 1
            );

            set_transient( 'wpw_attempted_login_' . $ip, $datas , 86400 );

        }

        $wpw_options = get_option('wpw_settings');
                
        // Write failing ip to log file when logging is enabled
        if ( isset( $wpw_options['security_lockdown_logging'] ) && $wpw_options['security_lockdown_logging'] ) {

           $logfile = WP_CONTENT_DIR . '/wpw-lock.log';
           $filepointer = fopen($logfile, 'a');
           if ( $datas['tried'] < 3 ) { fputs($filepointer, date_i18n( 'Y-m-d H:i:s' ) . " - " . $ip . " - failed login as " . $username . "\n"); }
           if ( $datas['tried'] == 3 ) { fputs($filepointer, date_i18n( 'Y-m-d H:i:s' ) . " - " . $ip . " - failed login as " . $username . " - blocked \n"); }
           fclose($filepointer);

        }

    }, 10, 1 );

    /* ### Calculate the remaining time until the next try  */

    function time_to_go($timestamp) {

        // Convert MySQL timestamp to PHP time
        $periods = array(
            "second",
            "minute",
            "hour",
            "day",
            "week",
            "month",
            "year"
        );

        $lengths = array(
            "60",
            "60",
            "24",
            "7",
            "4.35",
            "12"
        );

        $current_timestamp = time();
        $difference = abs($current_timestamp - $timestamp);

        for ($i = 0; $difference >= $lengths[$i] && $i < count($lengths) - 1; $i ++) { $difference /= $lengths[$i]; }
        
        $difference = round($difference);
        
        if (isset($difference)) {

            if ($difference != 1) $periods[$i] .= "s";

            $output = "$difference $periods[$i]";
            return $output;

        }

    }

}

/* ## Login settings and user creation
------------------------------------------------------------------ */

/* ### Disable login with username */

if ( isset( $wpw_options['security_disable_username_login'] ) && $wpw_options['security_disable_username_login'] ) {

    add_action( 'wp_authenticate', function() { remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3); } );

    // Translate Error messages in en and de
    add_filter('gettext', function($translated, $text, $domain) {

        $translated = str_ireplace('Invalid username, email address or incorrect password.', 'Invalid email address or incorrect password.', $translated);
        $translated = str_ireplace('Username or Email Address', 'Email Address', $translated);

        $translated = str_ireplace('Benutzername oder E-Mail-Adresse', 'E-Mail-Adresse', $translated);
        $translated = str_ireplace('Ungültiger Benutzername, ungültige E-Mail-Adresse oder ungültiges Passwort.', 'Ungültige E-Mail-Adresse oder ungültiges Passwort.', $translated);
        
        return $translated;

    }, 100, 3);

}

/* ### Deny editors from creating admins if they can create users */

if ( isset( $wpw_options['security_disable_creating_admins'] ) && $wpw_options['security_disable_creating_admins'] ) {

    add_filter( 'editable_roles', function( $roles ) {

        $current_user = wp_get_current_user();
        if ( in_array( 'editor', $current_user->roles ) ) { unset( $roles['administrator'] ); }
        return $roles;
        
    } );

}