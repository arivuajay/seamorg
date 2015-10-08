<?php
/* This general search will find matches within event_name, event_notes, and the location_name, address, town, state and country. */
$args = !empty($args) ? $args : array(); /* @var $args array */
?>
<!-- START General Search -->
<div class="col-xs-12 col-sm-2 col-md-2">
    <div class="em-search-field">
        <select name="em_hike_type" id="em_hike_type">
            <?php
            $location = array('' => 'Hike Type', 'Day' => 'Day', 'Backpacker' => 'Backpacker');
            em_option_items($location, esc_attr($args['em_hike_type']))
            ?>
        </select>
    </div>
</div>
<div class="col-xs-12 col-sm-2 col-md-2">
    <div class="em-search-field">
        <select name="em_hike_difficult" id="em_hike_difficult">
            <?php
            $difficult = array('' => 'Hike Difficult', 'Strenuous' => 'Strenuous', 'Moderate' => 'Moderate', 'Easy' => 'Easy', 'Butt-kicker' => 'Butt-kicker');
            em_option_items($difficult, esc_attr($args['em_hike_difficult']))
            ?>
        </select>
    </div>
</div>
<!-- END General Search -->

<script type="text/javascript">
    function sort_hike(orderby,order){
        _redirect = jQuery.param.querystring(window.location.href, 'order='+order+'&orderby='+orderby);
        window.location.href = _redirect;
    }
</script>

