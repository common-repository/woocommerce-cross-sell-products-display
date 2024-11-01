jQuery(document).ready(function (){

    if(wcsp_ajax.enable_slider_up_sell) {
        jQuery('.up-sells.products ul.products').addClass('owl-carousel owl-theme');
        jQuery('.up-sells.products ul.products').owlCarousel({
            loop:true,
            margin:15,
            responsiveClass:true,
            nav:wcsp_ajax.enable_slider_nav_arrows,
            dots: wcsp_ajax.enable_slider_nav_dots,
            autoplay:wcsp_ajax.enable_slider_autoplay,
            autoplayHoverPause: true,
            autoplaySpeed:wcsp_ajax.enable_slider_speed,
            navText: [
                '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                '<i class="fa fa-angle-right" aria-hidden="true"></i>'
            ],
            // dotsContainer: '#myDots',
            //navContainer: '#wcsp-slider-nav',
            responsive:{
                0:{
                    items:wcsp_ajax.enable_slider_items_mobile,
                },
                600:{
                    items:wcsp_ajax.enable_slider_items_tablet,
                },
                1200:{
                    items:wcsp_ajax.enable_slider_items_desktop,
                }
            }
        });
    }
    if(wcsp_ajax.enable_slider_related_products) {
        jQuery('.related.products ul.products').addClass('owl-carousel owl-theme');
        jQuery('.related.products ul.products').owlCarousel({
            loop:true,
            margin:15,
            responsiveClass:true,
            nav:wcsp_ajax.enable_slider_nav_arrows,
            dots: wcsp_ajax.enable_slider_nav_dots,
            autoplay:wcsp_ajax.enable_slider_autoplay,
            autoplayHoverPause: true,
            autoplaySpeed:wcsp_ajax.enable_slider_speed,
            navText: [
                '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                '<i class="fa fa-angle-right" aria-hidden="true"></i>'
            ],
            // dotsContainer: '#myDots',
            //navContainer: '#wcsp-slider-related-products-nav',
            responsive:{
                0:{
                    items:wcsp_ajax.enable_slider_items_mobile,
                },
                600:{
                    items:wcsp_ajax.enable_slider_items_tablet,
                },
                1200:{
                    items:wcsp_ajax.enable_slider_items_desktop,
                }
            }
        });
    }
    if(wcsp_ajax.enable_slider_cross_sell) {
        jQuery('.wcsp-cross-sell-slider ul.products').addClass('owl-carousel owl-theme');
        jQuery('.wcsp-cross-sell-slider ul').owlCarousel({
            loop:true,
            margin:15,
            responsiveClass:true,
            nav:wcsp_ajax.enable_slider_nav_arrows,
            dots: wcsp_ajax.enable_slider_nav_dots,
            autoplay:wcsp_ajax.enable_slider_autoplay,
            autoplayHoverPause: true,
            autoplaySpeed:wcsp_ajax.enable_slider_speed,
            navText: [
                '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                '<i class="fa fa-angle-right" aria-hidden="true"></i>'
            ],
            // dotsContainer: '#myDots',
            //navContainer: '#wcsp-slider-cross-sell-nav',
            responsive:{
                0:{
                    items:wcsp_ajax.enable_slider_items_mobile,
                },
                600:{
                    items:wcsp_ajax.enable_slider_items_tablet,
                },
                1200:{
                    items:wcsp_ajax.enable_slider_items_desktop,
                }
            }
        });
    }


});