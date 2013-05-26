<?php
/**
 * Page Content Template
 *
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license docs/license.txt
 * @since 1.0
 */

// Action hook for placing content before post content
do_action( 'skyfall_entry_before' ); 
?>

	<article id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

		<?php 
			// Action hook for placing content after opening post content
			do_action( 'skyfall_entry_open' ); 
		?>

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

		<div class="entry">

			<header class="entry-header">
				<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); // Post title ?>
			</header><!-- .entry-header -->

			<div class="entry-container">

				<?php if ( is_singular( get_post_type() ) ) { ?>

					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'skyfall' ), 'after' => '</p>' ) ); ?>
					</div><!-- .entry-content -->

				<?php } else { ?>

					<div class="entry-summary">
						<?php the_excerpt(); ?>
						<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'skyfall' ), 'after' => '</p>' ) ); ?>
					</div><!-- .entry-summary -->

				<?php } ?>

			</div><!-- .entry-container -->
		
		</div><!-- .entry -->

		<?php 
			// Action hook for placing content before closing post content
			do_action( 'skyfall_entry_close' ); 
		?>

	</article><!-- #post-<?php the_ID(); ?> -->

<?php 
	// Action hook for placing content after post content
	do_action( 'skyfall_entry_after' ); 
?>