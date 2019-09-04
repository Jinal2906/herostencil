<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

/**
 * Twenty Nineteen only works in WordPress 4.7 or later.
 */
include ('svg-icons.php');
if ( version_compare( $GLOBALS['wp_version'], '4.7', '<' ) ) {
    require get_template_directory() . '/inc/back-compat.php';
    return;
}
function new_excerpt_more($more) {
    return ' <p><a class="read-more" href="' . get_permalink(get_the_ID()) . '"><span>' . __('Read Full Post', 'your-text-domain') . '</span></a></p>';
}
add_filter('excerpt_more', 'new_excerpt_more');

if ( !function_exists( 'get_image' ) ) {
    function get_image( $attachment_id, $size = 'thumbnail', $lazyload = true, $icon = false, $attr = '' ) {

        $_placeholder_image = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

		if ( empty( $attachment_id ) )
			return;

		$placeholder_image = apply_filters( 'lazysizes_placeholder_image', $_placeholder_image );

		$html = wp_get_attachment_image( $attachment_id, $size, $icon, $attr );

		if ( false === $lazyload )
			return $html;

		preg_match_all( '/<img\s+.*?>/', $html, $matches );

		$search = array();
		$replace = array();

		$skip_images_regex = '/class=".*lazyload.*"/';

		if ( !empty( $matches[0] ) ) {
			foreach ( $matches[0] as $imgHTML ) {

				// Don't to the replacement if a skip class is provided and the image has the class.
				if ( ! ( preg_match( $skip_images_regex, $imgHTML ) ) ) {

					$replaceHTML = preg_replace(
						'/<img(.*?)src=/i',
						'<img$1src="' . $placeholder_image . '" data-src=',
						$imgHTML
					);

					$replaceHTML = str_replace( 'data-srcset', 'srcset', $replaceHTML );
					$replaceHTML = str_replace( 'data-sizes', 'sizes', $replaceHTML );

					$replaceHTML = image_add_class( $replaceHTML, 'lazyload' );
					$replaceHTML .= '<noscript>' . $imgHTML . '</noscript>';

					array_push( $search, $imgHTML );
					array_push( $replace, $replaceHTML );
				}
			}

			$html = str_replace( $search, $replace, $html );
		}


		return $html;
	}
}

if ( !function_exists('image_add_class') ) {
    function image_add_class( $htmlString = '', $newClass ) {
		$pattern = '/class="([^"]*)"/';
		// Class attribute set.

		if ( preg_match( $pattern, $htmlString, $matches ) ) {
			$definedClasses = explode( ' ', $matches[1] );
			if ( ! in_array( $newClass, $definedClasses ) ) {
				$definedClasses[] = $newClass;
				$htmlString = str_replace(
					$matches[0],
					sprintf( 'class="%s"', implode( ' ', $definedClasses ) ),
					$htmlString
				);
			}

		// Class attribute not set.
		} else {
			$htmlString = preg_replace( '/(\<.+\s)/', sprintf( '$1class="%s" ', $newClass ), $htmlString );
		}

		return $htmlString;
	}
}

if ( ! function_exists( 'twentynineteen_setup' ) ) :
/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
function twentynineteen_setup() {
    /*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Nineteen, use a find and replace
		 * to change 'twentynineteen' to the name of your theme in all the template files.
		 */
    load_theme_textdomain( 'twentynineteen', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
    add_theme_support( 'title-tag' );

    /*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1568, 9999 );

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus(
        array(
            'main-navigation' => __( 'Primary', 'twentynineteen' ),
            'footer-services' => __( 'Footer Services', 'twentynineteen' ),
            'footer-specialties' => __( 'Footer Specialties', 'twentynineteen' ),
        )
    );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        )
    );

    /**
		 * Add support for core custom logo.
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
    add_theme_support(
        'custom-logo',
        array(
            /*	'height'      => 200,
				'width'       => 600,*/
            'flex-width'  => false,
            'flex-height' => false,
        )
    );

    /* sticky logo */
    function stickylogo($wp_customize) {
        // add a setting
        $wp_customize->add_setting('sticky_logo');
        // Add a control to upload the hover logo
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'sticky_logo', array(
            'label' => 'Sticky Logo',
            'section' => 'title_tagline', //this is the section where the custom-logo from WordPress is
            'settings' => 'sticky_logo',
            'priority' => 8 // show it just below the custom-logo
        )));
    }
    add_action('customize_register', 'stickylogo');

    /* responsive logo*/
    function responsive_logo($wp_customize) {
        // add a setting
        $wp_customize->add_setting('responsive_logo');
        // Add a control to upload the hover logo
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'responsive_logo', array(
            'label' => 'Reponsive Logo',
            'section' => 'title_tagline', //this is the section where the custom-logo from WordPress is
            'settings' => 'responsive_logo',
            'priority' => 9 // show it just below the custom-logo
        )));
    }
    add_action('customize_register', 'responsive_logo');

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for Block Styles.
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images.
    add_theme_support( 'align-wide' );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );

    // Enqueue editor styles.
    add_editor_style( 'style-editor.css' );

    // Add custom editor font sizes.
    add_theme_support(
        'editor-font-sizes',
        array(
            array(
                'name'      => __( 'Small', 'twentynineteen' ),
                'shortName' => __( 'S', 'twentynineteen' ),
                'size'      => 19.5,
                'slug'      => 'small',
            ),
            array(
                'name'      => __( 'Normal', 'twentynineteen' ),
                'shortName' => __( 'M', 'twentynineteen' ),
                'size'      => 22,
                'slug'      => 'normal',
            ),
            array(
                'name'      => __( 'Large', 'twentynineteen' ),
                'shortName' => __( 'L', 'twentynineteen' ),
                'size'      => 36.5,
                'slug'      => 'large',
            ),
            array(
                'name'      => __( 'Huge', 'twentynineteen' ),
                'shortName' => __( 'XL', 'twentynineteen' ),
                'size'      => 49.5,
                'slug'      => 'huge',
            ),
        )
    );

    // Editor color palette.
    add_theme_support(
        'editor-color-palette',
        array(
            array(
                'name'  => __( 'Primary', 'twentynineteen' ),
                'slug'  => 'primary',
                'color' => twentynineteen_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 33 ),
            ),
            array(
                'name'  => __( 'Secondary', 'twentynineteen' ),
                'slug'  => 'secondary',
                'color' => twentynineteen_hsl_hex( 'default' === get_theme_mod( 'primary_color' ) ? 199 : get_theme_mod( 'primary_color_hue', 199 ), 100, 23 ),
            ),
            array(
                'name'  => __( 'Dark Gray', 'twentynineteen' ),
                'slug'  => 'dark-gray',
                'color' => '#111',
            ),
            array(
                'name'  => __( 'Light Gray', 'twentynineteen' ),
                'slug'  => 'light-gray',
                'color' => '#767676',
            ),
            array(
                'name'  => __( 'White', 'twentynineteen' ),
                'slug'  => 'white',
                'color' => '#FFF',
            ),
        )
    );

    // Add support for responsive embedded content.
    add_theme_support( 'responsive-embeds' );
}
endif;
add_action( 'after_setup_theme', 'twentynineteen_setup' );


if (function_exists('add_image_size')) {
    add_image_size('staff-thumb', 400, 450, true);
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentynineteen_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Content Sidebar', 'twentynineteen' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Additional sidebar that appears on the right.', 'twentynineteen' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => __( 'Posts Widget Area', 'twentynineteen' ),
        'id' => 'posts_widgets',
        'description' => __('Appears in the Blog Page of the site.', ' '),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Services Navigation', 'twentynineteen' ),
        'id' => 'footer-services-nav',
        'description' => __('Appears in the footer of the site.', ' '),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Specialties Navigation', 'twentynineteen' ),
        'id' => 'footer-specialties-nav',
        'description' => __('Appears in the footer of the site.', ' '),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer About Navigation', 'twentynineteen' ),
        'id' => 'footer-about-nav',
        'description' => __('Appears in the footer of the site.', ' '),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Healthtips Navigation', 'twentynineteen' ),
        'id' => 'footer-healthtips-nav',
        'description' => __('Appears in the footer of the site.', ' '),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Contact Navigation', 'twentynineteen' ),
        'id' => 'footer-contact-nav',
        'description' => __('Appears in the footer of the site.', ' '),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ) );

}
add_action( 'widgets_init', 'twentynineteen_widgets_init' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width Content width.
 */
function twentynineteen_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'twentynineteen_content_width', 640 );
}
add_action( 'after_setup_theme', 'twentynineteen_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function site_styles() {
    //wp_enqueue_style( 'twentynineteen-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    wp_style_add_data( 'twentynineteen-style', 'rtl', 'replace' );

    if ( has_nav_menu( 'menu-1' ) ) {
        wp_enqueue_script( 'twentynineteen-priority-menu', get_theme_file_uri( '/js/priority-menu.js' ), array(), '1.0', true );
        wp_enqueue_script( 'twentynineteen-touch-navigation', get_theme_file_uri( '/js/touch-keyboard-navigation.js' ), array(), '1.0', true );
    }

    wp_enqueue_style( 'twentynineteen-print-style', get_template_directory_uri() . '/print.css', array(), wp_get_theme()->get( 'Version' ), 'print' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_enqueue_style( 'slick-slider-css', get_theme_file_uri() . '/css/slick.css', array(), wp_get_theme()->get( 'Version' ) );
    wp_enqueue_style( 'fancy-css', get_theme_file_uri() . '/css/jquery.fancybox.min.css', array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'site_styles' );
//add_action( 'get_footer', 'site_styles' );

function site_script() {
    wp_enqueue_script( 'lazysizes' );
    wp_enqueue_script('jquery');
    wp_script_add_data( 'jquery', 'rtl', 'replace' );
    wp_enqueue_script( 'slick-script', get_theme_file_uri() . '/js/slick.min.js', array(), wp_get_theme()->get( 'Version' ) , true );
    wp_enqueue_script( 'matchheight-script', get_theme_file_uri() . '/js/jquery.matchheight.min.js', array(), wp_get_theme()->get( 'Version' ) , true );
    wp_enqueue_script( 'fancy-script', get_theme_file_uri() . '/js/jquery.fancybox.min.js', array(), wp_get_theme()->get( 'Version' ) , true );
    wp_enqueue_script( 'fancy-script', get_theme_file_uri() . '/js/jquery.fancybox.min.js', array(), wp_get_theme()->get( 'Version' ) , true );
    wp_enqueue_script( 'general-script', get_theme_file_uri() . '/js/general.js', array(), wp_get_theme()->get( 'Version' ) , true );
    wp_enqueue_script( 'map-script', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCxpFA4oFr0LaqBIuNiWvXu2wlLS3Zmq_s', array(), wp_get_theme()->get( 'Version' ) , true );
    wp_localize_script( 'general-script', 'frontend_ajax_object',
                       array(
                           'siteurl' => get_template_directory_uri(),
                       )
                      );
}
add_action( 'wp_enqueue_scripts', 'site_script' );

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function twentynineteen_skip_link_focus_fix() {
    // The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
?>
<script>
    /(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
</script>
<?php
}
add_action( 'wp_print_footer_scripts', 'twentynineteen_skip_link_focus_fix' );

/**
 * Enqueue supplemental block editor styles.
 */
function twentynineteen_editor_customizer_styles() {

    wp_enqueue_style( 'twentynineteen-editor-customizer-styles', get_theme_file_uri( '/style-editor-customizer.css' ), false, '1.0', 'all' );

    if ( 'custom' === get_theme_mod( 'primary_color' ) ) {
        // Include color patterns.
        require_once get_parent_theme_file_path( '/inc/color-patterns.php' );
        wp_add_inline_style( 'twentynineteen-editor-customizer-styles', twentynineteen_custom_colors_css() );
    }
}
add_action( 'enqueue_block_editor_assets', 'twentynineteen_editor_customizer_styles' );

/**
 * Display custom color CSS in customizer and on frontend.
 */
function twentynineteen_colors_css_wrap() {

    // Only include custom colors in customizer or frontend.
    if ( ( ! is_customize_preview() && 'default' === get_theme_mod( 'primary_color', 'default' ) ) || is_admin() ) {
        return;
    }

    require_once get_parent_theme_file_path( '/inc/color-patterns.php' );

    $primary_color = 199;
    if ( 'default' !== get_theme_mod( 'primary_color', 'default' ) ) {
        $primary_color = get_theme_mod( 'primary_color_hue', 199 );
    }
?>

<style type="text/css" id="custom-theme-colors" <?php echo is_customize_preview() ? 'data-hue="' . absint( $primary_color ) . '"' : ''; ?>>
    <?php echo twentynineteen_custom_colors_css(); ?>
</style>
<?php
}
add_action( 'wp_head', 'twentynineteen_colors_css_wrap' );

/**
 * SVG Icons class.
 */
require get_template_directory() . '/classes/class-twentynineteen-svg-icons.php';

/**
 * Custom Comment Walker template.
 */
require get_template_directory() . '/classes/class-twentynineteen-walker-comment.php';

/**
 * Enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * SVG Icons related functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Custom template tags for the theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/** ACF Options page Single choice */
/*if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}*/


/* ACF Options page Multiple choices */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'Theme General Options',
        'menu_title'	=> 'Theme options',
        'menu_slug' 	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Header Options',
        'menu_title'	=> 'Header',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Footer Options',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Sidebar Options',
        'menu_title'	=> 'Sidebar',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Social Options',
        'menu_title'	=> 'Social',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme 404 Options',
        'menu_title'	=> '404',
        'parent_slug'	=> 'theme-general-options',
    ));
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Pop up',
        'menu_title'	=> 'General',
        'parent_slug'	=> 'theme-general-options',
    ));
}

/* section wise css */
add_action( 'init', 'action__init' );
function action__init() {

    $min  = ( WP_DEBUG ? '' : '.min' );

    wp_register_script( 'lazysizes/core',        get_theme_file_uri( '/js/lazysizes/lazysizes.core.min.js'        ), array(), '3.0.0' );
    wp_register_script( 'lazysizes/object-fit',  get_theme_file_uri( '/js/lazysizes/lazysizes.object-fit.min.js'  ), array(), '3.0.0' );
    wp_register_script( 'lazysizes/progressive', get_theme_file_uri( '/js/lazysizes/lazysizes.progressive.min.js' ), array(), '3.0.0' );
    wp_register_script( 'lazysizes/respimg',     get_theme_file_uri( '/js/lazysizes/lazysizes.respimg.min.js'     ), array(), '3.0.0' );

    if (
        SCRIPT_DEBUG
        || WP_DEBUG
    )
        wp_register_script(
            'lazysizes',
            null,
            array(
                'lazysizes/core',
                'lazysizes/object-fit',
                'lazysizes/progressive',
                'lazysizes/respimg',
            )
        );
    else
        wp_register_script( 'lazysizes', get_theme_file_uri( '/js/lazysizes/lazysizes.min.js' ), array(), '3.0.0' );

    /* Parts for Welcome */
    //wp_register_style( 'parts-front-banner', get_stylesheet_directory_uri() . '/css/parts/parts-front-banner.css', array( 'twentynineteen-style' ), 'init' );
    //wp_register_style( 'front-welcome', get_stylesheet_directory_uri() . '/assets/css/front-welcome.css', array( 'twentynineteen-style' ), 'init' );
    //wp_register_style( 'parts-front-feature-testimonials', get_stylesheet_directory_uri() . '/css/parts/parts-front-feature-testimonials.css', array( 'twentynineteen-style' ), 'init' );
    //wp_register_style( 'front-service', get_stylesheet_directory_uri() . '/assets/css/front-service.css', array( 'twentynineteen-style' ), 'init' );
    //wp_register_style( 'parts-front-testimonials', get_stylesheet_directory_uri() . '/assets/css/front-testimonials.css', array( 'twentynineteen-style' ), 'init' );
    //wp_register_style( 'parts-front-appointment', get_stylesheet_directory_uri() . '/css/parts/parts-front-appointment.css', array( 'twentynineteen-style' ), 'init' );
    //wp_register_style( 'parts-front-blog', get_stylesheet_directory_uri() . '/css/parts/parts-front-blog.css', array( 'twentynineteen-style' ), 'init' );

    /* inner pages */
    /*wp_register_style( 'page-contact', get_stylesheet_directory_uri() . '/css/parts/page-contact.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'page-location-list', get_stylesheet_directory_uri() . '/css/parts/page-location-list.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'single-location', get_stylesheet_directory_uri() . '/css/single-location.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'page-faq', get_stylesheet_directory_uri() . '/css/parts/page-faq.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'archive-newsletter-page', get_stylesheet_directory_uri() . '/css/archive-newsletter-page.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'archive-workshop-page', get_stylesheet_directory_uri() . '/css/archive-workshop-page.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'page-patient-testmonial', get_stylesheet_directory_uri() . '/css/parts/page-patient-testmonial.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'page-staff', get_stylesheet_directory_uri() . '/css/parts/page-staff.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'taxonomy-body_parts', get_stylesheet_directory_uri() . '/css/taxonomy-body_parts.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'page-ebook', get_stylesheet_directory_uri() . '/css/parts/page-ebook.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'content-patientinfo', get_stylesheet_directory_uri() . '/css/parts/content-patientinfo.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'content-servicessources', get_stylesheet_directory_uri() . '/css/parts/content-servicessources.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'content-accordion-block', get_stylesheet_directory_uri() . '/css/parts/content-accordion-block.css', array( 'twentynineteen-style' ), 'init' );
    wp_register_style( 'page-pt-wired-app', get_stylesheet_directory_uri() . '/css/parts/page-pt-wired-app.css', array( 'twentynineteen-style' ), 'init' );*/

    //wp_enqueue_style( 'sass-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array( 'twentynineteen-style' ), 'init' );

    /* scripts */
    wp_register_script( 'isotop-lib', get_stylesheet_directory_uri() . '/js/isotope.pkgd.min.js', array( 'jquery' ), 'init' );
    wp_register_script( 'isotop-function', get_stylesheet_directory_uri() . '/js/isotop-function.js', array( 'isotop-lib' ), 'init' );

    wp_register_script( 'patient-intake-function', get_stylesheet_directory_uri() . '/js/patient-intake-function.js', array( 'jquery' ), 'init' );
}





/** svg file upload permission */
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Enqueue SVG javascript and stylesheet in admin
 * @author fadupla
 */

function fadupla_svg_enqueue_scripts( $hook ) {
    wp_enqueue_style( 'fadupla-svg-style', get_theme_file_uri( '/css/svg.css' ) );
    wp_enqueue_script( 'fadupla-svg-script', get_theme_file_uri( '/js/svg.js' ), 'jquery' );
    wp_localize_script( 'fadupla-svg-script', 'script_vars',
                       array( 'AJAXurl' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'admin_enqueue_scripts', 'fadupla_svg_enqueue_scripts' );


/**
 * Ajax get_attachment_url_media_library
 * @author fadupla
 */
function fadupla_get_attachment_url_media_library() {

    $url          = '';
    $attachmentID = isset( $_REQUEST['attachmentID'] ) ? $_REQUEST['attachmentID'] : '';
    if ( $attachmentID ) {
        $url = wp_get_attachment_url( $attachmentID );
    }

    echo $url;

    die();
}

add_action( 'wp_ajax_svg_get_attachment_url', 'fadupla_get_attachment_url_media_library' );


/** Admin Logo */
function my_login_logo() { ?>
<style type="text/css">
    #login h1 a, .login h1 a {
        background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/admin-logo.png);
        height:100px;
        width:100%;
        background-size: contain;
        background-repeat: no-repeat;
    }
</style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
    return site_url();
}






function cptui_register_my_cpts() {

    /**
	 * Post Type: Faqs.
	 */

    $labels = array(
        "name" => __( "Faqs" ),
        "singular_name" => __( "FAQ" ),
    );

    $args = array(
        "label" => __( "Faqs" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "faq", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
    );

    register_post_type( "faq", $args );

    /**
	 * Post Type: Conditions.
	 */

    $labels = array(
        "name" => __( "Conditions" ),
        "singular_name" => __( "Condition" ),
    );

    $args = array(
        "label" => __( "Conditions" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => false,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "condition", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
    );

    register_post_type( "condition", $args );

    /**
	 * Post Type: Newsletters.
	 */

    $labels = array(
        "name" => __( "Newsletters" ),
        "singular_name" => __( "Newsletter" ),
    );

    $args = array(
        "label" => __( "Newsletters" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => "newsletters",
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "newsletter", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
    );

    register_post_type( "newsletter", $args );


    /**
	 * Post Type: Testimonials.
	 */

    $labels = array(
        "name" => __( "Testimonials" ),
        "singular_name" => __( "Testimonia" ),
    );

    $args = array(
        "label" => __( "Testimonials" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "testimonial", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail", "excerpt" ),
    );

    register_post_type( "testimonial", $args );

    /**
	 * Post Type: Workshops.
	 */

    $labels = array(
        "name" => __( "Workshops" ),
        "singular_name" => __( "Workshop" ),
    );

    $args = array(
        "label" => __( "Workshops" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => "workshops",
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => true,
        "rewrite" => array( "slug" => "workshops", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
    );

    register_post_type( "workshop", $args );

    /**
	 * Post Type: Locations.
	 */

    $labels = array(
        "name" => __( "Locations" ),
        "singular_name" => __( "Location" ),
    );

    $args = array(
        "label" => __( "Locations" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "location", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
    );

    register_post_type( "location", $args );

    /**
	 * Post Type: Our Staffs.
	 */

    $labels = array(
        "name" => __( "Our Staffs" ),
        "singular_name" => __( "Our Staff" ),
    );

    $args = array(
        "label" => __( "Our Staffs" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => array( "slug" => "our-team", "with_front" => true ),
        "query_var" => true,
        "supports" => array( "title", "editor", "thumbnail" ),
        "taxonomies" => array( "staff_category" ),
    );

    register_post_type( "our_staff", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );

function cptui_register_my_taxes() {

    /**
	 * Taxonomy: Body Parts.
	 */

    $labels = array(
        "name" => __( "Body Parts" ),
        "singular_name" => __( "Body Part" ),
    );

    $args = array(
        "label" => __( "Body Parts" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'body-parts', 'with_front' => true, ),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "body_parts",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => true,
    );
    register_taxonomy( "body_parts", array( "condition" ), $args );

    /**
	 * Taxonomy: Facility Categories.
	 */

    $labels = array(
        "name" => __( "Facility Categories" ),
        "singular_name" => __( "Facility Category" ),
    );

    $args = array(
        "label" => __( "Facility Categories" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => false,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'facility-cat', 'with_front' => false, ),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "facility-cat",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => true,
    );
    register_taxonomy( "facility-cat", array( "ourfacilities" ), $args );

    /**
	 * Taxonomy: Staff Categories.
	 */

    $labels = array(
        "name" => __( "Staff Categories" ),
        "singular_name" => __( "Staff Categories" ),
    );

    $args = array(
        "label" => __( "Staff Categories" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'staff_category', 'with_front' => true, ),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "staff_category",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    );
    register_taxonomy( "staff_category", array( "our_staff" ), $args );

    /**
	 * Taxonomy: Testimonial Categories.
	 */

    $labels = array(
        "name" => __( "Testimonial Categories" ),
        "singular_name" => __( "Testimonial Category" ),
    );

    $args = array(
        "label" => __( "Testimonial Categories" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => array( 'slug' => 'test_cats', 'with_front' => true, ),
        "show_admin_column" => false,
        "show_in_rest" => true,
        "rest_base" => "test_cats",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit" => false,
    );
    register_taxonomy( "test_cats", array( "testimonial" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes' );



/*------------ For Workshop Pagination---------*/
function action__pre_get_posts( $query ){
    if ( !is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'workshop' ) ) {

        $today = date('Ymd');

        $meta = array(
            array(
                'key'   => 'date',
                'compare' => '>=',
                'value'   => $today
            ));

        $query->set( 'meta_query', $meta );
        $query->set( 'posts_per_page', 8 );
    }
}
add_action( 'pre_get_posts', 'action__pre_get_posts' );

function quicklinks_fun() {
    global $formsIcon;
    global $locationIcon;
    global $faqIcon;
    global $humanbodyIcon;


    $menu = '<ul class="side-icon-links">';
    if( have_rows('quick_links','options') ):
    while ( have_rows('quick_links','options') ) : the_row();
    $icon = get_sub_field('select_icon','options');
    $pageUrl = get_sub_field('page_url','options');
    $pageTitle = get_sub_field('page_title','options');
    $newTabOption = get_sub_field('open_in_new_tab','options');
    $menu .=   '<li class="">';
    $menu .= '<a href="' . $pageUrl . '" class="' .  $icon . '" ' . ( $newTabOption == "yes" ? 'target="_blank"' : '' ) . ' >';

    if($icon == "form-icon"){
        $menu .= '<span class="side-menu-icon">' . $formsIcon . '</span>';
    } else if($icon == "location-icon") {
        $menu .= '<span class="side-menu-icon">' . $locationIcon . '</span>';
    } else if($icon == "faq-icon") {
        $menu .= '<span class="side-menu-icon">' . $faqIcon . '</span>';
    } else if($icon == "body-icon") {
        $menu .= '<span class="side-menu-icon">' . $humanbodyIcon . '</span>';
    }
    $menu .= $pageTitle;
    $menu .= '</a>';
    $menu .= '</li>';


    endwhile;

    endif;
    $menu .= '</ul>';
    return $menu;
}
add_shortcode('quicklinks', 'quicklinks_fun');

/*-------------For Sidebar Workshop------------*/
function workshops_fun() {
    $today = date('Ymd');
    $args = array(
        'post_type' => 'workshop',
        'posts_per_page' =>1,
        'order'       => 'ASC',
        'orderby'     => 'meta_value',
        'meta_type'     => 'DATE',
        'meta_key'      => 'date',
        'meta_query' => array(
        array(
        'key'   => 'date',
        'compare' => '>=',
        'value'   => $today
        )),
    );
    $wp_query = new WP_Query($args);
    if(have_posts()) {
    while ( $wp_query->have_posts() ) : $wp_query->the_post();
    $date = get_field('date');
    $date = new DateTime($date);
    $html = '<div class="worskshop-sidebar">' .
            '<div class="workshop-details">' .
                (   get_the_title()
                    ? '<h4><a href="' . get_the_permalink() . '" title="'. get_the_title() .'">' . get_the_title() . '</a></h4>'
                    : ''
                ) .
                (   (get_field('date') || get_field('time') || get_field('location'))
                    ?
                    '<div class="workshop-info">' .
                        (   get_field('date')
                            ? '<span>' . $date->format('F j, Y') . '</span>'
                            : ''
                        ) .
                        (   get_field('time')
                            ? '<span>' . get_field('time') . '</span>'
                            : ''
                        ) .
                        (   get_field('location')
                            ? '<span>' . get_field('location') . '</span>'
                            : ''
                        ) .
                    '</div>'
                    : ''
                ) .
                (   get_field('workshop_link')
                    ? '<a href="' . get_field('workshop_link') .'" class="read-more" target="_blank"><span>REGISTER NOW!</span></a>'
                    : '<a href="' . get_the_permalink() . '" class="read-more"><span>REGISTER NOW!</span></a>'
                ) .

            '</div>';
    endwhile;
    $html .= '</div>';
    }
    return $html;
}
add_shortcode('workshops', 'workshops_fun');


/*-------------For Sidebar Request Appointment------------*/

function reqappointment_fun() {
    $reqImage = get_field('req_appointment_image','options');
    $data = '<div class="reqappointment-sidebar  ">' .
            (
                $reqImage
                ? wp_get_attachment_image( $reqImage , 'large', false, array( 'class' => '' ) )
                : ''
            ) .
            (   (get_field('req_appoinment_title','options') || get_field('req_appointment_cta','options') )
                ? '<div class="appointment-detail ' . ( $reqImage ? '' : 'no-image' ) . ' ">' .
                    (   get_field('req_appoinment_title','options')
                        ? '<h2>' . get_field('req_appoinment_title','options') . '</h2>'
                        : ''
                    ) .
                    (   get_field('req_appointment_url','options')
                        ? '<a href="' . get_field('req_appointment_url','options'). '" class="read-more"><span>' . get_field('req_appointment_cta','options') . '</span></a>'
                        : ''
                    ) .
                '</div>'
                : ''
            ) .
    '</div>';
    return $data;

}
add_shortcode('reqappointment', 'reqappointment_fun');


/*-------------For Sidebar Blog------------*/

function blogs_fun() {
    $blog = '<div class="blog-sidebar">';
       query_posts( array('post_type' => 'post','posts_per_page' => 1, 'orderby' => 'date', 'order' => 'DESC' ) );
        if(have_posts()) {
        while ( have_posts() ) : the_post();

        $blog .= '<div class="blog-block">' .
            ( has_post_thumbnail()
                ? '<div class="blog-image">' . get_the_post_thumbnail() . '</div>'
                : ''
            ) .
            '<div class="blog-content">' .
                /*(   get_field('blog_title','options')
                    ? '<h4>' . get_field('blog_title','options') . '</h4>'
                    : ''
                ) .*/
                (   get_the_title()
                    ? '<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>'
                    : ''
                ) .
                '<a class="read-more" href="' . get_the_permalink() . '"><span>Read More </span></a>' .
            '</div>' .
        '</div>';
        endwhile ; }
        (   get_field('subscribe_form','options')
            ? $blog .= '<div class="subscribe-block">' .
               (   get_field('subscribe_form_title','options')
                    ? '<h3>' . get_Field('subscribe_form_title','options') . '</h3>'
                    : ''
                ) .
                do_shortcode(get_Field('subscribe_form','options')) .
            '</div>'
            : ''
        ) .
    '</div>';
    return $blog;
}
add_shortcode('blogs', 'blogs_fun');

/*-------------For Sidebar Ebook------------*/

function ebook_fun() {
    $ebook = '<div class="ebook-sidebar">' .
        (
            get_field('ebook_image','options')
            ? '<div class="ebook-image">' . wp_get_attachment_image( get_field('ebook_image','options'), 'large', false, array( 'class' => '' ) ) . '</div>'
                : ''
        ) .
        ( (get_field('ebook_title','options') || get_field('ebook_url','options'))
            ? '<div class="ebook-content">' .
                (   get_field('subscribe_form_title','options')
                    ? '<h3>' . get_Field('ebook_title','options') . '</h3>'
                    : ''
                ) .
                (   get_field('ebook_url','options')
                    ? '<a href="' . get_field('ebook_url','options') . '" class="read-more"><span>' . get_field('ebook_cta','options') . '</span></a>'
                    : ''
                ) .
              '</div>'
            : ''
        ) .
    '</div>';
    return $ebook;
    }
add_shortcode('ebook', 'ebook_fun');


function sidebar_review_fun() {
	if( get_field('review_section_script_only','options') ){
		$themeDirectoryPath = '<script src="' . get_stylesheet_directory_uri() . '/js/jquery.mCustomScrollbar.min.js"></script>' .
        '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/css/jquery.mCustomScrollbar.css" />' . get_field('review_section_script_only','options') .
        '<div id="v-review-display-widget-container" class="review-sidebar" style=""></div>' .
        '<style> #v-review-display-widget-container.review-sidebar { width: 100% !important; padding:12px 8px 12px 12px !important; overflow:auto !important;} .mCSB_inside>.mCSB_container {margin-right:24px;}.mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, .mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {background: rgb(37, 40, 105);}</style>';
    return $themeDirectoryPath;
	}
}
add_shortcode('sidebar_review', 'sidebar_review_fun');

function my_special_nav_class( $classes, $item ) {

    if  ( is_singular( 'our_staff' ) && ( $item->title == 'Our Team' || $item->title == 'About Us' ) )
    {
        $classes[] = 'current-menu-item';
    }
    else if ( is_singular('post') && ( $item->title == 'Health Blog' || $item->title == 'Health Tips' ) )
    {
        $classes[] = 'current-menu-item';
    }
    else if ( is_singular('location') && ( $item->title == 'Our Location' || $item->title == 'About Us' ) )
    {
        $classes[] = 'current-menu-item';
    }
    else if ( is_category() && ( $item->title == 'Health Blog' || $item->title == 'Health Tips' ) )
    {
        $classes[] = 'current-menu-item';
    }
    else if ( is_post_type_archive('workshop') && ( $item->title == 'Workshops' || $item->title == 'Health Tips' ) )
    {
        $classes[] = 'current-menu-item';
    }
    else if ( is_post_type_archive('newsletter') && ( $item->title == 'Newsletters' || $item->title == 'Health Tips' ) )
    {
        $classes[] = 'current-menu-item';
    }
    else if ( is_singular('workshop') && ( $item->title == 'Workshops' || $item->title == 'Health Tips' ) )
    {
        $classes[] = 'current-menu-item';
    }
    else if ( is_tax( 'body_parts' ) && ( $item->title == 'View More Conditions' || $item->title == 'Conditions We Treat' ) )
    {
        $classes[] = 'current-menu-item';
    }

    return $classes;
}
add_filter( 'nav_menu_css_class', 'my_special_nav_class', 10, 2 );


/*function max_entries_per_sitemap() {
    return 100;
}
add_filter( 'wpseo_sitemap_entries_per_page', 'max_entries_per_sitemap' );*/


/* Add External Sitemap to Yoast Sitemap Index
 * Credit: Paul https://wordpress.org/support/users/paulmighty/
 * Last Tested: Aug 25 2017 using Yoast SEO 5.3.2 on WordPress 4.8.1
 *********
 * This code adds two external sitemaps and must be modified before using.
 * Replace http://www.example.com/external-sitemap-#.xml
   with your external sitemap URL.
 * Replace 2018-01-30T23:12:27+00:00
   with the time and date your external sitemap was last updated.
   Format: yyyy-MM-dd'T'HH:mm:ssZ
 * If you have more/less sitemaps, add/remove the additional section.
 *********
 * Please note that changes will be applied upon next sitemap update.
 * To manually refresh the sitemap, please disable and enable the sitemaps.
 */
add_filter( 'wpseo_sitemap_index', 'add_sitemap_custom_items' );
function add_sitemap_custom_items() {
   $sitemap_custom_items = '<sitemap><loc>https://herostencil2k19.ythzzv9z-liquidwebsites.com/page-sitemap.xml</loc><lastmod>2017-05-22T23:12:27+00:00</lastmod></sitemap>';

/* DO NOT REMOVE ANYTHING BELOW THIS LINE
 * Send the information to Yoast SEO
 */
return $sitemap_custom_items;
}


/* registering Gutenberg block */
add_action('acf/init', 'my_acf_initpatient');
function my_acf_initpatient() {

    // check function exists
    if( function_exists('acf_register_block') ) {
        // register a patient info block
        acf_register_block(array(
            'name'              => 'patientinfo',
            'title'             => __('Patient Info'),
            'description'       => __('A custom patientinfo block.'),
            'render_callback'   => 'my_acf_block_render_callback_function',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'patientinfo', 'quote' ),
        ));

        // register a services sources block
        acf_register_block(array(
            'name'              => 'servicessources',
            'title'             => __('Services Sources'),
            'description'       => __('A custom Services Sources Links block.'),
            'render_callback'   => 'my_acf_block_render_callback_function',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'servicessources', 'services' ),
        ));

        // register a patient intake script block
        acf_register_block(array(
            'name'              => 'patient-intake-form',
            'title'             => __('patient Intake Form'),
            'description'       => __('A custom Patient Intake Script Links block.'),
            'render_callback'   => 'my_acf_block_render_callback_function',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'patient intake', 'intake' ),
        ));

        // register a accordion script block
        acf_register_block(array(
            'name'              => 'accordion-block',
            'title'             => __('Accordion Block'),
            'description'       => __('A custom Accordion Script block.'),
            'render_callback'   => 'my_acf_block_render_callback_function',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array('accordion-block', 'accordion'),
        ));
    }
}

function my_acf_block_render_callback_function( $block ) {
    $slug = str_replace('acf/', '', $block['name']);
    if( file_exists( get_theme_file_path("/template-parts/block/content-{$slug}.php") ) ) {
        include( get_theme_file_path("/template-parts/block/content-{$slug}.php") );
    }
}

/* hex code to rgba converter */
function hex2rgb( $colour ) {
        if ( $colour[0] == '#' ) {
                $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
    return $r . ',' . $g . ',' . $b ;
        //return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/* feature image overlay for top banner position */
function featureImageOverlay(){
    $gradOverlayCondition = get_field('do_you_want_to_add_gradient_overlay_on_feature_image','options');
    if( "yes" == $gradOverlayCondition ){
        $gradProperties = get_field('set_gradient_properties','options');
        $gradDir = $gradProperties['gradient_direction'];
        $gradColor1 = $gradProperties['gradient_top__left_color'];
        $gradColor2 = $gradProperties['gradient_bottom__right_color'];
        $gradOpacity1 = $gradProperties['left_top_overlay_opacity'];
        $gradOpacity2 = $gradProperties['bottom_right_overlay_opacity'];
        $rgb1 = hex2rgb( $gradColor1 ) . ' , ' . $gradOpacity1;
        $rgb2 = hex2rgb( $gradColor2 ) . ' , ' . $gradOpacity2;
        return '<span class="overlay" style="background-image:linear-gradient(' . $gradDir . ', rgba(' . $rgb1 . '), rgba(' . $rgb2 . '))"></span>';
    }
}
 /* Additonal Column for workshop date*/
 function set_custom_columns_to_cpt($columns) {
    $columns['workshop_date'] = __( 'Workshop Date', 'twentynineteen' );
    return $columns;
}
add_filter( 'manage_workshop_posts_columns', 'set_custom_columns_to_cpt' );

function custom_column_data( $column, $post_id ) {
    switch ( $column ) {
        case 'workshop_date' :
            $workshop_date = get_field('date');
            $workshop_date_obj = new DateTime($workshop_date);

            if ( is_string( $workshop_date ) )
                echo $workshop_date_obj->format('j M Y');
            else
                _e( 'Unable to get data', 'twentynineteen' );
            break;

    }
}
add_action( 'manage_workshop_posts_custom_column' , 'custom_column_data', 10, 2 );


add_filter('the_posts', 'show_future_posts');

function show_future_posts($posts)
{
   global $wp_query, $wpdb;

   if(is_single() && $wp_query->post_count == 0)
   {
      $posts = $wpdb->get_results($wp_query->request);
   }

   return $posts;
}

/* contact details in privacy page and terms of use page */
function contact_details() {
    $contactDetails = '';
    $argsContactDetails = array(
        'post_type' => 'location',
        'posts_per_page' => -1
    );
    $obituary_queryContactDetails = new WP_Query($argsContactDetails);
    if ($obituary_queryContactDetails->have_posts()) {
        $contactDetails .= '<div class="contact-details-sec">' . '<ul>';
        while ($obituary_queryContactDetails->have_posts()) : $obituary_queryContactDetails->the_post();
            $customTitle = get_field('custom_title');
            $locAddress = get_field('location_address');
            $phoneNumber = get_field('phone_number');
            $faxNumber = get_field('fax_number');
            $locEmailAddress = get_field('location_email');
            $contactDetails .= '<li>';
            $contactDetails .= ( $customTitle ? '<h5>' . $customTitle . '</h5>' : '' ) .
            ( $locAddress ? '<p>' . $locAddress . '</p>' : '' ) .
            (
                $phoneNumber || $faxNumber || $locEmailAddress
                ? '<p>' .
                    ( $phoneNumber ? '<strong>Phone: </strong>' . '<a href="tel:' . preg_replace("/[^0-9]/", '' , $phoneNumber ) . '">' . $phoneNumber . '</a><br>' : '' ) .
                    ( $faxNumber ? '<strong>Fax: </strong>' . '<a href="' . $faxNumber . '">' . $faxNumber . '</a><br>' : '' ) .
                    ( $locEmailAddress ? '<strong>Email: </strong>' . '<a href="mailto:' . $locEmailAddress . '">' . $locEmailAddress . '</a><br>' : '' ) .
                '</p>'
                : ''
            );
            $contactDetails .= '</li>';
        endwhile;
        wp_reset_postdata();
        wp_reset_query();
        $contactDetails .= '</ul>' . '</div>';
        return $contactDetails;
    }
}
add_shortcode('contact-details', 'contact_details');

/* site url for terms of use and privacy policy page */
function siteUrlFunction(){
	$siteUrlHtml = '<a class="link" href="' . site_url() . '">' . get_bloginfo( 'name' ) . '</a>';
	return $siteUrlHtml;
}
add_shortcode('site-url', 'siteUrlFunction');

/* site name for terms of use and privacy policy page */
function siteNameFunction(){
	$siteNameHTML = get_bloginfo( 'name' );
	return $siteNameHTML;
}
add_shortcode('site-name', 'siteNameFunction');

/* privacy policy for terms of use */
function privacyPolicyUrl( $atts, $content = null ){
	$privacyPolicyHTML = '<a class="link" href="' . site_url() . '/privacy-policy">' . $content . '</a>';
	return $privacyPolicyHTML;
}
add_shortcode('privacy-policy', 'privacyPolicyUrl');

/* state name for terms of use page */
function siteTermsState() {
	$stateHtml = get_field( 'terms_of_use_state', 'options' );
	if( $stateHtml ){
		return $stateHtml;
	}
}
add_shortcode('state-name', 'siteTermsState');

/*
 * Register the new merge tag class on the `ninja_forms_loaded` hook.
 */
/*
add_action( 'ninja_forms_loaded', 'my_register_merge_tags' );
function my_register_merge_tags(){
  require_once 'class.mergetags.php';
  Ninja_Forms()->merge_tags[ 'my_merge_tags' ] = new My_MergeTags();
}*/
/*
class My_MergeTags extends NF_Abstracts_MergeTags
{

   // The $id property should match the array key where the class is registered.

  protected $id = 'my_merge_tags';

  public function __construct()
  {
    parent::__construct();

    /* Translatable display name for the group.
    $this->title = __( 'My Merge Tags', 'ninja-forms' );

    /* Individual tag registration.
    $this->merge_tags = array(

        'foo' => array(
          'id' => 'foo',
          'tag' => '{my:foo}', // The tag to be  used.
          'label' => __( 'Foo', 'my_plugin' ), // Translatable label for tag selection.
          'callback' => 'foo' // Class method for processing the tag. See below.
      ),
    );


    // Use the `init` and `admin_init` hooks for any necessary data setup that relies on WordPress.
    // See: https://codex.wordpress.org/Plugin_API/Action_Reference

    add_action( 'init', array( $this, 'init' ) );
    add_action( 'admin_init', array( $this, 'admin_init' ) );
  }

  // public function init(){ /* This section intentionally left blank. }
  // public function admin_init(){ /* This section intentionally left blank.}


  // The callback method for the {my:foo} merge tag.
  // @return string

  public function foo()
  {
    // Do stuff here.
    return 'bar';
  }
}*/
