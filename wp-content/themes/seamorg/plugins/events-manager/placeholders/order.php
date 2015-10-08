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
/* @var $EM_Booking EM_Booking */
global $EM_Notices;

$booked_space = $EM_Booking->booking_spaces;
$date_format = ( get_option('dbem_date_format') ) ? get_option('dbem_date_format') : get_option('date_format');
?>
<?php if ($EM_Booking->booking_id): ?>
   <!--   <div class=" col-xs-12 col-sm-7 col-md-7 col-lg-7 inner-content">
        <div class="cart-cont">
            <div class="cart-heading">User Details</div>
            <div class="cart-content user-details">
                <p> <span>First Name  : </span> <?php echo $EM_Booking->person->user_firstname ?> </p>
                <p><span>Last Name : </span> <?php echo $EM_Booking->person->user_lastname ?></p>
                <p><span>Email  :    </span> <?php echo $EM_Booking->person->user_email ?> </p>
                      <div class="cart-total2">
                            <div class="row">
                                <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <button class="bookit"><?php // echo $EM_Booking->get_status(); ?></button>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>-->
    <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php echo $EM_Notices; ?>

        <div class="cart-cont">
            <div class="cart-heading summry-heading">Booking Details</div>
            <div class="cart-content user-details">
                <p><span>Event name : </span><?php echo $EM_Booking->get_event()->event_name ?></p>
                <p><span>Date :     </span><?php echo date_i18n($date_format, $EM_Booking->get_event()->start); ?></p>
                <p><span>Location :  </span><?php echo $EM_Booking->get_event()->get_location()->location_name; ?> </p>
                <p><span>Trip Details :</span><?php echo substr($EM_Booking->get_event()->post_content, 0, 200); ?>...</p>
                <p><span>Space :</span><?php echo $booked_space; ?> </p>
                <div class="cart-total2">
                    <div class="row">
                        <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">  Total :<?php echo $EM_Booking->get_price(true); ?> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>