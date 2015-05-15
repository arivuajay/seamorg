<?php
/**
 * Template Name: Guide signup Page
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
get_header();
?>

<div class="body-cont inner-cont guide-signup">
  <div class="container">
    <div class="row">
      <div class=" col-xs-12 col-sm-10 col-md-6 col-lg-6 col-sm-offset-1 col-md-offset-3 col-lg-offset-3 inner-content ">
        <div class="signup-form-cont">
          <h2> signup as a guide with seamorg</h2>
          <h3> profile section</h3>
          <div class=" col-xs-12 col-sm-8 col-md-10 col-lg-8 col-sm-offset-2 col-md-offset-1 col-lg-offset-2 "> <?php echo do_shortcode('[pie_register_form]'); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
get_footer();

