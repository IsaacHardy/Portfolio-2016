<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package pulse
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary hs-sidebar" class="widget-area hs-sidebar col-md-3 col-sm-4" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
