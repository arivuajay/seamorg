<?php
/*
 * This is where the booking form is generated.
 * For non-advanced users, It's SERIOUSLY NOT recommended you edit this form directly if avoidable, as you can change booking form settings in various less obtrusive and upgrade-safe ways:
 * - check your booking form options panel in the Booking Options tab in your settings.
 * - use CSS or jQuery to change the look of your booking forms
 * - edit the files in the forms/bookingform folder individually instead of this file, to make it more upgrade-safe
 * - hook into WP action/filters below to modify/generate information
 * Again, even if you're an advanced user, consider NOT editing this form and using other methods instead.
 */
/* @var $EM_Event EM_Event */
global $EM_Notices;
//count tickets and available tickets
$tickets_count = count($EM_Event->get_bookings()->get_tickets()->tickets);
$available_tickets_count = count($EM_Event->get_bookings()->get_available_tickets());
//decide whether user can book, event is open for bookings etc.
$can_book = is_user_logged_in() || (get_option('dbem_bookings_anonymous') && !is_user_logged_in());
$is_open = $EM_Event->get_bookings()->is_open(); //whether there are any available tickets right now
$show_tickets = true;
//if user is logged out, check for member tickets that might be available, since we should ask them to log in instead of saying 'bookings closed'
if (!$is_open && !is_user_logged_in() && $EM_Event->get_bookings()->is_open(true)) {
    $is_open = true;
    $can_book = false;
    $show_tickets = get_option('dbem_bookings_tickets_show_unavailable') && get_option('dbem_bookings_tickets_show_member_tickets');
}
if (!$can_book):
    $redir_url = get_permalink(104) . "?redirect_to=" . urlencode(get_permalink(343) . "?id=" . $EM_Event->ID);
    wp_redirect($redir_url);
    exit;
endif;

global $current_user;
get_currentuserinfo();
$date_format = ( get_option('dbem_date_format') ) ? get_option('dbem_date_format') : get_option('date_format');

$space = (isset($_REQUEST['space'])) ? $_REQUEST['space'] : 1;


// We are firstly checking if the user has already booked a ticket at this event, if so offer a link to view their bookings.
$EM_Booking = $EM_Event->get_bookings()->has_booking();
?>
<?php if (is_object($EM_Booking) && !get_option('dbem_bookings_double')): //Double bookings not allowed    ?>
    <p>
        <?php echo get_option('dbem_bookings_form_msg_attending'); ?>
        <a href="<?php echo em_get_my_bookings_url(); ?>"><?php echo get_option('dbem_bookings_form_msg_bookings_link'); ?></a>
    </p>
<?php elseif (!$EM_Event->event_rsvp): //bookings not enabled  ?>
    <p><?php echo get_option('dbem_bookings_form_msg_disabled'); ?></p>
<?php elseif ($EM_Event->get_bookings()->get_available_spaces() <= 0): ?>
    <p><?php echo get_option('dbem_bookings_form_msg_full'); ?></p>
<?php elseif (!$is_open): //event has started  ?>
    <p><?php echo get_option('dbem_bookings_form_msg_closed'); ?></p>
<?php else: ?>
    <?php echo $EM_Notices; ?>
    <?php if ($tickets_count > 0) : ?>
        <?php //Tickets exist, so we show a booking form. ?>
        <div class=" col-xs-12 col-sm-7 col-md-7 col-lg-7 inner-content">
<!--            <div class="cart-cont">
                <div class="cart-heading">User Details</div>
                <div class="cart-content user-details">
                    <p> <span>First Name  : </span> <?php // echo $current_user->user_firstname ?> </p>
                    <p><span>Last Name : </span> <?php // echo $current_user->user_lastname ?></p>
                    <p><span>Email  :    </span> <?php // echo $current_user->user_email ?> </p>
                </div>
            </div>-->
            <div class="cart-cont card-cont">
                <div class="cart-heading card-heading">Card Details</div>
                <div class="cart-content card-details">
                    <div class="row">
                        <div class=" col-xs-12 col-sm-12 col-md-6 col-lg-6"> <h2> Debit/Credit Card Details  </h2> </div>
                        <div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6 cardimg"> <img src="<?php echo get_template_directory_uri() ?>/images/card-img.png"  alt=""></div>
                        <div class="clearfix"></div>
                        <form class="em-booking-form" name='booking-form' method='post' action='<?php echo apply_filters('em_booking_form_action_url', ''); ?>#em-booking'>
                            <?php
                            $EM_Ticket = $EM_Event->get_bookings()->get_available_tickets()->get_first();
                            ?>
                            <input type='hidden' name='action' value='booking_add'/>
                            <input type='hidden' name='event_id' value='<?php echo $EM_Event->event_id; ?>'/>
                            <input type='hidden' name='_wpnonce' value='<?php echo wp_create_nonce('booking_add'); ?>'/>
                            <input type="hidden" name="em_tickets[<?php echo $EM_Ticket->ticket_id ?>][spaces]" value="<?php echo $space; ?>" class="em-ticket-select" />
                            <?php if ($can_book): ?>
                                <div class='em-booking-form-details'>
                                    <?php
                                    if ($show_tickets && $available_tickets_count == 1 && !get_option('dbem_bookings_tickets_single_form')) {
                                        do_action('em_booking_form_before_tickets', $EM_Event); //do not delete
                                        //show single ticket form, only necessary to show to users able to book (or guests if enabled)
//                                        em_locate_template('forms/bookingform/ticket-single.php', true, array('EM_Event' => $EM_Event, 'EM_Ticket' => $EM_Ticket));
                                        do_action('em_booking_form_after_tickets', $EM_Event); //do not delete
                                    }
                                    ?>
                                    <?php
                                    do_action('em_booking_form_before_user_details', $EM_Event);
                                    if (has_action('em_booking_form_custom')) {
                                        //Pro Custom Booking Form. You can create your own custom form by hooking into this action and setting the option above to true
                                        do_action('em_booking_form_custom', $EM_Event); //do not delete
                                    } else {
                                        //If you just want to modify booking form fields, you could do so here
                                        em_locate_template('forms/bookingform/booking-fields.php', true, array('EM_Event' => $EM_Event));
                                    }
                                    do_action('em_booking_form_after_user_details', $EM_Event);
                                    ?>
                                    <?php do_action('em_booking_form_footer', $EM_Event); //do not delete   ?>
                                    <div class="em-booking-buttons col-xs-12 col-sm-5 col-md-6 col-lg-6 card-filed">
                                        <?php if (preg_match('/https?:\/\//', get_option('dbem_bookings_submit_button'))): //Settings have an image url (we assume). Use it here as the button.   ?>
                                            <input type="image" src="<?php echo get_option('dbem_bookings_submit_button'); ?>" class="em-booking-submit" id="em-booking-submit" />
                                        <?php else: //Display normal submit button    ?>
                                            <input type="submit" class="bookit" id="em-booking-submit" value="<?php echo esc_attr(get_option('dbem_bookings_submit_button')); ?>" />
                                        <?php endif; ?>
                                    </div>
                                    <?php do_action('em_booking_form_footer_after_buttons', $EM_Event); //do not delete    ?>
                                </div>
                            <?php endif; ?>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class=" col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <div class="cart-cont">
                <div class="cart-heading summry-heading">Event Summary</div>
                <div class="cart-content user-details">
                    <p><span>  Event name : </span><?php echo $EM_Event->event_name ?></p>
                    <p><span>Date :     </span><?php echo date_i18n($date_format, $EM_Event->start); ?></p>
                    <p><span>Location :  </span><?php echo $EM_Event->get_location()->location_name; ?> </p>
                    <p><span>Trip Details :</span><?php echo substr($EM_Event->post_content, 0, 200); ?>...</p>
                    <p><span>Space :</span><?php echo $space; ?> </p>
                    <div class="cart-total2">
                        <div class="row">
                            <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">  Total :<?php echo em_get_currency_formatted($space * $EM_Ticket->get_price(false)); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>