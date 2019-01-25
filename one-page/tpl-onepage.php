<?php

/*
 * Template Name: caterer One Page
 *
 * @package dro_caterer
 */

get_template_part('one-page/header-onepage');
?>
<div class="container-fluid">
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
</div>
<?php
get_footer();


