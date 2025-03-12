<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Privacy ------------------------------------------------------------------------------- */

/* ## Masks sensitive data for scrapers and prevent home calling
------------------------------------------------------------------ */

/* ### Shortcode for masking emails with ASCII code */

if ( isset( $wpw_options['privacy_mask_mail_shortcode'] ) && $wpw_options['privacy_mask_mail_shortcode'] ) {

    add_shortcode('mask-mail', function( $atts , $content = null ) {
        if ( ! is_email( $content ) ) { return; }
        return '<a class="mask-mail" href="' . antispambot( 'mailto:' . $content ) . '" title="Nachricht an ' . antispambot( $content ) . ' schreiben">' . antispambot( $content ) . '</a>';
    } );

}

/* ### Shortcode for masking phone numbers with ASCII code */

if ( isset( $wpw_options['privacy_mask_phone_shortcode'] ) && $wpw_options['privacy_mask_phone_shortcode'] ) {

    add_shortcode('mask-phone', function( $atts , $content = null ) {
		return '<a class="mask-phone" href="' . antispambot( 'tel:' . $content ) . '" title="Telefonnummer ' . antispambot( $content ) . ' anrufen">' . antispambot( $content ) . '</a>';
    } );

}

/* ### Filters the whole site for mail adresses and phone numbers to encode them */

if ( isset( $wpw_options['privacy_encode_mails_numbers'] ) && $wpw_options['privacy_encode_mails_numbers'] ) {

    // Buffer all output    
    ob_start();
    add_action('wp_footer', function () {

        $html = ob_get_clean();
        // Find phone numbers without quotationmark at the beginning and the end
        $phone_pattern = '/(?<!["\'])(?<=\s|\>|^)(?:\+\d{2}|\(\d{3,}\))\s*\d+(?:\s*\d+)*\b(?=\s|\<|$)/';
        // Find email addresses without quotationmark at the beginning and the end
        $email_pattern = '/(?<!["\'])(?<=\s|\>|^)[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}(?=\s|\<|$)/';

        // Encrypt 'tel:' and 'mailto:'
        $html = str_replace(array('tel:', 'mailto:'), array(antispambot('tel:'), antispambot('mailto:')), $html);
    
        // Encrypt phone numbers
        $html = preg_replace_callback($phone_pattern, function($matches) {
            $phone_number = $matches[0];
            return '<a class="mask-phone" href="' . antispambot('tel:' . $phone_number) . '" title="Nummer ' . antispambot($phone_number) . ' anrufen">' . antispambot($phone_number) . '</a>';
        }, $html);
    
        // Encrypt email addresses
        $html = preg_replace_callback($email_pattern, function($matches) {
            $mail_address = $matches[0];
            return '<a class="mask-mail" href="' . antispambot('mailto:' . $mail_address) . '" title="Nachricht an ' . antispambot($mail_address) . ' schreiben">' . antispambot($mail_address) . '</a>';
        }, $html);
    
        echo $html;
        
    }, 0);

}

/* ### YouTube Privacy */

if ( isset( $wpw_options['privacy_nocookie_youtube'] ) && $wpw_options['privacy_nocookie_youtube'] ) {

    add_filter('oembed_dataparse', function($return, $data, $url) {
  
        if ($data->provider_name == 'YouTube' && strpos($data->html, 'youtube-nocookie.com') === false) {
            $data->html = str_replace('youtube.com', 'youtube-nocookie.com', $data->html);
            $return = $data->html;
        }

    }, 10, 3);

}

/* ### Disable Google Fonts */

if ( isset( $wpw_options['privacy_google_fonts'] ) && $wpw_options['privacy_google_fonts'] ) {

    // Remove DNS prefetch, preconnect and preload headers
    add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {

        if ( 'dns-prefetch' === $relation_type ) {
        
            $urls = array_diff( $urls, array( 'fonts.googleapis.com' ) );
        
        } elseif ( 'preconnect' === $relation_type || 'preload' === $relation_type ) {
            
            foreach ( $urls as $key => $url ) {
            
                if ( ! isset( $url['href'] ) ) { continue; }
                if ( preg_match( '/\/\/fonts\.(gstatic|googleapis)\.com/', $url['href'] ) ) { unset( $urls[ $key ] ); }

            }
            
        }

        return $urls;
        
    }, PHP_INT_MAX, 2 );

    // Dequeue Google Fonts based on URL
    add_action( 'wp_enqueue_scripts', 'drgf_dequeueu_fonts', PHP_INT_MAX );
    add_action( 'wp_print_styles', 'drgf_dequeueu_fonts', PHP_INT_MAX );
    function drgf_dequeueu_fonts() {

        global $wp_styles;
        if ( ! ( $wp_styles instanceof WP_Styles ) ) { return; }

        foreach ( $wp_styles->registered as $style ) {
            
            $handle = $style->handle;
            $src    = $style->src;

            if ( strpos( $src, 'fonts.googleapis' ) !== false ) { wp_dequeue_style( $handle ); }

        }

        remove_action( 'wp_head', 'hu_print_gfont_head_link', 2 );
        remove_action( 'wp_head', 'appointment_load_google_font' );

    }

}