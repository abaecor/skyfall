<?php
/**
 * Template Name: Blog
 *
 * Description: A Page Template for displaying blog or most recent posts
 *
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license docs/license.txt
 * @since 1.0
 *
 */

// Loads the header.php template
get_header(); 
?>

 	<?php 
 		// Action hook for placing content before opening #primary
 		do_action( 'skyfall_content_before' ); 
 	?>
 		
	<div id="primary" class="site-content <?php skyfall_content_class(); ?>">
		
		<?php 
			// Action hook for placing content before opening #content
			do_action( 'skyfall_content_open' ); 
		?>
		
		<div id="content" class="content hfeed" role="main">
			
			<?php 
				// Loads the loop-meta.php template
				get_template_part( 'loop', 'meta' ); 
			?>
			
			<?php
		  	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		  	
	        $args = array(
                'paged' => $paged,
				'post_type' => 'post',
				'post_status' => 'publish'
	        );

	        $wp_query = new WP_Query( $args );

			if ( $wp_query->have_posts() ) : ?>

				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

					<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

						<?php 
							// Action hook for placing content after opening post content
							do_action( 'skyfall_entry_open' ); 
						?>

						<?php if( has_post_thumbnail() ) { ?>

							<figure class="hmedia">
								<?php
									$image = get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'full', 'format' => 'array' ) );
									
									$layout = theme_layouts_get_layout();
									$size = '';
									if( 'layout-1c-full' == $layout )
										$size = 'skyfall-blog-full';
									else
										$size = 'skyfall-blog';
								?>
								<?php if( !empty( $image['src'] ) ) { ?>
									<a href="<?php echo $image['src']; ?>" class="overlay" rel="prettyPhoto">
										<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => $size, 'image_class' => 'photo', 'link_to_post' => false ) ); ?>
									</a>
								<?php } ?>
							</figure>

						<?php } ?>

						<div class="entry">

							<header class="entry-header">
								<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); // Post title ?>
							</header><!-- .entry-header -->

							<div class="entry-container">

								<div class="entry-summary">
									<?php the_excerpt(); ?>
									<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'skyfall' ), 'after' => '</p>' ) ); ?>
								</div><!-- .entry-summary -->

							</div><!-- .entry-container -->

							<?php 
								echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-published] &middot; [entry-author] &middot; [entry-terms taxonomy="category" before="Posted in "] &middot; [entry-terms before="Tagged "]', 'skyfall' ) . '</div><!-- .entry-meta -->' ); 
							?>
						
						</div><!-- .entry -->

						<?php 
							// Action hook for placing content before closing post content
							do_action( 'skyfall_entry_close' ); 
						?>

					</article><!-- #post-<?php the_ID(); ?> -->

				<?php endwhile; ?>

			<?php elseif ( current_user_can( 'edit_posts' ) ) : // check, if current user can edit posts ?>

				<?php 
					// Loads the no-results.php template
					get_template_part( 'no-results' ); 
				?>

			<?php endif; ?>
			
		</div><!-- #content .content .hfeed -->
		
		<?php 
			// Action hook for placing content after closing #content
			do_action( 'skyfall_content_close' ); 
		?>
		
		<?php 
			// Loads the loop-nav.php template
			get_template_part( 'loop', 'nav' ); 
		?>
		
	</div><!-- #primary .site-content .has-sidebar -->
 		
 	<?php 
 		// Action hook for placing content after closing #primary
 		do_action( 'skyfall_content_after' ); 
 	?>

<?php 
	// Loads the sidebar-primary.php template
	get_sidebar( 'primary' ); 
?>
 
<?php 
	// Loads the footer.php template
	get_footer(); 
?>