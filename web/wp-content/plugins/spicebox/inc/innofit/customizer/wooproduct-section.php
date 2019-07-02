<?php
	$wp_customize->add_section('innofit_shop_section',array(
			'title' => __('Home Shop settings','spicebox'),
			'panel' => 'section_settings',
			'priority'       => 5,
			));
		
			$wp_customize->add_setting( 'shop_section_enable' , array( 'default' => 'on') );
			$wp_customize->add_control(	'shop_section_enable' , array(
					'label'    => __( 'Enable Home Shop section', 'spicebox' ),
					'section'  => 'innofit_shop_section',
					'type'     => 'radio',
					'choices' => array(
						'on'=>__('ON', 'spicebox'),
						'off'=>__('OFF', 'spicebox')
					)
			));
			
			// Shop section title
			$wp_customize->add_setting( 'home_shop_section_title',array(
			'default' => __('Featured Products','spicebox'),
			'sanitize_callback' => 'innofit_home_page_sanitize_text',
			'transport'         => $selective_refresh,
			));	
			$wp_customize->add_control( 'home_shop_section_title',array(
			'label'   => __('Title','spicebox'),
			'section' => 'innofit_shop_section',
			'type' => 'text',
			));	
			
			//Shop section discription
			$wp_customize->add_setting( 'home_shop_section_discription',array(
			'default'=> __('Our amazing products','spicebox'),
			'transport'         => $selective_refresh,
			));	
			$wp_customize->add_control( 'home_shop_section_discription',array(
			'label'   => __('Description','spicebox'),
			'section' => 'innofit_shop_section',
			'type' => 'textarea',
			));
			
			
			//Plus Shop	
		class WP_shop_plus_Customize_Control extends WP_Customize_Control {
		public $type = 'new_menu';
		/**
		* Render the control's content.
		*/
		public function render_content() {
		?>
		 <div class="pro-vesrion">
		 <P><?php esc_html_e('More options available for Shop section in Innofit Plus','spicebox');?></P>
		 </div>
		  <div class="pro-box">
		 <a href="<?php echo esc_url('https://spicethemes.com/innofit-plus/');?>" class="read-more-button" id="review_plus" target="_blank"><?php esc_html_e( 'Upgrade to Plus','spicebox' ); ?></a>
		 <div>
		<?php
		}
	    }

		$wp_customize->add_setting(
			'add_plus_shop',
			array(
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)	
		);
		$wp_customize->add_control( new WP_shop_plus_Customize_Control( $wp_customize, 'add_plus_shop', array(	
				'section' => 'innofit_shop_section',
				'setting' => 'add_plus_shop',
		
		)));
			
			
	/**
	 * Add selective refresh for Front page shop section controls.
	 */
	
	
	$wp_customize->selective_refresh->add_partial( 'home_shop_section_title', array(
		'selector'            => '.shop .section-subtitle',
		'settings'            => 'home_shop_section_title',
		'render_callback'  => 'home_shop_section_title_render_callback',
	
	) );
	
	$wp_customize->selective_refresh->add_partial( 'home_shop_section_discription', array(
		'selector'            => '.shop .section-title',
		'settings'            => 'home_shop_section_discription',
		'render_callback'  => 'home_shop_section_discription_render_callback',
	
	) );
		
?>