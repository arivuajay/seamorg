<?php
/* WARNING! This file may change in the near future as we intend to add features to the location editor. If at all possible, try making customizations using CSS, jQuery, or using our hooks and filters. - 2012-02-14 */
/*
 * To ensure compatability, it is recommended you maintain class, id and form name attributes, unless you now what you're doing.
 * You also must keep the _wpnonce hidden field in this form too.
 */
global $EM_Location, $EM_Notices;
//check that user can access this page
if (is_object($EM_Location) && !$EM_Location->can_manage('edit_locations', 'edit_others_locations')) {
    ?>
    <div class="wrap"><h2><?php esc_html_e('Unauthorized Access', 'dbem'); ?></h2><p><?php echo sprintf(__('You do not have the rights to manage this %s.', 'dbem'), __('location', 'dbem')); ?></p></div>
    <?php
    return false;
} elseif (!is_object($EM_Location)) {
    $EM_Location = new EM_Location();
}
if (!is_admin())
    echo $EM_Notices;
?>
<form enctype='multipart/form-data' id='location-form' method='post' action='<?php echo esc_url(add_query_arg(array('success' => null))); ?>'>
    <input type='hidden' name='action' value='location_save' />
    <input type='hidden' name='_wpnonce' value='<?php echo wp_create_nonce('location_save'); ?>' />
    <input type='hidden' name='location_id' value='<?php echo $EM_Location->location_id ?>'/>
    <?php do_action('em_front_location_form_header'); ?>


    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 create-hike-part1">

            <div class="row em-location-data-select">
                <div class="col-xs-12 col-sm-12 col-md-12"><label><?php esc_html_e('Hike Name', 'dbem'); ?></label></div>
                <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                    <input name='location_name' id='location-name' type='text' value='<?php echo esc_attr($EM_Location->location_name, ENT_QUOTES); ?>' size='40'  />
                    <br />
                    <span class="help-block"><?php esc_html_e('The name of the location', 'dbem') ?></span>
                </div>
            </div>

            <?php if ($EM_Location->can_manage('upload_event_images', 'upload_event_images')): ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 location-form-image">
                        <label><?php esc_html_e('Hike Image', 'dbem'); ?></label>  (<span class="help-block label"><?php _e('Upload/change picture', 'dbem') ?></span>)
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-image">
                        <?php em_locate_template('forms/location/featured-image-public.php', true); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            if (get_option('dbem_location_attributes_enabled')) {
                em_locate_template('forms/location/attributes-public.php', true);
            }
            ?>

            <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 location-form-details">
                        <label><?php esc_html_e('Hike Details', 'dbem'); ?></label>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-details">
                        <?php if (get_option('dbem_events_form_editor') && function_exists('wp_editor')): ?>
                    <?php wp_editor($EM_Location->post_content, 'em-editor-content', array('textarea_name' => 'content')); ?>
                <?php else: ?>
                        <textarea class="form-control" name="content" rows="10" style="width:100%"><?php echo $EM_Location->post_content; ?></textarea>
                    <br />
                    <span class="help-block"><?php esc_html_e('Details about the location.', 'dbem') ?></span>
                <?php endif; ?>
                    </div>
                </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 create-hike-part2">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 location-form-where"><label><?php esc_html_e('Hike', 'dbem'); ?></label></div>
                <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-where">
                    <?php em_locate_template('forms/location/where.php', 'dbem'); ?>
                </div>
            </div>
        </div>
    </div>


    <?php do_action('em_front_location_form_footer'); ?>

    <?php if (!empty($_REQUEST['redirect_to'])): ?>
        <input type="hidden" name="redirect_to" value="<?php echo esc_attr($_REQUEST['redirect_to']); ?>" />
    <?php endif; ?>
    <p class='submit'>
        <?php if (empty($EM_Location->location_id)): ?>
            <input type='submit' class='button-primary' name='submit' value='<?php echo esc_attr(sprintf(__('Submit %s', 'dbem'), __('Hike', 'dbem'))); ?>' />
        <?php else: ?>
            <input type='submit' class='button-primary' name='submit' value='<?php echo esc_attr(sprintf(__('Update %s', 'dbem'), __('Hike', 'dbem'))); ?>' />
        <?php endif; ?>
    </p>
</form>