<?php
/**
 * Custom template tags
 * 
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license	docs/license.txt
 * @since 1.0
 *
 */

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
		echo '<section class="home-text"><p class="aligncenter">' . stripslashes( hybrid_get_setting( 'skyfall_home_text' ) ) . '</p></section>';
}
add_action( 'skyfall_content_before', 'skyfall_display_home_text', 2 );

/**
 * Display sidebar subsidiary
 *
 * @since 1.0
 */
function skyfall_display_sidebar_subsidiary() {
	get_template_part( 'sidebar', 'subsidiary' );
}
add_action( 'skyfall_main_after', 'skyfall_display_sidebar_subsidiary', 1 );