<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage CMB2_Example_Theme
 * @since 1.0
 */
?>

	</div><!-- .site-content -->

	<?php get_sidebar(); ?>

	<div class="cf"></div>

	<?php
	$footer_widget_areas = absint( cmb2_example_theme_get_option( 'footer_widget_areas' ) );
	if( $footer_widget_areas ) :
		$widget_area_width = 100 / $footer_widget_areas;
		?>
		<footer id="footer-widgets" class="footer-widget-areas">
		<?php for( $i = 1; $i <= $footer_widget_areas; $i++ ): ?>
			<div class="footer-widget-area" role="complementary" style="width: <?php echo $widget_area_width; ?>%;">
				<?php dynamic_sidebar( 'footer-' . $i ); ?>
			</div><!-- .widget-area -->
		<?php endfor; ?>
		<div class="cf"></div>
		</footer>
	<?php endif; ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'cmb2-example-theme' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'cmb2-example-theme' ), 'WordPress' ); ?></a>
			and
			<a href="<?php echo esc_url( __( 'https://github.com/WebDevStudios/CMB2', 'cmb2-example-theme' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'cmb2-example-theme' ), 'CMB2' ); ?></a>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
