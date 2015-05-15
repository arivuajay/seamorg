<?php
/**
 * Template Name: Home Page
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */

get_header(); ?>
<div class="slider">
    <?php putRevSlider( "homepage-slider" ) ?>
    <!--<img src="<?php echo get_bloginfo('template_directory');?>/images/slider.jpg"  alt="">-->
</div>
            <div class="body-cont">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1">
                            <div class="searchbg">
                                <input name="" type="text" class="searchfield1" value="Where do you want to go ?">
                                <input name="" type="text" class="searchfield1 searchfield2" value="Date">
                                <select name="" class="searchfield1 searchfield3">
                                    <option value="Select Place">Select Place</option>
                                </select>
                                <input name="" type="button" class="search-btn" value="search">
                                <input name="" type="button" class="search-btn search-btn2" value="Advanced Search">
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
                            <h2> Up Coming Events </h2>
                            <span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras iaculis ex id est tincidunt dictum. </span>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="event-cont">
                                <div class="event-img">
                                    <div class="eventplace-details"> <img src="<?php echo get_bloginfo('template_directory');?>/images/map-icon.png"  alt=""> London <span> $65</span></div>
                                    <img src="<?php echo get_bloginfo('template_directory');?>/images/event-thumb1.jpg"  alt="">
                                </div>
                                <div class="eventplace-details-txt">
                                    <div class="event-name">
                                        <h2>Hiking in autumn</h2>
                                        <span> 14 May 2016 </span>
                                    </div>
                                    <div class="buyticket"><a href="#">
                                            Buy Ticket
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="event-cont">
                                <div class="event-img">
                                    <div class="eventplace-details"> <img src="<?php echo get_bloginfo('template_directory');?>/images/map-icon.png"  alt=""> London <span> $65</span></div>
                                    <img src="<?php echo get_bloginfo('template_directory');?>/images/event-thumb1.jpg"  alt="">
                                </div>
                                <div class="eventplace-details-txt">
                                    <div class="event-name">
                                        <h2>Hiking in autumn</h2>
                                        <span> 14 May 2016 </span>
                                    </div>
                                    <div class="buyticket"><a href="#">
                                            Buy Ticket
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="event-cont">
                                <div class="event-img">
                                    <div class="eventplace-details"> <img src="<?php echo get_bloginfo('template_directory');?>/images/map-icon.png"  alt=""> London <span> $65</span></div>
                                    <img src="<?php echo get_bloginfo('template_directory');?>/images/event-thumb1.jpg"  alt="">
                                </div>
                                <div class="eventplace-details-txt">
                                    <div class="event-name">
                                        <h2>Hiking in autumn</h2>
                                        <span> 14 May 2016 </span>
                                    </div>
                                    <div class="buyticket"><a href="#">
                                            Buy Ticket
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="viewall-cont">
                            <a href="#"> View all</a></div>
                    </div>
                </div>
            </div>
            <div class="upcoming-event">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 upcoming-event-heading upcoming-event-heading2">
                            <h2> Popular Events</h2>
                            <span> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras iaculis ex id est tincidunt dictum. </span>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="event-cont">
                                <div class="event-img">
                                    <div class="eventplace-details"> <img src="<?php echo get_bloginfo('template_directory');?>/images/map-icon.png"  alt=""> London <span> $65</span></div>
                                    <img src="<?php echo get_bloginfo('template_directory');?>/images/event-thumb1.jpg"  alt="">
                                </div>
                                <div class="eventplace-details-txt">
                                    <div class="event-name">
                                        <h2>Hiking in autumn</h2>
                                        <span> 14 May 2016 </span>
                                    </div>
                                    <div class="buyticket buyticket2"><a href="#">
                                            Buy Ticket
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="event-cont">
                                <div class="event-img">
                                    <div class="eventplace-details"> <img src="<?php echo get_bloginfo('template_directory');?>/images/map-icon.png"  alt=""> London <span> $65</span></div>
                                    <img src="<?php echo get_bloginfo('template_directory');?>/images/event-thumb1.jpg"  alt="">
                                </div>
                                <div class="eventplace-details-txt">
                                    <div class="event-name">
                                        <h2>Hiking in autumn</h2>
                                        <span> 14 May 2016 </span>
                                    </div>
                                    <div class="buyticket buyticket2"><a href="#">
                                            Buy Ticket
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="event-cont">
                                <div class="event-img">
                                    <div class="eventplace-details"> <img src="<?php echo get_bloginfo('template_directory');?>/images/map-icon.png"  alt=""> London <span> $65</span></div>
                                    <img src="<?php echo get_bloginfo('template_directory');?>/images/event-thumb1.jpg"  alt="">
                                </div>
                                <div class="eventplace-details-txt">
                                    <div class="event-name">
                                        <h2>Hiking in autumn</h2>
                                        <span> 14 May 2016 </span>
                                    </div>
                                    <div class="buyticket buyticket2"><a href="#">
                                            Buy Ticket
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="viewall-cont">
                            <a href="#"> View all</a></div>
                    </div>
                </div>
            </div>
            <div class="video-slider"><img src="<?php echo get_bloginfo('template_directory');?>/images/video-banerr.jpg"  alt=""> </div>
            <div class="testimonsil-cont">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h2> Client Testimonials </h2>
                            <p> <img src="<?php echo get_bloginfo('template_directory');?>/images/clinet1.jpg"  alt=""></p>
                            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-lg-offset-1"> <p>Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica,
                                    quam nunc putamus parum claram,anteposuerit litterarum formas humanitatis per seacula .</p></div>
                            <p class="readmore-cont"> <a href="#" class="readmore">Read more</a></p>
                        </div>
                    </div>
                </div>
            </div>

<?php
get_footer();
