<?php
/**
 * Header Sidebar Template
 *
 * Displays widgets for the Header dynamic sidebar if any have been added to the sidebar through the 
 * widgets screen in the admin by the user.  Otherwise, nothing is displayed.
 *
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license	docs/license.txt
 * @since 1.0
 */

if ( is_active_sidebar( 'header' ) ) : // Check, if header sidebar at least has one widget ?>

	<?php 
		// Action hook for placing content before opening #sidebar-header
		do_action( 'skyfall_sidebar_header_before' ); 
	?>

	<aside id="sidebar-header" class="sidebar sidebar-header">

		<?php 
			// Action hook for placing content before header sidebar
			do_action( 'skyfall_sidebar_header_open' ); 
		?>

			<?php 
				// Calls each of the active widgets in header sidebar
				dynamic_sidebar( 'header' ); 
			?>

		<?php 
			// Action hook for placing content after header sidebar
			do_action( 'skyfall_sidebar_header_close' ); 
		?>

	</aside><!-- #sidebar-header .aside -->

	<?php 
		// Action hook for placing content after closing #sidebar-header
		do_action( 'skyfall_sidebar_header_after' ); 
	?>

<?php endif; ?>