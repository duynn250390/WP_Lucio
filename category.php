<?php

/**
 * Template Name: Category Default
 * @package WordPress
 * @subpackage nnDuy
 * @since News_nnDuy
 */

get_header(); ?>
<div class="warap">
    <section class="main_content single">
        <?php the_breadcrumb(); ?>
        <div class="container">
            <?php
            $args = array(
                'post_type' => 'post_product',
                'order'    => 'DESC',
                'showposts' => 25,
            );
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
                    $post_id = $post->ID;
                    ?>
                    <article class="list_item_post content_home">
                        <?php echo $post_id;?>
                    </article><!-- list_item_post -->
                <?php endwhile;
                else : ?>
                <p>Không có tin nào !</p>
            <?php endif;
            wp_reset_postdata(); ?>
        </div>
    </section>
</div>
<?php get_footer(); ?>