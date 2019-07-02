<?php
//Client Section

		$wp_customize->add_section('home_client_section',array(
		'title' => __('Clients settings','spicebox'),
		'panel' => 'section_settings',
		'priority'       => 15,
		));
		
		
		
		//Theme Custom typography plus
		class Innofit_client_section_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
			<h3><?php _e('Want to add client section? Then','spicebox'); ?><a href="<?php echo esc_url( 'https://spicethemes.com/innofit-plus/' ); ?>" target="_blank">
			<?php _e('Upgrade to Plus','spicebox'); ?> </a>  
			<?php
			}
		}
		
		
		$wp_customize->add_setting( 'client_upgrade', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Innofit_client_section_upgrade(
			$wp_customize,
			'client_upgrade',
				array(
					'section'				=> 'home_client_section',
					'settings'				=> 'client_upgrade',
				)
			)
		);
		
	
			// Enable client section
			$wp_customize->add_setting( 'client_section_enable' , array( 'default' => 'on') );
			$wp_customize->add_control(	'client_section_enable' , array(
					'label'    => __( 'Enable Home Client section', 'spicebox' ),
					'section'  => 'home_client_section',
					'type'     => 'radio',
					'choices' => array(
						'on'=>__('ON', 'spicebox'),
						'off'=>__('OFF', 'spicebox')
					),
					'input_attrs' => array('disabled' => 'disabled'),
			));
			
			
		if ( class_exists( 'Innofit_Repeater' ) ) {
			$wp_customize->add_setting(
				'innofit_clients_content', array(
				)
			);

			$wp_customize->add_control(
				new Innofit_Repeater(
					$wp_customize, 'innofit_clients_content', array(
						'label'                            => esc_html__( 'Clients content', 'spicebox' ),
						'section'                          => 'home_client_section',
						'add_field_label'                  => esc_html__( 'Add new client', 'spicebox' ),
						'item_name'                        => esc_html__( 'Client', 'spicebox' ),
						'customizer_repeater_image_control' => true,
						'customizer_repeater_link_control' => true,
						'customizer_repeater_checkbox_control' => true,
					)
				)
			);
		}
		
		$wp_customize->add_setting( 'client_background_text_static' , array( 'default' => 'on') );
		$wp_customize->add_control(	'client_background_text_static' , array(
				'label'    => __( 'Client background text:', 'spicebox' ),
				'section'  => 'home_client_section',
				'type'     => 'radio',
				'choices' => array(
					'on'=>__('Marquee', 'spicebox'),
					'off'=>__('Static', 'spicebox')
				),
				'input_attrs' => array('disabled' => 'disabled'),
		));
		
		
		$wp_customize->add_setting( 'client_background_text',array(
			'default' => __('<b>Our sponsors</b> Our sponsors','spicebox'),
			'sanitize_callback' => 'innofitp_home_page_sanitize_text',
			));	
			$wp_customize->add_control( 'client_background_text',array(
			'label'   => __('Background scroll text','spicebox'),
			'section' => 'home_client_section',
			'type' => 'text',
			'input_attrs' => array('disabled' => 'disabled'),
			));	
		
		
		// animation speed
		$wp_customize->add_setting( 'client_animation_speed', array( 'default' => 3000) );
		$wp_customize->add_control(	'client_animation_speed', 
			array(
				'label'    => __( 'Animation speed', 'spicebox' ),
				'section'  => 'home_client_section',
				'type'     => 'select',
				'choices'=>array(
					'2000'=>'2.0',
					'3000'=>'3.0',
					'4000'=>'4.0',
					'5000'=>'5.0',
					'6000'=>'6.0',
				),
				'input_attrs' => array('disabled' => 'disabled'),
		));
		
		
		// animation speed
		$wp_customize->add_setting( 'client_smoothSpeed', array( 'default' => 1000) );
		$wp_customize->add_control(	'client_smoothSpeed', 
			array(
				'label'    => __( 'Smooth speed', 'spicebox' ),
				'section'  => 'home_client_section',
				'type'     => 'select',
				'choices'=>array(
					 '500'=>'0.5',
					'1000'=>'1.0',
					'1500'=>'1.5',
					'2000'=>'2.0',
					'2500'=>'2.5',
					'3000'=>'3.0',
				),
				'input_attrs' => array('disabled' => 'disabled'),
		));
?>