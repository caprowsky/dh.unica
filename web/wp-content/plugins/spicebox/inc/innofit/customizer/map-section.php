<?php
//Google map Section
	$wp_customize->add_section('innofit_map_section',array(
			'title' => __('Google Maps settings','spicebox'),
			'panel' => 'section_settings',
			'priority'       => 12,
			));
			
		//Google Map plus
		class Innofit_google_maps_section_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
			<h3><?php _e('Want to add Google map section? Then','spicebox'); ?><a href="<?php echo esc_url( 'https://spicethemes.com/innofit-plus/' ); ?>" target="_blank">
			<?php _e('Upgrade to Plus','spicebox'); ?> </a>  
			<?php
			}
		}
		
		
		$wp_customize->add_setting( 'google_map_upgrade', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Innofit_google_maps_section_upgrade(
			$wp_customize,
			'google_map_upgrade',
				array(
					'section'				=> 'innofit_map_section',
					'settings'				=> 'google_map_upgrade',
				)
			)
		);
	
	
			// google map enable / disable
			$wp_customize->add_setting( 'google_map_enable' , array( 'default' => 'on') );
			$wp_customize->add_control(	'google_map_enable' , array(
					'label'    => __( 'Enable Google map', 'spicebox' ),
					'section'  => 'innofit_map_section',
					'type'     => 'radio',
					'choices' => array(
						'on'=>__('ON', 'spicebox'),
						'off'=>__('OFF', 'spicebox')
					),
					'input_attrs' => array('disabled' => 'disabled'),
			));
	
				
			// google map url
			$wp_customize->add_setting('contact_google_map_shortcode',array(
			'capability'  => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => $selective_refresh,
			));
			$wp_customize->add_control('contact_google_map_shortcode',array(
			'label' => __('Google Map Shortcode','spicebox'),
			'section' => 'innofit_map_section',
			'type' => 'textarea',
			'input_attrs' => array('disabled' => 'disabled'),
			));
?>