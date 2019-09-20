<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta http-equiv="content-language" content="vi" />
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php bloginfo( 'title' ); ?> - <?php bloginfo( 'description' ); ?></title>
    <!-- <title>LÚCIO SHOP</title> -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <link rel="alternate" href="<?php bloginfo('url'); ?>" hreflang="vn-vi" />
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="main_header">
        <div class="container">
            <div class="container_header">
                <div class="buttlet_menu"></div>
                <div class="site_branding">
                    <a class="logo" href="<?php bloginfo('url'); ?>"><img src="<?php echo get_template_directory_uri() ?>/public/images/icon/LOGO.png"></a>
                </div>
                <nav class="navigation">
                    <ul class="menu_primary_menu nav_menu">
                        <li class="menu_item"><a href="">TRANG CHỦ</a></li>
                        <li class="menu_item"><a href="">QUẦN JEANS</a></li>
                        <li class="menu_item"><a href="">ÁO THUN</a></li>
                        <li class="menu_item"><a href="">ÁO KHOÁC</a></li>
                        <li class="menu_item"><a href="">QUẦN JOGGER</a></li>
                        <li class="menu_item"><a href="">LIÊN HỆ</a></li>
                        <li class="menu_item"><a href="">ĐẶT HÀNG</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="respo_menu">
            <div class="mobile_logo">
                <a class="logo" href=""><img src="<?php echo get_template_directory_uri() ?>/public/images/icon/LOGO.png"></a>
            </div>
            <nav class="mobile_menu"></nav>
        </div>
    </header>