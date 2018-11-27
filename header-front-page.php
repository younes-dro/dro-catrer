<?php
/**
 * The header for the Front Page
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dro_caterer
 */
/**
 * Create the Front Page Object 
 */
global $dro_caterer_frontpage;
$dro_caterer_frontpage = new dro_caterer_frontpage(get_the_ID());
//var_dump($dro_caterer_frontpage);
if($dro_caterer_frontpage->has_child === 0)
    echo "Page without children ";

?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="https://gmpg.org/xfn/11">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div id="page" class="site">
            <?php
            global $bootstrap_container;
            $bootstrap_container = (dro_caterer_get_option('dro_caterer_full_width_status')) ? "container-fluid" : "container";
            ?>
            <div class="<?php echo $bootstrap_container ?>">
                <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'dro-caterer'); ?></a>
                <header id="masthead" class="site-header">

                    <div class="navbar navbar-inverse navbar-fixed-top">
                        <div class="navbar-inner">
                            <div class="<?php echo $bootstrap_container ?>">
                                <nav id="site-navigation" class="main-navigation" role="navigation">
                                    <!-- The navigation menu will be placed here using javascript -->
                                    <?php
                                    $menu_attributes = array(
                                        'menu_class' => 'menu'
                                    );
                                    $dro_caterer_frontpage->frontpage_nav_menu($menu_attributes);
                                    ?>
                                </nav><!-- #site-navigation -->
                            </div>
                        </div>
                    </div>
                </header><!-- #masthead -->


                <div id="content" class="site-content">
