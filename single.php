<?php
/*
 * Template Name: Chi tiết bài viết
 * Template Post Type: post, page, product
 * @package WordPress
 */
?>
<?php get_header(); ?>
<div class="warap">
    <section class="main_content single">
    <?php the_breadcrumb();?>
        <div class="container">
        <?php echo get_post_format();?>
					<?php if(have_posts()): while ( have_posts() ) : the_post(); ?>
						<?php  get_template_part( 'content', get_post_format());?>
						<div class="navigation"><p><?php posts_nav_link(); ?></p></div>
						<?php setpostview( get_the_ID());?>
					<?php endwhile?>
				<?php else:?>
					<?php  get_template_part( 'content', 'none');?>
				<?php endif; ?>
        </div>
    </section>
</div>
<?php get_footer();?>