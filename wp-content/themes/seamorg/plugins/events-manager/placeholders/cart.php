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
    $redir_url = get_permalink(104) . "?redirect_to=" . urlencode(get_permalink(367) . "?id=" . $EM_Event->ID);
//    var_dump($redir_url);
    wp_redirect($redir_url);
    exit;
endif;
?>
<div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12 inner-content">
    <div class="cart-cont">
        <div class="cart-heading"> Booking Details</div>
        <?php
        // We are firstly checking if the user has already booked a ticket at this event, if so offer a link to view their bookings.
        $EM_Booking = $EM_Event->get_bookings()->has_booking();
        ?>
        <?php if (is_object($EM_Booking) && !get_option('dbem_bookings_double')): //Double bookings not allowed ?>
            <p>
                <?php echo get_option('dbem_bookings_form_msg_attending'); ?>
                <a href="<?php echo em_get_my_bookings_url(); ?>"><?php echo get_option('dbem_bookings_form_msg_bookings_link'); ?></a>
            </p>
        <?php elseif (!$EM_Event->event_rsvp): //bookings not enabled ?>
            <p><?php echo get_option('dbem_bookings_form_msg_disabled'); ?></p>
        <?php elseif ($EM_Event->get_bookings()->get_available_spaces() <= 0): ?>
            <p><?php echo get_option('dbem_bookings_form_msg_full'); ?></p>
        <?php elseif (!$is_open): //event has started ?>
            <p><?php echo get_option('dbem_bookings_form_msg_closed'); ?></p>
        <?php else: ?>
            <?php echo $EM_Notices; ?>
            <?php
            if ($tickets_count > 0) :

                $date_format = ( get_option('dbem_date_format') ) ? get_option('dbem_date_format') : get_option('date_format');
                $time_format = ( get_option('dbem_time_format') ) ? get_option('dbem_time_format') : get_option('time_format');

                $imgsrc = esc_url($EM_Event->get_location()->get_image_url());

                $EM_Ticket = $EM_Event->get_bookings()->get_available_tickets()->get_first();
                $evt_price = $EM_Ticket->get_price(false);

                $default = !empty($_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces']) ? $_REQUEST['em_tickets'][$EM_Ticket->ticket_id]['spaces'] : 0;
                $spaces_options = $EM_Ticket->get_spaces_options(false, $default);
                ?>
                <div class="cart-content">
<!--                    <div class="cart-total">
                        <div class="row">
                            <div class=" col-xs-6 col-sm-6 col-md-6 col-lg-6">  Total :$<span class="sub-total">0.00</span> </div>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class=" col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <img src="<?php echo $imgsrc; ?>" />
                        </div>
                        <div class=" col-xs-12 col-sm-3 col-md-3 col-lg-3 cart-event-details">
                            <h2><?php echo $EM_Event->event_name ?> </h2>
                            <p><?php echo date_i18n($date_format, $EM_Event->start); ?> </p>
                            <p><?php echo date_i18n($time_format, $EM_Event->start)."-".date_i18n($time_format, $EM_Event->end); ?></p>
                            <h2><?php echo $ticket_price = em_get_currency_formatted($evt_price); ?></h2>
                        </div>
                        <div class=" col-xs-12 col-sm-3 col-md-3 col-lg-3 cart-event-details">
                            <h2> Spaces
                                <?php
                                if ($spaces_options) {
                                    echo $spaces_options;
                                    echo "<input type='hidden' id='single_ticket_price' value='$evt_price' />";
                                    echo "<input type='hidden' id='event_id' value='{$EM_Event->ID}' />";
                                } else {
                                    echo "<strong>" . __('N/A', 'dbem') . "</strong>";
                                }
                                ?>
                                x  <?php echo $ticket_price; ?> </h2>
                        </div>
                        <div class=" col-xs-12 col-sm-3 col-md-3 col-lg-3  remove">
                            <button class="continue-btn" id="go_checkout"> <i class="fa fa-shopping-cart"></i> Checkout  </button>
                        </div>
                    </div>
                    <div class="cart-total2">
                        <div class="row">
                            <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">  Total :$<span class="sub-total">0.00</span> </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>