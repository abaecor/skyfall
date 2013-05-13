<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license docs/license.txt
 * @since 1.0
 */
?>
			</div><!-- .container -->

			<?php 
				// Action hook for placing content before closing #main
				do_action( 'skyfall_main_close' ); 
			?>

		</div><!-- #main .site-main -->

		<?php 
			// Action hook for placing content after closing #main
			do_action( 'skyfall_main_after' ); 
		?>

		<footer id="footer" class="site-footer" role="contentinfo">

			<?php 
				// Action hook for placing content before the theme footer content
				do_action( 'skyfall_footer_open' ); 
			?>

				<div class="container">

					<div class="footer-content">
						<?php echo apply_atomic_shortcode( 'footer_content', '<p class="credit">' . __( 'Copyright &copy; [the-year] [site-link]. Powered by [wp-link] and [theme-link]', 'skyfall' ) . '</p>' ); ?>
					</div><!-- .footer-content -->

					<?php 
						// Action hook for placing content inside the theme footer content
						do_action( 'skyfall_footer' ); 
					?>

				</div><!-- .container -->

			<?php 
				// Action hook for placing content after the theme footer content
				do_action( 'skyfall_footer_close' ); 
			?>

		</footer><!-- #footer -->

		<?php 
			// Action hook for placing content after closing #footer
			do_action( 'skyfall_footer_after' ); 
		?>

	</div> <!-- #page .site -->	

	<?php 
		// Action hook for placing content after closing #page
		do_action( 'skyfall_body_close' ); 
	?>		

<?php 
	// wp_footer
	wp_footer(); 
?>

</body>
</html>