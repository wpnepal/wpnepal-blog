<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WPNepal_Blog
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="footer-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'wpnepal-blog' ); ?>">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'footer',
						'menu_class'     => 'footer-menu',
						'depth'          => 1,
					 ) );
				?>
			</nav><!-- .footer-navigation -->
		<?php endif; ?>

		<div class="copyright">
			<p><?php esc_attr_e( 'Copyright &copy;', 'wpnepal-blog' ); ?>&nbsp;<?php echo date_i18n( 'Y' ); ?>&nbsp;<?php printf( '<a class="site-link" href="%s" rel="home">%s</a>', esc_url( home_url( '/' ) ), get_bloginfo( 'name' ) ); ?></p>
		</div><!-- .copyright -->
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'wpnepal-blog' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'wpnepal-blog' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( '%1$s by %2$s', 'wpnepal-blog' ), 'WPNepal Blog', 'WP Nepal' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
