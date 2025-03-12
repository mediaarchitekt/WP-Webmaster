<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Login ------------------------------------------------------------------------------- */

/* ## Set custom design for login page
------------------------------------------------------------------ */

/* ### Load individual CSS */

add_action( 'login_enqueue_scripts', function() {

    wp_enqueue_style('login-theme', plugins_url('../../assets/css/wpw-login.min.css', __FILE__), array(), '1.0.0');

} );

/* ### Beautify login in an iframe when session expired */

add_action('admin_head', function() {

    echo '<style>
        #wp-auth-check-wrap #wp-auth-check { padding: 0px; background: none; }
        #wp-auth-check-wrap .wp-auth-check-close { color: indigo; z-index: 1; }
        #wp-auth-check-wrap #wp-auth-check-form { height: 102%; }
    </style>';

} );

/* ### Show credits in the footer */

if ( isset( $wpw_options['login_credits'] ) && !empty( $wpw_options['login_credits'] ) ) {

    add_action('login_footer', function() use ($wpw_options) {
        
        echo '<div class="footer">' . $wpw_options['login_credits'];

    } );

}

/* ### Load individual logo, title, link and url */

if ( isset( $wpw_options['login_logo'] ) && !empty( $wpw_options['login_logo'] ) ) {

    add_filter( 'login_headertext', function ($title) { return get_bloginfo('name'); } );
    add_filter( 'login_headerurl', function ($url) { return get_bloginfo('url'); } );

    add_action('login_head', function () use ($wpw_options) {

        echo '<style>
            .login #login h1 a { 
                background-image: url(' . $wpw_options['login_logo'] . '); 
                background-position: center center;
                background-size: contain;
                width: auto;
            }
        </style>';

    } );

}

/* ### Disable language switch */

if ( isset( $wpw_options['login_hide_language'] ) && !empty( $wpw_options['login_hide_language'] ) ) {

    add_filter('login_display_language_dropdown', function ($display) { return false; } );

}