<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # SMTP ------------------------------------------------------------------------------- */

/* ## SMTP Settings
------------------------------------------------------------------ */

// Check, if all options are set
if (!empty($wpw_options['smtp_host']) &&
    !empty($wpw_options['smtp_user']) &&
    !empty($wpw_options['smtp_entrance']) &&
    !empty($wpw_options['smtp_encryption']) &&
    !empty($wpw_options['smtp_port'])) {

    add_action('phpmailer_init', function( $phpmailer ) use( $wpw_options ) {

        // Be sure to have an object for data consisty
        if ( ! is_object( $phpmailer ) ) { $phpmailer = (object) $phpmailer; }

        $phpmailer->isSMTP();                                                                   // Send emails via SMTP
        $phpmailer->Timeout        = 15;                                                        // Mark as failed connection after specified time
		$phpmailer->Timelimit      = 15;                                                        // Sets execution time for delivering
        $phpmailer->Host = $wpw_options['smtp_host'];                                           // 'example.com'
        $phpmailer->Username = $wpw_options['smtp_user'];                                       // SMTP username 'John'
        $phpmailer->Password = wpw_decrypt_password($wpw_options['smtp_entrance']);             // SMTP Password 'password'
        $phpmailer->SMTPAuth = true;                                                            // SMTP-Authentification true or false
        $phpmailer->SMTPSecure = $wpw_options['smtp_encryption'];                               // 'ssl' or 'tls'
        $phpmailer->Port = $wpw_options['smtp_port'];                                           // Port number of the SMTP-Server
        $phpmailer->SMTPDebug = (int)$wpw_options['smtp_debuglevel'] * 2;                       // Debug level 0, 1, 2, 3, ...
        $phpmailer->SMTPOptions['ssl']['allow_self_signed'] = $wpw_options['smtp_selfsigned'];  // Defaults are true, true, false

        return $phpmailer;
    } );

}

?>