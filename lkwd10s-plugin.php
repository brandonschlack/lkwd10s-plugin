<?php
/*
Plugin Name: Lakewood Tennis Center Functions
Plugin URI:
Description: Bundle of functions to accompany the Lakewood Tennis Center theme.
Version:     0.1
Author:      Brandon Schlack
Author URI:  https://github.com/brandonschlack
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

require_once __DIR__ . '/inc/lkwd10s-event-post-type.php';

function lkwd10s_plugin_install() {

    // Trigger our function that registers the custom post type
    lkwd10s_event_post_type();

    // Clear the permalinks after the post type has been registered
    flush_rewrite_rules();

}
register_activation_hook( __FILE__, 'lkwd10s_plugin_install' );

function lkwd10s_plugin_deactivation() {

    // Our post type will be automatically removed, so no need to unregister it

    // Clear the permalinks to remove our post type's rules
    flush_rewrite_rules();

}
register_deactivation_hook( __FILE__, 'lkwd10s_plugin_deactivation' );
