<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # Developer ------------------------------------------------------------------------------- */

/* ## Setup hooks table at the very end of page load
------------------------------------------------------------------ */

/* ### Display hooks reference */

if ( isset( $wpw_options['developer_hooks_reference'] ) && $wpw_options['developer_hooks_reference'] ) {

    add_action( 'shutdown', function() {

        // Only shown for Administrator level users when ?hooks is added to the URL
        $trigger = isset( $_GET['hooks'] ) && current_user_can( 'manage_options' );
        if ( ! $trigger ) return;

        // Capture and sort filters and hooks
        $filters = array_keys( $GLOBALS['wp_filter'] );
        sort( $filters );
        $actions = array_keys( $GLOBALS['wp_actions'] );

        // Output rough template
        ob_start(); ?>

            <section class="wp-hooks">

                <h1 class="wp-hooks__h1">WordPress Hooks Reference</h1>
                
                <div class="wp-hooks__lists">

                    <div class="wp-hooks__col">
                        <h2 class="wp-hooks__h2">Actions</h2>
                        <?php foreach ( $actions as $hook ) : ?>
                            <p class="wp-hooks__hook"><?php echo $hook; ?></p>
                        <?php endforeach; ?>
                    </div>

                    <div class="wp-hooks__col">
                        <h2 class="wp-hooks__h2">Filters</h2>
                        <?php foreach ( $filters as $hook ) : ?>
                            <p class="wp-hooks__hook"><?php echo $hook; ?></p>
                        <?php endforeach; ?>
                    </div>

                </div>

            </section>

            <style>
                .wp-hooks {
                    padding: 30px;
                    margin: 30px;
                    border-radius: 4px;
                    background: white;
                    font-size: 16px;
                    line-height: 1.4;
                    height: 50vh;
                    min-height: 500px;
                    overflow-y: scroll;
                }
                .wp-hooks__lists {
                    display: flex;
                }
                .wp-hooks__col {
                    flex: 1;
                    width: 50%;
                }
                .wp-hooks__h1 {
                    margin: 0 0 20px;
                }
                .wp-hooks__h2 {
                    line-height: 1;
                    font-size: 18px;
                    margin: 0 0 10px;
                }
                .wp-hooks__hook {
                    padding: 0;
                    margin: 0;
                }
            </style>

        <?php ob_end_flush();

    } );

}