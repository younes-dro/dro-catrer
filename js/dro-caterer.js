/**
 * 
 * 
 * 
 */
(function ($) {

    /**
     * WP Mobile Menu
     */
    var droCatererMainMenu = $('.main-navigation ul.menu').clone();
    $(droCatererMainMenu).droSlidingMenu();
    
    /* Stick navigation  */
    if ($('.main-navigation').hasClass('sticky-active')) {

        var stickyNavTop = $('.main-navigation').offset().top;
        $(window).scroll(function () {
            var scrollTop = $(window).scrollTop();

            if (scrollTop > stickyNavTop) {
                $('.main-navigation').addClass('sticky-header');
            } else {
                $('.main-navigation').removeClass('sticky-header');
            }

        });
    }    
    
})(jQuery);


