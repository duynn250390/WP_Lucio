<?php
if (!function_exists('remove_admin_login_header')) :
  function remove_admin_login_header()
  {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }
  add_action('get_header', 'remove_admin_login_header');
endif;

// wp_headにscriptとstylesを追加
if (!function_exists('herozuzu_scripts_styles')) :
  function herozuzu_scripts_styles()
  {
    // Style
    wp_register_style('main-style', get_template_directory_uri() . "/style.css", 'all');
    wp_enqueue_style('main-style');
    // Script
    wp_enqueue_script('main_js', get_template_directory_uri() . "/public/js/jquery.min.js", array('jquery'), '3.2.1', false);
    wp_enqueue_script('slick', get_template_directory_uri() . "/public/js/slick.js", array('jquery'), '1.0.0', false);
    wp_enqueue_script('myquery', get_template_directory_uri() . "/public/js/mquery.js", array('jquery'), '1.0.0', false);
  }
  add_action('wp_enqueue_scripts', 'herozuzu_scripts_styles');
endif;

// headに出力されるタグを消去
remove_action('wp_head', 'wp_generator'); //WordPressのバージョン情報
remove_action('wp_head', 'print_emoji_detection_script', 7); //絵文字対応のスクリプト
remove_action('wp_print_styles', 'print_emoji_styles'); //絵文字対応のスタイル

if (!function_exists('herozuzu_setup')) :
  function herozuzu_setup()
  {
    load_theme_textdomain('herozuzu', get_template_directory() . '/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('customize-selective-refresh-widgets');
    register_nav_menu('global-nav', __('Header menu', 'herozuzu'));
    register_nav_menu('left-nav', __('Left menu', 'herozuzu'));
    register_nav_menu('right-nav', __('Right menu', 'herozuzu'));
    add_theme_support('post-thumbnails');
    add_image_size('large-thumbnail', 1118, 538, true);
    add_image_size('images_project', 1000, 440, true);
  }
  add_action('after_setup_theme', 'herozuzu_setup');
endif;
// =====================Count VIEW========================
function setpostview($postID)
{
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if ($count == '') {
    $count = 0;
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
  } else {
    $count++;
    update_post_meta($postID, $count_key, $count);
  }
}

function getpostviews($postID)
{
  $count_key = 'post_views_count';
  $count = get_post_meta($postID, $count_key, true);
  if ($count == '') {
    delete_post_meta($postID, $count_key);
    add_post_meta($postID, $count_key, '0');
    return "0 View";
  }
  return '<i class="fa fa-eye" aria-hidden="true"></i> ' . $count;
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
    'name' => 'Quản lý sản phẩm', //Tên post type dạng số nhiều
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
    'taxonomies' => array('category', 'post_tag'), //Các taxonomy được phép sử dụng để phân loại nội dung
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
add_action('init', 'size_taxonomy', 0);
function size_taxonomy()
{
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
  register_taxonomy('size', array('post_product'), $args);
}

add_action('init', 'color_taxonomy', 0);
function color_taxonomy()
{
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
  register_taxonomy('color', array('post_product'), $args);
}
// ==============FUNCTION AJAX ==============
add_action('wp_ajax_add_order', 'add_order_init');
add_action('wp_ajax_nopriv_add_order', 'add_order_init');
$mau_ao = [];
function add_order_init()
{
  // $array_send = (isset($_POST['array_send'])) ? esc_attr($_POST['array_send']) : '';
  $ten_san_pham = (isset($_POST['ten_san_pham'])) ? esc_attr($_POST['ten_san_pham']) : '';
  $so_luong = (isset($_POST['so_luong'])) ? esc_attr($_POST['so_luong']) : '';
  $tong_tien = (isset($_POST['tong_tien'])) ? esc_attr($_POST['tong_tien']) : '';
  $mau_ao = $_POST['mau_ao'];
  $gioi_tinh = (isset($_POST['gioi_tinh'])) ? esc_attr($_POST['gioi_tinh']) : '';
  $ho_ten = (isset($_POST['ho_ten'])) ? esc_attr($_POST['ho_ten']) : '';
  $email = (isset($_POST['email'])) ? esc_attr($_POST['email']) : '';
  $so_dien_thoai = (isset($_POST['so_dien_thoai'])) ? esc_attr($_POST['so_dien_thoai']) : '';
  $dia_chi = (isset($_POST['dia_chi'])) ? esc_attr($_POST['dia_chi']) : '';
  $ghi_chu = (isset($_POST['ghi_chu'])) ? esc_attr($_POST['ghi_chu']) : '';
  global $wpdb;
  $table_name = 'wp_order';
  $table_name_info = 'wp_order_info';
  $count_query = "select count(*) from $table_name";
  $num = $wpdb->get_var($count_query);
  $data_array = array(
    'ten-san-pham' => $ten_san_pham,
    'so-luong'   => $so_luong,
    'tong-tien' => $tong_tien,
    'gioi-tinh' => $gioi_tinh,
    'ho-ten'   => $ho_ten,
    'email' => $email,
    'so-dien-thoai'   => $so_dien_thoai,
    'dia-chi'   => $dia_chi,
    'thong-tin' => $ghi_chu
  );
  $rowResult = $wpdb->insert($table_name, $data_array, $format = NULL);

  for ($x = 0; $x <= count($mau_ao); $x++) {
    $data_array_info = array(
      'id_order' => $num + 1,
      'mau' => $mau_ao[$x][mau],
      'size' => $mau_ao[$x][size]
    );

    $wpdb->insert($table_name_info, $data_array_info, $format = NULL);
  }
  wp_send_json_success($mau_ao);
  die();
}

// ==============FUNCTION AJAX ==============
add_action('wp_ajax_get_post_by_select', 'get_post_by_select_init');
add_action('wp_ajax_nopriv_get_post_by_selectet', 'get_post_by_select_init');
function get_post_by_select_init()
{
  $id_post = (isset($_POST['id_post'])) ? esc_attr($_POST['id_post']) : '';
  ob_start(); //bắt đầu bộ nhớ đệm
  $post_new = new WP_Query(array(
    'post_type' =>  'post_product',
    'p' => $id_post
  ));
  if ($post_new->have_posts()) :
    while ($post_new->have_posts()) : $post_new->the_post();
      $terms_size = get_the_terms($post->ID, 'size');
      $terms_color = get_the_terms($post->ID, 'color');
      $result['size'] = $terms_size;
      $result['color'] =  $terms_color;
      echo $results;
    endwhile;
  endif;
  wp_reset_query();
  wp_send_json_success($result); // trả về giá trị dạng json
  die(); //bắt buộc phải có khi kết thúc
}
// ==============FUNCTION AJAX ==============
add_action('wp_ajax_get_post_by_cate', 'get_post_by_cate_init');
add_action('wp_ajax_nopriv_get_post_by_cate', 'get_post_by_cate_init');
function get_post_by_cate_init()
{

  //do bên js để dạng json nên giá trị trả về dùng phải encode
  $id_cate = (isset($_POST['id_category'])) ? esc_attr($_POST['id_category']) : '';
  ob_start(); //bắt đầu bộ nhớ đệm
  $post_new = new WP_Query(array(
    'post_type' =>  'post_product',
    'posts_per_page'    =>  '8',
    'cat' => $id_cate
  ));
  if ($post_new->have_posts()) :

    // echo '<div class="item_product ">';
    while ($post_new->have_posts()) : $post_new->the_post();
      echo '<div class="item_product ">';
      echo '<figure class="product_thumb">';
      echo '<img class="thumb" src="' . get_the_post_thumbnail_url($post_new->ID, 'large') . '" alt="' . get_the_title() . '"/>';
      echo '</figure>
          <div class="ovelay_product"></div>
          <div class="box_control_product">';
      echo '<a href="' . get_the_permalink() . '" class="btn_product">Chi tiết</a>';
      echo '</div>';
      echo '</div>';
    endwhile;
  endif;
  wp_reset_query();
  $result = ob_get_clean(); //cho hết bộ nhớ đệm vào biến $result
  wp_send_json_success($result); // trả về giá trị dạng json
  die(); //bắt buộc phải có khi kết thúc
}


function the_breadcrumb()
{
  echo '<nav id="breadcrumb" class="breadcrumb">';
  if (!is_home()) {
    echo '<a href="';
    echo get_option('home');
    echo '">';
    echo 'Trang chủ';
    echo "</a>";
    if (is_category() || is_single()) {
      the_category();
      if (is_single()) {
        the_title('  ');
      }
    } elseif (is_page()) {
      echo the_title('  ');
    }
  } elseif (is_tag()) {
    single_tag_title();
  } elseif (is_day()) {
    echo "<li>Archive for ";
    the_time('F jS, Y');
    echo '</li>';
  } elseif (is_month()) {
    echo "<li>Archive for ";
    the_time('F, Y');
    echo '</li>';
  } elseif (is_year()) {
    echo "<li>Archive for ";
    the_time('Y');
    echo '</li>';
  } elseif (is_author()) {
    echo "<li>Author Archive";
    echo '</li>';
  } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
    echo "<li>Blog Archives";
    echo '</li>';
  } elseif (is_search()) {
    echo "<li>Search Results";
    echo '</li>';
  }
  echo '</nav>';
}
//  <nav class="breadcrumb">
// <a href="">Trang chủ</a>
// <a href="">Áo thun nữ</a>
// <span>Áo thun cổ tròn</span>
// </nav>


function jamviet_edit_taxonomy($tag)
{
  $tagID = $tag->term_id;

  $cat_theme = get_option("cat-$tagID-template");

  $themes = wp_get_themes();
  $theme_options = '<option value="">Default</option>';
  foreach ($themes as $theme) {
    $selected = ($cat_theme == $theme->template) ? ' selected="selected"' : '';
    $theme_options .= '<option value="' . $theme->template . '"' . $selected . '>' . $theme->Name . '</option>';
  }
  ?>
  <tr>
    <th scope="row" valign="top">Select the templates</th>
    <td>
      <div><select name="cat_theme"><?php echo $theme_options; ?></select>
        <span>Select a template in your CMS</span></div>
    </td>
  </tr>

<?php
}
// =====================CUSTOM FEEDBACK========================
function feedback()
{
  /*
 * Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
 */
  $label = array(
    'name' => 'Feedback', //Tên post type dạng số nhiều
    'singular_name' => 'feedback' //Tên post type dạng số ít
  );
  /*
 * Biến $args là những tham số quan trọng trong Post Type
 */
  $args = array(
    'labels' => $label, //Gọi các label trong biến $label ở trên
    'description' => 'Quản lý feedback', //Mô tả của post type
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
  register_post_type('post_feedback', $args); //Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên
}
/* Kích hoạt hàm tạo custom post type */
add_action('init', 'feedback');
