<?php
/**
 * Primary Sidebar Template
 *
 * Displays widgets for the Primary dynamic sidebar if any have been added to the sidebar through the 
 * widgets screen in the admin by the user.  Otherwise, nothing is displayed.
 *
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license docs/license.txt
 * @since 1.0
 */

if ( is_active_sidebar( 'primary' ) ) : // Check, if primary sidebar at least has one widget ?>

	<?php 
		// Action hook for placing content before opening #sidebar-primary
		do_action( 'skyfall_sidebar_primary_before' ); 
	?>

	<aside id="sidebar-primary" class="sidebar sidebar-primary" role="complementary">

		<?php 
			// Action hook for placing content before primary sidebar
			do_action( 'skyfall_sidebar_primary_open' ); 
		?>

			<?php 
				// Calls each of the active widgets in primary sidebar
				dynamic_sidebar( 'primary' ); 
			?>

		<?php 
			// Action hook for placing content after primary sidebar
			do_action( 'skyfall_sidebar_primary_close' ); 
		?>

	</aside><!-- #sidebar-primary .sidebar -->

	<?php 
		// Action hook for placing content after closing #sidebar-primary
		do_action( 'skyfall_sidebar_primary_after' ); 
	?>

<?php endif; ?>