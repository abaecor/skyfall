<?php
/**
 * Custom template tags
 * 
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license docs/license.txt
 * @since 1.0
 *
 */

/**
 * Display favicon
 *
 * @since 1.0
 */
function skyfall_display_favicon() {
	if( hybrid_get_setting( 'skyfall_favicon' ) )
		echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_url( hybrid_get_setting( 'skyfall_favicon' ) ) . '">' . "\n";
}
add_action( 'wp_head', 'skyfall_display_favicon', 10 );

/**
 * Display sidebar on header
 *
 * @since 1.0
 */
function skyfall_sidebar_header() {
	get_template_part( 'sidebar', 'header' );
}
add_action( 'skyfall_header', 'skyfall_sidebar_header', 1 );

/**
 * Display the navigation
 *
 * @since 1.0
 */
function skyfall_nav() {
	get_template_part( 'menu', 'primary' );
}
add_action( 'skyfall_header_after', 'skyfall_nav', 1 );

/**
 * Sticky posts slides
 *
 * @since 1.0
 */
function skyfall_sticky_slides() {
	if ( is_home() && hybrid_get_setting( 'skyfall_sticky' ) )
		get_template_part( 'content', 'slides' );
}
add_action( 'skyfall_content_before', 'skyfall_sticky_slides', 1 );

/**
 * Home text
 *
 * @since 1.0
 */
function skyfall_display_home_text() {
	if ( is_home() && hybrid_get_setting( 'skyfall_home_text' ) )
		echo '<section class="home-text"><p class="aligncenter">' . do_shortcode( wp_filter_post_kses( hybrid_get_setting( 'skyfall_home_text' ) ) ) . '</p></section>';
}
add_action( 'skyfall_content_before', 'skyfall_display_home_text', 2 );

/**
 * Display sidebar primary
 *
 * @since 1.0
 */
function skyfall_display_sidebar_primary() {
	if( ! is_home() )
		get_template_part( 'sidebar', 'primary' );
}
add_action( 'skyfall_main', 'skyfall_display_sidebar_primary', 1 );

/**
 * Display sidebar subsidiary
 *
 * @since 1.0
 */
function skyfall_display_sidebar_subsidiary() {
	get_template_part( 'sidebar', 'subsidiary' );
}
add_action( 'skyfall_main_after', 'skyfall_display_sidebar_subsidiary', 1 );