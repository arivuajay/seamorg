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
    <!--<img src="<?php echo get_bloginfo('template_directory'); ?>/images/slider.jpg"  alt="">-->
</div>
<div class="body-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                <div class="searchbg">
                    <?php
                    $args = em_get_search_form_defaults($args);
                    em_locate_template('templates/events-search.php', true, array('args' => $args));
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
            <div class="col-xs-12 col-sm-12 col-md-12 upcoming-event-heading">

            <?php
            if (class_exists('EM_Events')) {
                $format_header = '<h2> Up Coming Events </h2><span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras iaculis ex id est tincidunt dictum. </span></div>';
                $format_footer = '<div class="viewall-cont"><a href="'.get_permalink(75).'"> View all</a></div>';

                $format = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="event-cont">
                    <div class="event-img">
                        <div class="eventplace-details">#_LOCATIONNAME <span> #_EVENTPRICERANGE</span></div>
                        #_EVENTIMAGE{360,230}
                    </div>
                    <div class="eventplace-details-txt">
                        <div class="event-name">
                            <h2>#_EVENTNAME</h2>
                            <span>#_EVENTDATES</span>
                        </div>
                        <div class="buyticket"><a href="#_EVENTURL">Book It</a></div>
                    </div>
                </div>
            </div>';
        echo EM_Events::output(array('scope'=>'future', 'order_by'=>'start_date','limit' => 3, 'format' => $format, 'format_header' =>$format_header, 'format_footer' => $format_footer));
            }
            ?>

        </div>
    </div>
</div>
<div class="upcoming-event">
    <div class="container">
        <div class="row">

            <?php
            if (class_exists('EM_Events')) {
                $format_header = '<div class="col-xs-12 col-sm-12 col-md-12 upcoming-event-heading upcoming-event-heading2"><h2> Popular Events</h2><span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras iaculis ex id est tincidunt dictum. </span></div>';
                $format_footer = '<div class="viewall-cont"><a href="'.get_permalink(75).'"> View all</a></div>';

                $format = '<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="event-cont">
                    <div class="event-img">
                        <div class="eventplace-details">#_LOCATIONNAME <span> #_EVENTPRICERANGE</span></div>
                        #_EVENTIMAGE{360,230}
                    </div>
                    <div class="eventplace-details-txt">
                        <div class="event-name">
                            <h2>#_EVENTNAME</h2>
                            <span>#_EVENTDATES</span>
                        </div>
                        <div class="buyticket"><a href="#_EVENTURL">Book It</a></div>
                    </div>
                </div>
            </div>';
        echo EM_Events::output(array('scope'=>'future', 'order_by'=>'start_date','limit' => 3, 'format' => $format, 'format_header' =>$format_header, 'format_footer' => $format_footer));
            }
            ?>
        </div>
    </div>
</div>
<div class="video-slider"><img src="<?php bloginfo('template_url'); ?>/images/video-banerr.jpg"  alt=""></div>
<div class="testimonsil-cont">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2> Client Testimonials </h2>
                <p> <img src="<?php echo get_bloginfo('template_directory'); ?>/images/clinet1.jpg"  alt=""></p>
                <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-lg-offset-1"> <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica,
                        quam nunc putamus parum claram,anteposuerit litterarum formas humanitatis per seacula .</p></div>
                <p class="readmore-cont"> <a href="#" class="readmore">Read more</a></p>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
