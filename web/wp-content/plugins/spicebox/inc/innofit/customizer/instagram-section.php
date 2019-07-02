<?php
//Gallery Section
		$wp_customize->add_section('innofit_gellary_section',array(
				'title' => __('Gallery settings','spicebox'),
				'panel' => 'section_settings',
				'priority'       => 16,
				));
		
		//Gallery plus
		class Innofit_gallery_section_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
			<h3><?php _e('Want to add gallery section? Then','spicebox'); ?><a href="<?php echo esc_url( 'https://spicethemes.com/innofit-plus/' ); ?>" target="_blank">
			<?php _e('Upgrade to Plus','spicebox'); ?> </a>  
			<?php
			}
		}
		
		
		$wp_customize->add_setting( 'gallery_upgrade', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Innofit_gallery_section_upgrade(
			$wp_customize,
			'gallery_upgrade',
				array(
					'section'				=> 'innofit_gellary_section',
					'settings'				=> 'gallery_upgrade',
				)
			)
		);
		
		
		// Enable gallery section
		$wp_customize->add_setting( 'gallery_section_enable' , array( 'default' => 'on') );
		$wp_customize->add_control(	'gallery_section_enable' , array(
					'label'    => __( 'Enable Home Gallery section', 'spicebox' ),
					'section'  => 'innofit_gellary_section',
					'type'     => 'radio',
					'choices' => array(
						'on'=>__('ON', 'spicebox'),
						'off'=>__('OFF', 'spicebox')
					),
					'input_attrs' => array('disabled' => 'disabled'),
			));
		
		// Gallery shortcode
		$wp_customize->add_setting('home_gallery_shortcode',array(
		'capability'  => 'edit_theme_options',
		
		));
		$wp_customize->add_control('home_gallery_shortcode',array(
		'label' => __('Gallery shortcode','spicebox'),
		'section' => 'innofit_gellary_section',
		'type' => 'textarea',
		'input_attrs' => array('disabled' => 'disabled'),
		));
?>