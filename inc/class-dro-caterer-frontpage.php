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
    public function __construct($id) {
        
        $this->parent_page = $id;
        $this->_get_pages();
        
//        get_pages
    }

    /**
     * 
     * @param int $id
     * @return boolean
     */
    private function _has_child($id) {
        
        return get_pages(array('child_of' => $id));
    }

    /**
     * Retreive the child pages.
     * 
     */
    private function _get_pages() {
        $this->pages = get_pages(array(
            'child_of' => $this->parent_page,
//            'hierarchical' => FALSE
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
     * Display the navigation menu for the Front Page
     * 
     * @param array $menu_attributes The menu parameters.
     */
    public function frontpage_nav_menu($menu_attributes = array()) {
        $this->menu_attributes = $this->_merge_menu_attributes($this->menu_attributes, $menu_attributes);
        echo $this->_construct_menu($this->pages);
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
                    esc_html__($pages[$key]->post_title, 'dro-caterer') . '">' .
                    esc_html__($pages[$key]->post_title, 'dro-caterer') . '</a>';
            $this->menu .='</li>';
        }
        $this->menu .="</ul>";

        return $this->menu;
    }

    /**
     * Display the content for the Front Page
     */
    public function frontpage_content() {

        echo $this->_construct_content($this->pages);
    }

    private function _construct_content(array $pages) {

        foreach ($pages as $key => $value) {
            $this->content .= '<section id="' . $pages[$key]->post_name . '" class="element">'
                    . '<div class="container">'
                    . '<div class="row">'
                    . '<div class="col-lg-3">'
                    . '<div class="entry-title">' . $pages[$key]->post_title . '</div>'
                    . '</div><!-- .col-lg-3 -->'
                    . '<div class="col-lg-9">'
                    . ' <div class="entry-content">' . $pages[$key]->post_content . '</div>'
                    . '</div>'
                    . '</div><!-- .row -->'
                    . '</div><!-- .content-fluid -->';
            $this->content .='</section>';
        }

        return $this->content;
    }

}
