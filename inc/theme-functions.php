<?php

/**
 * Theme-additional functions
 *
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license	docs/license.txt
 * @since 1.0
 */

/**
 * Site Title/Logo
 * 
 * @since 1.0
 */
if ( ! function_exists( 'skyfall_site_title' ) ):
function skyfall_site_title() {

	if ( get_header_image() ) {
		echo '<div id="site-title">' . "\n";
			echo '<a href="' . get_home_url() . '" title="' . get_bloginfo( 'name' ) . '" rel="home">' . "\n";
				echo '<img class="logo" src="' . get_header_image() . '" alt="' . get_bloginfo( 'name' ) . '" />' . "\n";
			echo '</a>' . "\n";
		echo '</div>' . "\n";
	} else {
		hybrid_site_title();
		hybrid_site_description();
	}

}
endif;

/**
 * Sets the post excerpt length to 30 words.
 *
 * @since 1.0
 */
function skyfall_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'skyfall_excerpt_length' );

/**
 * Replaces "[...]" with just ...
 *
 * @since 1.0
 */
function skyfall_auto_excerpt_more( $more ) {
	return ' &hellip;';
}
add_filter( 'excerpt_more', 'skyfall_auto_excerpt_more' );

/**
 * Filter the main loop
 *
 * @since 1.0
 */
function skyfall_filter_query( $query ) {
	
	if( $query->is_home() && hybrid_get_setting( 'skyfall_sticky' ) && !is_page_template( 'page-templates/blog.php' ) )
		$query->set( 'post__not_in', get_option( 'sticky_posts' ) );
	
}
add_action( 'pre_get_posts', 'skyfall_filter_query' );

/**
 * Dynamic content classes
 *
 * @since 1.0
 */
function skyfall_content_class( $class = '' ) {

	if ( is_home() || 'layout-1c' == theme_layouts_get_layout() || 'layout-1c-full' == theme_layouts_get_layout() )
		$class = 'no-sidebar cl';
	else
		$class = 'has-sidebar';

	echo apply_filters( 'skyfall_custom_content_class', $class );
}
?>