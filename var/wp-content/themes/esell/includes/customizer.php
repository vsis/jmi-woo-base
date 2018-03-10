<?php
/**
 * esell Theme Customizer
 *
 * @package esell
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function esell_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
   // $wp_customize->remove_section("background_image");         

	$wp_customize->add_section( 'esell_responsive' , 
        array(
				'title'       => __( 'Theme Options & Settings', 'esell' ),
				'priority'    => 30,
				'description'	=> __('Upload Logo and Change Theme Settings Please Go to Theme options.', 'esell'). '<a href="' . esc_url(__(admin_url( 'admin.php?page=options-framework' ).'','esell')) . '" target="_blank">' . esc_attr__( ' Change Theme Options', 'esell' ) . '</a>'
					
		));
		
         //Show or Hide woo product
         $wp_customize->add_setting('reponsive',
	
		array(
			'default'			=> 'Go To esell Options',
			'type'				=> 'theme_mod',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'esell_sanitize_text'
		)
	);
                 $wp_customize->add_control(new WP_customize_control ($wp_customize,'reponsive',
                         array (
                             
                             'settings'		=> 'reponsive',
                             'section'		=> 'esell_responsive',
                             'type'		=> 'text',    	 
                            'label'		=> __( 'Dashboard > Appearance > esell options', 'esell' )
			
                             
                         )  ));

	
	}
add_action("customize_register","esell_customize_register");


function esell_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
function esell_sanitize_nohtml( $nohtml ) {
	return wp_filter_nohtml_kses( $nohtml );
}
function esell_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


function esell_registers() {
    wp_register_script( 'esell_jquery_ui', '//code.jquery.com/ui/1.10.4/jquery-ui.js', array("jquery"), '20120206', true  );
	wp_enqueue_script( 'esell_jquery_ui' );
	wp_register_script( 'esell_customizer_script', get_template_directory_uri() . '/js/esell_customizer.js', array("jquery","esell_jquery_ui"), '20120206', true  );
	wp_enqueue_script( 'esell_customizer_script' );
	
	wp_localize_script( 'esell_customizer_script', 'scatmanjhon', array(
		'documentation' => __( 'Documentation', 'esell' ),
		'pro' => __('Upgrade to Pro','esell'),
		'support' => __('Support Forum','esell')
		
	) );
}
add_action( 'customize_controls_enqueue_scripts', 'esell_registers' );


function esell_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}
function esell_sanitize_css( $css ) {
	return wp_strip_all_tags( $css );
}

function esell_sanitize_html( $html ) {
	return stripslashes(wp_filter_post_kses( $html ));
        
}

 