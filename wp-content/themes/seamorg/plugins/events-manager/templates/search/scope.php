<?php $args = !empty($args) ? $args : array(); /* @var $args array */ ?>
<!-- START Date Search -->
<div class="em-search-scope em-search-field ">
    <div class=" em-search-scope em-events-search-dates em-date-range ">
       
         
                <input type="text" class="em-date-input-loc em-date-start   searchfield2" placeholder="<?php echo esc_html($args['scope_label']); ?>" aria-describedby="basic-addon2" />
                <input type="hidden" class="em-date-input" name="scope[0]" value="<?php echo esc_attr($args['scope'][0]); ?>" />
               
           
      

<!--            <label><?php echo esc_html($args['scope_label']); ?></label>
            <input type="text" class="em-date-input-loc em-date-start" />
            <input type="hidden" class="em-date-input" name="scope[0]" value="<?php echo esc_attr($args['scope'][0]); ?>" />-->
        <!--        <div class="col-xs-12 col-sm-4 col-md-4">
                    <label> <?php echo esc_html($args['scope_seperator']); ?> </label>
                    <input type="text" class="em-date-input-loc em-date-end" />
                    <input type="hidden" class="em-date-input" name="scope[1]" value="<?php echo esc_attr($args['scope'][1]); ?>" />
                </div>-->
    </div>
</div>
<script>
    jQuery('.em-date-start').on('blur', function() {
        if (jQuery(this).attr('placeholder') == '')
            jQuery(this).attr('placeholder', '<?php echo esc_attr($args['scope_label']); ?>');
    });
    jQuery('.em-date-start').on('focus', function() {
        if (jQuery(this).attr('placeholder') == '<?php echo esc_attr($args['scope_label']); ?>')
            jQuery(this).attr('placeholder', '');
    });
</script>
<!-- END Date Search -->