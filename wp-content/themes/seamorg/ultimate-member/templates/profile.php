<div class="">
    <div class="um-form">
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="um-profile" data-user_id="<?php echo um_profile_id(); ?>">
                <?php
                $data = um_user('submitted');
                $profile_photo = (!empty($data['photo']) && @file_get_contents($data['photo'])) ? $data['photo'] : site_url('/wp-content/uploads/2015/05/1431792347_unknown-128.png');
                ?>
                <a href="<?php echo um_get_core_page('account'); ?>" class="um-profile-photo-img" title="<?php echo um_user('display_name'); ?>">
                    <img  alt="<?php echo um_user('full_name'); ?>" class="gravatar avatar avatar-96 um-avatar" src="<?php echo $profile_photo; ?>">
                </a>
            </div>

            <div class="um-main-meta">
                <div class="um-name"><a href="<?php echo um_get_core_page('account'); ?>" title="<?php echo um_user('display_name'); ?>"><?php echo ucfirst(um_user('first_name')." ".um_user('last_name')); ?></a></div>
                <div class="um-clear"></div>
            </div>

        </div>


        <div class="col-xs-12 col-sm-8 col-md-9 guide-profile">
            <h3>The General Information</h3>

            <div class="um-meta-text"><?php echo um_filtered_value('full_name', FALSE, TRUE); ?></div>
            <div class="clearfix"></div>
<!--            <div class="um-meta-text"><?php // echo um_filtered_value('ssn', FALSE, TRUE); ?></div>
            <div class="clearfix"></div>-->
            <div class="um-meta-text"><?php echo um_filtered_value('phone', FALSE, TRUE); ?></div>
<!--            <div class="clearfix"></div>
            <div class="um-meta-text"><?php // echo um_filtered_value('dob', FALSE, TRUE); ?></div>
            <div class="clearfix"></div>
            <div class="um-meta-text"><?php // echo um_filtered_value('address', FALSE, TRUE); ?></div>
            <div class="clearfix"></div>
            <div class="um-meta-text"><?php // echo um_filtered_value('state', FALSE, TRUE); ?></div>
            <div class="clearfix"></div>
            <div class="um-meta-text"><?php // echo um_filtered_value('zipcode', FALSE, TRUE); ?></div>
            <div class="um-meta-text"><?php // echo um_filtered_value('description', FALSE, TRUE); ?></div>-->


            <div class="um-profile-status approved">
                <span>This user account status is Approved</span>
            </div>



        </div>

    </div>

</div>
<style>
    .entry-header{ display: none; }
</style>