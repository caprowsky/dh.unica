<?php
	//Latest News Section
	$wp_customize->add_section('innofit_latest_news_section',array(
			'title' => __('Latest News settings','innofit'),
			'panel' => 'section_settings',
			'priority'       => 11,
			));
		
			
			// Enable news section
			$wp_customize->add_setting( 'latest_news_section_enable' , array( 'default' => 'on',   'sanitize_callback' => 'innofit_sanitize_radio',) );
			$wp_customize->add_control(	'latest_news_section_enable' , array(
					'label'    => __( 'Enable Home News section', 'innofit' ),
					'section'  => 'innofit_latest_news_section',
					'type'     => 'radio',
					'choices' => array(
						'on'=>__('ON', 'innofit'),
						'off'=>__('OFF', 'innofit')
					)
			));

		// News section title
		$wp_customize->add_setting( 'home_news_section_title',array(
		'capability'     => 'edit_theme_options',
		'default' => __('Latest News','innofit'),
		'sanitize_callback' => 'spiceb_innofit_home_page_sanitize_text',
		'transport'         => $selective_refresh,
		));	
		$wp_customize->add_control( 'home_news_section_title',array(
		'label'   => __('Title','innofit'),
		'section' => 'innofit_latest_news_section',
		'type' => 'text',
		));	
		
		//News section discription
		$wp_customize->add_setting( 'home_news_section_discription',array(
		'default'=> __('From our blog','innofit'),
		'sanitize_callback' => 'spiceb_innofit_home_page_sanitize_text',
		'transport'         => $selective_refresh,
		));	
		$wp_customize->add_control( 'home_news_section_discription',array(
		'label'   => __('Description','innofit'),
		'section' => 'innofit_latest_news_section',
		'type' => 'textarea',
		));	

		// enable / disable meta section 
		$wp_customize->add_setting(
			'home_meta_section_settings',
			array('capability'  => 'edit_theme_options',
			'default' => true,
			'sanitize_callback' => 'innofit_sanitize_checkbox',
			
			));
		$wp_customize->add_control(
			'home_meta_section_settings',
			array(
				'type' => 'checkbox',
				'label' => __('Enable post meta in blog section','innofit'),
				'section' => 'innofit_latest_news_section',
			)
		);
		
		//Plus Blog
		class WP_news_plus_Customize_Control extends WP_Customize_Control {
		public $type = 'new_menu';
		/**
		* Render the control's content.
		*/
		public function render_content() {
		?>
		 <div class="pro-vesrion">
		 <P><?php esc_html_e('More options available for News section in Innofit Plus','spicebox');?></P>
		 </div>
		  <div class="pro-box">
		 <a href="<?php echo esc_url('https://spicethemes.com/innofit-plus/');?>" class="read-more-button" id="review_plus" target="_blank"><?php esc_html_e( 'Upgrade to Plus','spicebox' ); ?></a>
		 <div>
		<?php
		}
	    }

		$wp_customize->add_setting(
			'add_plus_news',
			array(
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
			)	
		);
		$wp_customize->add_control( new WP_news_plus_Customize_Control( $wp_customize, 'add_plus_news', array(	
				'section' => 'innofit_latest_news_section',
				'setting' => 'add_plus_news',
		
		)));

		
	/**
	* Add selective refresh for Front page testimonial section controls.
	*/
	
	$wp_customize->selective_refresh->add_partial( 'home_news_section_title', array(
		'selector'            => '.home-blog .section-header p',
		'settings'            => 'home_news_section_title',
		'render_callback'  => 'home_news_section_title_render_callback',
	
	) );
	
	$wp_customize->selective_refresh->add_partial( 'home_news_section_discription', array(
		'selector'            => '.home-blog .section-header h1',
		'settings'            => 'home_news_section_discription',
		'render_callback'  => 'home_news_section_discription_render_callback',
	
	) );	
		

?>