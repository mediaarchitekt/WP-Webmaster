<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Frontend ------------------------------------------------------------------------------- */

/* ## Tweaks the output of the frontend
------------------------------------------------------------------ */

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
