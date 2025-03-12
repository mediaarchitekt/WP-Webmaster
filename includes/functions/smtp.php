<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # SMTP ------------------------------------------------------------------------------- */

/* ## SMTP Settings
------------------------------------------------------------------ */

/* ## Set credentials for sending via SMTP  */

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
        $phpmailer->SMTPDebug = (int)$wpw_options['smtp_debugging'] * 2;                       // Debug level 0, 1, 2, 3, ...
        $phpmailer->SMTPOptions['ssl']['allow_self_signed'] = $wpw_options['smtp_selfsigned'];  // Defaults are true, true, false
    
        /* ## Enable debugging */
        
        if (isset($wpw_options['smtp_debugging']) && $wpw_options['smtp_debugging']) {
      
            // Activates SMTP-debugging
            $GLOBALS['wpw_debug_output'] = '';

            // Adds the debug output string to the variable
            $phpmailer->Debugoutput = function($str, $level) { $GLOBALS['wpw_debug_output'] .= $str; };
            
            add_action( 'wp_footer', 'wpw_debug_alert' );
            add_action( 'admin_footer', 'wpw_debug_alert' );
            
            // Check if debug output exists and then popup JavaScript alert 
            function wpw_debug_alert() {

                global $wpw_debug_output;
                if (isset($wpw_debug_output) && !empty($wpw_debug_output)) { echo "<script>alert(" . json_encode($wpw_debug_output) . ");</script>"; }

            }

        }

        return $phpmailer;

    } );

}

/* ## Enable loggin */

if (isset($wpw_options['smtp_logging']) && $wpw_options['smtp_logging']) {

    add_action( 'phpmailer_init', function($phpmailer) {

        $recipients = $phpmailer->getToAddresses();

        if (!empty($recipients)) {
        
            $first_recipient = reset($recipients);
            $recipient_email = $first_recipient[0];
            $recipient_name = $first_recipient[1];

        }

        $log_entry = date_i18n( 'Y-m-d H:i:s' ) . " - " . $phpmailer->FromName . " <" . $phpmailer->From . "> - " . $recipient_name . " <" . $recipient_email . "> - " . $phpmailer->Subject . "\n";
        error_log( $log_entry, 3, WP_CONTENT_DIR . '/wpw-mail.log' );

    } );
    
    add_action( 'wp_mail_failed', function($wp_error) {

        $logfile = WP_CONTENT_DIR . '/wpw-mail.log';
        $filepointer = fopen($logfile, 'a');
        fputs($filepointer, date_i18n( 'Y-m-d H:i:s' ) . " - " . $wp_error->get_error_message() . "\n");
        fclose($filepointer);

    } );

}