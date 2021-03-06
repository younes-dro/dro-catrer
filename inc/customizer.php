<?php

/**
 * dro caterer Theme Customizer
 *
 * @package dro_caterer
 */
if (!function_exists('dro_caterer_customize_register')) {

    /**
     * Add postMessage support for site title and description for the Theme Customizer.
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     */
    function dro_caterer_customize_register($wp_customize) {
        $wp_customize->get_setting('blogname')->transport = 'postMessage';
        $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
        $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

        if (isset($wp_customize->selective_refresh)) {
            $wp_customize->selective_refresh->add_partial('blogname', array(
                'selector' => '.site-title a',
                'render_callback' => 'dro_caterer_customize_partial_blogname',
            ));
            $wp_customize->selective_refresh->add_partial('blogdescription', array(
                'selector' => '.site-description',
                'render_callback' => 'dro_caterer_customize_partial_blogdescription',
            ));
        }

        $default = dro_caterer_default_theme_options();

        //Theme option panel
        $wp_customize->add_panel('theme_option_panel', array('title' => esc_html__('Theme Options', 'dro-caterer'),
            'priority' => 200,
            'capability' => 'edit_theme_options'
        ));

        /**
         * Global Design section
         */
        $wp_customize->add_section('dro_caterer_design_section', array('title' => esc_html__('Desgin Option', 'dro-caterer'),
            'priority' => 100,
            'capability' => 'edit_theme_options',
            'panel' => 'theme_option_panel')
        );

        // Full width  option
        $wp_customize->add_setting('dro_caterer_full_width_status', array(
            'default' => $default['dro_caterer_full_width_status'],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'dro_caterer_sanitize_checkbox',
            'transport' => 'postMessage',
        ));
        $wp_customize->add_control('dro_caterer_full_width_status', array(
            'label' => esc_html__('Enable Full Width', 'dro-caterer'),
            'section' => 'dro_caterer_design_section',
            'type' => 'checkbox',
            'priority' => 100
                )
        );

        // Blog description color
        $wp_customize->add_setting('dro_caterer_blog_description_text_color', array(
            'default' => '#000000',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dro_caterer_blog_description_text_color', array(
            'label' => esc_html__('Blog Description Text Color', 'dro-caterer'),
            'description' => esc_html__('Change the text color for the blog description', 'dro-caterer'),
            'section' => 'colors',
            'priority' => 100
        )));

        // Main Menu color
        $wp_customize->add_setting('dro_caterer_main_menu_text_color', array(
            'default' => '#000000',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dro_caterer_main_menu_text_color', array(
            'label' => esc_html__('Main Menu text Color', 'dro-caterer'),
            'description' => esc_html__('Change the text color for the main menu', 'dro-caterer'),
            'section' => 'colors',
            'priority' => 100
        )));
        // Background Main Menu color
        $wp_customize->add_setting('dro_caterer_main_menu_background_color', array(
            'default' => '#000000',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport' => 'postMessage',
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'dro_caterer_main_menu_background_color', array(
            'label' => esc_html__('Main Menu Background Color', 'dro-caterer'),
            'description' => esc_html__('Change the background color for the main menu', 'dro-caterer'),
            'section' => 'colors',
            'priority' => 100
        )));

        /**
         * Design options for onepage style ( TODO);
         */
    }

}

add_action('customize_register', 'dro_caterer_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function dro_caterer_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function dro_caterer_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function dro_caterer_customize_preview_js() {
    wp_enqueue_script('dro-caterer-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), '20151215', true);
}

add_action('customize_preview_init', 'dro_caterer_customize_preview_js');


if (!function_exists('dro_caterer_default_theme_options')):

    /**
     * 
     * @return array The defaults values for the theme options 
     */
    function dro_caterer_default_theme_options() {

        $defaults = array();
        $defaults['dro_caterer_full_width_status'] = false;
//        $defaults['dro_caterer_sticky_header_status'] = false;
//        $defaults['dro_caterer_search_form_status'] = false;
//        $defaults['dro_caterer_scroll_top_status'] = false;

        return $defaults;
    }

endif;

/**
 * @param bool $checked Whether the checkbox is checked.
 *
 * @return bool Whether the checkbox is checked.
 */
if (!function_exists('dro_caterer_sanitize_checkbox')):

    function dro_caterer_sanitize_checkbox($checked) {
        return ( ( isset($checked) && true === $checked ) ? true : false );
    }

endif;

/**
 * Get theme option.
 * @param string $key Option key.
 * @return mixed Option value.
 */
if (!function_exists('dro_caterer_get_option')) :

    function dro_caterer_get_option($key) {

        if (empty($key)) {

            return;
        }
        $value = '';
        $default = dro_caterer_default_theme_options();
        $default_value = null;
        if (is_array($default) && isset($default[$key])) {

            $default_value = $default[$key];
        }
        if (null !== $default_value) {

            $value = get_theme_mod($key, $default_value);
        } else {
            $value = get_theme_mod($key);
        }

        return $value;
    }








endif;
