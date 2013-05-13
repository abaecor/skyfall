<?php
/**
 * Content Slides Template
 *
 * Template used to show sticky post as a slider.
 *
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license	docs/license.txt
 * @since 1.0
 */

$sticky = get_option( 'sticky_posts' );
if( ! empty( $sticky ) ) :

	$args = array( 'post__in' => $sticky );
	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) : ?>

		<div class="camera_wrap camera_white_skin" id="slides">

			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					
    			<?php 
					if ( current_theme_supports( 'get-the-image' ) ) 
						$image = get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'skyfall-slides', 'format' => 'array' ) ); 
				?>

				<div data-src="<?php echo $image['src']; ?>" data-link="<?php the_permalink(); ?>">
				    <div class="camera_caption fadeIn">
				    	<?php the_title( '<h2 class="entry-title"><a href="' . get_permalink() . '">', '</a></h2>' ); ?>
				    	<?php the_excerpt(); ?>
				    </div>
				</div>

			<?php endwhile; ?>
			
		</div>

	<?php endif; wp_reset_postdata(); ?>

<?php endif; ?>