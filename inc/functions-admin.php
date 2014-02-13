<?php

add_action( 'admin_menu', 'bearded_theme_admin_setup' );

function bearded_theme_admin_setup() {

	/* Get the theme prefix. */
	$prefix = hybrid_get_prefix();

	/* Create a settings meta box only on the theme settings page. */
	add_action( 'load-appearance_page_theme-settings', 'bearded_theme_settings_meta_boxes' );

	/* Add a filter to validate/sanitize your settings. */
	add_filter( "sanitize_option_{$prefix}_theme_settings", 'bearded_theme_validate_settings' );
}

/* Adds custom meta boxes to the theme settings page. */
function bearded_theme_settings_meta_boxes() {

	/* Add a custom meta box. */
	add_meta_box(
		'bearded-social-meta-box',			// Custom meta box ID
		__( 'Social Settings', 'bearded' ),	// Custom label
		'bearded_social_meta_box',			// Custom callback function
		'appearance_page_theme-settings',		// Page to load on, leave as is
		'normal',					// normal / advanced / side
		'high'					// high / low
	);

	/* Add additional add_meta_box() calls here. */
}


/* Validates theme settings. */
function bearded_theme_validate_settings( $input ) {

	$socials = bearded_get_social_lists();

	foreach($socials as $key => $val ) {
		$input[$val] = wp_filter_nohtml_kses( $input[$val] );
	}

	/* Return the array of theme settings. */
	return $input;
}

/* Function for displaying the meta box. */
function bearded_social_meta_box() { ?>


	<table class="form-table">
		<!-- Add custom form elements below here. -->

		<!-- Text input box -->
		<?php $socials = bearded_get_social_lists(); ?>

		<?php foreach( $socials as $key => $val ) { ?>

			<tr>
				<th>
					<label for="<?php echo hybrid_settings_field_id( 'bearded_social_'.$key ); ?>">
						<?php printf( __('%1$s URL' ,'bearded'), ucwords(str_replace('-', ' ', $key)) ); ?>
					</label>
				</th>
				<td>
					<p>
						<input type="text" id="<?php echo hybrid_settings_field_id( 'bearded_social_'.$key ); ?>" name="<?php echo hybrid_settings_field_name( 'bearded_social_'.$key ); ?>" size="80" value="<?php echo $val; ?>" />
					</p>
				</td>
			</tr>

		<?php } ?>
		

		<!-- End custom form elements. -->
	</table><!-- .form-table -->


	<?php
}


function bearded_theme_customizer( $wp_customize ) {

    $wp_customize->add_section( 'bearded_logo_section' , array(
	    'title'       => __( 'Logo', 'bearded' ),
	    'priority'    => 30,
	    'description' => __('Upload a logo to replace the default site name and description in the header','bearded'),
	) );

	$wp_customize->add_setting( 'bearded_logo' );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bearded_logo', array(
	    'label'    => __( 'Logo', 'bearded' ),
	    'section'  => 'bearded_logo_section',
	    'settings' => 'bearded_logo',
	) ) );

}

add_action('customize_register', 'bearded_theme_customizer');
?>