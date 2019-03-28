<?php 
function innofit_color_back_settings_customizer( $wp_customize ){


$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

/* Home Page Panel */
	$wp_customize->add_panel( 'colors_back_settings', array(
		'priority'       => 125,
		'capability'     => 'edit_theme_options',
		'title'      => esc_html__('Colors / Background','innofit'),
	) );
	
	/* Footer backgrund color settings */
	$wp_customize->add_section( 'footer_background_color_settings', array(
		'title' => esc_html__('Footer', 'innofit'),
		'panel' => 'colors_back_settings',
   	) );		
	
	
			//Footer background color
			$wp_customize->add_setting('footer_background_color', array(
			'default' => '#21202e',
			'sanitize_callback' => 'sanitize_hex_color',
			) );
			
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'footer_background_color', array(
				'label'      => esc_html__('Footer background color', 'innofit' ),
				'section'    => 'footer_background_color_settings',
				'settings'   => 'footer_background_color',) 
			) );
	


}
add_action( 'customize_register', 'innofit_color_back_settings_customizer' );