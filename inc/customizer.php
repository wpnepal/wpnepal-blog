<?php
/**
 * WPNepal Blog Theme Customizer.
 *
 * @package WPNepal_Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wpnepal_blog_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->add_setting( 'wpnepal_blog_custom_header_status',
		array(
		'default'           => 'entire-site',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wpnepal_blog_sanitize_select',
		)
	);
	$wp_customize->add_control( 'wpnepal_blog_custom_header_status',
		array(
		'label'    => __( 'Enable On', 'wpnepal-blog' ),
		'section'  => 'header_image',
		'type'     => 'select',
		'priority' => 100,
		'choices'  => array(
			'disabled'                => __( 'Disabled', 'wpnepal-blog' ),
			'entire-site'             => __( 'Entire Site', 'wpnepal-blog' ),
			'entire-site-except-blog' => __( 'Entire Site Except Blog Index Page', 'wpnepal-blog' ),
			'home-page'               => __( 'Static front page only', 'wpnepal-blog' ),
			),
		)
	);

	$wp_customize->add_setting( 'wpnepal_blog_custom_header_tagline',
		array(
		'default'           => __( 'The future will be better tomorrow.', 'wpnepal-blog' ),
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control( 'wpnepal_blog_custom_header_tagline',
		array(
		'label'    => __( 'Header Tagline', 'wpnepal-blog' ),
		'section'  => 'header_image',
		'type'     => 'text',
		'priority' => 100,
		)
	);

	// Colors.
	// Default color.
	$wp_customize->add_setting( 'wpnepal_blog_default_color',
		array(
		'default'           => '#565656',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wpnepal_blog_sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
		$wp_customize,
		'wpnepal_blog_default_color',
		array(
			'label'      => __( 'Default Color', 'wpnepal-blog' ),
			'section'    => 'colors',
			'settings'   => 'wpnepal_blog_default_color',
		) )
	);

	// Link color.
	$wp_customize->add_setting( 'wpnepal_blog_link_color',
		array(
		'default'           => '#919191',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wpnepal_blog_sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
		$wp_customize,
		'wpnepal_blog_link_color',
		array(
			'label'      => __( 'Link Color', 'wpnepal-blog' ),
			'section'    => 'colors',
			'settings'   => 'wpnepal_blog_link_color',
		) )
	);

	// Link hover color.
	$wp_customize->add_setting( 'wpnepal_blog_link_hover_color',
		array(
		'default'           => '#000000',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wpnepal_blog_sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
		$wp_customize,
		'wpnepal_blog_link_hover_color',
		array(
			'label'      => __( 'Link Hover Color', 'wpnepal-blog' ),
			'section'    => 'colors',
			'settings'   => 'wpnepal_blog_link_hover_color',
		) )
	);

	// Partial implementation.
	if ( isset( $wp_customize->selective_refresh ) ) {

		// Site title.
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'            => '.site-title a',
			'container_inclusive' => false,
			'render_callback'     => 'wpnepal_blog_customize_partial_blogname',
		) );

		// Site tagline.
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'            => '.site-description',
			'container_inclusive' => false,
			'render_callback'     => 'wpnepal_blog_customize_partial_blogdescription',
		) );

		// Header tagline.
		$wp_customize->get_setting( 'wpnepal_blog_custom_header_tagline' )->transport         = 'postMessage';
		$wp_customize->selective_refresh->add_partial( 'headertagline', array(
			'selector'            => '.head-img .head-title',
			'container_inclusive' => false,
			'settings'            => array( 'wpnepal_blog_custom_header_tagline' ),
			'render_callback'     => 'wpnepal_blog_customize_partial_header_tagline',
		) );

	}

}

add_action( 'customize_register', 'wpnepal_blog_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wpnepal_blog_customize_preview_js() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'wpnepal-blog-customizer', get_template_directory_uri() . '/js/customizer' . $min . '.js', array( 'customize-preview' ), '1.1.0', true );

}
add_action( 'customize_preview_init', 'wpnepal_blog_customize_preview_js' );

if ( ! function_exists( 'wpnepal_blog_sanitize_select' ) ) :

	/**
	 * Sanitize select.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	function wpnepal_blog_sanitize_select( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

	}

endif;

if ( ! function_exists( 'wpnepal_blog_sanitize_hex_color' ) ) :

	/**
	 * Sanitize hex color.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	function wpnepal_blog_sanitize_hex_color( $input, $setting ) {

		// Sanitize input.
		$input = sanitize_hex_color( $input );

		// If $input is a valid hex value, return it; otherwise, return the default.
		return ( $input ? $input : $setting->default );

	}

endif;

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.1.0
 *
 * @return void
 */
function wpnepal_blog_customize_partial_blogname() {

	bloginfo( 'name' );

}

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.1.0
 *
 * @return void
 */
function wpnepal_blog_customize_partial_blogdescription() {

	bloginfo( 'description' );

}

/**
 * Render the header tagline for the selective refresh partial.
 *
 * @since 1.1.0
 *
 * @return void
 */
function wpnepal_blog_customize_partial_header_tagline() {

	echo esc_html( get_theme_mod( 'wpnepal_blog_custom_header_tagline' ) );

}
