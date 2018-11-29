<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package dro_caterer
 */
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
if (!function_exists('dro_caterer_body_classes')) {

    function dro_caterer_body_classes($classes) {
        // Adds a class of hfeed to non-singular pages.
        if (!is_singular()) {
            $classes[] = 'hfeed';
        }

        // Adds a class of no-sidebar when there is no sidebar present.
        if (!is_active_sidebar('sidebar-1')) {
            $classes[] = 'no-sidebar';
        }

        // Adds a class of dro-caterer-one-page when theme is witch to one page style .
        if (is_page_template()) {
            $classes[] = 'dro-caterer-one-page';
        }

        return $classes;
    }

}
add_filter('body_class', 'dro_caterer_body_classes');

if (!function_exists('dro_caterer_pingback_header')) {

    /**
     * Add a pingback url auto-discovery header for single posts, pages, or attachments.
     */
    function dro_caterer_pingback_header() {
        if (is_singular() && pings_open()) {
            echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
        }
    }

}
add_action('wp_head', 'dro_caterer_pingback_header');

if (!function_exists('dro_caterer_sidebar_status')) {
    /*
     * Whether a sidebar is in use
     */

    function dro_caterer_sidebar_status($sidebar) {

        if (is_active_sidebar($sidebar)) {
            return TRUE;
        }
    }

}
add_action('after_setup_theme', 'dro_caterer_sidebar_status');
