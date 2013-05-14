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

	hybrid_site_title();
	hybrid_site_description();

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
	
	if( $query->is_home() && hybrid_get_setting( 'skyfall_sticky' ) )
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

	echo $class;
}

/**
 * Retrieves embedded audio from the post content.  This script only searches for embeds used by 
 * the WordPress embed functionality.
 *
 * @since 1.0
 */
function skyfall_get_audio( $args = array() ) {
	global $wp_embed;

	/* If this is not a 'audio' post, return. */
	if ( !has_post_format( 'audio' ) )
		return false;

	/* Merge the input arguments and the defaults. */
	$args = wp_parse_args( $args, wp_embed_defaults() );

	/* Get the post content. */
	$content = get_the_content();

	/* Set the default $embed variable to false. */
	$embed = false;

	/* Use WP's built in WP_Embed class methods to handle the dirty work. */
	add_filter( 'post_format_tools_audio_shortcode_embed', array( $wp_embed, 'run_shortcode' ) );
	add_filter( 'post_format_tools_audio_auto_embed', array( $wp_embed, 'autoembed' ) );

	/* We don't want to return a link when an embed doesn't work.  Filter this to return false. */
	add_filter( 'embed_maybe_make_link', '__return_false' );

	/* Check for matches against the [embed] shortcode. */
	preg_match_all( '|\[embed.*?](.*?)\[/embed\]|i', $content, $matches, PREG_SET_ORDER );

	/* If matches were found, loop through them to see if we can hit the jackpot. */
	if ( is_array( $matches ) ) {
		foreach ( $matches  as $value ) {

			/* Apply filters (let WP handle this) to get an embedded audio. */
			$embed = apply_filters( 'post_format_tools_audio_shortcode_embed', '[embed width="' . absint( $args['width'] ) . '" height="' . absint( $args['height'] ) . '"]' . $value[1]. '[/embed]' );

			/* If no embed, continue looping through the array of matches. */
			if ( empty( $embed ) )
				continue;
		}
	}

	/* If no embed at this point and the user has 'auto embeds' turned on, let's check for URLs in the post. */
	if ( empty( $embed ) && get_option( 'embed_autourls' ) ) {
		preg_match_all( '|^\s*(https?://[^\s"]+)\s*$|im', $content, $matches, PREG_SET_ORDER );

		/* If URL matches are found, loop through them to see if we can get an embed. */
		if ( is_array( $matches ) ) {
			foreach ( $matches  as $value ) {

				/* Let WP work its magic with the 'autoembed' method. */
				$embed = apply_filters( 'post_format_tools_audio_auto_embed', $value[0] );

				/* If no embed, continue looping through the array of matches. */
				if ( empty( $embed ) )
					continue;
			}
		}
	}

	/* Remove the maybe make link filter. */
	remove_filter( 'embed_maybe_make_link', '__return_false' );

	/* Return the embed. */
	return $embed;
}
?>