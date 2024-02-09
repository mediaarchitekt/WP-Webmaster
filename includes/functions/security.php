<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Security ------------------------------------------------------------------------------- */

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

/* ## Deny editors from creating admins if they can create users */

if ( isset( $wpw_options['security_disable_creating_admins'] ) && $wpw_options['security_disable_creating_admins'] ) {

    add_filter( 'editable_roles', function( $roles ) {

        $current_user = wp_get_current_user();
        if ( in_array( 'editor', $current_user->roles ) ) { unset( $roles['administrator'] ); }
        return $roles;
        
    } );

}

?>