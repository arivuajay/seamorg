<?php
/**
 * Template Name: Contact Us Page
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
get_header();
?>
<div class="body-cont inner-cont">
    <div class="container">
        <div class="row">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-content">
                        <?php the_title('<div class="col-xs-12 col-sm-12 col-md-12 inner-heading ">', '</div>'); ?>
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
                </article><!-- #post-## -->
            <?php endwhile; ?>
        </div>
    </div>
</div>
<?php
get_footer();