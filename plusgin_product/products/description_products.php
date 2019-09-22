<?php
/*
Plugin Name: Đăng thông tin Sản phẩm
Author: HeroZuZu
Description: Thêm sản phẩm
*/
function add_gallery_metabox($post_type) {
	$types = array('post_product');
	if (in_array($post_type, $types)) {
		add_meta_box(
			'gallery-metabox',
			'Thêm hình ảnh',
			'gallery_meta_callback',
			$post_type,
			'normal',
			'high'
		);
	}  
}
add_action('add_meta_boxes', 'add_gallery_metabox');


function gallery_meta_callback($post) {
	wp_nonce_field( basename(__FILE__), 'gallery_meta_nonce' );
	$ids = get_post_meta($post->ID, 'tdc_gallery_id', true);
	?>
	<table class="form-table">
		<tr><td>
			<a class="gallery-add button" href="#" data-uploader-title="Thêm hình ảnh" data-uploader-button-text="Thêm nhiều hình ảnh">Thêm nhiều hình ảnh</a>
			<ul id="gallery-metabox-list" class="gallery-metabox-list">
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
	function gallery_meta_save($post_id) {
		if (!isset($_POST['gallery_meta_nonce']) || !wp_verify_nonce($_POST['gallery_meta_nonce'], basename(__FILE__))) return;
		if (!current_user_can('edit_post', $post_id)) return;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

		if(isset($_POST['tdc_gallery_id'])) {
			update_post_meta($post_id, 'tdc_gallery_id', $_POST['tdc_gallery_id']);
		} else {
			delete_post_meta($post_id, 'tdc_gallery_id');
		}
	}
	add_action('save_post', 'gallery_meta_save');

	function gallery_enqueue_hook($hook) {
		wp_enqueue_script('gallery-metaboxs', get_template_directory_uri() . '/public/js/gallery-metabox.js', array('jquery', 'jquery-ui-sortable'));
		wp_enqueue_style('gallery-metaboxs', get_template_directory_uri() . '/public/css/gallery-metabox.css.css');
	}
	add_action('admin_enqueue_scripts', 'gallery_enqueue_hook');

// Thông tin người nhập và liên hệ
// =======================================
	function info_home_meta_box(){
		$id = 'info_home_meta_box';
		$title = 'Thông tin sản phẩm';
		$callback = 'info_home_output';
		$screen = 'post_product';
		add_meta_box( $id, $title, $callback,$screen);

	}
	add_action('add_meta_boxes','info_home_meta_box');
	function info_home_output($post){
		$gia_tien = get_post_meta( $post->ID, '_gia_tien', true );
		$thong_tin = get_post_meta( $post->ID, '_thong_tin', true );
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
	<?php global $current_user;
	$lever =  $current_user->user_level;
	?>
	<div class="box_info_meta_box">
		<div class="item_list">
			<div class="item_list_box haft">
				<lable for="gia_tien">Giá tiền(VNĐ)</lable>
				<input name="gia_tien" class="input_control" id="gia_tien" type="number" placeholder="500.000" value="<?php echo $gia_tien ?>">
			</div>		
		</div>
		<div class="item_list">
			<div class="item_list_box">
				<lable for="thong_tin">Thông tin</lable>
				<textarea name="thong_tin" class="input_control" rows="5" id="thong_tin"><?php echo $thong_tin ?></textarea>
			</div>		
		</div>
	</div>
	<!-- <script type="text/javascript">
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
	</script> -->
	<?php
}
function info_product($post_id){
	if(isset($_POST['gia_tien'])){
		$gia_tien = sanitize_text_field( $_POST['gia_tien'] );
		update_post_meta($post_id,'_gia_tien',$gia_tien);
	}
	if(isset($_POST['thong_tin'])){
		$thong_tin = sanitize_text_field( $_POST['thong_tin'] );
		update_post_meta($post_id,'_thong_tin',$thong_tin);
	}
}
add_action('save_post','info_product');