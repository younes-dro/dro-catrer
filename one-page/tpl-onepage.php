<?php

/*
 * Template Name: caterer one page
 *
 * @package dro_caterer
 */
//get_header('one-page/header-onepage');
require get_template_directory().'/one-page/header-onepage.php';
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


