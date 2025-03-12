<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Frontend ------------------------------------------------------------------------------- */

/* ## Tweaks the output of the frontend
------------------------------------------------------------------ */

/* ### Filter categories out of the loop */

if ( isset( $wpw_options['frontend_cf7_popup'] ) && $wpw_options['frontend_cf7_popup'] ) {

    add_action( 'wp_enqueue_scripts', function() {
        
        global $wpw_plugin_url;
        $cf7spVersion = '1.6';

        wp_enqueue_script( 'cf7simplepopup', $wpw_plugin_url . 'assets/js/cf7simplepopup.js', null, $cf7spVersion, true );
        wp_enqueue_script( 'sweetalert', $wpw_plugin_url . 'assets/js/sweetalert.min.js', null, $cf7spVersion, true );

        // Use handle of CF7 to implement inline css to hide classic response output
        wp_add_inline_style( 'contact-form-7', '.wpcf7-response-output { display: none !important; }' );

    });

}

/* ### Filter categories out of the loop */

if ( isset( $wpw_options['frontend_filter_cats'] ) && $wpw_options['frontend_filter_cats'] ) {
    
    add_action( 'pre_get_posts', function($query) use ( $wpw_options ) {

        if (!is_admin() && $query->is_main_query() && ($query->is_home() || $query->is_tag() || $query->is_author() || $query->is_date() || $query->is_search())) {
        
            // Convert the string of comma separated category names into an array
            $excluded_categories = array_map('trim', explode(',', $wpw_options['frontend_filter_cats']));
            
            // Transform category names into IDs
            $excluded_category_ids = array();
            foreach ($excluded_categories as $category_name) {
                $category = get_category_by_slug($category_name);
                if ($category) {
                    $excluded_category_ids[] = $category->term_id;
                }
            }
        
            // Create a string with negative IDs for the WP_Query
            $excluded_category_ids_string = '-' . implode(',-', $excluded_category_ids);
            $query->set('cat', $excluded_category_ids_string);

        }

    } );

}


if ( isset( $wpw_options['frontend_mediacontext_off'] ) && $wpw_options['frontend_mediacontext_off'] ) {

    add_action('wp_enqueue_scripts', function() { 

        global $wpw_plugin_url;
        wp_enqueue_script( 'frontend_mediacontext_off', $wpw_plugin_url . 'assets/js/mediacontextoff.js', null, 1.0, true );

    });

}