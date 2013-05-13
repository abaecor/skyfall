<?php
/**
 * Admin functions.
 * 
 * @package skyfall
 * @author Satrya
 * @copyright Copyright (c) 2013, Satrya
 * @license docs/license.txt
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
		'skyfall-settings-general',
		__( 'General settings', 'skyfall' ),
		'skyfall_settings_general',
		'appearance_page_theme-settings',
		'normal',
		'high'
	);

	add_meta_box(
		'skyfall-settngs-home-text',
		__( 'Home text', 'skyfall' ),
		'skyfall_settings_home_text',
		'appearance_page_theme-settings',
		'normal',
		'high'
	);

}

/**
 * Render the General settings meta boxes.
 *
 * @since 1.0
 */
function skyfall_settings_general() { ?>

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
 * Render the Home text settings meta boxes.
 *
 * @since 1.0
 */
function skyfall_settings_home_text() {

	wp_editor(
		esc_textarea( hybrid_get_setting( 'skyfall_home_text' ) ),
		hybrid_settings_field_id( 'skyfall_home_text' ),
		array(
			'tinymce' => 		false,
			'textarea_name' => 	hybrid_settings_field_name( 'skyfall_home_text' ),
			'media_buttons' =>	false
		)
	); ?>

	<p>
		<span class="description"><?php _e( 'You can add custom <acronym title="Hypertext Markup Language">HTML</acronym> and/or shortcodes, which will be automatically inserted into your theme.', 'skyfall' ); ?></span>
	</p>
	
<?php }

/**
 * Validate theme settings.
 *
 * @since 1.0
 */
function skyfall_theme_validate_settings( $input ) {
    
    /* Sanitize sticky post slider */
	$input['skyfall_sticky'] = ( isset( $input['skyfall_sticky'] ) ? 1 : 0 );

	/* Sanitize home text. */
	if ( isset( $input['skyfall_home_text'] ) && !current_user_can( 'unfiltered_html' ) )
		$input['skyfall_home_text'] = stripslashes( wp_filter_post_kses( addslashes( $input['skyfall_home_text'] ) ) );

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
?>