<?php
//TODO Simplify panel for events, use form flags to detect certain actions (e.g. submitted, etc)
global $wpdb, $bp, $EM_Notices;
/* @var $args array */
/* @var $EM_Events array */
/* @var events_count int */
/* @var future_count int */
/* @var pending_count int */
/* @var url string */
/* @var show_add_new bool */
//add new button will only appear if called from em_event_admin template tag, or if the $show_add_new var is set
if (!empty($show_add_new) && current_user_can('edit_events'))
    echo '<a class="em-button button add-new-h2" href="' . em_add_get_params($_SERVER['REQUEST_URI'], array('action' => 'edit', 'scope' => null, 'status' => null, 'event_id' => null, 'success' => null)) . '">' . __('Add New', 'dbem') . '</a>';
?>
<div class="wrap">
<?php echo $EM_Notices; ?>
    <form id="posts-filter" action="" method="get">
        <div class="subsubsub">
            <?php $default_params = array('scope' => null, 'status' => null, 'em_search' => null, 'pno' => null); //template for cleaning the link for each view below  ?>
            <a href='<?php echo em_add_get_params($_SERVER['REQUEST_URI'], $default_params + array('view' => 'future')); ?>' <?php echo (!isset($_GET['status']) ) ? 'class="current"' : ''; ?>><?php _e('Upcoming', 'dbem'); ?> <span class="count">(<?php echo $future_count; ?>)</span></a> &nbsp;|&nbsp;
            <?php if ($pending_count > 0): ?>
                <a href='<?php echo em_add_get_params($_SERVER['REQUEST_URI'], $default_params + array('view' => 'pending')); ?>' <?php echo (!empty($_REQUEST['scope']) && $_REQUEST['scope'] == 'all' && !isset($_GET['status']) ) ? 'class="current"' : ''; ?>><?php _e('Pending', 'dbem'); ?> <span class="count">(<?php echo $pending_count; ?>)</span></a> &nbsp;|&nbsp;
            <?php endif; ?>
            <?php if ($draft_count > 0): ?>
                <a href='<?php echo em_add_get_params($_SERVER['REQUEST_URI'], $default_params + array('view' => 'draft')); ?>' <?php echo ( isset($_GET['status']) && $_GET['status'] == 'draft' ) ? 'class="current"' : ''; ?>><?php _e('Draft', 'dbem'); ?> <span class="count">(<?php echo $draft_count; ?>)</span></a> &nbsp;|&nbsp;
<?php endif; ?>
            <a href='<?php echo em_add_get_params($_SERVER['REQUEST_URI'], $default_params + array('view' => 'past')); ?>' <?php echo (!empty($_REQUEST['scope']) && $_REQUEST['scope'] == 'past' ) ? 'class="current"' : ''; ?>><?php _e('Past Events', 'dbem'); ?> <span class="count">(<?php echo $past_count; ?>)</span></a>
        </div>
        <p class="search-box">
            <label class="screen-reader-text" for="post-search-input"><?php _e('Search Events', 'dbem'); ?>:</label>
            <input type="text" id="post-search-input" name="em_search" value="<?php echo (!empty($_REQUEST['em_search'])) ? esc_attr($_REQUEST['em_search']) : ''; ?>" />
            <?php if (!empty($_REQUEST['view'])): ?>
                <input type="hidden" name="view" value="<?php echo esc_attr($_REQUEST['view']); ?>" />
<?php endif; ?>
            <input type="submit"  value="<?php _e('Search Events', 'dbem'); ?>" class="button button-primary" />
        </p>
        <div class="tablenav">
            <?php
            if ($events_count >= $limit) {
                $events_nav = em_admin_paginate($events_count, $limit, $page);
                echo $events_nav;
            }
            ?>
            <br class="clear" />
        </div>
        <div class="row">
        <?php
        if (empty($EM_Events)) {
            echo get_option('dbem_no_events_message');
        } else {
            ?>

                    <?php
                    $rowno = 0;
                    $recurrence_delete_confirm = 'Are you sure want to delete?';
                    foreach ($EM_Events as $EM_Event) {
                        /* @var $EM_Event EM_Event */
                        $rowno++;
                        $class = ($rowno % 2) ? 'alternate' : '';
                        // FIXME set to american
                        $localised_start_date = date_i18n(get_option('dbem_date_format'), $EM_Event->start);
                        $localised_end_date = date_i18n(get_option('dbem_date_format'), $EM_Event->end);
                        $style = "";
                        $today = current_time('timestamp');

                        $min = false;
                        foreach ($EM_Event->get_tickets()->tickets as $EM_Ticket) {
                            /* @var $EM_Ticket EM_Ticket */
                            if ($EM_Ticket->is_available() || get_option('dbem_bookings_tickets_show_unavailable')) {
                                if ($EM_Ticket->get_price() < $min || $min === false) {
                                    $min = $EM_Ticket->get_price();
                                }
                            }
                        }
                        if ($min === false)
                            $min = 0;


                        if ($EM_Event->start < $today && $EM_Event->end < $today) {
                            $class .= " past";
                        }
                        //Check pending approval events
                        if (!$EM_Event->get_status()) {
                            $class .= " pending";
                        }
                        ?>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 event-grid event <?php echo trim($class); ?>" <?php echo $style; ?> id="event_<?php echo $EM_Event->event_id ?>">
                        <div class="event-cont">
                            <div class="event-img">
                                <div class="eventplace-details"> <img src="<?php echo get_template_directory_uri(); ?>/images/map-icon.png"  alt=""> <?php echo esc_html($EM_Event->get_location()->location_name); ?> <span> <?php echo em_get_currency_formatted($min); ?></span></div>
                                <?php if ($EM_Event->get_image_url() != '') : ?>
                                    <img src='<?php echo $EM_Event->get_image_url('grid-3-thumbnails'); ?>' alt='<?php echo $EM_Event->event_name ?>'/>
        <?php endif; ?>
                            </div>
                            <div class="eventplace-details-txt">
                                <div class="event-name">
                                    <h2><?php echo esc_html($EM_Event->event_name); ?></h2>
                                    <span><?php echo $localised_start_date; ?></span>
                                </div>
                                <div class="buyticket">
                                    <a class="row-title" href="<?php echo esc_url($EM_Event->get_edit_url()); ?>"><i class="fa fa-pencil"></i> Edit</a>
                                    <?php if (current_user_can('delete_events')) : ?>
                                        <a class="row-title em-event-rec-delete" href="<?php echo esc_url(add_query_arg(array('action' => 'event_delete', 'event_id' => $EM_Event->event_id, '_wpnonce' => wp_create_nonce('event_delete_' . $EM_Event->event_id)))); ?>" onclick ="if (!confirm('<?php echo $recurrence_delete_confirm; ?>')) {
                                                                return false;
                                                            }"> <i class="fa fa-trash"></i> Delete</a>

        <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
        <?php } ?>
    <?php } ?>
        </div>
        <div class='tablenav'>
            <div class="alignleft actions">
                <br class='clear' />
            </div>
                <?php if ($events_count >= $limit) : ?>
                <div class="tablenav-pages">
                <?php
                echo $events_nav;
                ?>
                </div>
<?php endif; ?>
            <br class='clear' />
        </div>
    </form>
</div>