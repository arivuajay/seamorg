<?php
/**
 * Template Name: Home Page
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
get_header();
?>
<div class="slider">
    <?php putRevSlider("homepage-slider") ?>
</div>
<div class="body-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                <div class="searchbg">
                    <?php
                    $args = em_get_search_form_defaults($args);
                    em_locate_template('templates/locations-search.php', true, array('args' => $args));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div></div>
</div>
<div class="upcoming-event">
    <div class="container">
        <div class="row">
            <?php
            if (class_exists('EM_Events')) {
                $format_header = '<div class="col-xs-12 col-sm-12 col-md-12 upcoming-event-heading"><h2> Up Coming Events </h2><span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras iaculis ex id est tincidunt dictum. </span></div>';
                $format_footer = '<div class="viewall-cont"><a href="' . get_permalink(76) . '"> View all</a></div>';

                $format = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="event-cont">
                    <div class="event-img">
                        <div class="eventplace-details"><img src="' . get_template_directory_uri() . '/images/map-icon.png" alt="#_LOCATIONNAME" />&nbsp; #_LOCATIONNAME</div>
                        <a href="#_LOCATIONURL" title="#_LOCATIONNAME">#_LOCATIONIMAGE{360,230}</a>
                    </div>
                    <div class="eventplace-details-txt">
                        <div class="event-name">
                            <h2><a href="#_LOCATIONURL">#_LOCATIONNAME</a></h2>
                            <span>#_EVENTSTARTDATE</span>
                        </div>
                    </div>
                </div>
            </div>';

                $args = array(
                    'post_type' => EM_POST_TYPE_EVENT,
                    'posts_per_page' => 10,
                    'meta_query' => array('key' => '_start_ts', 'value' => current_time('timestamp'), 'compare' => '>=', 'type' => 'numeric'),
                    'orderby' => 'meta_value_num',
                    'order' => 'ASC',
                    'meta_key' => '_start_ts',
                    'meta_value' => current_time('timestamp'),
                    'meta_value_num' => current_time('timestamp'),
                    'meta_compare' => '>='
                );

                // The Query
                $query = new WP_Query($args);
                echo $format_header;
                if ($query->have_posts()) {
                    // The Loop
                    $upcoming_hikes = array();
                    while ($query->have_posts()):
                        $query->next_post();
                        $event = new EM_Event($query->post);
                        if (!in_array($event->location_id, $upcoming_hikes)) {
                            echo $event->output($format);
                        }
                        $upcoming_hikes[] = $event->location_id;
                    endwhile;
                    // Reset Post Data
                    wp_reset_postdata();
                    echo $format_footer;
                } else {
                    echo '<div class="viewall-cont"><a href="javascript:void(0);"> No upcoming events</a></div>';
                }

//        echo EM_Events::output(array('scope'=>'future', 'order_by'=>'start_date','limit' => 3, 'format' => $format, 'format_header' =>$format_header, 'format_footer' => $format_footer));
            }
            ?>

        </div>
    </div>
</div>
</div>
<div class="upcoming-event">
    <div class="container">
        <div class="row">

            <?php
            if (class_exists('EM_Locations')) {
                $format_header = '<div class="col-xs-12 col-sm-12 col-md-12 upcoming-event-heading upcoming-event-heading2"><h2> Popular Events</h2><span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras iaculis ex id est tincidunt dictum. </span></div>';
                $format_footer = '<div class="viewall-cont"><a href="' . get_permalink(76) . '"> View all</a></div>';

                $format = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="event-cont">
                    <div class="event-img">
                        <div class="eventplace-details"><img src="' . get_template_directory_uri() . '/images/map-icon.png" alt="#_LOCATIONNAME" />&nbsp; #_LOCATIONNAME</div>
                        <a href="#_LOCATIONURL" title="#_LOCATIONNAME">#_LOCATIONIMAGE{360,230}</a>
                    </div>
                    <div class="eventplace-details-txt">
                        <div class="event-name">
                            <h2><a href="#_LOCATIONURL">#_LOCATIONNAME</a></h2>
                        </div>
                    </div>
                </div>
            </div>';

                $args = array(
                    'post_type' => EM_POST_TYPE_LOCATION,
                    'posts_per_page' => 3,
                    'orderby' => 'post_modified',
                    'order' => 'DESC',
                    'meta_key' => '_is_ns_featured_post',
                    'meta_value' => 'yes',
                );
                // The Query
                $query = new WP_Query($args);
                echo $format_header;
                if ($query->have_posts()) {
                    // The Loop
                    while ($query->have_posts()):
                        $query->next_post();
                        $event = new EM_Location($query->post);
                        echo $event->output($format);
                    endwhile;
                    // Reset Post Data
                    wp_reset_postdata();
                    echo $format_footer;
                }else {
                    echo '<div class="viewall-cont"><a href="javascript:void(0);"> No popular events</a></div>';
                }
//                echo EM_Events::output(array('scope' => 'future', 'order_by' => 'start_date', 'limit' => 3, 'format' => $format, 'format_header' => $format_header, 'format_footer' => $format_footer));
            }
            ?>
        </div>
    </div>
</div>
<div class="video-slider">
    <img src="<?php bloginfo('template_url'); ?>/images/video-banerr.jpg"  alt="">
    <?php // putRevSlider("video_slider") ?>
</div>
<div class="testimonsil-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2> Client Testimonials </h2>
<!--                <p> <img src="<?php echo get_bloginfo('template_directory'); ?>/images/clinet1.jpg"  alt=""></p>
                -->                 <?php dynamic_sidebar('testimonial-area'); // Displays rotating testimonials or statically     ?>
                <p class="readmore-cont"> <a href="#" class="readmore">Read more</a></p>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
