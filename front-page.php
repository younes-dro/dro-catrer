<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dro_caterer
 */
get_header('front-page');
?>
<div class="row">

    <div class="col-12">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                
                <?php
//                var_dump(get_pages(array('child_of'=>  get_the_ID())));
                    $dro_caterer_frontpage->frontpage_content();
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .col-12 -->
</div><!-- .row -->

<?php
get_footer();
