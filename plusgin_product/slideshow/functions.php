<?php
/*
Plugin Name: Sideshow
Author: HeroZuZu
Description: Slideshow
*/
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
                  <input name="size_Product" class="input_control" id="size_Product" type="number" placeholder="500.000" value="<?php echo $SizeProduct ?>">
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