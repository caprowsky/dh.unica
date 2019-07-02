<?php
    //Pricing Section
		$wp_customize->add_section('home_pricing_section',array(
		'title' => __('Pricing settings','spicebox'),
		'panel' => 'section_settings',
		'priority'       => 9,
		));
		
		//Pricing section plus
		class Innofit_pricing_section_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
			<h3><?php _e('Want to add pricing section? Then','spicebox'); ?><a href="<?php echo esc_url( 'https://spicethemes.com/innofit-plus/' ); ?>" target="_blank">
			<?php _e('Upgrade to Plus','spicebox'); ?> </a>  
			<?php
			}
		}
		
		
		$wp_customize->add_setting( 'pricing_upgrade', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Innofit_pricing_section_upgrade(
			$wp_customize,
			'pricing_upgrade',
				array(
					'section'				=> 'home_pricing_section',
					'settings'				=> 'pricing_upgrade',
				)
			)
		);
		
		
			// Enable pricing section
			$wp_customize->add_setting( 'pricing_section_enable' , array( 'default' => 'on') );
			$wp_customize->add_control(	'pricing_section_enable' , array(
					'label'    => __( 'Enable Home Pricing section', 'spicebox' ),
					'section'  => 'home_pricing_section',
					'type'     => 'radio',
					'choices' => array(
						'on'=>__('ON', 'spicebox'),
						'off'=>__('OFF', 'spicebox')
					),
					'input_attrs' => array('disabled' => 'disabled'),
			));
			
			// Pricing section title
			$wp_customize->add_setting( 'home_pricing_section_title',array(
			'default' => __('Affordable pricing','spicebox'),
			'sanitize_callback' => 'innofitp_home_page_sanitize_text',
			'transport'         => $selective_refresh,
			));	
			$wp_customize->add_control( 'home_pricing_section_title',array(
			'label'   => __('Title','spicebox'),
			'section' => 'home_pricing_section',
			'type' => 'text',
			'input_attrs' => array('disabled' => 'disabled'),
			));	
			
			//Pricing section discription
			$wp_customize->add_setting( 'home_pricing_section_discription',array(
			'default'=> __('Great price plans for you','spicebox'),
			'transport'         => $selective_refresh,
			));	
			$wp_customize->add_control( 'home_pricing_section_discription',array(
			'label'   => __('Description','spicebox'),
			'section' => 'home_pricing_section',
			'type' => 'textarea',
			'input_attrs' => array('disabled' => 'disabled'),
			));
			
			//Pricing section Content
			
			if ( class_exists( 'Innofit_Repeater' ) ) {
			$wp_customize->add_setting( 'innofit_pricing_content', array(
			) );

			$wp_customize->add_control( new Innofit_Repeater( $wp_customize, 'innofit_pricing_content', array(
				'label'                             => esc_html__( 'Pricing content', 'spicebox' ),
				'section'                           => 'home_pricing_section',
				'add_field_label'                   => esc_html__( 'Add new Pricing', 'spicebox' ),
				'item_name'                         => esc_html__( 'Pricing', 'spicebox' ),
				'customizer_repeater_price_heighlight' => true,
				'customizer_repeater_title_control' => true,
				'customizer_repeater_price_control' => true,
				'customizer_repeater_features_control'  => true,
				'customizer_repeater_button_text_control'  => true,
				'customizer_repeater_link_control' => true,
				'customizer_repeater_checkbox_control' => true,
				
				) ) );
		}
			
?>