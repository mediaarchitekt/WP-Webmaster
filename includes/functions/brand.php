<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Brand ------------------------------------------------------------------------------- */

/* ## Customized backend
------------------------------------------------------------------ */

/* ### Build widget when all infos exist */

if ( isset( $wpw_options['brand_widget_title'] ) && $wpw_options['brand_widget_title'] && isset( $wpw_options['brand_widget_message'] ) && $wpw_options['brand_widget_message'] ) {
        
    add_action('wp_dashboard_setup', function() use ( $wpw_options ) { 

        global $wp_meta_boxes;
        wp_add_dashboard_widget('custom_help_widget', $wpw_options['brand_widget_title'], 'wpw_custom_dashboard_content');  
                  
    } );

    function wpw_custom_dashboard_content() { 

        global $wpw_options;
        echo $wpw_options['brand_widget_message']; 
    
    }

}

/* ### Change footer text in admin backend */

if ( isset( $wpw_options['brand_footnote'] ) && !empty( $wpw_options['brand_footnote'] ) ) {

    add_filter('admin_footer_text', function() use ( $wpw_options ) { echo $wpw_options['brand_footnote'] . ' '; } );

}