<?php
/**
 * Primary Menu Template
 *
 * Displays the Primary Menu if it has active menu items.
 *
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license	docs/license.txt
 * @since 1.0
 */

if ( has_nav_menu( 'primary' ) ) : ?>

	<section class="header-navigation">

		<?php 
			// Action hook for placing content before opening menu container
			do_action( 'skyfall_menu_primary_before' ); 
		?>

			<div class="container">

				<?php
					// Action hook for placing content before the menu
					do_action( 'skyfall_menu_primary_open' ); 
				?>

					<nav class="menu-primary-container" role="navigation">

						<?php 
							wp_nav_menu( 
								array( 
									'theme_location'	=> 'primary', 
									'container'			=> false,
									'menu_class'		=> 'menu-primary no-list-style', 
									'menu_id'			=> ''
								) 
							); 
						?>

					</nav><!-- .container .primary-navigation -->

				<?php 
					// Action hook for placing content after the menu
					do_action( 'skyfall_menu_primary_close' ); 
				?>

			</div><!-- .container -->

		<?php 
			// Action hook for placing content after closing menu container
			do_action( 'skyfall_menu_primary_after' ); 
		?>
		
	</section><!-- .header-navigation -->

<?php endif; ?>