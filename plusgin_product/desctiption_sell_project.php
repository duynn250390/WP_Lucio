<?php
/*
Plugin Name: Đăng Tin Dự Án Cần Bán
Author: Vnroki
Description: Tổng hợp thông tin về các dự án bất động sản đang và sắp mở bán.
*/


/*==========================================
THÊM ẢNH DỰ ÁN
==========================================*/

function add_gallery_metabox_sell_project($post_type) {
	$types = array('post_sell_project');
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
add_action('add_meta_boxes', 'add_gallery_metabox_sell_project');

function gallery_meta_callback_sell_project($post) {
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
	function gallery__project_meta_sell_project_save($post_id) {
		if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;
		if (!current_user_can('edit_post', $post_id)) return;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		if(isset($_POST['tdc_gallery_id'])) {
			update_post_meta($post_id, 'tdc_gallery_id', $_POST['tdc_gallery_id']);
		} else {
			delete_post_meta($post_id, 'tdc_gallery_id');
		}
	}
	add_action('save_post', 'gallery__project_meta_sell_project_save');

	function gallery_enqueue_hook_sell_project($hook) {
		wp_enqueue_script('gallery-metabox', get_template_directory_uri() . '/lib/js/gallery-metabox.js', array('jquery', 'jquery-ui-sortable'));
		wp_enqueue_style('gallery-metabox', get_template_directory_uri() . '/lib/css/gallery-metabox.css');
	}
	add_action('admin_enqueue_scripts', 'gallery_enqueue_hook_sell_project');

// Thông tin người nhập và liên hệ
// =======================================
	function sellproject_land_meta_box(){
		$id = 'info_land_meta_box';
		$title = 'Đất cần bán';
		$callback = 'sellproject_land_output';
		$screen = 'post_sell_project';
		add_meta_box( $id, $title, $callback,$screen);
	}
	add_action('add_meta_boxes','sellproject_land_meta_box');

	function sellproject_land_output($post){
		$huong_nha = get_post_meta( $post->ID, '_huong_nha', true );
		$dien_tich = get_post_meta( $post->ID, '_dien_tich', true );
		$duong = get_post_meta( $post->ID, '_duong', true );
		$gia_tien = get_post_meta( $post->ID, '_gia_tien', true );
		$dia_chi = get_post_meta( $post->ID, '_dia_chi', true );
		$mat_tien = get_post_meta( $post->ID, '_mat_tien', true );
		$loai_tin = get_post_meta( $post->ID, '_loai_tin', true );
		$quan = get_post_meta( $post->ID, '_quan', true );
		$thuoc_du_an = get_post_meta( $post->ID, '_thuoc_du_an', true );
		$tinh_trang = get_post_meta( $post->ID, '_tinh_trang', true );
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
	</style>
	<?php global $current_user;
	$lever =  $current_user->user_level;
	?>
<div class="box_info_meta_box">
	<?php 
		$taxonomies = get_terms( array(
			'taxonomy' => 'duan_taxonomy',
			'hide_empty' => false
		) );
		if ( !empty($taxonomies) ) :?>
		<div class="item_list">
			<div class="item_list_box">
				<lable for="thuoc_du_an" style="display: block;">Thuộc dự án</lable>
				<select  name="thuoc_du_an" id="thuoc_du_an" class="code">
					<?php 
					foreach( $taxonomies as $category ) {?>
					<option value="<?php echo  esc_attr( $category->slug );?>" <?php if(esc_attr( $category->slug ) == $thuoc_du_an){ echo 'selected';} ?>><?php echo esc_attr( $category->name ) ?></option>
					<?php }?>
				</select>
			</div>	
		</div>	
	<?php endif;?>
	<div class="item_list">
		<div class="item_list_box">
			<lable for="dia_chi" style="display: block;">Địa chỉ</lable>
			<input name="dia_chi" class="code"  id="dia_chi" type="text" value="<?php echo $dia_chi ?>">	
		</div>	
	</div>	
	<div class="item_list">
		<div class="item_list_box">
			<lable for="huong_nha" style="display: block;">Hướng </lable>
			<select  name="huong_nha" id="huong_nha" class="code">
				<option value="Bắc" <?php if($huong_nha == 'Bắc'){echo 'selected';} ?>>Bắc</option>
				<option value="Đông Bắc" <?php if($huong_nha == 'Đông Bắc'){echo 'selected';} ?>>Đông Bắc</option>
				<option value="Tây Bắc" <?php if($huong_nha == 'Tây Bắc'){echo 'selected';} ?>>Tây Bắc</option>
				<option value="Nam" <?php if($huong_nha == 'Nam'){echo 'selected';} ?>>Nam</option>
				<option value="Đông Nam" <?php if($huong_nha == 'Đông Nam'){echo 'selected';} ?>>Đông Nam</option>
				<option value="Tây Nam" <?php if($huong_nha == 'Tây Nam'){echo 'selected';} ?>>Tây Nam</option>
				<option value="Đông " <?php if($huong_nha == 'Đông'){echo 'selected';} ?>>Đông</option>
				<option value="Tây" <?php if($huong_nha == 'Tây'){echo 'selected';} ?>>Tây</option>
			</select>
		</div>	
	</div>	
	<div class="item_list">
		<div class="item_list_box">
			<lable for="mat_tien" style="display: block;">Mặt tiền(m<sup>2</sup>)</lable>
			<input name="mat_tien" class="code"  id="mat_tien" type="text" value="<?php echo $mat_tien ?>">
		</div>	
	</div>	
	<div class="item_list">
		<div class="item_list_box">
			<lable for="dien_tich" style="display: block;">Diện tích(m<sup>2</sup>)</lable>
			<input name="dien_tich" class="code"  id="dien_tich" type="text" value="<?php echo $dien_tich ?>">
		</div>	
	</div>	
	<div class="item_list">
		<div class="item_list_box">
			<lable for="duong" style="display: block;">Đường(m<sup>2</sup>)</lable>
			<input name="duong" class="code"  id="duong" type="text" value="<?php echo $duong ?>">
		</div>	
	</div>	
	<div class="item_list">
		<div class="item_list_box">
			<lable for="gia_tien" style="display: block;">Giá tiền(VNĐ)</lable>
			<input name="gia_tien" class="code" id="gia_tien" type="text" value="<?php echo $gia_tien ?>">
		</div>		
	</div>		
	<div class="item_list">
		<div class="item_list_box">
			<lable for="loai_tin" style="display: block;">Hình thức ưu tiên</lable>
			<?php
			if($lever == 10){?>
			<select  name="loai_tin" id="loai_tin" class="code">
				<option value="Vip" <?php if($loai_tin == 'Vip'){echo 'selected';} ?>>Vip</option>
				<option value="Ưu tiên" <?php if($loai_tin == 'Ưu tiên'){echo 'selected';} ?>>Ưu tiên</option>
				<option value="Thường" <?php if($loai_tin == 'Thường'){echo 'selected';} ?>>Thường</option>
			</select>	
			<?php }else{ ?>
			<select  name="loai_tin" id="loai_tin" class="code">
				<option value="Thường" <?php if($loai_tin == 'Thường'){echo 'selected';} ?>>Thường</option>
			</select>	
			<?php } ?>
		</div>		
	</div>		
	<div class="item_list">
		<div class="item_list_box">
			<lable for="tinh_trang" style="display: block;">Tình trạng</lable>
			<select  name="tinh_trang" id="tinh_trang" class="code">
				<option value="Còn hàng" <?php if($tinh_trang == 'Còn hàng'){echo 'selected';} ?>>Còn hàng</option>
				<option value="Đã bán" <?php if($tinh_trang == 'Đã bán'){echo 'selected';} ?>>Đã bán</option>
			</select>	
		</div>		
	</div>				
</div>
<?php
}
function sellproject_land_save($post_id){
	if(isset($_POST['duong'])){
		$duong = sanitize_text_field( $_POST['duong'] );
		update_post_meta($post_id,'_duong',$duong);
	}
	if(isset($_POST['thuoc_du_an'])){
		$thuoc_du_an = sanitize_text_field( $_POST['thuoc_du_an'] );
		update_post_meta($post_id,'_thuoc_du_an',$thuoc_du_an);
	}
	if(isset($_POST['huong_nha'])){
		$huong_nha = sanitize_text_field( $_POST['huong_nha'] );
		update_post_meta($post_id,'_huong_nha',$huong_nha);
	}
	if(isset($_POST['dien_tich'])){
		$dien_tich = sanitize_text_field( $_POST['dien_tich'] );
		update_post_meta($post_id,'_dien_tich',$dien_tich);
	}
	if(isset($_POST['gia_tien'])){
		$gia_tien = sanitize_text_field( $_POST['gia_tien'] );
		update_post_meta($post_id,'_gia_tien',$gia_tien);
	}
	if(isset($_POST['dia_chi'])){
		$dia_chi = sanitize_text_field( $_POST['dia_chi'] );
		update_post_meta($post_id,'_dia_chi',$dia_chi);
	}
	if(isset($_POST['mat_tien'])){
		$mat_tien = sanitize_text_field( $_POST['mat_tien'] );
		update_post_meta($post_id,'_mat_tien',$mat_tien);
	}
	if(isset($_POST['loai_tin'])){
		$loai_tin= sanitize_text_field( $_POST['loai_tin'] );
		update_post_meta($post_id,'_loai_tin',$loai_tin);
	}
	if(isset($_POST['quan'])){
		$quan= sanitize_text_field( $_POST['quan'] );
		update_post_meta($post_id,'_quan',$quan);
	}
	if(isset($_POST['tinh_trang'])){
		$quan= sanitize_text_field( $_POST['tinh_trang'] );
		update_post_meta($post_id,'_tinh_trang',$quan);
	}
}
add_action('save_post','sellproject_land_save');

// Thông tin người nhập và liên hệ

function sellproject_auth_meta_box(){
	$id = 'info_auth_meta_box';
	$title = 'Thông tin người đăng';
	$callback = 'sellproject_auth_output';
	$screen = 'post_sell_project';
	add_meta_box( $id, $title, $callback,$screen);

}
add_action('add_meta_boxes','sellproject_auth_meta_box');

function sellproject_auth_output($post){
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
function sellproject_auth_save($post_id){
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
add_action('save_post','sellproject_auth_save');
