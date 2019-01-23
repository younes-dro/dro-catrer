<?php

/**
 * dro caterer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dro_caterer
 */
if (!function_exists('dro_caterer_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function dro_caterer_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on dro caterer, use a find and replace
         * to change 'dro-caterer' to the name of your theme in all the template files.
         */
        load_theme_textdomain('dro-caterer', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        /*
         * This theme uses wp_nav_menu() in tow location.
         * The First is the main menu for all website pages.
         * The second menu (Front page) will be visible 
         */
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'dro-caterer'),
            'menu-2' => esc_html__('Front Page (This Menu will be displayed in the Front Page)', 'dro-caterer')
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
//		add_theme_support( 'custom-background', apply_filters( 'dro_caterer_custom_background_args', array(
//			'default-color' => 'ffffff',
//			'default-image' => '',
//		) ) );
        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));
    }

endif;
add_action('after_setup_theme', 'dro_caterer_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function dro_caterer_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('dro_caterer_content_width', 640);
}

add_action('after_setup_theme', 'dro_caterer_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function dro_caterer_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar Right', 'dro-caterer'),
        'id' => 'sidebar-right',
        'description' => esc_html__('Add widgets here.', 'dro-caterer'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Sidebar Footer', 'dro-caterer'),
        'id' => 'sidebar-footer',
        'description' => esc_html__('Add widgets here.', 'dro-caterer'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'dro_caterer_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function dro_caterer_scripts() {
    /**
     * CSS
     */
    wp_enqueue_style('dro-caterer-bootstrap-css', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.css');
    wp_enqueue_style('dro-caterer-ionicons', get_template_directory_uri() . '/assets/ionicons/css/ionicons.css');
    wp_enqueue_style('dro-caterer-mobile-menu', get_template_directory_uri() . '/layouts/dro-sliding-menu.css');
    wp_enqueue_style('dro-caterer-style', get_stylesheet_uri());
    if(is_page_template()){
        wp_enqueue_style('dro-caterer-one-page-css', get_template_directory_uri() . '/layouts/dro-caterer-one-page.css');
    }

    /**
     * JS
     */
    if (!is_front_page()) {
        wp_enqueue_script('dro-caterer-superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), '20181014', true);
        wp_enqueue_script('dro-caterer-superfish-settings', get_template_directory_uri() . '/js/superfish-settings.js', array('dro-caterer-superfish'), '20181014', true);
    }
    if(is_page_template()){
        wp_enqueue_script('dro-caterer-one-page-js', get_template_directory_uri() . '/js/dro-caterer-one-page.js', array('jquery','dro-caterer-dro-sliding-menu'), '20181211', true);
    }
    
    
    wp_enqueue_script('dro-caterer-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20180511', true);
    wp_enqueue_script('dro-caterer-dro-sliding-menu', get_template_directory_uri() . '/js/dro-sliding-menu.js', array('jquery'), '20181211', true);
    wp_enqueue_script('dro-caterer-js', get_template_directory_uri() . '/js/dro-caterer.js', array('dro-caterer-dro-sliding-menu'), '20181211', true);
    wp_enqueue_script('dro-caterer-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);
    wp_enqueue_script('dro-caterer-bootsrap-js', get_template_directory_uri().'/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '20181711',TRUE);
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'dro_caterer_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load the Front Page Class
 */
function dro_caterer_class_frontpage() {
    if (is_page_template()) {
        require get_template_directory() . '/inc/class-dro-caterer-frontpage.php';
    }
}
add_action('template_redirect', 'dro_caterer_class_frontpage');

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function dro_caterer_front_page_template($template) {
    return is_home() ? '' : $template;
}

add_filter('frontpage_template', 'dro_caterer_front_page_template');
