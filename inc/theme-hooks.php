<?php
/**
 * Theme hooks.
 *
 * @package WPNepal_Blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wpnepal_blog_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'wpnepal_blog_body_classes' );

/**
 * Add go to top.
 *
 * @since 1.0
 */
function wpnepal_blog_add_go_to_top() {

	echo '<a href="#" class="scrollup" id="btn-scrollup"><span class="genericon genericon-collapse"></span></a>';

}
add_action( 'wp_footer', 'wpnepal_blog_add_go_to_top' );

/**
 * Add go to top.
 *
 * @since 1.0
 */
function wpnepal_blog_add_custom_header() {

	$custom_header_status = apply_filters( 'wpnepal_blog_filter_custom_header_status', false );
	if ( true !== $custom_header_status ) {
		return;
	}
	?>
	<section class="head-img" style="background-image: url(<?php echo esc_url( get_header_image() ); ?>" >
		<?php $wpnepal_blog_custom_header_tagline = get_theme_mod( 'wpnepal_blog_custom_header_tagline', __( 'The future will be better tomorrow.', 'wpnepal-blog' ) ); ?>
		<?php if ( ! empty( $wpnepal_blog_custom_header_tagline ) ) : ?>
			<div class="head-titlecontainer">
				<div class="head-title"><?php echo esc_html( $wpnepal_blog_custom_header_tagline ); ?></div><!-- .head-title -->
			</div><!-- .head-titlecontainer -->
		<?php endif; ?>
	</section>
	<?php

}
add_action( 'wpnepal_blog_action_custom_header', 'wpnepal_blog_add_custom_header' );

/**
 * Status of custom header
 *
 * @since 1.0.0
 * @param bool $status Status.
 * @return bool Modified status.
 */
function wpnepal_blog_check_custom_header_status( $status ) {

	if ( ! get_header_image() ) {
		$status = false;
	} else {
		global $post, $wp_query;

		// Custom header status.
		$wpnepal_blog_custom_header_status = get_theme_mod( 'wpnepal_blog_custom_header_status', 'entire-site' );

		// Get Page ID outside Loop.
		$page_id = $wp_query->get_queried_object_id();

		// Front page displays in Reading Settings.
		$page_on_front  = absint( get_option( 'page_on_front' ) );
		$page_for_posts = absint( get_option( 'page_for_posts' ) );

		switch ( $wpnepal_blog_custom_header_status ) {
			case 'entire-site':
				$status = true;
				break;

			case 'entire-site-except-blog':
				$status = true;
			    if ( 'posts' === get_option( 'show_on_front' ) && is_front_page() ) {
					$status = false;
			    }
			    if ( $page_for_posts === $page_id && $page_for_posts > 0 ) {
					$status = false;
			    }
				break;

			case 'disabled':
				$status = false;
				break;

			case 'home-page':
			    if ( $page_on_front === $page_id && $page_on_front > 0 ) {
					$status = true;
			    }
				break;

			default:
				break;
		}
	}
	return $status;

}

add_filter( 'wpnepal_blog_filter_custom_header_status', 'wpnepal_blog_check_custom_header_status' );

/**
 * Add custom style.
 *
 * @since 1.0.0
 */
function wpnepal_blog_add_custom_styling() {

	$css = '';

	// Default color.
	$wpnepal_blog_default_color = get_theme_mod( 'wpnepal_blog_default_color' );
	if ( ! empty( $wpnepal_blog_default_color ) ) {
		$css .= 'body{color:' . esc_attr( $wpnepal_blog_default_color ) . ';}';
	}

	// Link color.
	$wpnepal_blog_link_color = get_theme_mod( 'wpnepal_blog_link_color' );
	if ( ! empty( $wpnepal_blog_link_color ) ) {
		$css .= 'a,a:visited,.posted-on a,.cat-links a,.tags-links a,.author a,.comments-link a,.nav-links .nav-previous a,.nav-links .nav-next a, .widget ul li a,.edit-link a{color:' . esc_attr( $wpnepal_blog_link_color ) . ';}';
	}

	// Link hover color.
	$wpnepal_blog_link_hover_color = get_theme_mod( 'wpnepal_blog_link_hover_color' );
	if ( ! empty( $wpnepal_blog_link_hover_color ) ) {
		$css .= 'a:hover, a:focus, a:active, .site-title a:hover, .site-title a:focus, .main-navigation a:hover, .nav-links .nav-previous a:hover, .nav-links .nav-previous a:focus, .nav-links .nav-next a:hover, .nav-links .nav-next a:focus, .posted-on a:hover, .cat-links a:hover, .tags-links a:hover, .author a:hover, .comments-link a:hover, .edit-link a:hover, .edit-link a:focus, .widget ul li a:hover, .widget ul li a:focus, .widget ul li a:active{color:' . esc_attr( $wpnepal_blog_link_hover_color ) . ';}';
	}

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'wpnepal-blog-style', $css );
	}

}
add_action( 'wp_enqueue_scripts', 'wpnepal_blog_add_custom_styling', 20 );

if ( ! function_exists( 'wpnepal_blog_header_style' ) ) :

	/**
	 * Styles the header image and text displayed on the blog.
	 */
	function wpnepal_blog_header_style() {

		$header_text_color = get_header_textcolor();
		$default_header_text_color = get_theme_support( 'custom-header', 'default-text-color' );

		/*
		 * If no custom options for text are set, let's bail.
		 */
		if ( $default_header_text_color === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
			// Has the text been hidden?
		if ( ! display_header_text() ) :
		?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
		<?php
		// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php

	}
endif;
