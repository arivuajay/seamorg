<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <!--[if lt IE 9]>
        <script src="<?php echo esc_url(get_template_directory_uri()); ?>/js/html5.js"></script>
        <![endif]-->
<?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div id="sb-site">
            <div class="header" >
                <div class="container">
                    <div class="row">
                        <div class="col-xs-2 col-sm-2 col-md-2 menu">
                            <?php if(is_user_logged_in()): ?>
                            <button  class="sb-toggle-left menu-btn" >
                                <img src="<?php echo get_bloginfo('template_directory'); ?>/images/menu.png" width="29" height="13" alt=""> &nbsp; <span>Menu </span>
                            </button>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-9 col-sm-2 col-md-3 logo">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_bloginfo('template_directory'); ?>/images/logo.png" alt=""></a>
                        </div>
                        <div class="col-xs-12 col-sm-7 col-md-7 toplinks pull-right">
                            <ul>
<?php if (is_user_logged_in()) { ?>
                                    <li><a href="<?php echo wp_logout_url('$index.php'); ?>" class="singup-btn">Log Out</a></li>
                                    <li class="um-username"><a class="u-fullname" href="<?php echo get_permalink(112); ?>"><?php echo ucfirst(um_user('display_name')); ?> </a></li>
                                    <li class="um-useravatar">
                                        <a href="<?php echo get_permalink(112); ?>" class="profile-photo-img" title="<?php echo ucfirst(um_user('display_name')); ?> ">
    <?php
    if ($user_photo = um_user('photo')) {
       echo '<img width="96" height="96" alt="" class="gravatar avatar avatar-96 um-avatar" src="'.$user_photo.'">';
    } else {
        echo '<img width="96" height="96" alt="" class="gravatar avatar avatar-96 um-avatar" src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&f=y">';
    }
    ?>
                                        </a>
                                    </li>

                                <?php } else { ?>
                                    <li><a href="<?php echo get_permalink(48) ?>">SIGN IN</a></li>
                                    <li><a href="<?php echo get_permalink(46) ?>" class="singup-btn">SIGN UP</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
