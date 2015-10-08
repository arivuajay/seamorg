<?php
/**
 * Template Name: Cart Page
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
get_header();
?>
<div class="body-cont inner-cont ">
    <div class="container">
        <div class="row">
                <?php
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
                ?>
        </div>
    </div>
</div>
<?php
get_footer();
