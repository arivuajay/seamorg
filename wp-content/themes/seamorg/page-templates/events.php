<?php
/**
 * Template Name: Event Template
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
get_header();
?>
<div class="body-cont inner-cont">
    <div class="inner-searchcont">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="searchbg searchbg2">
                        <?php
                        $args = em_get_search_form_defaults($args);
                        em_locate_template('templates/events-search.php', true, array('args' => $args));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php get_footer();