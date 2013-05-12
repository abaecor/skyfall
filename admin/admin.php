<?php
/**
 * Admin functions.
 * 
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license	docs/license.txt
 * @since 1.0
 */

/**
 * Sets up the admin functionality.
 *
 * @since 1.0
 */
function skyfall_theme_admin_setup() {
    
	$prefix = hybrid_get_prefix();
	$settings_page = hybrid_get_settings_page_name();

	/* If no settings are available, add the default settings to the database. */
	if ( false === get_option( "{$prefix}_theme_settings" ) )
		add_option( "{$prefix}_theme_settings", skyfall_get_default_settings(), '', 'yes' );

	/* Create a settings meta box only on the theme settings page. */
	add_action( "load-{$settings_page}", 'skyfall_theme_settings_meta_boxes' );

	/* Add a filter to validate/sanitize your settings. */
	add_filter( "sanitize_option_{$prefix}_theme_settings", 'skyfall_theme_validate_settings' );
	
	/* Enqueue scripts */
	add_action( 'admin_enqueue_scripts', 'skyfall_admin_scripts' );
	
}
add_action( 'admin_menu', 'skyfall_theme_admin_setup' );

/**
 * Adds custom meta boxes to the theme settings page.
 *
 * @since 1.0
 */
function skyfall_theme_settings_meta_boxes() {

	add_meta_box(
		'skyfall-theme-meta-box-general',
		__( 'General settings', 'skyfall' ),
		'skyfall_theme_meta_box_general',
		'appearance_page_theme-settings',
		'normal',
		'high'
	);

}

/**
 * Render the meta boxes.
 *
 * @since 1.0
 */
function skyfall_theme_meta_box_general() { ?>

	<table class="form-table">
	    
		<!-- Display Sticky Slider -->
		<tr>
			<th>
				<label for="<?php echo esc_attr( hybrid_settings_field_id( 'skyfall_sticky' ) ); ?>"><?php _e( 'Sticky Posts Slider:', 'skyfall' ); ?></label>
			</th>
			<td>
				<input type="checkbox" id="<?php echo esc_attr( hybrid_settings_field_id( 'skyfall_sticky' ) ); ?>" name="<?php echo esc_attr( hybrid_settings_field_name( 'skyfall_sticky' ) ); ?>" value="1" <?php checked( hybrid_get_setting( 'skyfall_sticky' ), 1 ); ?> />
				<br />
				<span class="description"><?php _e( 'Display a slider of sticky posts on the front page', 'skyfall' ); ?></span>
			</td>
		</tr>

	</table><!-- .form-table -->

	<?php
	
}

/**
 * Validate theme settings.
 *
 * @since 1.0
 */
function skyfall_theme_validate_settings( $input ) {
    
	$input['skyfall_sticky'] = ( isset( $input['skyfall_sticky'] ) ? 1 : 0 );

    /* Return the array of theme settings. */
    return $input;
}

/**
 * Enqueue scripts.
 *
 * @since 1.0
 */
function skyfall_admin_scripts( $hook_suffix ) {

	/* Enqueue Styles */
	wp_enqueue_style( 'skyfall-theme-settings-style', trailingslashit ( THEME_URI ) . 'admin/admin.css', false, 1.0, 'screen' );

}

/**
 * Default theme settings.
 *
 * @since 1.0
 */
function skyfall_get_default_settings() {

	/* Set up the default plugin settings. */
	$settings['skyfall_sticky'] = 1;

	/* Return the default settings. */
	return $settings;

}

?>