<?php
/* WARNING! This file may change in the near future as we intend to add features to the event editor. If at all possible, try making customizations using CSS, jQuery, or using our hooks and filters. - 2012-02-14 */
/*
 * To ensure compatability, it is recommended you maintain class, id and form name attributes, unless you now what you're doing.
 * You also must keep the _wpnonce hidden field in this form too.
 */
global $EM_Event, $EM_Notices, $bp;

//check that user can access this page
if (is_object($EM_Event) && !$EM_Event->can_manage('edit_events', 'edit_others_events')) {
    ?>
    <div class="wrap"><h2><?php esc_html_e('Unauthorized Access', 'dbem'); ?></h2><p><?php echo sprintf(__('You do not have the rights to manage this %s.', 'dbem'), __('Event', 'dbem')); ?></p></div>
    <?php
    return false;
} elseif (!is_object($EM_Event)) {
    $EM_Event = new EM_Event();
}
$required = apply_filters('em_required_html', '<i>*</i>');

echo $EM_Notices;
//Success notice
if (!empty($_REQUEST['success'])) {
    if (!get_option('dbem_events_form_reshow'))
        return false;
}
?>
<form enctype='multipart/form-data' id="event-form" method="post" action="<?php echo esc_url(add_query_arg(array('success' => null))); ?>">
    <div class="wrap">
        <?php do_action('em_front_event_form_header'); ?>
        <?php if (get_option('dbem_events_anonymous_submissions') && !is_user_logged_in()): ?>
            <h3 class="event-form-submitter"><?php esc_html_e('Your Details', 'dbem'); ?></h3>
            <div class="inside event-form-submitter">
                <p>
                    <label><?php esc_html_e('Name', 'dbem'); ?></label>
                    <input type="text" name="event_owner_name" id="event-owner-name" value="<?php echo esc_attr($EM_Event->event_owner_name); ?>" />
                </p>
                <p>
                    <label><?php esc_html_e('Email', 'dbem'); ?></label>
                    <input type="text" name="event_owner_email" id="event-owner-email" value="<?php echo esc_attr($EM_Event->event_owner_email); ?>" />
                </p>
                <?php do_action('em_font_event_form_guest'); ?>
            </div>
        <?php endif; ?>

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 create-event-part1">
                <?php if (get_option('dbem_locations_enabled')): ?>

                    <h3 class="event-form-where hidden"><?php esc_html_e('Where', 'dbem'); ?></h3>

                    <div class="inside event-form-where">
                        <?php em_locate_template('forms/event/location.php', true); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6 create-event-part2">


                <div class="row hidden">


                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <?php esc_html_e('Event Name', 'dbem'); ?>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="inside event-form-name">
                            <input type="text" name="event_name" id="event-name" value="<?php echo esc_attr($EM_Event->event_name, ENT_QUOTES); ?>" /><?php echo $required; ?>
                            <br />
                            <span class="help-block"> <?php esc_html_e('The event name. Example: Birthday party', 'dbem'); ?></span>
                            <?php em_locate_template('forms/event/group.php', true); ?>
                        </div>

                    </div>


                </div>



                <h3 class="event-form-when hidden"><?php esc_html_e('When', 'dbem'); ?></h3>
                <div class="inside event-form-when">
                    <?php
                    if (empty($EM_Event->event_id) && $EM_Event->can_manage('edit_recurring_events', 'edit_others_recurring_events') && get_option('dbem_recurrence_enabled')) {
                        em_locate_template('forms/event/when-with-recurring.php', true);
                    } elseif ($EM_Event->is_recurring()) {
                        em_locate_template('forms/event/recurring-when.php', true);
                    } else {
                        em_locate_template('forms/event/when.php', true);
                    }
                    $EM_Tickets = $EM_Event->get_tickets();
                    if (count($EM_Tickets->tickets) == 0) {
                        $EM_Tickets->tickets[] = new EM_Ticket();
                        $delete_temp_ticket = true;
                    }
                    $col_count = 1;
                    $EM_Ticket = $EM_Tickets->get_first();
                    ?>
                    <!--@j@y Price Field From Ticket Option-->
                    <div id="em-form-price" class="event-form-price">
                        <div class="row em-price-range">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <span class="em-event-text">Price </span>
                                <input type="text" name="em_tickets[<?php echo $col_count; ?>][ticket_price]" class="ticket_price" value="<?php echo esc_attr($EM_Ticket->get_price_precise()) ?>" />
                            </div>
                        </div>
                    </div>
                    <!--@j@y Price Field From Ticket Option-->
                    <?php em_locate_template('forms/event/bookings.php', true); ?>
                </div>
            </div>

        </div>

        <span class="event-form-details"><?php esc_html_e('Things to bring', 'dbem'); ?></span>
        <div class="inside event-ttb-details">
            <div class="event-editor">
                <?php to_bring_taxonomy($EM_Event->ID);  ?>
            </div>
        </div>

        <span class="event-form-details"><?php esc_html_e('Notes', 'dbem'); ?></span>
        <div class="inside event-form-details">
            <div class="event-editor">
                <?php if (get_option('dbem_events_form_editor') && function_exists('wp_editor')): ?>
                    <?php wp_editor($EM_Event->post_content, 'em-editor-content', array('textarea_name' => 'content')); ?>
                <?php else: ?>
                    <textarea name="content"><?php echo $EM_Event->post_content ?></textarea>

                    <?php //esc_html_e('Details about the event.', 'dbem') ?> <?php //esc_html_e('HTML allowed.', 'dbem') ?>
                <?php endif; ?>
            </div>
            <div class="event-extra-details">
                <?php
                if (get_option('dbem_attributes_enabled')) {
                    em_locate_template('forms/event/attributes-public.php', true);
                }
                ?>
                <?php
                if (get_option('dbem_categories_enabled')) {
                    em_locate_template('forms/event/categories-public.php', true);
                }
                ?>
            </div>
        </div>

        <?php if ($EM_Event->can_manage('upload_event_images', 'upload_event_images')): ?>
            <div class="event-image-list hidden">
                <span><?php esc_html_e('Event Image', 'dbem'); ?>  (<span class="help-block label"><?php _e('Upload/change picture', 'dbem') ?></span>)</span>
                <div class="inside event-form-image">
                    <?php em_locate_template('forms/event/featured-image-public.php', true); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (get_option('dbem_rsvp_enabled') && $EM_Event->can_manage('manage_bookings', 'manage_others_bookings')) : ?>
            <!-- START Bookings -->
            <h4 class="hidden"><?php esc_html_e('Bookings/Registration', 'dbem'); ?></h4>
            <div class="inside event-form-bookings">
                <?php // em_locate_template('forms/event/bookings.php', true); ?>
            </div>
            <!-- END Bookings -->
        <?php endif; ?>

        <?php do_action('em_front_event_form_footer'); ?>
    </div>
    <p class="submit">
        <?php if (empty($EM_Event->event_id)): ?>
            <input type='submit' class='button-primary' name='submit' value='<?php echo esc_attr(sprintf(__('Create %s', 'dbem'), __('Event', 'dbem'))); ?>' />
        <?php else: ?>
            <input type='submit' class='button-primary' name='submit' value='<?php echo esc_attr(sprintf(__('Update %s', 'dbem'), __('Event', 'dbem'))); ?>' />
        <?php endif; ?>
    </p>
    <input type="hidden" name="event_id" value="<?php echo $EM_Event->event_id; ?>" />
    <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('wpnonce_event_save'); ?>" />
    <input type="hidden" name="action" value="event_save" />
    <?php if (!empty($_REQUEST['redirect_to'])): ?>
        <input type="hidden" name="redirect_to" value="<?php echo esc_attr($_REQUEST['redirect_to']); ?>" />
    <?php endif; ?>
</form>