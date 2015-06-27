<div class="um <?php echo $this->get_class($mode); ?> um-<?php echo $form_id; ?>">
    <div class="um-form">
            <div class="um-header">
                <div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">
                    <?php
                    $data = um_user('submitted');
                    $profile_photo = (!empty($data['photo']) && @file_get_contents($data['photo'])) ? $data['photo'] : site_url('/wp-content/uploads/2015/05/1431792347_unknown-128.png');
                    ?>
                    <a href="<?php echo um_get_core_page('account'); ?>" class="um-profile-photo-img" title="<?php echo um_user('display_name'); ?>">
                        <img width="96" height="96" alt="<?php echo um_user('full_name'); ?>" class="gravatar avatar avatar-96 um-avatar" src="<?php echo $profile_photo; ?>">
                    </a>
                </div>

                <div class="um-profile-meta">
                    <div class="um-main-meta">
                        <div class="um-name"><a href="<?php echo um_get_core_page('account'); ?>" title="<?php echo um_user('display_name'); ?>"><?php echo um_user('full_name'); ?></a></div>
                        <div class="um-clear"></div>
                    </div>



                    <div class="um-meta-text"><?php echo um_filtered_value('full_name',FALSE,TRUE); ?></div>
                    <div class="um-meta-text"><?php echo um_filtered_value('ssn',FALSE,TRUE); ?></div>
                    <div class="um-meta-text"><?php echo um_filtered_value('phone',FALSE,TRUE); ?></div>
                    <div class="um-meta-text"><?php echo um_filtered_value('dob',FALSE,TRUE); ?></div>
                    <div class="um-meta-text"><?php echo um_filtered_value('address',FALSE,TRUE); ?></div>
                    <div class="um-meta-text"><?php echo um_filtered_value('state',FALSE,TRUE); ?></div>
                    <div class="um-meta-text"><?php echo um_filtered_value('zipcode',FALSE,TRUE); ?></div>
                    <div class="um-meta-text"><?php echo um_filtered_value('description',FALSE,TRUE); ?></div>


                    <div class="um-profile-status approved">
                        <span>This user account status is Approved</span>
                    </div>

                </div>
            </div>



<?php // do_action('um_profile_navbar', $args );  ?>

<?php
//			$nav = $ultimatemember->profile->active_tab;
//			$subnav = ( get_query_var('subnav') ) ? get_query_var('subnav') : 'default';
//
//			print "<div class='um-profile-body $nav $nav-$subnav'>";
//
//				// Custom hook to display tabbed content
//				do_action("um_profile_content_{$nav}", $args);
//				do_action("um_profile_content_{$nav}_{$subnav}", $args);
//
//			print "</div>";
?>

            <?php // if ( um_is_on_edit_profile() ) { ?></form><?php // } ?>

    </div>

</div>
<style>
    .entry-header{ display: none; }
</style>