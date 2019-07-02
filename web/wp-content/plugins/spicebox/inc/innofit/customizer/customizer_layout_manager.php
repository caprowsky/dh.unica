<?php // Adding customizer layout manager settings

class WP_innofit_layout_Customize_Control extends WP_Customize_Control {	

	public $type = 'new_menu';
	
	public function render_content() {
		
		$front_page = get_theme_mod('front_page_data','services,about,portfolio,funfact,wooproduct,testimonial,team,pricing,news,map,contact,subscriber,client,instagram');
		$data_enable = explode(",",$front_page);	
		$defaultenableddata=array('services','about','portfolio','funfact','wooproduct','testimonial','team','pricing','news','map','contact','subscriber','client','instagram');
		$layout_disable=array_diff($defaultenableddata,$data_enable);  
		?>
		
		<h3><?php esc_attr_e('Enable','spicebox'); ?></h3>
		  <ul class="sortable customizer_layout" id="enable">
		  <?php if( !empty($data_enable[0]) )    { foreach( $data_enable as $value ){ ?>
		  <li class="ui-state" id="<?php echo $value; ?>"><?php echo $value; ?></li>
		  <?php } } ?>
		  </ul>
  
  
		 <h3><?php esc_attr_e('Disable','spicebox'); ?></h3> 
		 <ul class="sortable customizer_layout" id="disable">
		 <?php if(!empty($layout_disable)){ foreach($layout_disable as $val){ ?>
		  <li class="ui-state" id="<?php echo $val; ?>"><?php echo $val; ?></li>
		  <?php } } ?>
		 </ul>
		 <div class="section">
		 <p> <b><?php esc_attr_e('Slider has fixed position on homepage','spicebox'); ?></b></p>
		 <p> <b><?php esc_attr_e('Note','spicebox'); ?> </b> <?php esc_attr_e('By default, all sections are enabled on homepage. If you wish not to display a section, just drag it onto the "disabled" box.','spicebox'); ?><p>
		</div>
<script>
jQuery(document).ready(function($) {
    $( ".sortable" ).sortable({
		connectWith: '.sortable'
	});
  });
   
jQuery(document).ready(function($){	
	
	// Get items id you can chose
	function innofitItems(spicethemes)
	{
		var columns = [];
		$(spicethemes + ' #enable').each(function(){
			columns.push($(this).sortable('toArray').join(','));
		});
		return columns.join('|');
	}
	
	function spicethemesItems_disable(spicethemes)
	{
		var columns = [];
		$(spicethemes + ' #disable').each(function(){
			columns.push($(this).sortable('toArray').join(','));
		});
		return columns.join('|');
	}
	
	//onclick check id
	$('#enable .ui-state,#disable .ui-state').mouseleave(function(){ 
		var enable = innofitItems('#customize-control-layout_manager');
		$("#customize-control-front_page_data input[type = 'text']").val(enable);
		$("#customize-control-front_page_data input[type = 'text']").change();		
	});

  });
</script>
<?php } }
	/* layout manager section */
	$wp_customize->add_section( 'frontpage_layout' , array(
		'title'      => __('Theme Layout Manager', 'spicebox'),
		'priority'       => 991,
   	) );
	
	//Theme Custom typography plus
		class Innofit_layout_manager_section_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
			<h3><?php _e('Want to change home page layout section? Then','spicebox'); ?><a href="<?php echo esc_url( 'https://spicethemes.com/innofit-plus/' ); ?>" target="_blank">
			<?php _e('Upgrade to Plus','spicebox'); ?> </a>  
			<?php
			}
		}
		
		
		$wp_customize->add_setting( 'layoutmanager_upgrade', array(
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Innofit_layout_manager_section_upgrade(
			$wp_customize,
			'layoutmanager_upgrade',
				array(
					'section'				=> 'frontpage_layout',
					'settings'				=> 'layoutmanager_upgrade',
				)
			)
		);
	
	$wp_customize->add_setting(
		'layout_manager',
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
			
		)	
	);
	$wp_customize->add_control( new WP_innofit_layout_Customize_Control( $wp_customize, 'layout_manager', array(
			'section' => 'frontpage_layout',
			'setting' => 'layout_manager',
		))
	);
	
	$wp_customize->add_setting(
		'front_page_data',
		array(
			'default'           =>'services,about,portfolio,funfact,wooproduct,testimonial,team,pricing,news,map,contact,subscriber,client,instagram',
			'capability'        =>  'edit_theme_options',
			'sanitize_callback' =>  'sanitize_text_field',
		)	
	);
	$wp_customize->add_control('front_page_data', array(
			'label' => __('Enable','spicebox'),
			'section' => 'frontpage_layout',
			'type'    =>  'text'
	));	 // enable textbox