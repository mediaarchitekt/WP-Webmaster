<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Uninstall ------------------------------------------------------------------------------- */

/* ## Trigger uninstall process if WP_UNINSTALL_PLUGIN is defined
------------------------------------------------------------------ */

if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) { delete_option( 'wpw_settings' ); }