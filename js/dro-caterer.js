/**
 * 
 * 
 * 
 */
(function ($) {

    /**
     * WP Mobile Menu
     * 
     * We clone the main menu and pass it to the plugin
     */
    var droCatererMainMenu = $('.main-navigation ul.menu').clone();
    $(droCatererMainMenu).droSlidingMenu();
    
})(jQuery);


