<?php
/* This general search will find matches within event_name, event_notes, and the location_name, address, town, state and country. */
$args = !empty($args) ? $args : array(); /* @var $args array */
$locations = get_locations_list();
$selected = (isset($args['search']) && !empty($args['search'])) ? $args['search'] : null;
?>
<!-- START General Search -->
<div class="em-search-text em-search-field">
<!--    <input type="text" name="em_search" id="em_search_hikename" class="em-events-search-text em-search-text searchfield1" value="<?php // echo esc_attr($args['search']);        ?>" />-->


<!--    <select name="em_search" id="em_search_hikename" class="em-events-search-text em-search-text searchfield1">
        <option></option>
    <?php
//        foreach ($locations as $location):
//            echo "<option value='$location' ";
//            if (!is_null($selected) && $location == $selected)
//                echo "selected='selected'";
//            echo ">$location</option>";
//        endforeach;
    ?>
    </select>-->
    <input name="em_search" id="em_search_hikename" class="em-events-search-text em-search-text searchfield1" placeholder="<?php echo esc_attr($args['search_term_label']); ?>" value="<?php echo esc_attr($args['search']); ?>" autocomplete="off" />

    <script type="text/javascript">
//        jQuery(document).ready(function() {
//            jQuery("#em_search_hikename").select2({
//                placeholder: "<?php // echo esc_attr($args['search_term_label']); ?>",
//                allowClear: false,
//                selectOnBlur: true
//            });
//        });

//        jQuery(document).ready(function() {
//            var availableTags = <?php echo json_encode($locations) ?>;
//            jQuery("#em_search_hikename").autocomplete({
//                source: availableTags,
//                minLength: 0
//            }).focus(function() {
//                jQuery(this).autocomplete("search", jQuery(this).val());
//            });
//        });
    </script>
</div>
<!-- END General Search -->