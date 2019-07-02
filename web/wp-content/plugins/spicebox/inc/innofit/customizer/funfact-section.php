<?php

		//Pricing section plus
		class Innofit_funfact_section_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
			<h3><?php _e('Want to add funcfact section? Then','spicebox'); ?><a href="<?php echo esc_url( 'https://spicethemes.com/innofit-plus/' ); ?>" target="_blank">
			<?php _e('Upgrade to Plus','spicebox'); ?> </a>  
			<?php
			}
		}
		
		
		$wp_customize->add_setting( 'funfact_upgrade', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Innofit_funfact_section_upgrade(
			$wp_customize,
			'funfact_upgrade',
				array(
					'section'				=> 'funfact_section',
					'settings'				=> 'funfact_upgrade',
				)
			)
		);


    /* funfact section */
		$wp_customize->add_setting( 'funfact_section_enabled' , array( 'default' => 'on') );
		$wp_customize->add_control(	'funfact_section_enabled' , array(
				'label'    => __( 'Enable Funfact on homepage', 'spicebox' ),
				'section'  => 'funfact_section',
				'type'     => 'radio',
				'choices' => array(
					'on'=>__('ON', 'spicebox'),
					'off'=>__('OFF', 'spicebox')
				)
		));
	
	
	$wp_customize->add_section( 'funfact_section' , array(
		'title'      => __('Funfact settings', 'spicebox'),
		'panel'  => 'section_settings',
		'priority'   => 5,
	) );
	
	if ( class_exists( 'Innofit_Repeater' ) ) {
			$wp_customize->add_setting( 'innofit_funfact_content', array(
			) );

			$wp_customize->add_control( new Innofit_Repeater( $wp_customize, 'innofit_funfact_content', array(
				'label'                             => esc_html__( 'Funfact content', 'spicebox' ),
				'section'                           => 'funfact_section',
				'priority'                          => 10,
				'add_field_label'                   => esc_html__( 'Add new Funfact', 'spicebox' ),
				'item_name'                         => esc_html__( 'Funfact', 'spicebox' ),
				'customizer_repeater_icon_control'  => true,
				'customizer_repeater_title_control' => true,
				'customizer_repeater_text_control'  => true,
				) ) );
	}	


	/**
	 * Add selective refresh for Front page funfact section controls.
	 */

    $wp_customize->selective_refresh->add_partial( 'innofit_funfact_content', array(
		'selector'            => '.funfact .container',
		'settings'            => 'innofit_funfact_content',
		
	) );
?>