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

$date_format = ( get_option('dbem_date_format') ) ? get_option('dbem_date_format') : get_option('date_format');
$hours_format = em_get_hour_format();
?>
<div class=" col-xs-12 col-sm-7 col-md-7 col-lg-7 inner-content">
    <div class="cart-cont card-cont">
        <div class="cart-heading card-heading">Feedback</div>
        <div class="cart-content card-details">
            <div class="row">
                <?php echo do_shortcode('[contact-form-7 id="450" title="Feedback"]'); ?>
            </div>
        </div>
    </div>
</div>
<div class=" col-xs-12 col-sm-5 col-md-5 col-lg-5">
    <div class="cart-cont">
        <div class="cart-heading summry-heading">Event Summary</div>
        <div class="cart-content user-details">
            <p><span>Event name : </span><?php echo $EM_Event->event_name ?></p>
            <p><span>Date :     </span><?php echo date_i18n($date_format, $EM_Event->start); ?></p>
            <p><span>Time :</span><?php echo date( $hours_format, $EM_Event->start )."-".date( $hours_format, $EM_Event->end ); ?> </p>
            <p><span>Location :  </span><?php echo $EM_Event->get_location()->location_name; ?> </p>
            <p><span>Trip Details :</span><?php echo substr($EM_Event->post_content, 0, 200); ?>...</p>
            <p><span>Space :</span><?php echo $EM_Booking->booking_spaces; ?> </p>
        </div>
    </div>
</div>