<?php
/**
 * Template Name: Sign in/up Page
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
get_header();
?>

<div class="body-cont inner-cont guide-signup">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-## -->
        <?php endwhile; ?>
    </div>
</div>
<?php
get_footer();
