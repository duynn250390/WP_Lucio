<?php

/**
 * Template Name: Single Product
 * Template Post Type: post_product
 * @package WordPress
 * @subpackage nnDuy
 * @since News_nnDuy
 */

get_header(); ?>
<div class="warap">
	<?php echo get_post_format(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php get_template_part('content', 'post_product'); ?>
			<div class="navigation">
				<p><?php posts_nav_link(); ?></p>
			</div>
			<?php setpostview(get_the_ID()); ?>
		<?php endwhile ?>
	<?php else : ?>
		<?php get_template_part('content', 'none'); ?>
	<?php endif; ?>
	</section>
	<?php get_footer(); ?>