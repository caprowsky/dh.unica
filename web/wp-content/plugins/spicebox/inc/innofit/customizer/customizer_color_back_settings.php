<?php 	
	
		// Copyright section color and background settings 

		$wp_customize->add_section( 'footer_copyright_background_color_settings', array(
			'title' => __('Footer Copyright', 'spicebox'),
			'panel' => 'colors_back_settings',
		) );
		
		//Theme Custom typography plus
		class Innofit_copyright_color_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
			<h3><?php _e('Want to use copyright section color settings ? Then','spicebox'); ?><a href="<?php echo esc_url( 'https://spicethemes.com/innofit-plus/' ); ?>" target="_blank">
			<?php _e('Upgrade to Plus','spicebox'); ?> </a>  
			<?php
			}
		}
		
		
		$wp_customize->add_setting( 'copyright_color_upgrade', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Innofit_copyright_color_upgrade(
			$wp_customize,
			'copyright_color_upgrade',
				array(
					'section'				=> 'footer_copyright_background_color_settings',
					'priority'	 => 1,
					'settings'				=> 'copyright_color_upgrade',
				)
			)
		);
			
			
			//Copyright Text color
			$wp_customize->add_setting('copyright_text_color', array(
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			) );
			
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'copyright_text_color', array(
				'label'      => __('Text color', 'spicebox' ),
				'section'    => 'footer_copyright_background_color_settings',
				'priority'	 => 2,
				'settings'   => 'copyright_text_color',) 
			) );
			
			
			//Copyright Link color
			$wp_customize->add_setting('copyright_link_color', array(
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			) );
			
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'copyright_link_color', array(
				'label'      => __('Link color', 'spicebox' ),
				'priority'	 => 3,
				'section'    => 'footer_copyright_background_color_settings',
				'settings'   => 'copyright_link_color',) 
			) );
			
			
			//Copyright Link Hover color
			$wp_customize->add_setting('copyright_link_hover_color', array(
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			) );
			
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'copyright_link_hover_color', array(
				'label'      => __('Link Hover color', 'spicebox' ),
				'priority'	 => 4,
				'section'    => 'footer_copyright_background_color_settings',
				'settings'   => 'copyright_link_hover_color',) 
			) );
			
			
			//Copyright background color
			$wp_customize->add_setting('copyright_background_color', array(
			'default' => '#2a83e8',
			'sanitize_callback' => 'sanitize_hex_color',
			) );
			
			$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'copyright_background_color', array(
				'label'      => __('Footer background color', 'spicebox' ),
				'section'    => 'footer_copyright_background_color_settings',
				'priority'	 => 10,
				'settings'   => 'copyright_background_color',) 
			) );