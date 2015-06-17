<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
?>
<div class="footer-cont">
    <div class="footer-row1"> <img src="<?php echo get_bloginfo('template_directory'); ?>/images/footerbg1.png"  alt=""></div>
    <div class="footer-row2">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-4 footerpart1">
                    <?php dynamic_sidebar('footer-area-1'); ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 footerpart1">
                    <?php dynamic_sidebar('footer-area-2'); ?>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-2 footerpart1">
                    <h2>Join with us</h2>
                    <?php wp_nav_menu(array('container' => false, 'menu_id' => 'social', 'menu_class' => 'social-nav', 'depth' => 0, 'theme_location' => 'social', 'walker' => new social_nav_walker())); ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 copy"> &copy; Copyright <?php echo date('Y') . " " . get_bloginfo('name'); ?> . All rights reserved.  Designed By <a href="http://www.8milestechnologies.com/" target="_blank">8milestechnologies</a></div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="sb-slidebar sb-left">
    <a href="#" class="sb-close"><span class="fa fa-close"></span></a>
    <?php if (is_user_logged_in()) { ?>
        <span class="menu-signin">Hi, <a href="<?php echo um_user_profile_url(); ?>">  <?php echo um_user('display_name'); ?> </a></span><br/>
        <a href="<?php echo wp_logout_url('$index.php'); ?>" class="signup-btn2" >Log Out</a>

    <?php } else { ?>

        <span class="menu-signin"><a href="<?php echo get_permalink(48) ?>"> Sign in </a></span><br/>
        <a href="<?php echo get_permalink(46) ?>" class="signup-btn2">Sign Up</a>
    <?php } ?>
    <div class="">
        <?php wp_nav_menu(array('theme_location' => 'primary', 'container_class' => 'big-menu', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu')); ?>
        <?php wp_nav_menu(array('theme_location' => 'primary-2', 'container_class' => 'small-menu', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-2-menu')); ?>
        <!--        <div class="language-cont">
                    <p> Language</p>
                    <select name="">
                        <option>English</option>
                    </select>
                </div>-->
        <div class="joinwith">
            <p> Join with us</p>
            <?php wp_nav_menu(array('container' => false, 'menu_id' => 'social', 'menu_class' => 'social-nav', 'depth' => 0, 'theme_location' => 'social', 'walker' => new social_nav_walker())); ?>
        </div>
    </div>
</div>
<!-- Slidebars -->
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/slidebars.js"></script>
<script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/jquery.maskedinput.min.js"></script>
<script>
    (function($) {
        $(document).ready(function() {
            $.slidebars({
                scrollLock: true
            });

            $("#phone-118").mask("(999) 999-9999");
            $("#ssn-118").mask("999-999-9999");
        });
    })(jQuery);
</script>

<?php
if ($_REQUEST['debug'] == 'true') {
    $included_files = get_included_files();
    $stylesheet_dir = str_replace('\\', '/', get_stylesheet_directory());
    $template_dir = str_replace('\\', '/', get_template_directory());

    foreach ($included_files as $key => $path) {

        $path = str_replace('\\', '/', $path);

        if (false === strpos($path, $stylesheet_dir) && false === strpos($path, $template_dir))
            unset($included_files[$key]);
    }

    echo '<pre>';
    var_dump($included_files);
}
wp_footer();
?>
</body>
</html>