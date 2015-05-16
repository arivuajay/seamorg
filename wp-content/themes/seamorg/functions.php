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
        set_post_thumbnail_size(825, 510, true);

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
        'name' => __('Footer Area', 'seamorg'),
        'id' => 'footer-area',
        'description' => __('Add widgets here to appear in your sidebar.', 'seamorg'),
        'before_widget' => '<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 footerpart1 %2$s" id="%1$s">',
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
}

add_action('wp_head', 'seamorg_javascript_detection', 0);

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

    wp_enqueue_script('seamorg-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20150330', true);
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



/**
 * Builds the Video shortcode output.
 *
 * This implements the functionality of the Video Shortcode for displaying
 * WordPress mp4s in a post.
 *
 * @since 3.6.0
 *
 * @param array  $attr {
 *     Attributes of the shortcode.
 *
 *     @type string $src      URL to the source of the video file. Default empty.
 *     @type int    $height   Height of the video embed in pixels. Default 360.
 *     @type int    $width    Width of the video embed in pixels. Default $content_width or 640.
 *     @type string $poster   The 'poster' attribute for the `<video>` element. Default empty.
 *     @type string $loop     The 'loop' attribute for the `<video>` element. Default empty.
 *     @type string $autoplay The 'autoplay' attribute for the `<video>` element. Default empty.
 *     @type string $preload  The 'preload' attribute for the `<video>` element.
 *                            Default 'metadata'.
 *     @type string $class    The 'class' attribute for the `<video>` element.
 *                            Default 'wp-video-shortcode'.
 *     @type string $id       The 'id' attribute for the `<video>` element.
 *                            Default 'video-{$post_id}-{$instance}'.
 * }
 * @param string $content Shortcode content.
 * @return string HTML content to display video.
 */
function my_video_shortcode( $attr, $content = '' ) {
	global $content_width;
	$post_id = get_post() ? get_the_ID() : 0;

	static $instance = 0;
	$instance++;

	/**
	 * Filter the default video shortcode output.
	 *
	 * If the filtered output isn't empty, it will be used instead of generating
	 * the default video template.
	 *
	 * @since 3.6.0
	 *
	 * @see my_video_shortcode()
	 *
	 * @param string $html     Empty variable to be replaced with shortcode markup.
	 * @param array  $attr     Attributes of the video shortcode.
	 * @param string $content  Video shortcode content.
	 * @param int    $instance Unique numeric ID of this video shortcode instance.
	 */
	$override = apply_filters( 'my_video_shortcode_override', '', $attr, $content, $instance );
	if ( '' !== $override ) {
		return $override;
	}

	$video = null;

	$default_types = wp_get_video_extensions();
	$defaults_atts = array(
		'src'      => '',
		'poster'   => '',
		'loop'     => '',
		'autoplay' => '',
		'preload'  => 'metadata',
		'width'    => 640,
		'height'   => 360,
	);

	foreach ( $default_types as $type ) {
		$defaults_atts[$type] = '';
	}

	$atts = shortcode_atts( $defaults_atts, $attr, 'video' );

	if ( is_admin() ) {
		// shrink the video so it isn't huge in the admin
		if ( $atts['width'] > $defaults_atts['width'] ) {
			$atts['height'] = round( ( $atts['height'] * $defaults_atts['width'] ) / $atts['width'] );
			$atts['width'] = $defaults_atts['width'];
		}
	} else {
		// if the video is bigger than the theme
		if ( ! empty( $content_width ) && $atts['width'] > $content_width ) {
			$atts['height'] = round( ( $atts['height'] * $content_width ) / $atts['width'] );
			$atts['width'] = $content_width;
		}
	}

	$is_vimeo = $is_youtube = false;
	$yt_pattern = '#^https?://(?:www\.)?(?:youtube\.com/watch|youtu\.be/)#';
	$vimeo_pattern = '#^https?://(.+\.)?vimeo\.com/.*#';

	$primary = false;
	if ( ! empty( $atts['src'] ) ) {
		$is_vimeo = ( preg_match( $vimeo_pattern, $atts['src'] ) );
		$is_youtube = (  preg_match( $yt_pattern, $atts['src'] ) );
		if ( ! $is_youtube && ! $is_vimeo ) {
			$type = wp_check_filetype( $atts['src'], wp_get_mime_types() );
			if ( ! in_array( strtolower( $type['ext'] ), $default_types ) ) {
				return sprintf( '<a class="wp-embedded-video" href="%s">%s</a>', esc_url( $atts['src'] ), esc_html( $atts['src'] ) );
			}
		}

		if ( $is_vimeo ) {
			wp_enqueue_script( 'froogaloop' );
		}

		$primary = true;
		array_unshift( $default_types, 'src' );
	} else {
		foreach ( $default_types as $ext ) {
			if ( ! empty( $atts[ $ext ] ) ) {
				$type = wp_check_filetype( $atts[ $ext ], wp_get_mime_types() );
				if ( strtolower( $type['ext'] ) === $ext ) {
					$primary = true;
				}
			}
		}
	}

	if ( ! $primary ) {
		$videos = get_attached_media( 'video', $post_id );
		if ( empty( $videos ) ) {
			return;
		}

		$video = reset( $videos );
		$atts['src'] = wp_get_attachment_url( $video->ID );
		if ( empty( $atts['src'] ) ) {
			return;
		}

		array_unshift( $default_types, 'src' );
	}

	/**
	 * Filter the media library used for the video shortcode.
	 *
	 * @since 3.6.0
	 *
	 * @param string $library Media library used for the video shortcode.
	 */
	$library = apply_filters( 'my_video_shortcode_library', 'mediaelement' );
	if ( 'mediaelement' === $library && did_action( 'init' ) ) {
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );
	}

	/**
	 * Filter the class attribute for the video shortcode output container.
	 *
	 * @since 3.6.0
	 *
	 * @param string $class CSS class or list of space-separated classes.
	 */
	$html_atts = array(
		'class'    => apply_filters( 'my_video_shortcode_class', 'wp-video-shortcode' ),
		'id'       => sprintf( 'video-%d-%d', $post_id, $instance ),
		'width'    => absint( $atts['width'] ),
		'height'   => absint( $atts['height'] ),
		'poster'   => esc_url( $atts['poster'] ),
		'loop'     => wp_validate_boolean( $atts['loop'] ),
		'autoplay' => wp_validate_boolean( $atts['autoplay'] ),
		'preload'  => $atts['preload'],
	);

	// These ones should just be omitted altogether if they are blank
	foreach ( array( 'poster', 'loop', 'autoplay', 'preload' ) as $a ) {
		if ( empty( $html_atts[$a] ) ) {
			unset( $html_atts[$a] );
		}
	}

	$attr_strings = array();
	foreach ( $html_atts as $k => $v ) {
		$attr_strings[] = $k . '="' . esc_attr( $v ) . '"';
	}

	$html = '';
	if ( 'mediaelement' === $library && 1 === $instance ) {
		$html .= "<!--[if lt IE 9]><script>document.createElement('video');</script><![endif]-->\n";
	}
	$html .= sprintf( '<video %s controls="controls">', join( ' ', $attr_strings ) );

	$fileurl = '';
	$source = '<source type="%s" src="%s" />';
	foreach ( $default_types as $fallback ) {
		if ( ! empty( $atts[ $fallback ] ) ) {
			if ( empty( $fileurl ) ) {
				$fileurl = $atts[ $fallback ];
			}
			if ( 'src' === $fallback && $is_youtube ) {
				$type = array( 'type' => 'video/youtube' );
			} elseif ( 'src' === $fallback && $is_vimeo ) {
				$type = array( 'type' => 'video/vimeo' );
			} else {
				$type = wp_check_filetype( $atts[ $fallback ], wp_get_mime_types() );
			}
			$url = add_query_arg( '_', $instance, $atts[ $fallback ] );
			$html .= sprintf( $source, $type['type'], esc_url( $url ) );
		}
	}

	if ( ! empty( $content ) ) {
		if ( false !== strpos( $content, "\n" ) ) {
			$content = str_replace( array( "\r\n", "\n", "\t" ), '', $content );
		}
		$html .= trim( $content );
	}

	if ( 'mediaelement' === $library ) {
		$html .= wp_mediaelement_fallback( $fileurl );
	}
	$html .= '</video>';

	$width_rule = '';
	if ( ! empty( $atts['width'] ) ) {
		$width_rule = sprintf( 'width: %d; ', $atts['width'] );
	}
	$output = sprintf( '<div style="%s" class="wp-video">%s</div>', $width_rule, $html );

	/**
	 * Filter the output of the video shortcode.
	 *
	 * @since 3.6.0
	 *
	 * @param string $output  Video shortcode HTML output.
	 * @param array  $atts    Array of video shortcode attributes.
	 * @param string $video   Video file.
	 * @param int    $post_id Post ID.
	 * @param string $library Media library used for the video shortcode.
	 */
	return apply_filters( 'my_video_shortcode', $output, $atts, $video, $post_id, $library );
}
add_shortcode( 'myvideo', 'my_video_shortcode' );