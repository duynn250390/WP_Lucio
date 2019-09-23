<?php
get_header();
?>
<div class="warap">
    <section class="slideshow">
        <?php
        $args = array(
            'post_type' => 'post_slideshow',
            'showposts' => 6,
            'order'    => 'DESC'
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                $post_id = $post->ID;
                $color_Product = get_post_meta(get_the_ID(), '_color_Product', TRUE);
                $size_Product = get_post_meta(get_the_ID(), '_size_Product', TRUE);
                ?>
                <?php echo $color_Product; ?>
                <div class="item_slick " style="background-image:url('<?php  echo get_the_post_thumbnail_url($post_id, 'full');?>')">
                    <div class="main_info_slide animated">
                        <div class="box_infomation">
                            <h3 class="title_1"><?php the_title(); ?></h3>
                            <div class="size_slideshow"><?php echo $color_Product; ?></div>
                            <!-- <ul class="list_color aothun">
                            <li class=""># Mã màu </li>
                            <li class="color color01"></li>
                            <li class="color color02"></li>
                            <li class="color color03"></li>
                            <li class="color color04"></li>
                        </ul> -->
                            <div class="size_ao">
                                <span>Size:</span> <?php echo $size_Product; ?>
                            </div>
                            <div class="box_readmore">
                                <a href="" class="btn01">
                                    Chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            else : ?>
            <p>Không có tin nào !</p>
        <?php endif;
        wp_reset_postdata(); ?>
    </section>
    <section class="main_content home product">
        <div class="container">
            <div class="main_heading control_heading">
                Sản phẩm đang bán
            </div>
            <div class="control_tabs_product">
                <ul class="tabs_product">
        <?php $all_categories = get_categories( $args );
        $i = 1;
        foreach ( $all_categories as $category ) {
            ?>
            <li class="item_tabs" id="item_tabs" data-id-cate="<?php echo $category->term_id;?>" data-tabs="<?php echo($i++);?>"><?php echo $category->name;?></li>
             <?php
        }
        ?>
        <script type="text/javascript">
        $(document).ready(function () {
            $('.item_tabs').on('click', function () {
                
                var ID_CATE = $(this).attr('data-id-cate');
                // console.log(ID_CATE);
                $('.product_main ').removeClass('fadeIn');
                $.ajax({
                    type : "post", //Phương thức truyền post hoặc get
                    dataType : "json", //Dạng dữ liệu trả về xml, json, script, or html
                    url : '<?php echo admin_url('admin-ajax.php');?>', //Đường dẫn chứa hàm xử lý dữ liệu. Mặc định của WP như vậy
                    data : {
                        action: "get_post_by_cate", //Tên action
                        'id_category' : ID_CATE
                    },
                    context: this,
                    beforeSend: function(){
                        //Làm gì đó trước khi gửi dữ liệu vào xử lý
                    },
                    success: function(response) {
                        //Làm gì đó khi dữ liệu đã được xử lý
                        $('.product_main ').addClass('fadeIn');
                        if(response.success) {
                            // alert(response.data);
                            var data = response.data;
                            // var html = "<option value='0'>--Phường/xã--</option>";
                            // data.forEach(function (item) {
                            //     console.log(item);
                            // html += "<option value='" + item.name + "' data_id_huyen ='"+item.term_id+"'>" + item.name + "</option>";
                            // });
                            // console.log(response.data);
                            $('.product_main ').html(data);
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
                </ul>
            </div>
        </div>
        <div class="box_product">
            <div class="product_main active animated" id="product_1">
            <?php
        $args = array(
            'post_type' => 'post_product',
            'showposts' => 8,
            // 'cat' => 17,
            'order'    => 'DESC'
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
            $post_id = $post->ID;
            $color_Product = get_post_meta(get_the_ID(), '_color_Product', TRUE);
            $size_Product = get_post_meta(get_the_ID(), '_size_Product', TRUE);
            ?>
            <div class="item_product ">
                <figure class="product_thumb">
                <img class="thumb" src="<?php  echo get_the_post_thumbnail_url($post_id, 'large');?>" alt="<?php echo the_title()?>"/>
                </figure>
                    <div class="ovelay_product"></div>
                    <div class="box_control_product">
                    <a href="<?php echo the_permalink(); ?>" class="btn_product">Chi tiết</a>
                </div>
            </div>
                 <?php endwhile;
            else : ?>
            <p>Không có tin nào !</p>
        <?php endif;
        wp_reset_postdata(); ?>
        </div>
    </section>
    <section class="customer_feedback">
        <div class="container">
            <div class="main_heading control_heading">
                KHÁCH HÀNG PHẢN HỒI
            </div>
        </div>
        <div class="box_slide_feedback">
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/1.jpg" class="thumb" alt="Feedback" />
                </figure>
            </div>
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/2.jpg" class="thumb" alt="Feedback" />
                </figure>
            </div>
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/3.jpg" class="thumb" alt="Feedback" />
                </figure>
            </div>
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/4.jpg" class="thumb" alt="Feedback" />
                </figure>
            </div>
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/5.jpg" class="thumb" alt="Feedback" />
                </figure>
            </div>
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/6.jpg" class="thumb" alt="Feedback" />
                </figure>
            </div>
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/7.png" class="thumb" alt="Feedback" />
                </figure>
            </div>
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/8.jpg" class="thumb" alt="Feedback" />
                </figure>
            </div>
            <div class="item_feedback">
                <figure class="thum_feedback">
                    <img src="<?php echo get_template_directory_uri() ?>/public/images/feedback/9.jpg" class="thumb" alt="Feedback" />
                </figure>
            </div>
        </div>
    </section>
</div>
<?php
get_footer();
?>