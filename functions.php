<?php
/**
 * WPNepal Blog functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WPNepal_Blog
 */

if ( ! function_exists( 'wpnepal_blog_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wpnepal_blog_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'wpnepal-blog' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'wpnepal-blog' ),
			'footer'  => esc_html__( 'Footer Menu', 'wpnepal-blog' ),
			'social'  => esc_html__( 'Social Menu', 'wpnepal-blog' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'wpnepal_blog_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Set up the WordPress core custom header feature.
		add_theme_support( 'custom-header', apply_filters( 'wpnepal_blog_custom_header_args', array(
			'default-image'      => get_template_directory_uri() . '/images/header-image.png',
			'default-text-color' => '#565656',
			'width'              => 1170,
			'height'             => 450,
			'flex-height'        => true,
			'header-text'        => true,
			'wp-head-callback'   => 'wpnepal_blog_header_style',
		) ) );

		// Register default custom header image.
		register_default_headers( array(
			'enjoy-nature' => array(
			'url'           => '%s/images/header-image.png',
			'thumbnail_url' => '%s/images/header-image.png',
			'description'   => _x( 'Nature', 'header image description', 'wpnepal-blog' ),
			),
		) );

		/*
		 * Enable support for custom logo.
		 */
		add_theme_support( 'custom-logo' );

		/*
		 * Enable support for selective refresh of widgets in Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

	}
endif;
add_action( 'after_setup_theme', 'wpnepal_blog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpnepal_blog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wpnepal_blog_content_width', 806 );
}
add_action( 'after_setup_theme', 'wpnepal_blog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpnepal_blog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wpnepal-blog' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'wpnepal-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wpnepal_blog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wpnepal_blog_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'wpnepal-blog-google-fonts', wpnepal_blog_fonts_url(), array(), null );

	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/third-party/genericons/genericons' . $min . '.css', array(), '3.4.1' );

	wp_enqueue_style( 'wpnepal-blog-style', get_stylesheet_uri(), array(), '1.1.2' );

	wp_enqueue_script( 'wpnepal-blog-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $min . '.js', array(), '20151215', true );

	wp_enqueue_script( 'wpnepal-blog-custom', get_template_directory_uri() . '/js/custom' . $min . '.js', array( 'jquery' ), '1.1.0', true );

	wp_localize_script( 'wpnepal-blog-custom', 'WPNepalBlogScreenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'wpnepal-blog' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'wpnepal-blog' ) . '</span>',
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'wpnepal_blog_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom theme functions.
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Theme hooks.
 */
require get_template_directory() . '/inc/theme-hooks.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
