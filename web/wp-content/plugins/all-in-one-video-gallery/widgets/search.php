<?php

/**
 * Search Widget.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG_Widget_Search class.
 *
 * @since 1.0.0
 */
class AIOVG_Widget_Search extends WP_Widget {

	/**
     * Unique identifier for the widget.
     *
     * @since  1.0.0
	 * @access protected
     * @var    string
     */
    protected $widget_slug;
	
	/**
 	 * Get things started.
     *
     * @since 1.0.0
     */
	public function __construct() {
		$this->widget_slug = 'aiovg-widget-search';
		
		$options = array( 
			'classname'   => $this->widget_slug,
			'description' => __( 'A videos search form for your site.', 'all-in-one-video-gallery' ),
		);
		
		parent::__construct( $this->widget_slug, __( 'AIOVG - Search Form', 'all-in-one-video-gallery' ), $options );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ), 11 );		
	}

	/**
	 * Display the content of the widget.
	 *
	 * @since 1.0.0
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {		
		// Vars
		$page_settings = get_option( 'aiovg_page_settings' );
		
		$attributes = array(
			'widget_id'      => $args['widget_id'] . '-wrapper',
			'template'       => isset( $instance['template'] ) ? sanitize_text_field( $instance['template'] ) : 'vertical',
			'search_page_id' => $page_settings['search'],
			'has_category'   => isset( $instance['has_category'] ) ? (int) $instance['has_category'] : 0
		);
		
		// Process output
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . 'public/templates/search-form-template-' . $attributes['template'] . '.php' );
		
		echo $args['after_widget'];		
	}
	
	/**   
	 * Process widget options on save. 
	 * 
	 * @since 1.0.0
	 * @param array $new_instance The new options.
	 * @param array $old_instance The previous options.
	 */
	public function update( $new_instance, $old_instance ) {	
		$instance = array();
		
		$instance['title']        = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['template']     = isset( $new_instance['template'] ) ? sanitize_text_field( $new_instance['template'] ) : 'vertical';
		$instance['has_category'] = isset( $new_instance['has_category'] ) ? 1 : 0;
		
		return $instance;		
	}

	/**
	 * Display the options form on admin.
	 *
	 * @since 1.0.0
	 * @param array $instance The widget options.
	 */
	public function form( $instance ) {	
		$general_settings = get_option( 'aiovg_general_settings' );
		
		// Define the array of defaults
		$defaults = array(
			'title'        => __( 'Search Videos', 'all-in-one-video-gallery' ),
			'template'     => 'horizontal',
			'has_category' => 0
		);
		
		// Parse incoming $instance into an array and merge it with $defaults
		$instance = wp_parse_args(
			(array) $instance,
			$defaults
		);
		
        include AIOVG_PLUGIN_DIR . 'widgets/forms/search.php';		                    
	}        

	/**
 	 * Enqueue styles and scripts.
     *
     * @since 1.0.0
     */
	public function enqueue_styles_scripts() {	
		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			wp_enqueue_style( AIOVG_PLUGIN_SLUG . '-public' );
		}		
	}
		
}