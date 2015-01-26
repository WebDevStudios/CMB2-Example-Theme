<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage CMB2_Example_Theme
 * @since 1.0
 */
?>
<div id="secondary" class="secondary">

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="widget-area" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- .widget-area -->
<?php endif; ?>

</div><!-- .secondary -->