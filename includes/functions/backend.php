<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Backend ------------------------------------------------------------------------------- */

/* ## Backend Cleanup
------------------------------------------------------------------ */

/* ### Remove some items from the WordPress Admin Bar */

if ( isset( $wpw_options['backend_hide_adminbar_items'] ) && $wpw_options['backend_hide_adminbar_items'] ) {
    
    add_action( 'wp_before_admin_bar_render', function() {

        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
        $wp_admin_bar->remove_menu('comments');
        $wp_admin_bar->remove_menu('updates');
        $wp_admin_bar->remove_menu('customize');
        $wp_admin_bar->remove_node('themes');
        $wp_admin_bar->remove_node('widgets');
        $wp_admin_bar->remove_node('menus');
        $wp_admin_bar->remove_node('plugins');
        $wp_admin_bar->remove_node('dashboard');
        $wp_admin_bar->remove_node('view-site');

    } );

}

/* ### Hide admin bar for all users except admins and editors */

if ( isset( $wpw_options['backend_hide_adminbar'] ) && $wpw_options['backend_hide_adminbar'] ) {

    add_action('after_setup_theme', function() { if ( ! current_user_can('edit_pages') ) { show_admin_bar(false); } } );

}

/* ### Hide blog functionality from admin menu for users that are not admins */

if ( isset( $wpw_options['backend_hide_menu_blog'] ) && $wpw_options['backend_hide_menu_blog'] ) {

    add_action( 'admin_bar_menu', function($wp_admin_bar) use ( $wpw_options ) {

        $current_user = wp_get_current_user();

        if ( $wpw_options['backend_main_admin'] !== $current_user->user_email ) { $wp_admin_bar->remove_node('new-post'); }

    }, 999 );

    add_action('admin_menu', function() use ( $wpw_options ) {

        $current_user = wp_get_current_user();

        if ( $wpw_options['backend_main_admin'] !== $current_user->user_email ) {

            remove_menu_page('edit.php');
            remove_menu_page('edit-comments.php');
    
        }

    }, 999 );

    add_action('wp_dashboard_setup', function () { remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); } );

}

/* ### Hide sensitive settings from admin menu for users that are not admins or not main admin */

if ( isset( $wpw_options['backend_hide_menu_settings'] ) && $wpw_options['backend_hide_menu_settings'] ) {     

    add_action('admin_menu', function() use ( $wpw_options ) {

        if ( ! current_user_can('manage_options') ) {

            global $menu;
            $restricted = array(__('Links'), __('Appearance'), __('Plugins'), __('Tools'), __('Settings'));
            end ($menu);

            while (prev($menu)){
                $value = explode(' ',$menu[key($menu)][0]);
                if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
            }

            remove_menu_page('edit.php?post_type=genesis_custom_block');
            remove_menu_page('kadence-blocks');

        }

    }, 999);

}

/* ## Disable update notifications for users that are not main admin */

if ( isset( $wpw_options['backend_hide_updates'] ) && $wpw_options['backend_hide_updates'] ) {
    
    add_action('admin_head', function() use ( $wpw_options ) { 
        
        $current_user = wp_get_current_user();

        if ( $wpw_options['backend_main_admin'] !==  $current_user->user_email ) { 

            remove_action( 'admin_notices', 'update_nag', 3 );
            remove_submenu_page( 'index.php', 'update-core.php' );
            echo '<style type="text/css">.update-plugins { display: none !important; }</style>';
            
        }

    } );
 
}

/* ## Disable site health status menu and widget for users that are not main admin */

if ( isset( $wpw_options['backend_hide_health'] ) && $wpw_options['backend_hide_health'] ) {

    add_action('admin_init', function() use ( $wpw_options ) {
        
        $admin_email = get_bloginfo('admin_email');
        $current_user = wp_get_current_user();

        if ( $wpw_options['backend_main_admin'] !==  $current_user->user_email ) {

            global $wp_meta_boxes;
            remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
            remove_submenu_page( 'tools.php', 'site-health.php' );
            
        }

    } );

}

/* ## Disable the settings page of this plugin for all users except main admin */

if ( isset( $wpw_options['backend_hide_wpw_settings'] ) && $wpw_options['backend_hide_wpw_settings'] ) { 
        
    add_action('admin_init', function() use ( $wpw_options ) { 
        
        $current_user = wp_get_current_user();
        
        if ( $wpw_options['backend_main_admin'] !==  $current_user->user_email ) { remove_submenu_page( 'options-general.php', 'wp-webmaster' ); }

    } );
    
}

?>