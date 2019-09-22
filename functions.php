<?php
if ( !function_exists( 'remove_admin_login_header' ) ):
  function remove_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }
  add_action('get_header', 'remove_admin_login_header');
  endif;

// wp_headにscriptとstylesを追加
      if ( !function_exists( 'herozuzu_scripts_styles' ) ):
        function herozuzu_scripts_styles() {
        // Style
          wp_register_style('main-style',get_template_directory_uri()."/style.css", 'all');
          wp_enqueue_style('main-style');
        // Script
          wp_enqueue_script('main_js',get_template_directory_uri()."/public/js/jquery.min.js", array('jquery'),'3.2.1',false);
          wp_enqueue_script('slick',get_template_directory_uri()."/public/js/slick.js", array('jquery'),'1.0.0',false);
          wp_enqueue_script('myquery',get_template_directory_uri()."/public/js/mquery.js", array('jquery'),'1.0.0',false);

        }
        add_action( 'wp_enqueue_scripts', 'herozuzu_scripts_styles' );
      endif;
      
      // headに出力されるタグを消去
remove_action( 'wp_head', 'wp_generator' ); //WordPressのバージョン情報
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); //絵文字対応のスクリプト
remove_action( 'wp_print_styles', 'print_emoji_styles'); //絵文字対応のスタイル

if ( !function_exists( 'herozuzu_setup' ) ):
  function herozuzu_setup() {
    load_theme_textdomain( 'herozuzu', get_template_directory() . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    register_nav_menu( 'global-nav', __( 'Header menu', 'herozuzu' ) );
    register_nav_menu( 'left-nav', __( 'Left menu', 'herozuzu' ) );
    register_nav_menu( 'right-nav', __( 'Right menu', 'herozuzu' ) );
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'large-thumbnail', 1118, 538, true );
    add_image_size( 'images_project', 1000, 440, true );
    add_image_size( 'square_smallb_thumbnail', 250, 250, true );
    add_image_size( 'square_smallc_thumbnail', 210, 160, true );
    add_image_size( 'square_smalld_thumbnail', 120, 90, true );
    add_image_size( 'square_news_thumbnail', 82, 82, true );
  }
  add_action( 'after_setup_theme', 'herozuzu_setup' );
endif;
// =====================Count VIEW========================
function setpostview($postID){
  $count_key ='post_views_count';
  $count = get_post_meta($postID, $count_key,true);
  if($count==''){
    $count =0;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key,'0');
  }else{
    $count++;
    update_post_meta($postID, $count_key, $count);
  }
}

function getpostviews($postID){
  $count_key ='post_views_count';
  $count = get_post_meta($postID, $count_key,true);
  if($count==''){
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key,'0');
    return"0 View";
  }
  return '<i class="fa fa-eye" aria-hidden="true"></i> '.$count;
}
// =====================CUSTOM SLIDESHOW========================
function slideshow()
{
/*
 * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
 */
$label = array(
    'name' => 'Slideshow', //Tên post type dạng số nhiều
    'singular_name' => 'slideshow' //Tên post type dạng số ít
  );
/*
 * Biến $args là những tham số quan trọng trong Post Type
 */
$args = array(
    'labels' => $label, //Gọi các label trong biến $label ở trên
    'description' => 'Quản lý slideshow', //Mô tả của post type
    'supports' => array(
      'title',
      // 'editor',
      // 'excerpt',
      // 'author',
      'thumbnail',
      // 'comments',
      // 'trackbacks',
      'revisions',
      // 'custom-fields'
    ), //Các tính năng được hỗ trợ trong post type
    // 'taxonomies' => array( 'category', 'post_tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
    'rewrite' => array(
      // 'slug'                  => 'references',
      'with_front'            => false,
      'pages'                 => true,
      'feeds'                 => true,
    ),
    'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
    'public' => true, //Kích hoạt post type
    'show_ui' => true, //Hiển thị khung quản trị như Post/Page
    'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
    'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
    'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
    'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
    'menu_icon' => 'dashicons-format-video', //Đường dẫn tới icon sẽ hiển thị
    'can_export' => true, //Có thể export nội dung bằng Tools -> Export
    'has_archive' => true, //Cho phép lưu trữ (month, date, year)
    'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
    'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
    'capability_type' => 'post' //
  );
register_post_type('post_slideshow', $args); //Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
add_action('init', 'slideshow');

// =====================CUSTOM PRODUCT========================
function manager_product()
{
/*
 * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
 */
$label = array(
    'name' => 'Quản lý ản phẩm', //Tên post type dạng số nhiều
    'singular_name' => 'products' //Tên post type dạng số ít
  );
/*
 * Biến $args là những tham số quan trọng trong Post Type
 */
$args = array(
    'labels' => $label, //Gọi các label trong biến $label ở trên
    'description' => 'Quản lý sản phẩm', //Mô tả của post type
    'supports' => array(
      'title',
      // 'editor',
      // 'excerpt',
      // 'author',
      'thumbnail',
      // 'comments',
      // 'trackbacks',
      'revisions',
      'custom-fields'
    ), //Các tính năng được hỗ trợ trong post type
    'taxonomies' => array( 'category', 'post_tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
    'rewrite' => array(
      // 'slug'                  => 'references',
      'with_front'            => false,
      'pages'                 => true,
      'feeds'                 => true,
    ),
    'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
    'public' => true, //Kích hoạt post type
    'show_ui' => true, //Hiển thị khung quản trị như Post/Page
    'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
    'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
    'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
    'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
    'menu_icon' => 'dashicons-cart', //Đường dẫn tới icon sẽ hiển thị
    'can_export' => true, //Có thể export nội dung bằng Tools -> Export
    'has_archive' => true, //Cho phép lưu trữ (month, date, year)
    'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
    'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
    'capability_type' => 'post' //
  );
register_post_type('post_product', $args); //Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
add_action('init', 'manager_product');
// ====================================================
// CUSTOM TỈNH HUYỆN XÃ
// ====================================================
add_action( 'init', 'size_taxonomy', 0 );
function size_taxonomy() {
 $labels = array(
   'name' => 'Danh sách Size',
   'singular' => 'Size',
   'menu_name' => 'Size'
 );
 $args = array(
  'labels'                     => $labels,
  'hierarchical'               => true,
  'public'                     => true,
  'show_ui'                    => true,
  'show_admin_column'          => true,
  'show_in_nav_menus'          => true,
  'show_tagcloud'              => true,
);
 register_taxonomy( 'size', array( 'post_product' ), $args );
}

add_action( 'init', 'color_taxonomy', 0 );
function color_taxonomy() {
 $labels = array(
   'name' => 'Mã màu',
   'singular' => 'Mã màu',
   'menu_name' => 'Mã màu'
 );
 $args = array(
  'labels'                     => $labels,
  'hierarchical'               => true,
  'public'                     => true,
  'show_ui'                    => true,
  'show_admin_column'          => true,
  'show_in_nav_menus'          => true,
  'show_tagcloud'              => true,
);
 register_taxonomy( 'color', array( 'post_product' ), $args );
}