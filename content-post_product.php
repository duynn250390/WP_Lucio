<?php the_breadcrumb(); ?>
<div class="container">
    <div class="box_content_product">
        <div class="box_left box_control">
            <div class="control_images_product">
                <div class="box_thumb box_thumb_avatar">
                    <figure class="control_img">
                        <!-- <div class="myresult"></div> -->
                        <div class="slideimg">
                            <?php
                            $images = get_post_meta($post->ID, 'tdc_gallery_id', true);
                            foreach ($images as $image) {
                                $url_img =  wp_get_attachment_url($image, 'large');
                                $image_img = wp_get_attachment_image($image, 'large');
                                ?>
                                <figure class="item_slide">
                                    <?php echo $image_img; ?>
                                </figure>
                            <?php } ?>
                        </div>
                        <!-- <img class="img_thum_con" id="img_thum_con"
                            src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>" /> -->
                    </figure>
                </div>
                <div class="box_thumb box_thumb_small">
                    <div class="ct_thumb">
                        <?php
                        $images = get_post_meta($post->ID, 'tdc_gallery_id', true);
                        foreach ($images as $image) {
                            $url_img =  wp_get_attachment_url($image, 'large');
                            $image_img = wp_get_attachment_image($image, 'large');
                            ?>
                            <div class="thumb_avata">
                                <?php echo $image_img; ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_right box_control">
            <div class="main_heading control_heading">
                <?php the_title(); ?>
            </div>
            <?php
            $giatien =  get_post_meta(get_the_ID(), '_gia_tien', TRUE);
            ?>
            <div class="price"><?php echo  $giatien; ?> VND</div>
            <article class="descrption_product">
                <?php
                $thong_tin =  get_post_meta(get_the_ID(), '_thong_tin', TRUE);
                echo  $thong_tin;
                ?>
            </article>
            <div class="color_list list">
                <div class="title">Màu hiện có</div>
                <ul class="list_color_detail">
                    <?php
                    $terms = get_the_terms($post->ID, 'color');
                    if (!empty($terms)) {
                        foreach ($terms as $term) { ?>
                            <li class="color mau2 <?php echo $term->slug ?> "></li>
                    <?php  }
                    }
                    ?>
                </ul>
            </div>
            <div class="size_list list">
                <div class="title" id="checkSize">Size</div>
                <ul class="list_size">
                    <?php
                    $terms = get_the_terms($post->ID, 'size');
                    if (!empty($terms)) {
                        foreach ($terms as $term) { ?>
                            <li class="size"><?php echo $term->name ?></li>
                    <?php }
                    } ?>
                    <!-- <li class="size active">S</li>
                            <li class="size">M</li>
                            <li class="size">L</li>
                            <li class="size">XL</li> -->
                </ul>
            </div>
            <div class="check_order check_control">
                <input type="checkbox" id="check_order" class="check_order_in check_show_custom">
                <span class="checkmark"></span>
                <label for="check_order" class="check_order_label">ĐẶT HÀNG NGAY</label>
            </div>

            <div class="box_order">
                <div class="box_heading">Đặt mua NGAY </div>
                <aside class="form_order">
                    <!-- <form  method="post" enctype="multipart/form-data"> -->
                    <div class="box_info_product">
                        <div class="info_pro">
                            <div class="item_info">
                                <span>Sản phẩm:</span><label class="ten_san_pham" data-san-pham="<?php the_title(); ?>"><?php the_title(); ?></label>
                            </div>
                            <div class="item_info ">
                                <div class="sum_info">
                                    <div class="name"><span>Số lượng:</span></div>
                                    <div class="count">
                                        <select class="so_luong" name="so_luong" id="so_luong" data-money=" <?php $gia_tien =  get_post_meta(get_the_ID(), '_gia_tien', TRUE);
                                                                                                            echo  $gia_tien; ?>" data-id-content="<?php echo $post->ID ?>">
                                            <option value="0">Chọn</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="full_item item_info">
                                <div class="item_list_full item_info_sub">
                                    <div class="item_info">
                                        <div class="item_info">
                                            <div class="sum_info">
                                                <div class="name"><span>Màu:</span></div>
                                                <div class="count">
                                                    <select class="list_color" name="mau">
                                                        <?php
                                                        $terms = get_the_terms($post->ID, 'color');
                                                        if (!empty($terms)) {
                                                            foreach ($terms as $term) { ?>
                                                                <option value="<?php echo $term->name ?>"><?php echo $term->name ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item_info">
                                        <div class="sum_info">
                                            <div class="name"><span>Size:</span></div>
                                            <div class="count">
                                                <select class="list_size" name="size">
                                                    <?php
                                                    $terms = get_the_terms($post->ID, 'size');
                                                    if (!empty($terms)) {
                                                        foreach ($terms as $term) { ?>
                                                            <option value="<?php echo $term->name ?>"><?php echo $term->name ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" item_info sum_money">Tổng tiền: <b class="count_noney">
                                    <?php $gia_tien =  get_post_meta(get_the_ID(), '_gia_tien', TRUE);
                                    echo  $gia_tien; ?>
                                </b> VND</div>
                        </div>
                    </div>
                    <div class="box_info_customer">
                        <div class="alert_validate"></div>
                        <div class="box_gender form_control">
                            <div class="item_gender check_control">
                                <input type="radio" name="gioi_tinh" data_gender="Anh" id="check_gender_male" class="gioi_tinh check_order_in">
                                <span class="checkmark"></span>
                                <label for="check_gender_male" class="check_order_label">Anh</label>
                            </div>
                            <div class="item_gender check_control">
                                <input type="radio" name="gioi_tinh" data_gender="Chị" id="check_gender_female" class="gioi_tinh check_order_in">
                                <span class="checkmark"></span>
                                <label for="check_gender_female" class="check_order_label">Chị</label>
                            </div>
                        </div>
                        <div class="form_control">
                            <div class="haft_box">
                                <input class="in_control" id="get_ho_ten" type="text" placeholder="Họ tên người mua" name="ho_ten" />
                            </div>
                            <div class="haft_box">
                                <input class="in_control" id="get_email" type="text" placeholder="Thông tin Email" name="email" />
                            </div>
                        </div>
                        <div class="form_control">
                            <div class="haft_box">
                                <input class="in_control" id="get_so_dien_thoai" name="so_dien_thoai" type="text" placeholder="Số điện thoại liên hệ" />
                            </div>
                            <div class="haft_box">
                                <input class="in_control" id="get_dia_chi" name="dia_chi" type="text" placeholder="Địa chỉ" name="dia_chi" />
                            </div>
                        </div>
                        <div class="form_control">
                            <div class="full_box">
                                <textarea class="in_control" rows="5" id="get_ghi_chu" name="ghi_chu" placeholder="Thông tin ghi chú"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box_order_action">
                        <div id="action_submit" class="btn_order">Đặt Hàng ngay</div>
                    </div>
                    <!-- </form> -->
                    <script type="text/javascript">
                        $(document).on('change', '.so_luong', function() {
                            var num_so_luong = this.value;
                            var id_post = $(this).attr('data-id-content');
                            var data_money = $(this).attr('data-money');
                            var i;
                            var html = '';
                            var list_color = $('list_color').html();
                            var tong_tien = num_so_luong * data_money;

                            $('.count_noney').html(tong_tien);
                            $.ajax({
                                type: "post",
                                dataType: "json",
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    action: "get_post_by_select", //Tên action
                                    'id_post': id_post
                                },
                                context: this,
                                success: function(response) {
                                    if (response.success) {
                                        var data = response.data;
                                        var data_Size = data.size;
                                        var data_Color = data.color;
                                        var htmlSize = '';
                                        var htmlColor = '';
                                        data_Color.forEach(function(entrycl) {
                                            htmlColor = htmlColor + ' <option value="8" data-color="' + entrycl.name + '">' + entrycl.name + '</option>';
                                        });
                                        data_Size.forEach(function(entryS) {
                                            htmlSize = htmlSize + ' <option value="8" data-size="' + entryS.name + '">' + entryS.name + '</option>';
                                        });
                                        $('.list_si').html(htmlSize);
                                        $('.list_cl').html(htmlColor);
                                        // console.log(data);
                                    } else {
                                        alert('Đã có lỗi xảy ra');
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    //Làm gì đó khi có lỗi xảy ra
                                    // console.log('The following error occured: ' + textStatus, errorThrown);
                                }
                            });
                            for (i = 1; i <= num_so_luong; i++) {
                                html = html +
                                    '<div class="item_info_sub">' +
                                    '<div class="item_info ">' +
                                    '<div class = "item_info" >' +
                                    '<div class = "sum_info" >' +
                                    '<div class = "name" > ' +
                                    '<span> Màu: </span></div >' +
                                    '<div class = "count" >' +
                                    '<select class="list_cl list_cl' + i + '" > ' +
                                    '<option value = "' +
                                    i + '" >' + list_color + '</option>' +
                                    '</select> </div > </div> </div > </div>' +
                                    '<div class="item_info">' +
                                    '<div class="sum_info">' +
                                    '<div class="name"><span>Size:</span></div>' +
                                    '<div class="count">' +
                                    '<select class="list_si list_si' + i + '">' +
                                    '</select>' +
                                    '</div></div></div></div>';
                            }
                            $('.item_list_full').html(html);
                        });
                        $(document).on('click', '#action_submit', function() {
                            var i;
                            var color;
                            var mau;
                            var size;
                            var arr = [];
                            var num_so_luong = $(".so_luong option:selected").text();
                            for (i = 1; i <= num_so_luong; i++) {
                                arr.push({
                                    mau: $(".list_cl" + (i)).find(':selected').attr('data-color'),
                                    size: $(".list_si" + (i)).find(':selected').attr('data-size')
                                })
                            }
                            var get_ho_ten = $('#get_ho_ten').val();
                            var get_email = $('#get_email').val();
                            var get_so_dien_thoai = $('#get_so_dien_thoai').val();
                            var get_dia_chi = $('#get_dia_chi').val();
                            var get_so_luong = $("#so_luong option:selected").text();
                            if (get_ho_ten === '' || get_email === '' || get_so_dien_thoai === '' || get_dia_chi === '' || get_so_luong === 'Chọn') {
                                $('.alert_validate').html('Xảy ra lỗi ! Vui lòng nhập đầy đủ thông tin để việc xác nhận được nhanh chóng và chính xác !');
                            } else {
                                $('.alert_validate').html('');
                                $.ajax({
                                    type: "post",
                                    dataType: "json",
                                    // async: true,
                                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                    data: {
                                        action: "add_order",
                                        ten_san_pham: $('.ten_san_pham').attr('data-san-pham'),
                                        so_luong: $("#so_luong option:selected").text(),
                                        tong_tien: $('.count_noney').text(),
                                        mau_ao: arr,
                                        gioi_tinh: $("input[name='gioi_tinh']:checked").attr('data_gender'),
                                        ho_ten: $('#get_ho_ten').val(),
                                        email: $('#get_email').val(),
                                        so_dien_thoai: $('#get_so_dien_thoai').val(),
                                        dia_chi: $('#get_dia_chi').val(),
                                        ghi_chu: $('#get_ghi_chu').val(),
                                    },
                                    context: this,
                                    success: function(response) {
                                        if (response.success) {

                                            console.log(response.data);
                                        } else {
                                            console.log('Đã có lỗi xảy ra');
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log('The following error occured: ' + textStatus, errorThrown);
                                    }
                                });
                                var box_order = $('.box_order');
                                box_order.css({
                                    'height': '0',
                                    'opacity': '0'
                                });
                                $('.in_control').val('');
                                $('.alert_order').show('slow');
                                $('.alert_order').html('Bạn đã đặt hàng thành công ! Chúng tôi sẽ liên hệ xác thực và giao hàng đến bạn sớm nhất. Xin cảm ơn !')
                            }
                        });
                    </script>
                </aside>

            </div>
            <div class="alert alert_order hideMe"></div>
        </div>
    </div>
</div>
<div class="modal_show fade" id="modal_content_size">
    <div class="dialog_modal">
        <div class="modal_header">
            <h3>Tư Vấn Size</h3>
        </div>
        <div class="box_now">
            <section class="box_input_size">
                <div class="item_size full">
                    <select class="gioi_tinh fullcontrol">
                        <option value="Nam">Chọn giới tính</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </div>
                <div class="item_size">
                    <label for="get_height">Nhập Chiều Cao (cm)</label>
                    <input class="fullcontrol get_height " name="get_height" id="get_height" type="number" placeholder="Nhập chiều cao">
                </div>
                <div class="item_size">
                    <label for="get_weight">Nhập Cân Nặng (KG)</label>
                    <input class="fullcontrol get_weight" name="get_weight" id="get_weight" type="number" placeholder="Nhập Cân nặng">
                </div>
                <div class="item_size full right">
                    <button class="btn check" id="checkSizeFRONT">Kiểm tra</button>
                </div>

            </section>
            <section class="result_size">
                Bạn nên mặc Size: <span id="Size_RS"></span>
            </section>
        </div>
        <div class="footer">
            <span class="btn" id="closeModal">Close</span>
        </div>
    </div>
</div>
<!-- https://www.youtube.com/watch?v=MQKqmlYamYM&list=PLVwbFltmnQtXd35iH9oJ-rE3MFaoPOmMp&index=4 -->