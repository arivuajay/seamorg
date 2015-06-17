<?php

/**
 * Seamorg functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Seamorg
 * @since Seamorg 1.0
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Seamorg 1.0
 */
if (!isset($content_width)) {
    $content_width = 660;
}

/**
 * Seamorg only works in WordPress 4.1 or later.
 */
if (version_compare($GLOBALS['wp_version'], '4.1-alpha', '<')) {
    require get_template_directory() . '/inc/back-compat.php';
}

if (!function_exists('seamorg_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * @since Seamorg 1.0
     */
    function seamorg_setup() {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on seamorg, use a find and replace
         * to change 'seamorg' to the name of your theme in all the template files
         */
        load_theme_textdomain('seamorg', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(640, 360, true);

        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'seamorg'),
            'primary-2' => __('Primary-2 Menu', 'seamorg'),
            'social' => __('Social Links Menu', 'seamorg'),
            'footer-company' => __('Footer Company Menu', 'seamorg'),
            'footer-discover' => __('Footer Discover Menu', 'seamorg'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        /*
         * Enable support for Post Formats.
         *
         * See: https://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ));

        $color_scheme = seamorg_get_color_scheme();
        $default_color = trim($color_scheme[0], '#');

        // Setup the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('seamorg_custom_background_args', array(
            'default-color' => $default_color,
            'default-attachment' => 'fixed',
        )));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/editor-style.css', 'genericons/genericons.css', seamorg_fonts_url()));
    }

endif; // seamorg_setup
add_action('after_setup_theme', 'seamorg_setup');

/**
 * Register widget area.
 *
 * @since Seamorg 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function seamorg_widgets_init() {

    register_sidebar(array(
        'name' => __('Footer1 Area', 'seamorg'),
        'id' => 'footer-area-1',
        'description' => __('Add widgets here to appear in your sidebar.', 'seamorg'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Footer2 Area', 'seamorg'),
        'id' => 'footer-area-2',
        'description' => __('Add widgets here to appear in your sidebar.', 'seamorg'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Testimonial Area', 'seamorg'),
        'id' => 'testimonial-area',
        'description' => __('Add widgets here to appear in your sidebar.', 'seamorg'),
        'before_widget' => '<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-lg-offset-1">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'seamorg_widgets_init');

if (!function_exists('seamorg_fonts_url')) :

    /**
     * Register Google fonts for Seamorg.
     *
     * @since Seamorg 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function seamorg_fonts_url() {
        $fonts_url = '';
        $fonts = array();
        $subsets = 'latin,latin-ext';

        /*
         * Translators: If there are characters in your language that are not supported
         * by Noto Sans, translate this to 'off'. Do not translate into your own language.
         */
        if ('off' !== _x('on', 'Noto Sans font: on or off', 'seamorg')) {
            $fonts[] = 'Lato:400,100,300,700,900';
        }

        /*
         * Translators: If there are characters in your language that are not supported
         * by Noto Serif, translate this to 'off'. Do not translate into your own language.
         */
        if ('off' !== _x('on', 'Noto Serif font: on or off', 'seamorg')) {
            $fonts[] = 'Lato:400,100,300,700,900';
        }

        /*
         * Translators: If there are characters in your language that are not supported
         * by Inconsolata, translate this to 'off'. Do not translate into your own language.
         */
        if ('off' !== _x('on', 'Inconsolata font: on or off', 'seamorg')) {
            $fonts[] = 'Lato:400,100,300,700,900';
        }

        /*
         * Translators: To add an additional character subset specific to your language,
         * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
         */
        $subset = _x('no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'seamorg');

        if ('cyrillic' == $subset) {
            $subsets .= ',cyrillic,cyrillic-ext';
        } elseif ('greek' == $subset) {
            $subsets .= ',greek,greek-ext';
        } elseif ('devanagari' == $subset) {
            $subsets .= ',devanagari';
        } elseif ('vietnamese' == $subset) {
            $subsets .= ',vietnamese';
        }

        if ($fonts) {
            $fonts_url = add_query_arg(array(
                'family' => urlencode(implode('|', $fonts)),
                'subset' => urlencode($subsets),
                    ), '//fonts.googleapis.com/css');
        }

        return $fonts_url;
    }

endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Seamorg 1.1
 */
function seamorg_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
    echo "<script>var site_url = '" . site_url() . "';</script>\n";
}

add_action('wp_head', 'seamorg_javascript_detection', 0);

//function seamorg_admin_javascript_detection() {
//    echo "<script>var site_url = '" . site_url() . "';</script>\n";
//}
//
//add_action('admin_init', 'seamorg_admin_javascript_detection', 0);

/**
 * Enqueue scripts and styles.
 *
 * @since Seamorg 1.0
 */
function seamorg_scripts() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('seamorg-fonts', seamorg_fonts_url(), array(), null);

    // Add Genericons, used in the main stylesheet.
    wp_enqueue_style('seamorg-slidebar', get_template_directory_uri() . '/css/slidebars.css', array(), '3.2');
    wp_enqueue_style('seamorg-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.2');
    wp_enqueue_style('seamorg-fontawesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '3.2');
    wp_enqueue_style('seamorg-styles', get_template_directory_uri() . '/css/style.css', array(), '3.2');
    wp_enqueue_style('seamorg-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '3.2');
    wp_enqueue_style('seamorg-developer', get_template_directory_uri() . '/css/dev.css', array(), '3.2');
    wp_enqueue_style('seamorg-developer2', get_template_directory_uri() . '/css/dev2.css', array(), '3.2');


//        <link href='http://fonts.googleapis.com/css?family=Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>
    // Load our main stylesheet.
    wp_enqueue_style('seamorg-style', get_stylesheet_uri());

    // Load the Internet Explorer specific stylesheet.
    wp_enqueue_style('seamorg-ie', get_template_directory_uri() . '/css/ie.css', array('seamorg-style'), '20141010');
    wp_style_add_data('seamorg-ie', 'conditional', 'lt IE 9');

    // Load the Internet Explorer 7 specific stylesheet.
    wp_enqueue_style('seamorg-ie7', get_template_directory_uri() . '/css/ie7.css', array('seamorg-style'), '20141010');
    wp_style_add_data('seamorg-ie7', 'conditional', 'lt IE 8');

    wp_enqueue_script('seamorg-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_singular() && wp_attachment_is_image()) {
        wp_enqueue_script('seamorg-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20141010');
    }

    wp_enqueue_script('seamorg-bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '20150330', true);
    wp_enqueue_script('seamorg-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20150330', true);
    wp_enqueue_script('seamorg-custom-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), '20150330', true);
    wp_localize_script('seamorg-script', 'screenReaderText', array(
        'expand' => '<span class="screen-reader-text">' . __('expand child menu', 'seamorg') . '</span>',
        'collapse' => '<span class="screen-reader-text">' . __('collapse child menu', 'seamorg') . '</span>',
    ));
}

add_action('wp_enqueue_scripts', 'seamorg_scripts');

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Seamorg 1.0
 *
 * @see wp_add_inline_style()
 */
function seamorg_post_nav_background() {
    if (!is_single()) {
        return;
    }

    $previous = ( is_attachment() ) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
    $next = get_adjacent_post(false, '', false);
    $css = '';

    if (is_attachment() && 'attachment' == $previous->post_type) {
        return;
    }

    if ($previous && has_post_thumbnail($previous->ID)) {
        $prevthumb = wp_get_attachment_image_src(get_post_thumbnail_id($previous->ID), 'post-thumbnail');
        $css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url($prevthumb[0]) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
    }

    if ($next && has_post_thumbnail($next->ID)) {
        $nextthumb = wp_get_attachment_image_src(get_post_thumbnail_id($next->ID), 'post-thumbnail');
        $css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url($nextthumb[0]) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
    }

    wp_add_inline_style('seamorg-style', $css);
}

add_action('wp_enqueue_scripts', 'seamorg_post_nav_background');

/**
 * Display descriptions in main navigation.
 *
 * @since Seamorg 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function seamorg_nav_description($item_output, $item, $depth, $args) {
    if ('primary' == $args->theme_location && $item->description) {
        $item_output = str_replace($args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output);
    }

    return $item_output;
}

add_filter('walker_nav_menu_start_el', 'seamorg_nav_description', 10, 4);

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Seamorg 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function seamorg_search_form_modify($html) {
    return str_replace('class="search-submit"', 'class="search-submit screen-reader-text"', $html);
}

add_filter('get_search_form', 'seamorg_search_form_modify');

/**
 * Implement the Custom Header feature.
 *
 * @since Seamorg 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Seamorg 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Seamorg 1.0
 */
require get_template_directory() . '/inc/customizer.php';
/**
 * Custom Social Nav
 *
 * @since Seamorg 1.0
 */
require get_template_directory() . '/inc/social_nav_walker.php';

function link_from_id($atts) {
    extract(shortcode_atts(array('id' => false), $atts));
    if ('id' == false) {
        return false;
    }
    $id = $atts['id'];
    if (isset($id))
        return get_permalink((int) $atts['id']);
}

add_shortcode('link', 'link_from_id');
add_filter('link', 'link_from_id');

/* First we need to extend main profile tabs */
add_filter('um_profile_tabs', 'add_my_events_tab', 1000);

function add_my_events_tab($tabs) {
    $tabs['myeventstab'] = array(
        'name' => 'My Events',
        'icon' => 'um-faicon-pencil',
    );

    return $tabs;
}

/* Then we just have to add content to that tab using this action */
add_filter('um_profile_content_myeventstab', 'myevents_content');

function myevents_content($args) {
    echo 'My event list(s) will come up here... :-)';
}

add_filter('um_profile_tabs', 'add_my_bookings_tab', 1000);

function add_my_bookings_tab($tabs) {
    $tabs['mybookingstab'] = array(
        'name' => 'My Bookings',
        'icon' => 'um-faicon-pencil',
    );

    return $tabs;
}

/* Then we just have to add content to that tab using this action */
add_filter('um_profile_content_mybookingstab', 'mybookings_content');

function mybookings_content($args) {
    echo 'My bookings list(s) will come up here... :-)';
}

add_action('user_register', 'update_role_registration_save', 10, 1);

function update_role_registration_save($user_id) {
    if (isset($_POST['role']) && $_POST['role'] == 'guide') {
        $u = new WP_User($user_id);
        $u->remove_role('subscriber');
        $u->add_role('guide');
    }
}

add_shortcode('theme_uri', 'theme_uri_shortcode');

function theme_uri_shortcode($attrs = array(), $content = '') {
    $theme_uri = is_child_theme() ? get_stylesheet_directory_uri() : get_template_directory_uri();

    return trailingslashit($theme_uri);
}

function getCurrentUserRole() {
    $current_user = wp_get_current_user();
    if (!($current_user instanceof WP_User))
        return;
    $roles = $current_user->roles;

    return $roles;
}

//For Event Manager
function custom_placeholders($atts) {
    extract(shortcode_atts(array('id' => false), $atts));
    if ('id' == false) {
        return false;
    }
    $id = $atts['id'];
    switch ($id) {
        case '#_SEARCHWORD':
            $args = em_get_search_form_defaults($args);
            $replace = (empty($args['search'])) ? $atts['default'] : ucwords($args['search']);

            break;
    }
    return $replace;
}

add_shortcode('CUSTOMPLACEHOLDER', 'custom_placeholders');
add_filter('CUSTOMPLACEHOLDER', 'custom_placeholders');

function my_em_styles_placeholders($replace, $EM_Event, $result) {
    global $wp_query, $wp_rewrite;
    switch ($result) {
        case '#_EVENTSTARTDATE':
            //get format of time to show
            $date_format = ( get_option('dbem_date_format') ) ? get_option('dbem_date_format') : get_option('date_format');
            $replace = date_i18n($date_format, $EM_Event->start);
            break;
        case '#_HIKEWEATHER':
            $latitude = $EM_Event->get_location()->location_latitude;
            $longtitude = $EM_Event->get_location()->location_longitude;

            $content = file_get_contents("https://api.forecast.io/forecast/ae31edd2080dfa3f1ccf6b8fdb4aa71d/$latitude,$longtitude");
            $report = json_decode($content);
            $celcius = round(($report->currently->temperature - 32) * 5 / 9);

            $replace = "<a target='_blank' href='http://forecast.io/#/f/$latitude,$longtitude'>{$celcius}&deg;C</a>";
            break;
    }
    return $replace;
}

add_filter('em_event_output_placeholder', 'my_em_styles_placeholders', 1, 3);

add_filter('um_account_page_default_tabs_hook', 'my_custom_tab_in_um', 100);

function my_custom_tab_in_um($tabs) {
    if (in_array('guide', getCurrentUserRole())) {
        $tabs[800]['mytab']['icon'] = 'um-faicon-pencil';
        $tabs[800]['mytab']['title'] = 'My Events';
        $tabs[800]['mytab']['custom'] = true;
        $tabs[800]['mytab']['tablink'] = get_permalink(158);

        $tabs[801]['mytab']['icon'] = 'um-faicon-pencil';
        $tabs[801]['mytab']['title'] = 'Suggest Hike';
        $tabs[801]['mytab']['custom'] = true;
        $tabs[801]['mytab']['tablink'] = get_permalink(250) . "?action=edit";
    } elseif (in_array('subscriber', getCurrentUserRole())) {
        $tabs[900]['mytab']['icon'] = 'um-faicon-pencil';
        $tabs[900]['mytab']['title'] = 'My Bookings';
        $tabs[900]['mytab']['custom'] = true;
        $tabs[900]['mytab']['tablink'] = get_permalink(79);
    }
    return $tabs;
}

function guide_can_create() {
    if (in_array('guide', getCurrentUserRole())) {
        $event_limit = DBEM_CUSTOM_MAX_EVENT_LIMIT;
        global $wpdb;
        $current_user = wp_get_current_user();
        $current_time = date('Y-m-d', strtotime(current_time('mysql')));
        $sql = "SELECT COUNT(*) as count FROM {$wpdb->prefix}em_events WHERE event_owner = '{$current_user->ID}' AND event_status = '1' AND event_end_date >= '{$current_time}'";
        $results = $wpdb->get_results($sql, OBJECT);

        if ($results && $results[0]->count >= $event_limit) {
            return false;
        }
    }

    return true;
}

//For Event Manager
add_image_size('grid-3-thumbnails', 360, 230, true);

/*
  Validate Numbers in Contact Form 7
  This is for 10 digit numbers
 */

function is_number($result, $tag) {
    $type = $tag['type'];
    $name = $tag['name'];

    if ($name == 'your-phone' || $name == 'fax') { // Validation applies to these textfield names. Add more with || inbetween
        $stripped = preg_replace('/\D/', '', $_POST[$name]);
        $_POST[$name] = $stripped;
        if (strlen($_POST[$name]) != 10) { // Number string must equal this
            $result['valid'] = false;
            $result['reason'][$name] = $_POST[$name] = 'Please enter a 10 digit phone number.';
        }
    }
    return $result;
}

add_filter('wpcf7_validate_text', 'is_number', 10, 2);
add_filter('wpcf7_validate_text*', 'is_number', 10, 2);

//Disable WP Updatees
function remove_core_updates() {
    global $wp_version;
    return(object) array('last_checked' => time(), 'version_checked' => $wp_version,);
}

add_filter('pre_site_transient_update_core', 'remove_core_updates');
add_filter('pre_site_transient_update_plugins', 'remove_core_updates');
add_filter('pre_site_transient_update_themes', 'remove_core_updates');
//Disable WP Updatees