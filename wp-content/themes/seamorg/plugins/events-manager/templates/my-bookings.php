<?php do_action('em_template_my_bookings_header'); ?>
<?php
global $wpdb, $current_user, $EM_Notices, $EM_Person;
if (is_user_logged_in()):
    $EM_Person = new EM_Person(get_current_user_id());
    $EM_Bookings = $EM_Person->get_bookings();
    $bookings_count = count($EM_Bookings->bookings);
    if ($bookings_count > 0) {
        //Get events here in one query to speed things up
        $event_ids = array();
        foreach ($EM_Bookings as $EM_Booking) {
            $event_ids[] = $EM_Booking->event_id;
        }
    }
    $limit = (!empty($_GET['limit']) ) ? $_GET['limit'] : 20; //Default limit
    $page = (!empty($_GET['pno']) ) ? $_GET['pno'] : 1;
    $offset = ( $page > 1 ) ? ($page - 1) * $limit : 0;
    echo $EM_Notices;
    ?>
    <div class='em-my-bookings'>
        <?php if ($bookings_count >= $limit) : ?>
            <div class='tablenav'>
                <?php
                if ($bookings_count >= $limit) {
                    $link = em_add_get_params($_SERVER['REQUEST_URI'], array('pno' => '%PAGE%'), false); //don't html encode, so em_paginate does its thing
                    $bookings_nav = em_paginate($link, $bookings_count, $limit, $page);
                    echo $bookings_nav;
                }
                ?>
                <div class="clear"></div>
            </div>
        <?php endif; ?>
        <div class="clear"></div>
        <div class='row'>
            <?php if ($bookings_count > 0): ?>
                <?php
                $rowno = 0;
                $event_count = 0;
                $nonce = wp_create_nonce('booking_cancel');
                foreach ($EM_Bookings as $EM_Booking) {
                    /* @var $EM_Booking EM_Booking */
                    $EM_Event = $EM_Booking->get_event();
                    $localised_start_date = date_i18n(get_option('dbem_date_format'), $EM_Event->start);

                    if (($rowno < $limit || empty($limit)) && ($event_count >= $offset || $offset === 0)) {
                        $rowno++;
                        ?>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 booking-grid">
                            <div class="event-cont">
                                <div class="event-img">
                                    <div class="eventplace-details">
                                    <div class="event-detailname">
                                        <i class="fa fa-user-plus"></i> &nbsp;<?php echo ucwords($EM_Event->get_contact()->user_firstname." ".$EM_Event->get_contact()->user_lastname); ?>
                                        <!--<img src="<?php // echo get_template_directory_uri(); ?>/images/map-icon.png"  alt=""> <?php // echo esc_html($EM_Event->get_location()->location_name); ?>-->
                                    </div>
                                        <span>  <i class="fa fa-user"></i>
                                            <?php echo $EM_Booking->get_spaces() ?></span></div>
                                    <?php if ($EM_Event->get_location()->get_image_url() != '') : ?>
                                        <img src='<?php echo $EM_Event->get_location()->get_image_url('grid-3-thumbnails'); ?>' alt='<?php echo $EM_Event->event_name ?>'/>
                                    <?php endif; ?>
                                </div>
                                <div class="eventplace-details-txt">
                                    <div class="event-name">
                                        <h2>
                                            <a title="Kodaikanal" href="<?php echo $EM_Event->get_location()->get_permalink(); ?>">
                                                <?php echo esc_html($EM_Event->event_name); ?>
                                            </a>
                                        </h2>
                                        <span><?php echo $localised_start_date; ?></span>
                                    </div>
                                    <div class="buyticket">
                                        <?php
                                        $cf7_db_cls = new CF7DBPlugin();
                                        $cf7_db_tbl_name = $cf7_db_cls->getSubmitsTableName();
                                        $current_user_id = get_current_user_id();

            $sql = "SELECT COUNT(*) FROM " . $cf7_db_tbl_name . " AS a WHERE submit_time = (SELECT  `submit_time` FROM " . $cf7_db_tbl_name . " AS b WHERE form_name = 'Feedback' AND field_name = 'bookinguserid' AND field_value = '".$current_user_id."' AND a.submit_time = b.submit_time) AND `field_name` = 'bookingid' AND `field_value` = '{$EM_Booking->booking_id}'";
            $feedback_state =  $wpdb->get_var($sql);
                                        if($feedback_state == 0 && current_time( 'timestamp', 0 ) > $EM_Event->end): ?>

                                        <a class="row-title" href="<?php echo esc_url(add_query_arg('id', $EM_Booking->booking_id, get_permalink('451'))); ?>">Feedback</a>
                                        <?php endif; ?>
                                        <?php
                                        $cancel_link = '';
                                        if (!in_array($EM_Booking->booking_status, array(2, 3)) && get_option('dbem_bookings_user_cancellation') && $EM_Event->get_bookings()->has_open_time()) {
                                            $cancel_url = em_add_get_params($_SERVER['REQUEST_URI'], array('action' => 'booking_cancel', 'booking_id' => $EM_Booking->booking_id, '_wpnonce' => $nonce));
                                            $cancel_link = '<a class="row-title em-bookings-cancel" href="' . $cancel_url . '" onclick="if( !confirm(EM.booking_warning_cancel) ){ return false; }"> <i class="fa fa-close"></i> ' . __('Cancel', 'dbem') . '</a>';
                                        }
                                        echo apply_filters('em_my_bookings_booking_actions', $cancel_link, $EM_Booking);
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    do_action('em_my_bookings_booking_loop', $EM_Booking);
                    $event_count++;
                }
                ?>

            <?php else: ?>
                <?php _e('You do not have any bookings.', 'dbem'); ?>
            <?php endif; ?>
        </div>
        <?php if (!empty($bookings_nav) && $bookings_count >= $limit) : ?>
            <div class='tablenav'>
                <?php echo $bookings_nav; ?>
                <div class="clear"></div>
            </div>
        <?php endif; ?>
    </div>
    <?php do_action('em_template_my_bookings_footer', $EM_Bookings); ?>
<?php else: ?>
    <p><?php echo sprintf(__('Please <a href="%s">Log In</a> to view your bookings.', 'dbem'), site_url('wp-login.php?redirect_to=' . urlencode(get_permalink()), 'login')) ?></p>
<?php endif; ?>