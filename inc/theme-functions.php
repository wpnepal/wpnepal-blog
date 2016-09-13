<?php
/**
 * Theme helper functions.
 *
 * @package WPNepal_Blog
 */

if ( ! function_exists( 'wpnepal_blog_fonts_url' ) ) :
	/**
	 * Register Google fonts.
	 *
	 * @since 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function wpnepal_blog_fonts_url() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/*
         * Translators: If there are characters in your language that are not supported
         * by Montserrat, translate this to 'off'. Do not translate into your own language.
         */
		if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'wpnepal-blog' ) ) {
			$fonts[] = 'Montserrat:400italic,700italic,400,700';
		}

		/*
         * Translators: If there are characters in your language that are not supported
         * by Lato, translate this to 'off'. Do not translate into your own language.
         */
		if ( 'off' !== _x( 'on', 'Lato font: on or off', 'wpnepal-blog' ) ) {
			$fonts[] = 'Lato:400italic,700italic,400,700';
		}

		/*
         * Translators: To add an additional character subset specific to your language,
         * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
         */
		$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'wpnepal-blog' );

		if ( 'cyrillic' === $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		} elseif ( 'greek' === $subset ) {
			$subsets .= ',greek,greek-ext';
		} elseif ( 'devanagari' === $subset ) {
			$subsets .= ',devanagari';
		} elseif ( 'vietnamese' === $subset ) {
			$subsets .= ',vietnamese';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;


if ( ! function_exists( 'wpnepal_blog_primary_navigation_fallback' ) ) :

	/**
	 * Fallback for primary navigation.
	 *
	 * @since 1.0
	 */
	function wpnepal_blog_primary_navigation_fallback() {
		echo '<ul>';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'wpnepal-blog' ) . '</a></li>';
		wp_list_pages( array(
			'title_li' => '',
			'depth'    => 1,
		) );
		echo '</ul>';

	}

endif;
