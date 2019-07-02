<?php
  /* Portfolio Section */
	$wp_customize->add_section( 'portfolio_section' , array(
			'title'      => __('Portfolio settings', 'spicebox'),
			'panel'  => 'section_settings',
			'priority'   => 4,
		) );
		
		
		
		
		//Portfolio plus
		class Innofit_portfolio_section_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
			<h3><?php _e('Want to add portfolio section? Then','spicebox'); ?><a href="<?php echo esc_url( 'https://spicethemes.com/innofit-plus/' ); ?>" target="_blank">
			<?php _e('Upgrade to Plus','spicebox'); ?> </a>  
			<?php
			}
		}
		
		
		$wp_customize->add_setting( 'portfolio_upgrade', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Innofit_portfolio_section_upgrade(
			$wp_customize,
			'portfolio_upgrade',
				array(
					'section'				=> 'portfolio_section',
					'settings'				=> 'portfolio_upgrade',
				)
			)
		);
	
		
		
		
		// Enable portfolio more btn
		$wp_customize->add_setting( 'portfolio_section_enable' , array( 'default' => 'on') );
		$wp_customize->add_control(	'portfolio_section_enable' , array(
				'label'    => __( 'Enable Home Portfolio section', 'spicebox' ),
				'section'  => 'portfolio_section',
				'type'     => 'radio',
				'choices' => array(
					'on'=>__('ON', 'spicebox'),
					'off'=>__('OFF', 'spicebox')
				),
				'disabled' => array('disabled' => ''),
		));	
		
		// room section title
		$wp_customize->add_setting( 'home_portfolio_section_title',array(
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'innofitp_home_page_sanitize_text',
		'default' => __('Look at our projects','spicebox'),
		'transport'         => $selective_refresh,
		));	
		$wp_customize->add_control( 'home_portfolio_section_title',array(
		'label'   => __('Title','spicebox'),
		'section' => 'portfolio_section',
		'type' => 'text',
		'input_attrs' => array('disabled' => 'disabled'),
		));	
		
		
		
		
	//link
		class WP_portfolio_Customize_Control extends WP_Customize_Control {
		public $type = 'new_menu';
		/**
		* Render the control's content.
		*/
		public function render_content() {
		?>
		<a href="#" class="button" disabled target="_blank"><?php _e( 'Click here to add project', 'spicebox' ); ?></a>
		<?php
		}
	}

	$wp_customize->add_setting(
		'plus_project',
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		)	
	);
	$wp_customize->add_control( new WP_portfolio_Customize_Control( $wp_customize, 'plus_project', array(	
			'section' => 'portfolio_section',
		))
	);	
?>