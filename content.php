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
                            <!--                        
                            <li class="color mau1 active"></li>
                            <li class="color mau2 "></li>
                            <li class="color mau3 "></li>
                            <li class="color mau4"></li>
                            <li class="color mau5"></li>
                            <li class="color mau6"></li> -->
                        </ul>
                    </div>
                    <div class="size_list list">
                        <div class="title">Size</div>
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
                        <label for="check_order" class="check_order_label">Bạn cần mua ?</label>
                    </div>
                    <div class="box_order">
                        <div class="box_heading">Đặt mua </div>
                        <aside class="form_order">
                            <form action="" method="post">
                                <div class="box_info_product">
                                    <ul class="info_pro">
                                        <li class="item_info">
                                            <span>Sản phẩm cần mua:</span> Áo thun cổ tròn
                                        </li>
                                        <li class="item_info">
                                            <span>Màu áo:</span> Màu Đỏ Đô
                                        </li>
                                        <li class="item_info">
                                            <span>Size:</span> S
                                        </li>
                                        <li class="item_info">
                                            <div class="sum_info">
                                                <div class="name"><span>Số lượng:</span></div>
                                                <div class="count">
                                                    <select>
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
                                        </li>
                                        <li class=" item_info sum_money">Tổng tiền: <span>100.000 VND</span></li>
                                    </ul>
                                </div>
                                <div class="box_info_customer">
                                    <div class="box_gender form_control">
                                        <div class="item_gender check_control">
                                            <input type="radio" name="gender" id="check_gender_male" class="check_order_in">
                                            <span class="checkmark"></span>
                                            <label for="check_gender_male" class="check_order_label">Anh</label>
                                        </div>
                                        <div class="item_gender check_control">
                                            <input type="radio" name="gender" id="check_gender_female" class="check_order_in">
                                            <span class="checkmark"></span>
                                            <label for="check_gender_female" class="check_order_label">Chị</label>
                                        </div>
                                    </div>
                                    <div class="form_control">
                                        <div class="haft_box">
                                            <input class="in_control" type="text" placeholder="Họ tên người mua" name="ho_ten" />
                                        </div>
                                        <div class="haft_box">
                                            <input class="in_control" type="text" placeholder="Thông tin Email" name="email" />
                                        </div>
                                    </div>
                                    <div class="form_control">
                                        <div class="haft_box">
                                            <input class="in_control" type="text" placeholder="Số điện thoại liên hệ" name="phone" />
                                        </div>
                                        <div class="haft_box">
                                            <input class="in_control" type="text" placeholder="Địa chỉ" name="dia_chi" />
                                        </div>
                                    </div>
                                    <div class="form_control">
                                        <div class="full_box">
                                            <textarea class="in_control" rows="5" name="ghi_chu" placeholder="Thông tin ghi chú"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="box_order_action">
                                    <button class="btn_order">Đặt Hàng ngay</button>
                                </div>
                            </form>
                        </aside>
                    </div>
                </div>
            </div>