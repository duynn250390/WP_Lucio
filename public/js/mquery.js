$(document).ready(function() {
    $('.slideshow').slick({
        dots: false,
        infinite: false,
        speed: 300,
        autoplay: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        nextArrow: '<button class="slick-arrow slick-next"></button>',
        prevArrow: '<button class="slick-arrow slick-prev"></button>',
    });
    $('.slideimg').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        slidesToScroll: 1,
        prevArrow: null,
        nextArrow: null,
        asNavFor: '.ct_thumb'
    });
    $('.ct_thumb').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slideimg',
        dots: false,
        centerMode: true,
        focusOnSelect: true,
        prevArrow: null,
        nextArrow: null,

    });
    $('.box_slide_feedback').slick({
        dots: false,
        infinite: false,
        autoplay: true,
        speed: 500,
        // fade: true,
        // cssEase: 'linear',
        slidesToShow: 5,
        slidesToScroll: 1,
        nextArrow: '<button class="slick-arrow slick-next"></button>',
        prevArrow: '<button class="slick-arrow slick-prev"></button>',
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    infinite: true,
                    dots: false
                }
            },
            {
                breakpoint: 980,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: false
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false
                }
            },
        ]
    });
});
$(document).on('click', '.list_color_detail .color', function() {
    $('.list_color_detail .color').removeClass('active');
    $(this).addClass('active');
});
$(document).on('click', '.list_size .size', function() {
    $('.list_size .size').removeClass('active');
    $(this).addClass('active');
});
$(document).on('click', '.check_show_custom', function() {
    var box_order = $('.box_order');
    var isCheck = $('.check_show_custom').is(":checked");
    if (isCheck == true) {
        box_order.css({
            'height': 'auto',
            'opacity': '1'
        });
    } else {
        box_order.css({
            'height': '0',
            'opacity': '0'
        });
    }
});
$(document).on('click', '.list_size .size', function() {
    $('.list_size .size').removeClass('active');
    $(this).addClass('active');
});
// $(document).ready(function () {});
$(document).on('click', '.buttlet_menu', function() {
    CONTROL_MODAL = {
        Body: $('body'),
        main_header: $('.main_header'),
        navigation: $('.menu-menu-header-container'),
    }
    CONTROL_MODAL.main_header.append('<div class="menu_ovelay"></div>');
    $('.menu_ovelay').css({
        'z-index': 9,
    });
    var MENU_HTML = CONTROL_MODAL.navigation.html();
    // console.log(MENU_HTML);
    $('.mobile_menu').html(MENU_HTML);
    CONTROL_MODAL.Body.addClass('open_menu');
    $('.respo_menu').css({
        'z-index': 10,
        'left': '0',
    });
});
$(document).on('click', '.menu_ovelay', function() {
    $(".menu_ovelay").remove();
    $('.respo_menu').css({
        'left': '-260px',
    });
});