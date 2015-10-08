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
                $format_header = '<div class="col-xs-12 col-sm-12 col-md-12 upcoming-event-heading"><h2> Up Coming Events </h2></div>';
                $format_footer = '<div class="viewall-cont"><a href="' . get_permalink(76) . '"> View all</a></div>';

                $format = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="event-cont">
                    <div class="event-img">
                        <a href="#_LOCATIONURL?predate=#_EVENTDATE" title="#_LOCATIONNAME">#_LOCATIONIMAGE{360,230}</a>
                    </div>
                    <div class="eventplace-details-txt">
                        <div class="event-name full">
                            <h2><a href="#_LOCATIONURL?predate=#_EVENTDATE">#_LOCATIONNAME</a></h2>
                            <span>#_EVENTSTARTDATE</span>
                        </div>
                    </div>
                </div>
            </div>';

                $args = array(
                    'post_type' => EM_POST_TYPE_EVENT,
                    'posts_per_page' => 50,
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
                $i = 0;
                if ($query->have_posts()) {
                    // The Loop
                    $upcoming_hikes = array();
                    while ($i < 9 && $query->have_posts()):
                        $query->next_post();

                        $event = new EM_Event($query->post);
                        if ($event->get_location()->post_status == 'publish' && !in_array($event->location_id, $upcoming_hikes) && $event->get_bookings()->get_available_spaces() > 0 ) {
                            echo $event->output($format);
                            $i++;
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
                $format_header = '<div class="col-xs-12 col-sm-12 col-md-12 upcoming-event-heading upcoming-event-heading2"><h2> Popular Events</h2></div>';
                $format_footer = '<div class="viewall-cont"><a href="' . get_permalink(76) . '"> View all</a></div>';

                $format = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="event-cont">
                    <div class="event-img">
                        <a href="#_LOCATIONURL" title="#_LOCATIONNAME">#_LOCATIONIMAGE{360,230}</a>
                    </div>
                    <div class="eventplace-details-txt">
                        <div class="event-name full">
                            <h2><a href="#_LOCATIONURL">#_LOCATIONNAME</a></h2>
                        </div>
                    </div>
                </div>
            </div>';

                $args = array(
                    'post_type' => EM_POST_TYPE_LOCATION,
                    'post_status' => 'publish',
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
                    $i = 0;
                    while ($i < 3 && $query->have_posts()):
                        $query->next_post();
                        $event = new EM_Location($query->post);
                        echo $event->output($format);
                        $i++;
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
    <?php
    $video_post = 443; //This is page id or post id
    $content_post = get_post($video_post);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    echo $content;
    ?>
</div>
<div class="testimonsil-cont ">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!--<h2> Client Testimonials </h2>-->
                <?php // dynamic_sidebar('testimonial-area'); ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
