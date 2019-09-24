<?php

/**
 * Template Name: Category Product
 * @package WordPress
 * @subpackage nnDuy
 * @since News_nnDuy
 */

get_header(); ?>
<div class="warap">
    <section class="main_content single">
        <!-- <?php the_breadcrumb(); ?> -->
        <nav class="breadcrumb">
            <a href="<?php echo get_home_url(); ?>">Trang chủ</a>
            <span><?php single_cat_title(); ?></span>
        </nav>
        <div class="container">
            <div class="container_box_list">
                <?php
                $category = get_the_category();
                the_category_ID();
                var_dump($category);
                echo $category[0]->cat_ID;
                $args = array(
                    'post_type' => 'post_product',
                    'order'    => 'DESC',
                    'showposts' => 25,
                    'cat' => 1,
                );
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                        $post_id = $post->ID;
                        ?>
                        <article class="list_item_post content_home">
                            <figure class="thumb_post">
                                <a href="<?php echo the_permalink(); ?>">
                                    <img src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>" alt="<?php echo $post->post_title; ?>" />
                                </a>
                            </figure>
                            <div class="description_fashion">
                                <h3 class="title"><?php echo $post->post_title; ?></h3>
                                <div class="money">
                                    <?php
                                            $gia_tien =  get_post_meta(get_the_ID(), '_gia_tien', TRUE);
                                            echo  $gia_tien;
                                            ?>
                                    VND
                                </div>
                            </div>
                        </article><!-- list_item_post -->
                    <?php endwhile;
                    else : ?>
                    <p>Không có tin nào !</p>
                <?php endif;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
</div>
<?php get_footer(); ?>