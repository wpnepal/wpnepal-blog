<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPNepal_Blog
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wpnepal-blog' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="head-inner">
			<div class="site-branding">
				<?php wpnepal_blog_the_custom_logo(); ?>
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif; ?>

				<?php $description = get_bloginfo( 'description', 'display' ); ?>
				<?php if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->
			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<div class="header-widget">
					<nav id="social-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Menu', 'wpnepal-blog' ); ?>">
						<?php
						wp_nav_menu( array(
							'theme_location'  => 'social',
							'menu_class'      => 'social-links',
							'container_class' => 'social-section',
							'depth'           => 1,
							'fallback_cb'     => false,
							'link_before'     => '<span class="screen-reader-text">',
							'link_after'      => '</span>',
							) );
							?>
					</nav><!-- #social-navigation -->
				</div><!-- .header-widget -->
			<?php endif; ?>

		</div><!-- .head-inner -->

		<button id="menu-toggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="genericon genericon-menu"></span></button>

		<div id="site-header-menu" class="site-header-menu">
			<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'wpnepal-blog' ); ?>">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'     => 'primary-menu',
						'fallback_cb'    => 'wpnepal_blog_primary_navigation_fallback',
					) );
				?>
			</nav><!-- #site-navigation -->
		</div><!-- site-header-menu -->
		<?php do_action( 'wpnepal_blog_action_custom_header' ); ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
