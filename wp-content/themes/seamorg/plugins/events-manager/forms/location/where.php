<?php
global $EM_Location, $post;
$required = apply_filters('em_required_html', '<i>*</i>');
?>
<?php if (get_option('dbem_gmap_is_active')): ?>
    <span class="em-location-data-maps-tip help-block"><?php _e("If you're using the Google Maps, the more detail you provide, the more accurate Google can be at finding your location. If your address isn't being found, please <a='http://maps.google.com'>try it on maps.google.com</a> by adding all the fields below seperated by commas.", 'dbem') ?></span>
<?php endif; ?>
<div id="em-location-data" class="em-location-data">
    <div class="em-location-data">
        <div class="row em-location-data-address">
            <div class="col-xs-12 col-sm-12 col-md-12"><label><?php _e('Address:', 'dbem') ?> <?php echo $required; ?></label></div>
            <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                <input class="form-control" id="location-address" type="text" name="location_address" value="<?php echo esc_attr($EM_Location->location_address, ENT_QUOTES);
;
?>" />
            </div>
        </div>
        <div class="row em-location-data-town">
            <div class="col-xs-12 col-sm-12 col-md-12"><label><?php _e('City/Town:', 'dbem') ?> <?php echo $required; ?></label></div>
            <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                <input class="form-control" id="location-town" type="text" name="location_town" value="<?php echo esc_attr($EM_Location->location_town, ENT_QUOTES); ?>" />
            </div>
        </div>
        <div class="row em-location-data-state">
            <div class="col-xs-12 col-sm-12 col-md-12"><label><?php _e('State/County:', 'dbem') ?></label></div>
            <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                <input class="form-control" id="location-state" type="text" name="location_state" value="<?php echo esc_attr($EM_Location->location_state, ENT_QUOTES); ?>" />
            </div>
        </div>
        <div class="row em-location-data-postcode">
            <div class="col-xs-12 col-sm-12 col-md-12"><label><?php _e('Postcode:', 'dbem') ?></label></div>
            <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                <input class="form-control" id="location-postcode" type="text" name="location_postcode" value="<?php echo esc_attr($EM_Location->location_postcode, ENT_QUOTES); ?>" />
            </div>
        </div>
        <div class="row em-location-data-region">
            <div class="col-xs-12 col-sm-12 col-md-12"><label><?php _e('Region:', 'dbem') ?></label></div>
            <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                <input class="form-control" id="location-region" type="text" name="location_region" value="<?php echo esc_attr($EM_Location->location_region, ENT_QUOTES); ?>" />
                <input id="location-region-wpnonce" type="hidden" value="<?php echo wp_create_nonce('search_regions'); ?>" />
            </div>
        </div>
        <div class="row em-location-data-country">
            <div class="col-xs-12 col-sm-12 col-md-12"><label><?php _e('Country:', 'dbem') ?> <?php echo $required; ?></label></div>
            <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                <select id="location-country" name="location_country" class="form-control">
                    <?php foreach (em_get_countries(__('none selected', 'dbem')) as $country_key => $country_name): ?>
                        <option value="<?php echo $country_key; ?>" <?php echo ( $EM_Location->location_country === $country_key || ($EM_Location->location_country == '' && $EM_Location->location_id == '' && get_option('dbem_location_default_country') == $country_key) ) ? 'selected="selected"' : ''; ?>><?php echo $country_name; ?></option>
<?php endforeach; ?>
                </select>
            </div>
        </div>
        <div id="location_coordinates">
            <div class="row em-location-data-coordinates">
                <div class="col-xs-12 col-sm-12 col-md-12"><label><?php _e('Latitude:', 'dbem') ?> <?php echo $required; ?></label></div>
                <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                    <input id='location-latitude' name='location_latitude' type='text' value='<?php echo $EM_Location->location_latitude; ?>' size='15' />
                </div>
            </div>

            <div class="row em-location-data-coordinates">
                <div class="col-xs-12 col-sm-12 col-md-12"><label><?php _e('Longtitude:', 'dbem') ?> <?php echo $required; ?></label></div>
                <div class="col-xs-12 col-sm-12 col-md-12 inside location-form-name">
                    <input id='location-longitude' name='location_longitude' type='text' value='<?php echo $EM_Location->location_longitude; ?>' size='15' />
                </div>
            </div>
        </div>

        <br style="clear:both; " />

    </div>
<?php if (get_option('dbem_gmap_is_active')) em_locate_template('forms/map-container.php', true); ?>

</div>