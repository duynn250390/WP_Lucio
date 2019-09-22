	<?php
/*
Plugin Name: Đăng Tin Đất Cần Bán
Author: Vnroki
Description: Thêm thông tin của tin bất động sản: Hướng nhà - Đường - Quận...
*/
/*==========================================
ĐẤT CẦN BÁN
==========================================*/

function add_gallery_metabox_land($post_type) {
	$types = array('post_land');
	if (in_array($post_type, $types)) {
		add_meta_box(
			'gallery-metabox',
			'Thêm hình ảnh',
			'gallery_meta_callback_land',
			$post_type,
			'normal',
			'high'
		);
	}  
}
add_action('add_meta_boxes', 'add_gallery_metabox_land');

function gallery_meta_callback_land($post) {
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
	function gallery_meta_save_land($post_id) {
		if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;
		if (!current_user_can('edit_post', $post_id)) return;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		if(isset($_POST['tdc_gallery_id'])) {
			update_post_meta($post_id, 'tdc_gallery_id', $_POST['tdc_gallery_id']);
		} else {
			delete_post_meta($post_id, 'tdc_gallery_id');
		}
	}
	add_action('save_post', 'gallery_meta_save_land');

	function gallery_enqueue_hook_land($hook) {
		wp_enqueue_script('gallery-metabox', get_template_directory_uri() . '/lib/js/gallery-metabox.js', array('jquery', 'jquery-ui-sortable'));
		wp_enqueue_style('gallery-metabox', get_template_directory_uri() . '/lib/css/gallery-metabox.css');
	}
	add_action('admin_enqueue_scripts', 'gallery_enqueue_hook_land');
/*==========================================
ĐẤT CẦN BÁN
==========================================*/
function info_land_meta_box(){
	$id = 'info_land_meta_box';
	$title = 'Đất cần bán';
	$callback = 'info_land_output';
	$screen = 'post_land';
	add_meta_box( $id, $title, $callback,$screen);
}
add_action('add_meta_boxes','info_land_meta_box');

function info_land_output($post){
	$huong_nha = get_post_meta( $post->ID, '_huong_nha', true );
	$dien_tich = get_post_meta( $post->ID, '_dien_tich', true );
	$gia_tien = get_post_meta( $post->ID, '_gia_tien', true );
	$mat_tien = get_post_meta( $post->ID, '_mat_tien', true );
	$loai_tin = get_post_meta( $post->ID, '_loai_tin', true );
	$tinh_thanhpho = get_post_meta( $post->ID, '_tinh_thanhpho', true );
	$quan = get_post_meta( $post->ID, '_quan', true );
	$phuong_xa = get_post_meta( $post->ID, '_phuong_xa', true );
	$info_dia_chi = get_post_meta( $post->ID, '_info_dia_chi', true );
	$dia_chi = get_post_meta( $post->ID, '_dia_chi', true );
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
	<div class="item_list">
		<div class="item_list_box">
			<lable for="huong_nha" style="display: block;">Hướng Nhà </lable>
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
				<option value="1" <?php if($loai_tin == 1){echo 'selected';} ?>>Vip</option>
				<option value="2" <?php if($loai_tin == 2){echo 'selected';} ?>>Ưu tiên</option>
				<option value="3" <?php if($loai_tin == 3){echo 'selected';} ?>>Thường</option>
			</select>	
			<?php }else{ ?>
			<select  name="loai_tin" id="loai_tin" class="code">
				<option value="3" <?php if($loai_tin == 3){echo 'selected';} ?>>Thường</option>
			</select>	
			<?php } ?>	
		</div>		
	</div>		
	<div class="item_list">
		<div class="item_list_box">
			<lable for="tinh_thanhpho" style="display: block;">Thuộc tỉnh/thành phố</lable>
			<?php
			$terms = get_terms( array(
				'taxonomy' => 'loc',
				'hide_empty' => false,
					// 'term_taxonomy_id' => 36,
				'parent' => 0,
			) );
			echo '<select  name="tinh_thanhpho" id="tinh_thanhpho" class="code">';
			echo '<option value="0">--Tỉnh/thành phố--</option>';
			foreach ( $terms as $term ) {?>
			<option value="<?php echo $term->name?>"  data_id_tinh ="<?php echo $term->term_id;?>"  <?php if($tinh_thanhpho == $term->name){echo 'selected';} ?>><?php echo $term->name?></option>
			<?php } echo '</select>';?>
		</div>		
	</div>
	<div class="local_box" id="local_box">
		<div class="item_list">
			<div class="item_list_box">
				<lable for="quan" style="display: block;">Thuộc quận </lable>
				<select  name="quan" id="quan_huyen" class="code">
					<?php if(isset($quan)){?>
					<option value="<?php echo $quan ?>"><?php echo $quan ?></option>	
					<?php }else{ ?>
					<option value="0">--Quận/huyện--</option>
					<?php } ?>
				</select>
			</div>		
		</div>	
		<div class="item_list">
			<div class="item_list_box">
				<lable for="phuong_xa" style="display: block;">Thuộc Phường</lable>
				<select  name="phuong_xa" id="phuong_xa" class="code">
					<?php if(isset($phuong_xa)){?>
					<option value="<?php echo $phuong_xa ?>"><?php echo $phuong_xa ?></option>	
					<?php }else{ ?>
					<option  value="0">--Phường/xã--</option>
					<?php } ?>
				</select>
			</div>		
		</div>	
		<div class="item_list">
			<div class="item_list_box">
				<lable for="info_dia_chi" style="display: block;">Tên đường/ Số nhà cụ thể:</lable>
				<input name="info_dia_chi" class="code" placeholder="Số 04 đường Nguyễn Văn Linh"  id="info_dia_chi" type="text" value="<?php echo $info_dia_chi ?>">	
			</div>	
		</div>	
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		
		$('#tinh_thanhpho').on('change', function () {
			var id_tinh = $(this).find("option:selected").attr('data_id_tinh');
			$.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "getquan", //Tên action
                        'id_tinh' : id_tinh
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function(response) {
                        //Làm gì đó khi dữ liệu đã được xử lý
                        if(response.success) {
                            // alert(response.data);
                            var data = response.data;
                            var html = "<option value='0'>--Phường/xã--</option>";
                            data.forEach(function (item) {
                            	html += "<option value='" + item.name + "' data_id_huyen ='"+item.term_id+"'>" + item.name + "</option>";
                            });
                            $('#quan_huyen').html(html);
                        }
                        else {
                        	alert('Đã có lỗi xảy ra');
                        }
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        //Làm gì đó khi có lỗi xảy ra
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                })
			return false;
		});
		$('#quan_huyen').on('change', function () {
			var id_quan = $(this).find("option:selected").attr('data_id_huyen');
				// $('#ten_huyenthixa').removeAttr('disabled');
				$.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "getphuongxa", //Tên action
                        'id_quan' : id_quan
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function(response) {
                        //Làm gì đó khi dữ liệu đã được xử lý
                        if(response.success) {
                            // alert(response.data);
                            var data = response.data;
                            var html = "<option value='0'>--Phường/xã--</option>";
                            data.forEach(function (item) {
                            	html += "<option value='" + item.name + "'>" + item.name + "</option>";
                            });
                            $('#phuong_xa').html(html);
                        }
                        else {
                        	alert('Đã có lỗi xảy ra');
                        }
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        //Làm gì đó khi có lỗi xảy ra
                        console.log( 'The following error occured: ' + textStatus, errorThrown );
                    }
                })
				return false;
			});
	});
</script>
<?php
}
function info_land_save($post_id){
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
	if(isset($_POST['mat_tien'])){
		$mat_tien = sanitize_text_field( $_POST['mat_tien'] );
		update_post_meta($post_id,'_mat_tien',$mat_tien);
	}
	if(isset($_POST['loai_tin'])){
		$loai_tin= sanitize_text_field( $_POST['loai_tin'] );
		update_post_meta($post_id,'_loai_tin',$loai_tin);
	}
	if(isset($_POST['tinh_thanhpho'])){
		$quan= sanitize_text_field( $_POST['tinh_thanhpho'] );
		update_post_meta($post_id,'_tinh_thanhpho',$quan);
	}
	if(isset($_POST['quan'])){
		$quan= sanitize_text_field( $_POST['quan'] );
		update_post_meta($post_id,'_quan',$quan);
	}
	if(isset($_POST['phuong_xa'])){
		$quan= sanitize_text_field( $_POST['phuong_xa'] );
		update_post_meta($post_id,'_phuong_xa',$quan);
	}
	if(isset($_POST['info_dia_chi'])){
		$quan= sanitize_text_field( $_POST['info_dia_chi'] );
		update_post_meta($post_id,'_info_dia_chi',$quan);
	}
}
add_action('save_post','info_land_save');

// Thông tin người nhập và liên hệ

function info_auth_meta_box(){
	$id = 'info_auth_meta_box';
	$title = 'Thông tin người đăng';
	$callback = 'info_auth_output';
	$screen = 'post_land';
	add_meta_box( $id, $title, $callback,$screen);

}
add_action('add_meta_boxes','info_auth_meta_box');

function info_auth_output($post){
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
function info_auth_save($post_id){
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
add_action('save_post','info_auth_save');
