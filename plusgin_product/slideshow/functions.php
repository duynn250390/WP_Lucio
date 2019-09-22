<?php
/*
Plugin Name: Sideshow
Author: HeroZuZu
Description: Slideshow
*/

function add_slideshow_metabox($post_type) {
  $types = array('post_slideshow');
  if (in_array($post_type, $types)) {
    add_meta_box(
      'gallery-metabox',
      'Thêm hình ảnh',
      'gallery_meta_callback_slideshow',
      $post_type,
      'normal',
      'high'
    );
  }  
}
add_action('add_meta_boxes', 'add_slideshow_metabox');

function gallery_meta_callback_slideshow($post) {
  wp_nonce_field( basename(__FILE__), 'gallery_meta_nonce' );
  $ids = get_post_meta($post->ID, 'tdc_gallery_id', true);
  ?>
  <style type="text/css">
   .gallery-metabox-list_slideshow{
  display: grid;
  grid-template-columns: repeat(12, 1fr); 
  grid-gap: 20px;
}
.gallery-metabox-list_slideshow li{
  grid-column: 12 span;
  display: grid;
  justify-content: center;
  align-items: center;
}
.gallery-metabox-list_slideshow li img{
  min-height: 400px;
}
.box_change{
  margin-top: 1em;
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
.box_change .remove-image,.box_change .change-image{
  border:none;
  padding: 0.5em 1em;
  color:#fff;
}
.box_change .remove-image{
  background: red;
}
.box_change .change-image{
  background:#56cfe1 ;
}
  </style>
 <table class="form-table">
   <tr><td>
      <a class="gallery-add button" href="#" data-uploader-title="Thêm hình ảnh" data-uploader-button-text="Thêm nhiều hình ảnh">Thêm nhiều hình ảnh</a>
      <ul id="gallery-metabox-list" class="gallery-metabox-list_slideshow">
        <?php if ($ids) : foreach ($ids as $key => $value) : $image = wp_get_attachment_image_src($value); ?>
        <li>
           <input type="hidden" name="tdc_gallery_id[<?php echo $key; ?>]" value="<?php echo $value; ?>">
           <img class="image-preview" src="<?php echo $image[0]; ?>">
           <div class="box_change">
           <a class="change-image button button-small" href="#" data-uploader-title="Đổi hình" data-uploader-button-text="Đổi hình">Đổi hình</a>
           <a class="remove-image  button button-small" href="#">Xóa</a>
           </div>
        </li>
        <?php endforeach; endif; ?>
     </ul>
  </td></tr>
 </table>
  <?php }
  function slideshow_meta_save($post_id) {
   if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if(isset($_POST['tdc_gallery_id'])) {
      update_post_meta($post_id, 'tdc_gallery_id', $_POST['tdc_gallery_id']);
    } else {
      delete_post_meta($post_id, 'tdc_gallery_id');
    }
  }
  add_action('save_post', 'slideshow_meta_save');


 function gallery_enqueue_hook_slideshow($hook) {
    wp_enqueue_script('gallery-metaboxs', get_template_directory_uri() . '/public/js/gallery-metabox.js', array('jquery', 'jquery-ui-sortable'));
    wp_enqueue_style('gallery-metaboxs', get_template_directory_uri() . '/public/css/gallery-metabox.css.css');
  }
  add_action('admin_enqueue_scripts', 'gallery_enqueue_hook_slideshow');
  // ========================================================================
function info_slidshow_meta_box(){
    $id = 'info_slidshow_meta_box';
    $title = 'Thông tin slidshow';
    $callback = 'info_slideshow_output';
    $screen = 'post_slideshow';
    add_meta_box( $id, $title, $callback,$screen);
  }
  
  add_action('add_meta_boxes','info_slidshow_meta_box');
  
  function info_slideshow_output($post){
    $SizeProduct = get_post_meta( $post->ID, '_size_Product', true );
    $colorProduct = get_post_meta( $post->ID, '_color_Product', true );
    ?>
    <style type="text/css">
    .box_info_meta_box{
      display: grid;
      grid-template-columns: repeat(12,1fr);
      grid-gap: 2em;
    }
    .box_info_meta_box .item_list{
      grid-column: 12 span;
      display: grid;
      grid-template-columns: repeat(12,1fr);
      grid-gap: 2em;
    }
    .box_info_meta_box .item_list .item_list_box.haft{
      grid-column: 6 span;
    }
    .box_info_meta_box .item_list .item_list_box{
      grid-column: 12 span;
    }
    
    .box_info_meta_box .item_list .item_list_box .input_control{
      margin-top:14px;
      text-decoration: none;
      outline: none;
      width: 100%;
      border-radius: 6px;
      border:1px solid #ccc;
      
      outline: none;
    }
    .box_info_meta_box input,.box_info_meta_box select{
      height: 40px;
      padding: 0 1em;
    }
    .box_info_meta_box textarea{
      padding:1em;
    }
  </style>
  <div class="box_info_meta_box">
          <div class="item_list">
              <div class="item_list_box haft">
                  <lable for="size_Product">Size Product(VNĐ)</lable>
                  <input name="size_Product" class="input_control" id="size_Product" type="text" placeholder="500.000" value="<?php echo $SizeProduct ?>">
              </div>    
          </div>
          <div class="item_list">
              <div class="item_list_box">
                  <lable for="color_Product">Color Product</lable>
                  <textarea name="color_Product" class="input_control" rows="5" id="color_Product"><?php echo $colorProduct ?></textarea>
              </div>    
          </div>
      </div>
      <?php
  }
  function info_slideshow($post_id){
      if(isset($_POST['size_Product'])){
          $SizeProduct = sanitize_text_field( $_POST['size_Product'] );
          update_post_meta($post_id,'_size_Product',$SizeProduct);
      }
      if(isset($_POST['color_Product'])){
          $colorProduct = sanitize_text_field( $_POST['color_Product'] );
          update_post_meta($post_id,'_color_Product',$colorProduct);
      }
  }
  add_action('save_post','info_slideshow');