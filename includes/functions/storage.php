<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Storage ------------------------------------------------------------------------------- */

/* ## S3
------------------------------------------------------------------ */

/* ## Overwrite the default AWS S3 endpoint for third party compatibility */

add_filter( 's3_uploads_s3_client_params', function( $params ) use ( $wpw_options ) {
    
    $params['endpoint'] = $wpw_options['storage_s3_endpoint'];
    $params['use_path_style_endpoint'] = $wpw_options['storage_s3_path'];
    $params['debug'] = $wpw_options['storage_s3_path']; // Set to true if uploads are failing.
    return $params;

} );

?>