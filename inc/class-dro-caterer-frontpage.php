<?php

/**
 * 
 * This Class generate the menu and content for the front page 
 *
 * @author Younés DRO <dro66_8@hotmail.fr>
 * @version 1.0.0
 * @since 1.0.0
 */
class dro_caterer_frontpage {

    /**
     *
     * @var int $parant_page
     */
    public $parent_page;

    /**
     *
     * @var boolean 
     */
    public $has_child;

    /**
     * 
     * @var array 
     */
    private $pages;

    /**
     * The navigation menu parameters.
     * 
     * @var type array The Menu Parameters
     */
    public $menu_attributes = array(
        'menu_class' => 'front-page-nav-menu',
    );

    /**
     * The tags HTML content parameters.
     * Unused for the moment .
     * 
     * @var array The Content Parameters
     */
    public $content_attributes = array(
        'wrapper_html_tag' => '',
        'wrapper_class' => '',
    );

    /**
     * HTML navigation menu
     * 
     * @var string $menu 
     */
    private $menu;

    /**
     * HTML content 
     * 
     * @var string $content 
     */
    private $content;

    /**
     * Constructor
     * 
     * @param int $id The ID of the parent page.
     */
    public function __construct($id = '') {

        $this->parent_page = $id;
        $this->_get_pages();
        $this->_has_child();
    }

//    static function notice(){
//        echo '<div class="notice notice-info is-dismissible">'
//        .'<p>notice dro caterer <p>'
//        .'</div>';
//    }
//    static function display_notice(){
//        $obj = new dro_caterer_frontpage();
//        add_action('admin_notices', array($obj, 'notice'));
//    }

    /**
     * Verfiy if the main page has a children pages or not
     * minimum one child 
     *
     * @return int 
     */
    private function _has_child() {

        return $this->has_child = count($this->pages);
    }

    /**
     * Retreive the child pages.
     * 
     */
    private function _get_pages() {
        $this->pages = get_pages(array(
            'child_of' => $this->parent_page,
            'parent' => $this->parent_page
        ));
    }

    /**
     * Combine user attributes with known attributes and fill in defaults when needed.
     * 
     * @param array $pairs Entire list of supported attributes and their defaults.
     * @param array $atts  User defined attributes.
     * @return array Combined and filtered attribute list. 
     */
    private function _merge_menu_attributes($pairs, $atts) {
        $atts = (array) $atts;
        $out = array();
        foreach ($pairs as $name => $default) {
            if (array_key_exists($name, $atts)) {
                $out[$name] = $atts[$name];
            } else {
                $out[$name] = $default;
            }
        }

        return $out;
    }

    /**
     * 
     * @param array $pages
     * 
     * @return string The HTML menu output
     */
    private function _construct_menu(array $pages) {
        extract($this->menu_attributes);
        $this->menu = '<ul class="' . $menu_class . '">';
        foreach ($pages as $key => $value) {
            $this->menu .='<li>';
            $this->menu .='<a href="#' . $pages[$key]->post_name . '" title="' .
                    $pages[$key]->post_title . '">' .
                    $pages[$key]->post_title . '</a>';
            $this->menu .='</li>';
        }
        $this->menu .="</ul>";

        return $this->menu;
    }

    /**
     * Display the navigation menu for the Front Page
     * 
     * @param array $menu_attributes The menu parameters.
     */
    public function frontpage_nav_menu($menu_attributes = array()) {
        $this->menu_attributes = $this->_merge_menu_attributes($this->menu_attributes, $menu_attributes);
        echo $this->_construct_menu($this->pages);
    }

    /**
     * Display the content for the Front Page
     */
    public function frontpage_content() {

        echo $this->_construct_content($this->pages);
    }

    /**
     * 
     * @param array $pages
     * @return string
     */
    private function _construct_content(array $pages) {

        foreach ($pages as $key => $value) {
            
//            var_dump($pages[$key]);
            /*
             * Retrieve the featured image (if exists)  and set it as background of the section
             */

            $background = '';
            $trans = '';
            
            if(has_post_thumbnail($pages[$key]->ID)){
                
               $featured_image_url =  get_the_post_thumbnail_url(($pages[$key]->ID));
               $background = 'style= "background-image : url('.$featured_image_url.')"';
               $trans = '<div class="trans"></div>';
            }
            
            
            // If the child page has a children too
            if ($this->_subpage_has_child($pages[$key]->ID) > 0) {
                $this->content .= '<section id="' . $pages[$key]->post_name . '" class="element" '.$background.'>'
                        .$trans
                        . '<div class="container-fluid">'
                        . '<div class="row">'
                        . '<div class="col-lg-12">'
                        . '<h1 class="entry-title section-title section-title-has-child">' . $pages[$key]->post_title . '</h1>'
                        . '<div class="entry-content entry-content-has-child">' . substr($pages[$key]->post_content, 0, 250) . '</div>'
                        . '</div>'
                        . '<div class="col-lg-12 children-pages">'
                        . '<div class="row justify-content-center">'
                        . $this->_subpage_content($pages[$key]->ID, $this->_subpage_has_child($pages[$key]->ID))
                        . '</div><!-- .row (child ) -->'
                        . '</div><!-- .col-lg-12 (child) -->'
                        . '</div><!-- .row (parent) -->'
                        . '</div><!-- .content-fluid (parent) -->';
                $this->content .='</section>';
            } else {
                $this->content .= '<section id="' . $pages[$key]->post_name . '" class="element"'.$background.'>'
                        .$trans
                        . '<div class="container-fluid">'
                        . '<div class="row">'
                        . '<div class="col-lg-5">'
                        . '<h1 class="entry-title section-title">' . $pages[$key]->post_title . '</h1>'
                        . '</div>'
                        . '<div class="col-lg-7">'
                        . '<div class="entry-content">'
                        . substr($pages[$key]->post_content,0,250)
//                        . '<span> .. more </span>'
                        . '</div>'
                        . '</div>'
                        . '</div><!-- .row -->'
                        . '</div><!-- .content-fluid -->';
                $this->content .='</section>';
            }
        }

        return $this->content;
    }

    /**
     * Verfy if a child page has children too
     * @param int $id
     */
    private function _subpage_has_child($id) {
        return count(get_pages(array(
            'child_of' => $id,
            'parent' => $id
        )));
    }

    /**
     *  retreive the content of the subpages  only the first level elements
     * @param int $id
     * @param int $number_subpage The number of the subpage
     * @return string the title and the content of the subpages
     */
    private function _subpage_content($id, $number_subpage) {
        $out = '';
//        $subpages = get_pages(array(
//            'child_of' => $id,
//            'parent' => $id
//        ));
        $subpages = new WP_Query(array(
            'post_type' => 'page',
            'post_parent' => $id,
            'orderby' => 'rand'
        ));
        while ($subpages->have_posts()):
            $subpages->the_post();
            $out .= '<div class="col-md-6  child-element">';
            $out .= '<div class="child-element-wrapper">';
            $out .= '<div class="row">';
            if (has_post_thumbnail()) {
                $out .= '<div class="col-md-4"><div class="row">'
                        . '<div class="col-12">'
                        . '<h1 class="entry-title">' . get_the_title() . '</h1>'
                        . '</div><!-- ./ col-12 -->'
                        . '';
                $out .= ''
                        . '<div class="col-12">'
                        . '<img src="' . get_the_post_thumbnail_url() . '" class="">'
                        . '</div><!-- ./ col-12 -->'
                        . '</div></div>';
            } else {
                $out .= '<div class="col-md-4">'
                        . ''
                        . '<h1 class="entry-title">' . get_the_title() . '</h1>'
                        . ''
                        . '</div><!-- ./col-6 -->';                
            }
            $out .= '<div class="col-md-8">'
                    . '<div class="col-12">'
                    . '<div class="entry-content">' . substr(get_the_excerpt(), 0, 200) . '</div>'
                    . '</div><!-- ./ col-12 -->'
                    . '</div>';
            $out .= '</div><!-- ./ row -->';
            $out .= '</div><!-- ./ child-element-wrapper -->';
            $out .= '</div><!-- ./ col-md-6  child-element-->';
        endwhile;
        wp_reset_postdata();
//        foreach ($subpages as $key => $value) {
//            $out .= '<div class="col-md-6 col-lg-4">'
//                    . '<div class="row">'
//                    . '<div class="col-12">'
//                    . '<h1 class="entry-title">' . $subpages[$key]->post_title . '</h1>'
//                    . '</div><!-- ./ col-12 -->'
//                    . '</div><!-- ./ row -->'
//                    . '<div class="row">'
//                    . '<div class="col-12">'
//                    . '<div class="entry-content">' . $subpages[$key]->post_excerpt . '</div>'
//                    . '</div><!-- ./ col-12 -->'
//                    . '</div><!-- ./ row -->'
//                    . '</div><!-- ./ col-md-6 col-lg-4 -->';
//        }

        return $out;
    }

    private function _the_content($id) {
        
    }

}
