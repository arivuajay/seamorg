<?php
/* This general search will find matches within event_name, event_notes, and the location_name, address, town, state and country. */
$args = !empty($args) ? $args : array(); /* @var $args array */
$locations = get_locations_list();
$selected = (isset($args['search']) && !empty($args['search'])) ? $args['search'] : null;
?>
<!-- START General Search -->
<div class="em-search-text em-search-field">
<!--    <input type="text" name="em_search" id="em_search_hikename" class="em-events-search-text em-search-text searchfield1" value="<?php // echo esc_attr($args['search']);      ?>" />-->


    <select name="em_search" id="em_search_hikename" class="em-events-search-text em-search-text searchfield1">
        <option></option>
        <?php
        foreach ($locations as $location):
            echo "<option value='$location' ";
            if (!is_null($selected) && $location == $selected)
                echo "selected='selected'";
            echo ">$location</option>";
        endforeach;
        ?>
    </select>

    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery("#em_search_hikename").select2({
                placeholder: "<?php echo esc_attr($args['search_term_label']); ?>",
                allowClear: true
            });
        });
    </script>
</div>
<!-- END General Search -->