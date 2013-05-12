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
	get_template_part( 'content', 'slides' );
}
add_action( 'skyfall_content_before', 'skyfall_sticky_slides', 1 );