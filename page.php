<?php

/**
 * Template Name: Page Polici
 * @package WordPress
 * @subpackage HeroZuzu
 * @since HeroZuzu
 */
get_header(); ?>
<div class="warap">
<?php the_breadcrumb(); ?>
    <div class="container">
        <article class="pagesty main_article">
            <?php while (have_posts()) : the_post(); ?>
                <div class="main_title_header">
                    <?php echo get_the_title() ?>
                </div>
                <div class="box_content_article">
                    <?php the_content(); ?>
                </div>
        </article>
    </div>

<?php endwhile;  ?>
</div>
<?php get_footer(); ?>