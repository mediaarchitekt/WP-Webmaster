<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Media ------------------------------------------------------------------------------- */

/* ## Media library settings
------------------------------------------------------------------ */

/* ## Allow SVG upload */

if ( isset( $wpw_options['media_svg_upload'] ) && $wpw_options['media_svg_upload'] ) {

    add_filter( 'wp_check_filetype_and_ext', function( $data, $file, $filename, $mimes) {

        // SVG files mime check
        $filetype = wp_check_filetype( $filename, $mimes );
        return [
            'ext'             => $filetype['ext'],
            'type'            => $filetype['type'],
            'proper_filename' => $data['proper_filename']
        ];

    }, 10, 4 );

    add_filter( 'upload_mimes', function( $upload_mimes ) {

        // By default, only administrator users are allowed to add SVGs.
        if ( current_user_can( 'manage_options' ) ) {
         
            // Allow SVG mime type
            $upload_mimes['svg']  = 'image/svg+xml';
            $upload_mimes['svgz'] = 'image/svg+xml';
            
        }
        return $upload_mimes;

    } );

}

/* ## Support SVG thumbnails in media library and frontend */

if ( isset( $wpw_options['media_svg_images'] ) && $wpw_options['media_svg_images'] ) {
    
    add_action( 'admin_head', function () {

        // Show proper thumbnails in the backend at media list view
        echo '<style type="text/css">.image-icon img[width="1"] { width: 60px !important; height: 60px !important; }</style>'; 
    
    } );

    add_filter( 'wp_get_attachment_image_src', function( $image, $attachment_id, $size, $icon ) {

        // Only manipulate for svgs to fix division by zero error https://github.com/WordPress/gutenberg/issues/36603
        if ( get_post_mime_type($attachment_id) == 'image/svg+xml' ) {
    
            if ( isset($image[1]) && $image[1] === 0 ) { $image[1] = 1; }
            if ( isset($image[2]) && $image[2] === 0 ) { $image[2] = 1; }
    
        }

        return $image;
    
    }, 10, 4 );

    add_filter( 'wp_calculate_image_srcset', function ( $sources ) {

        // Remove srcset for svg images
        $first_element = reset($sources);
        if ( isset($first_element) && !empty($first_element['url']) ) {

            $ext = pathinfo(reset($sources)['url'], PATHINFO_EXTENSION);

            if ( $ext == 'svg' ) {

                // Return empty array
                $sources = array();
                return $sources;

            } else { return $sources; }

        } else { return $sources; }

    } ); 

}

/* ## Organize media per year */

if ( isset( $wpw_options['media_per_year'] ) && $wpw_options['media_per_year'] ) {
    
    add_filter( 'upload_dir', function( $uploads ) {

        $year = date( 'Y' );
        $uploads['path'] = $uploads['basedir'] . '/' . $year;
        $uploads['url']  = $uploads['baseurl'] . '/' . $year;
        return $uploads;

    } );

}

?>