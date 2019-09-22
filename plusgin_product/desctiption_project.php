<?php
/*
Plugin Name: Đăng Tin Dự Án Cần Bán
Author: Vnroki
Description: Tổng hợp thông tin về các dự án bất động sản đang và sắp mở bán.
*/


/*==========================================
THÊM ẢNH DỰ ÁN
==========================================*/

function add_gallery_metabox_project($post_type) {
  $types = array('post_project');
  if (in_array($post_type, $types)) {
  add_meta_box(
     'gallery-metabox',
     'Thêm hình ảnh về dự án',
     'gallery_meta_callback_project',
     $post_type,
     'normal',
     'high'
     );
   }  
 }
 add_action('add_meta_boxes', 'add_gallery_metabox_project');

 function gallery_meta_callback_project($post) {
   wp_nonce_field( basename(__FILE__), 'gallery_meta_nonce' );
   $ids = get_post_meta($post->ID, 'tdc_gallery_id', true);
?>
 <table class="form-table">
   <tr><td>
      <a class="gallery-add button" href="#" data-uploader-title="Thêm hình ảnh" data-uploader-button-text="Thêm nhiều hình ảnh">Thêm nhiều hình ảnh</a>
      <ul id="gallery-metabox-list">
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
 function gallery__project_meta_save($post_id) {
  if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;
  if (!current_user_can('edit_post', $post_id)) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  if(isset($_POST['tdc_gallery_id'])) {
    update_post_meta($post_id, 'tdc_gallery_id', $_POST['tdc_gallery_id']);
  } else {
    delete_post_meta($post_id, 'tdc_gallery_id');
  }
 }
add_action('save_post', 'gallery__project_meta_save');

 function gallery_enqueue_hook_project($hook) {
      wp_enqueue_script('gallery-metabox', get_template_directory_uri() . '/lib/js/gallery-metabox.js', array('jquery', 'jquery-ui-sortable'));
     wp_enqueue_style('gallery-metabox', get_template_directory_uri() . '/lib/css/gallery-metabox.css');
 }
 add_action('admin_enqueue_scripts', 'gallery_enqueue_hook_project');

// Thông tin người nhập và liên hệ
// =======================================
function info_project_meta_box(){
	$id = 'info_project_meta_box';
	$title = 'Thông tin dự án cần bán';
	$callback = 'info_project_output';
	$screen = 'post_project';
	add_meta_box( $id, $title, $callback,$screen);
}
add_action('add_meta_boxes','info_project_meta_box');

function info_project_output($post){
	$ten_du_an = get_post_meta( $post->ID, '_ten_du_an', true );
	$chu_dau_tu = get_post_meta( $post->ID, '_chu_dau_tu', true );
	$dia_chi = get_post_meta( $post->ID, '_dia_chi', true );
	$tong_dien_tich = get_post_meta( $post->ID, '_tong_dien_tich', true );
	$loai_hinh_phat_trien = get_post_meta( $post->ID, '_loai_hinh_phat_trien', true );
	$gia_ban = get_post_meta( $post->ID, '_gia_ban', true );
	$quy_mo_du_an = get_post_meta( $post->ID, '_quy_mo_du_an', true );
	$quan = get_post_meta( $post->ID, '_quan', true );
	$vi_tri_du_an = get_post_meta( $post->ID, '_vi_tri_du_an', true );
	$ha_tang_du_an = get_post_meta( $post->ID, '_ha_tang_du_an', true );
	?>
	<style type="text/css">
	.box_info_meta_box:after{
		content: '';
		display: block;
		clear: both;
		height: 0;
		overflow: hidden;
	}
	.item_list{
		width: 50%;
		float: left;
		margin-bottom: 15px;
	}
	.item_list_box{
		padding:0 15px;
	}
	.box_info_meta_box{display: block;}
	.box_info_meta_box lable{
		display: block;
		font-weight: bold;
	}
	.box_info_meta_box input,.box_info_meta_box select{
		width: 100%;
	}
	.full{
		margin-top: 25px;
		border-top: 1px solid #e4e4e4;
		width: 100%!important;
		padding: 10px 0;
	}
</style>
<div class="box_info_meta_box">
	<div class="item_list">
		<div class="item_list_box">
			<lable for="ten_du_an" style="display: block;">Tên dự án</lable>
			<input name="ten_du_an" class="code"  id="ten_du_an" type="text" value="<?php echo $ten_du_an ?>">	
		</div>	
	</div><!-- ten_du_an -->
	<div class="item_list">
		<div class="item_list_box">
			<lable for="chu_dau_tu" style="display: block;">Chủ đầu tư</lable>
			<input name="chu_dau_tu" class="code"  id="chu_dau_tu" type="text" value="<?php echo $chu_dau_tu ?>">	
		</div>	
	</div><!-- chu_dau_tu -->
	<div class="item_list">
		<div class="item_list_box">
			<lable for="dia_chi" style="display: block;">Địa chỉ</lable>
			<input name="dia_chi" class="code"  id="dia_chi" type="text" value="<?php echo $dia_chi ?>">	
		</div>	
	</div><!-- dia_chi -->
	<div class="item_list">
		<div class="item_list_box">
			<lable for="tong_dien_tich" style="display: block;">Tổng diện tích(m<sup>2</sup>)</lable>
			<input name="tong_dien_tich" class="code"  id="tong_dien_tich" type="text" value="<?php echo $tong_dien_tich ?>">
		</div>	
	</div><!-- tong_dien_tich -->
	<div class="item_list">
		<div class="item_list_box">
			<lable for="loai_hinh_phat_trien" style="display: block;">Loại hình phát triển</lable>
			<input name="loai_hinh_phat_trien" class="code"  id="loai_hinh_phat_trien" type="text" value="<?php echo $loai_hinh_phat_trien ?>">
		</div>	
	</div><!-- loai_hinh_phat_trien -->
	<div class="item_list">
		<div class="item_list_box">
			<lable for="gia_ban" style="display: block;">Giá bán</lable>
			<input name="gia_ban" class="code"  id="gia_ban" type="text" value="<?php echo $gia_ban ?>">
		</div>	
	</div><!-- gia_ban -->
	<div class="item_list">
		<div class="item_list_box">
			<lable for="quy_mo_du_an" style="display: block;">Quy mô dự án</lable>
			<input name="quy_mo_du_an" class="code"  id="quy_mo_du_an" type="text" value="<?php echo $quy_mo_du_an ?>">
		</div>	
	</div><!-- quy_mo_du_an -->
	<div class="item_list">
		<div class="item_list_box">
			<lable for="quan" style="display: block;">Thuộc</lable>
			<select  name="quan" id="quan" class="code">
				<option value="Hải Châu" <?php if($quan == 'Hải Châu'){echo 'selected';} ?>>Hải Châu</option>
				<option value="Thanh Khê" <?php if($quan == 'Thanh Khê'){echo 'selected';} ?>>Thanh Khê</option>
				<option value="Sơn Trà" <?php if($quan == 'Sơn Trà'){echo 'selected';} ?>>Sơn Trà</option>
				<option value="Ngũ Hành Sơn" <?php if($quan == 'Ngũ Hành Sơn'){echo 'selected';} ?>>Ngũ Hành Sơn</option>
				<option value="Liên Chiểu" <?php if($quan == 'Liên Chiểu'){echo 'selected';} ?>>Liên Chiểu</option>
				<option value="Hòa Vang" <?php if($quan == 'Hòa Vang'){echo 'selected';} ?>>Hòa Vang</option>
				<option value="Cẩm Lệ" <?php if($quan == 'Cẩm Lệ'){echo 'selected';} ?>>Cẩm Lệ</option>
				<option value="Quảng Nam" <?php if($quan == 'Quảng Nam'){echo 'selected';} ?>>Quảng Nam</option>
				<option value="Quảng Ngãi" <?php if($quan == 'Quảng Ngãi'){echo 'selected';} ?>>Quảng Ngãi</option>
			</select>		
		</div>		
	</div>	
	<hr>
	<div class="item_list full">
		<div class="item_list_box">
			<lable for="vi_tri_du_an" style="display: block;">Vị trí dự án</lable>
			<?php 
			$description = $vi_tri_du_an;
			wp_editor( $description, 'desc', array('textarea_name' => 'vi_tri_du_an', 'editor_class' => 'vi_tri_du_an', 'teeny' => false, 'textarea_rows' => 8) ); ?>
		</div>		
	</div>		
	<div class="item_list full">
		<div class="item_list_box">
			<lable for="ha_tang_du_an" style="display: block;">Hạ tầng dự án</lable>
			<!-- <textarea name='vi_tri' rows="5"></textarea> -->
			<?php 
			$description = $ha_tang_du_an;
			wp_editor( $description, $editor_id = "ha_tang_du_an",'desc', array('textarea_name' => 'ha_tang_du_an','editor_class' => 'ha_tang_du_an', 'teenya' => false, 'textarea_rows' => 8) ); ?>
		</div>		
	</div>		
</div>
<?php
}

function info_project_save($post_id){	

	if(isset($_POST['chu_dau_tu'])){
		$chu_dau_tu= $_POST['chu_dau_tu'];
		update_post_meta($post_id,'_chu_dau_tu',$chu_dau_tu);
	}
	if(isset($_POST['ten_du_an'])){
		$ten_du_an= $_POST['ten_du_an'];
		update_post_meta($post_id,'_ten_du_an',$ten_du_an);
	}
	if(isset($_POST['dia_chi'])){
		$dia_chi= $_POST['dia_chi'];
		update_post_meta($post_id,'_dia_chi',$dia_chi);
	}
	if(isset($_POST['tong_dien_tich'])){
		$tong_dien_tich= $_POST['tong_dien_tich'];
		update_post_meta($post_id,'_tong_dien_tich',$tong_dien_tich);
	}
	if(isset($_POST['loai_hinh_phat_trien'])){
		$loai_hinh_phat_trien= $_POST['loai_hinh_phat_trien'];
		update_post_meta($post_id,'_loai_hinh_phat_trien',$loai_hinh_phat_trien);
	}
	if(isset($_POST['gia_ban'])){
		$gia_ban= $_POST['gia_ban'];
		update_post_meta($post_id,'_gia_ban',$gia_ban);
	}
	if(isset($_POST['quy_mo_du_an'])){
		$quy_mo_du_an= $_POST['quy_mo_du_an'];
		update_post_meta($post_id,'_quy_mo_du_an',$quy_mo_du_an);
	}
	if(isset($_POST['quan'])){
		$quan= $_POST['quan'];
		update_post_meta($post_id,'_quan',$quan);
	}
	if(isset($_POST['vi_tri_du_an'])){
		$vi_tri_du_an= $_POST['vi_tri_du_an'];
		update_post_meta($post_id,'_vi_tri_du_an',$vi_tri_du_an);
	}
	if(isset($_POST['ha_tang_du_an'])){
		$ha_tang_du_an= $_POST['ha_tang_du_an'];
		update_post_meta($post_id,'_ha_tang_du_an',$ha_tang_du_an);
	}
}
add_action('save_post','info_project_save');


// Thông tin người nhập và liên hệ

function info_auth_project_meta_box(){
	$id = 'info_auth_project_meta_box';
	$title = 'Thông tin người đăng';
	$callback = 'info_auth_project_output';
	$screen = 'post_project';
	add_meta_box( $id, $title, $callback,$screen);

}
add_action('add_meta_boxes','info_auth_project_meta_box');

function info_auth_project_output($post){
	global $current_user;
	$name =  $current_user->display_name ;
	$email_s =  $current_user->user_email ;
	$phone =  $current_user->phone ;
	$ho_ten_check =  get_post_meta( $post->ID, '_ho_ten', true );
	if(empty($ho_ten_check)){
		$ho_ten = $name;
	}else{
		$ho_ten = $ho_ten_check;
	}
	if(empty($mobile)){
		$mobile = $phone;
	}else{
		$mobile = get_post_meta( $post->ID, '_mobile', true );
	}
	if(empty($email)){
		$email = $email_s;
	}else{
		$email = 'cskh@kyguinhadat43.com';
	}
	?>
	<div class="box_info_meta_box">
		<div class="item_list">
			<div class="item_list_box">
				<lable for="ho_ten" style="display: block;">Tên liên lạc</lable>
				<input name="ho_ten" class="code"  id="ho_ten" type="text" value="<?php echo $ho_ten ?>">	
			</div>	
		</div>	
		<div class="item_list">
			<div class="item_list_box">
				<lable for="mobile" style="display: block;">Mobile</lable>
				<input name="mobile" class="code"  id="mobile" type="text" value="<?php echo $mobile ?>">	
			</div>	
		</div>	
		<div class="item_list">
			<div class="item_list_box">
				<lable for="email" style="display: block;">Email</lable>
				<input name="email" class="code"  id="email" type="text" value="<?php echo $email ?>">	
			</div>	
		</div>	
	</div>	
	<?php
}
function info_auth_project_save($post_id){
	if(isset($_POST['ho_ten'])){
		$ho_ten = sanitize_text_field( $_POST['ho_ten'] );
		update_post_meta($post_id,'_ho_ten',$ho_ten);
	}
	if(isset($_POST['mobile'])){
		$mobile = sanitize_text_field( $_POST['mobile'] );
		update_post_meta($post_id,'_mobile',$mobile);
	}
	if(isset($_POST['email'])){
		$email = sanitize_text_field( $_POST['email'] );
		update_post_meta($post_id,'_email',$email);
	}
}
add_action('save_post','info_auth_project_save');
