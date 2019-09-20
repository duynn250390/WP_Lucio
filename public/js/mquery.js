$(document).ready(function () {
    $('.slideshow').slick({
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        nextArrow: '<button class="slick-arrow slick-next"></button>',
        prevArrow: '<button class="slick-arrow slick-prev"></button>',
    });
    $('.box_slide_feedback').slick({
        dots: false,
        infinite: false,
        speed: 300,
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
    console.log(MENU_HTML);
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
$(".control_img").on("mouseover", function() {
    console.log('ad');
    // imageZoom("img_thum_con", "myresult");
});

// function imageZoom(imgID, resultID) {
//     var img, lens, result, cx, cy;
//     img = document.getElementById(imgID);
//     result = document.getElementById(resultID);
//     /* Create lens: */
//     lens = document.createElement("DIV");
//     lens.setAttribute("class", "img-zoom-lens");
//     /* Insert lens: */
//     img.parentElement.insertBefore(lens, img);
//     /* Calculate the ratio between result DIV and lens: */
//     cx = result.offsetWidth / lens.offsetWidth;
//     cy = result.offsetHeight / lens.offsetHeight;
//     /* Set background properties for the result DIV */
//     result.style.backgroundImage = "url('" + img.src + "')";
//     result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
//     /* Execute a function when someone moves the cursor over the image, or the lens: */
//     lens.addEventListener("mousemove", moveLens);
//     img.addEventListener("mousemove", moveLens);
//     /* And also for touch screens: */
//     lens.addEventListener("touchmove", moveLens);
//     img.addEventListener("touchmove", moveLens);
//     function moveLens(e) {
//       var pos, x, y;
//       /* Prevent any other actions that may occur when moving over the image */
//       e.preventDefault();
//       /* Get the cursor's x and y positions: */
//       pos = getCursorPos(e);
//       /* Calculate the position of the lens: */
//       x = pos.x - (lens.offsetWidth / 2);
//       y = pos.y - (lens.offsetHeight / 2);
//       /* Prevent the lens from being positioned outside the image: */
//       if (x > img.width - lens.offsetWidth) {x = img.width - lens.offsetWidth;}
//       if (x < 0) {x = 0;}
//       if (y > img.height - lens.offsetHeight) {y = img.height - lens.offsetHeight;}
//       if (y < 0) {y = 0;}
//       /* Set the position of the lens: */
//       lens.style.left = x + "px";
//       lens.style.top = y + "px";
//       /* Display what the lens "sees": */
//       result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
//     }
//     function getCursorPos(e) {
//       var a, x = 0, y = 0;
//       e = e || window.event;
//       /* Get the x and y positions of the image: */
//       a = img.getBoundingClientRect();
//       /* Calculate the cursor's x and y coordinates, relative to the image: */
//       x = e.pageX - a.left;
//       y = e.pageY - a.top;
//       /* Consider any page scrolling: */
//       x = x - window.pageXOffset;
//       y = y - window.pageYOffset;
//       return {x : x, y : y};
//     }
//   }
//   https://www.w3schools.com/howto/howto_js_image_zoom.asp