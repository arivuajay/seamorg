<?php
/* This general search will find matches within event_name, event_notes, and the location_name, address, town, state and country. */
$args = !empty($args) ? $args:array(); /* @var $args array */
?>
<!-- START General Search -->
<div class="em-search-text em-search-field">
	<input type="text" name="em_search" class="em-events-search-text em-search-text searchfield1" value="<?php echo esc_attr($args['search']); ?>" />

	<script type="text/javascript">
	EM.search_term_placeholder = '<?php echo esc_attr($args['search_term_label']); ?>';
        jQuery('.em-events-search-text').on('blur', function() {
                if (jQuery(this).attr('placeholder') == '')
                    jQuery(this).attr('placeholder', '<?php echo esc_attr($args['search_term_label']); ?>');
            });
            jQuery('.em-events-search-text').on('focus', function() {
                if (jQuery(this).attr('placeholder') == EM.search_term_placeholder)
                    jQuery(this).attr('placeholder', '');
            });
	</script>
</div>
<!-- END General Search -->