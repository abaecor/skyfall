<?php
/**
 * Theme functions file
 *
 * Contains all of the Theme's setup functions, custom functions,
 * custom hooks and Theme settings.
 * 
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license	docs/license.txt
 * @since 1.0
 *
 */
 
/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'skyfall_theme_setup' );

/* Load additional libraries a little later. */
add_action( 'after_setup_theme', 'skyfall_load_libraries', 11 );

/**
 * Theme setup function. This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 1.0
 */
function skyfall_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Set content width. */
	hybrid_set_content_width( 580 );

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 
		'hybrid-core-menus', 
		array( 'primary' ) 
	);
	add_theme_support( 
		'hybrid-core-sidebars', 
		array( 'primary', 'subsidiary' ) 
	);
	add_theme_support( 
		'hybrid-core-styles', 
		array( 'gallery', 'parent', 'style' ) 
	);
	add_theme_support( 
		'hybrid-core-scripts', 
		array( 'comment-reply' ) 
	);
	add_theme_support( 
		'hybrid-core-theme-settings', 
		array( 'footer', 'about' ) 
	);

	/* Add theme support for framework extensions. */
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );
	add_theme_support( 'cleaner-caption' );
	add_theme_support( 'post-stylesheets' );
	add_theme_support( 
		'theme-layouts', 
		array( '1c', '1c-full', '2c-l', '2c-r' ), array( 'default' => '2c-l' ) 
	);

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 
		'custom-background',
		array( 'default-color' => 'ffffff' )
	);
	/* Add support for custom headers. */
	$defaults = array(
		'width'         => 235,
		'height'        => 70,
		'flex-height'   => true,
		'flex-width'    => true,		
		'header-text'   => false,
		'uploads'       => true,
	);
	add_theme_support( 'custom-header', apply_filters( 'skyfall_header_args_defaults', $defaults ) );

	/* Embed width defaults. */
	add_filter( 'embed_defaults', 'skyfall_embed_defaults' );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'skyfall_disable_sidebars' );
	add_action( 'template_redirect', 'skyfall_one_column' );

	/* Enqueue styles & scripts. */
	add_action( 'wp_enqueue_scripts', 'skyfall_enqueue_scripts' );

	/* Add custom image sizes. */
	add_action( 'init', 'skyfall_add_image_sizes' );
	/* Add custom image sizes custom name. */
	add_filter( 'image_size_names_choose', 'skyfall_custom_name_image_sizes' );

	/* Add classes to the comments pagination. */
	add_filter( 'previous_comments_link_attributes', 'skyfall_previous_comments_link_attributes' );
	add_filter( 'next_comments_link_attributes', 'skyfall_next_comments_link_attributes' );

	/* Removes default styles set by WordPress recent comments widget. */
	add_action( 'widgets_init', 'skyfall_remove_recent_comments_style' );

	/* Filter size of the gravatar on comments. */
	add_filter( "{$prefix}_list_comments_args", 'skyfall_comments_args' );

	/* Remove theme-layouts meta box from custom post type. */
	add_action( 'init', 'skyfall_remove_theme_layout_metabox', 11 );

	/* Register custom sidebar. */
	add_action( 'widgets_init', 'skyfall_register_custom_sidebars' );

	/* Hybrid Core 1.6 changes. */
	add_filter( "{$prefix}_sidebar_defaults", 'skyfall_sidebar_defaults' );
	add_filter( 'cleaner_gallery_defaults', 'skyfall_gallery_defaults' );

	/* Add no widgets layout. */
	add_filter( 'theme_layouts_strings', 'skyfall_register_theme_layout' );

	/* Default theme setting. */
	add_filter( "{$prefix}_default_theme_settings", 'skyfall_default_setting' );

	/** 
	 * Disqus issue.
	 * URL: http://themehybrid.com/support/topic/weird-problem-wit-disqus-plugin 
	 */
	if( function_exists( 'dsq_comments_template' ) ) :
		remove_filter( 'comments_template', 'dsq_comments_template' );
		add_filter( 'comments_template', 'dsq_comments_template', 11 );
	endif;	

}

/**
 * Loads some additional functions.
 *
 * @since 1.0
 */
function skyfall_load_libraries() {

	/* Loads the admin functions. */
	require_once( trailingslashit( THEME_DIR ) . 'admin/admin.php' );

	/* Loads additional functions file. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/theme-functions.php' );

	/* Loads custom template tags. */
	require_once( trailingslashit( THEME_DIR ) . 'inc/templates.php' );
}

/**
 * Overwrites the default widths for embeds. This is especially useful for making sure videos properly
 * expand the full width on video pages. This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 1.0
 */
function skyfall_embed_defaults( $args ) {

	$args['width'] = 580;

	if ( current_theme_supports( 'theme-layouts' ) ) {

		$layout = theme_layouts_get_layout();

		if ( 'layout-1c-full' == $layout )
			$args['width'] = 900;

	}

	return $args;
}

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since 1.0
 */
function skyfall_one_column() {
	if ( is_home() )
		add_filter( 'theme_mod_theme_layout', 'skyfall_theme_layout_full' );
}

/**
 * Filters 'get_theme_layout' by returning 'layout-1c-full'.
 *
 * @since 1.0
 */
function skyfall_theme_layout_full( $layout ) {
	return '1c-full';
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since 1.0
 */
function skyfall_disable_sidebars( $sidebars_widgets ) {

	if ( current_theme_supports( 'theme-layouts' ) && ! is_admin() ) {

		if ( 'layout-1c' == theme_layouts_get_layout() || 'layout-1c-full' == theme_layouts_get_layout() ) {
			$sidebars_widgets['primary'] = false;
		}
	}

	return $sidebars_widgets;
}

/**
 * Enqueue styles & scripts
 *
 * @since 1.0
 */
function skyfall_enqueue_scripts() {

	wp_enqueue_style( 'skyfall-fonts', 'http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Roboto+Condensed:400,700', false, '1.0', 'all' );

	wp_enqueue_style( 'skyfall-slides', trailingslashit( THEME_URI ) . 'css/camera.css', false, '1.0', 'all' );

	wp_enqueue_style( 'skyfall-prettyphoto', trailingslashit( THEME_URI ) . 'css/prettyphoto.css', false, '1.0', 'all' );

	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'skyfall-plugins', trailingslashit( THEME_URI ) . 'js/plugins.js', array( 'jquery' ), '1.0', true );
	
	wp_enqueue_script( 'skyfall-methods', trailingslashit( THEME_URI ) . 'js/methods.js', array( 'jquery' ), '1.0', true );

}

/**
 * Adds custom image sizes.
 *
 * @since 1.0
 */
function skyfall_add_image_sizes() {
	add_image_size( 'skyfall-small-thumb', 45, 45, true );
	add_image_size( 'skyfall-attachment', 580, 400, true );
	add_image_size( 'skyfall-slides', 940, 400, true );
	add_image_size( 'skyfall-blog-thumbnail', 300, 180, true );
	add_image_size( 'skyfall-blog', 620, 300, true );
	add_image_size( 'skyfall-blog-full', 940, 300, true );
}

/**
 * Adds custom image sizes custom name.
 *
 * @since 1.0
 */
function skyfall_custom_name_image_sizes( $sizes ) {
    $sizes['skyfall-small-thumb'] = __( 'Small Thumbnail', 'skyfall' );
    $sizes['skyfall-attachment'] = __( 'Attachment', 'skyfall' );
    $sizes['skyfall-slides'] = __( 'Slides', 'skyfall' );
    $sizes['skyfall-blog-thumbnail'] = __( 'Blog Thumbnail', 'skyfall' );
    $sizes['skyfall-blog'] = __( 'Blog', 'skyfall' );
    $sizes['skyfall-blog-full'] = __( 'Full Width Blog', 'skyfall' );
 
    return $sizes;
}

/**
 * Adds 'class="prev" to the previous comments link.
 *
 * @since 1.0
 */
function skyfall_previous_comments_link_attributes( $attributes ) {
	return $attributes . ' class="prev"';
}

/**
 * Adds 'class="next" to the next comments link.
 *
 * @since 1.0
 */
function skyfall_next_comments_link_attributes( $attributes ) {
	return $attributes . ' class="next"';
}

/**
 * Removes default styles set by WordPress recent comments widget.
 *
 * @since 1.0
 */
function skyfall_remove_recent_comments_style() {

	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );

}

/**
 * Filter size of the gravatar on comments.
 * 
 * @since 1.0
 */
function skyfall_comments_args( $args ) {
	$args['avatar_size'] = 60;
	return $args;
}

/**
 * Remove theme-layouts meta box
 * 
 * @since 1.0
 */
function skyfall_remove_theme_layout_metabox() {
	remove_post_type_support( 'portfolio_item', 'theme-layouts' ); // custom content portfolio plugin
}

/**
 * Registers custom sidebars.
 * 
 * @since 1.0
 */
function skyfall_register_custom_sidebars() {
		
	register_sidebar(
		array(
			'id' => 'header',
			'name' => __( 'Header', 'skyfall' ),
			'description' => __( 'A widget area loaded in the header of the site.', 'skyfall' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s widget-%2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		)
	);

}

/**
 * Sidebar parameter defaults.
 *
 * @since 1.0
 */
function skyfall_sidebar_defaults( $defaults ) {

	$defaults = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s widget-%2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	);

	return $defaults;
}

/**
 * Gallery defaults for the Cleaner Gallery extension.
 *
 * @since 1.0
 */
function skyfall_gallery_defaults( $defaults ) {

	$defaults['itemtag']    = 'figure';
	$defaults['icontag']    = 'div';
	$defaults['captiontag'] = 'figcaption';

	return $defaults;
}

/**
 * Add no widgets layout.
 *
 * @since 1.0
 */
function skyfall_register_theme_layout( $strings ) {
	$strings['1c-full'] = __( 'Full Width', 'skyfall' );
	return $strings;
}

/**
 * Default theme setting
 *
 * @since 1.0
 */
function skyfall_default_setting( $settings ) {

	$settings = array(
		'skyfall_sticky'	=> 1,
		'skyfall_home_text'	=> __( 'Beautiful in minimalistic design. Perfect for personal blog or even photographers to showcase their portfolio.', 'skyfall' ),
		'footer_insert'		=> __( 'Copyright &copy; [the-year] [site-link]. Powered by [wp-link] and [theme-link]', 'skyfall' )
	);

    return $settings;
}
?>