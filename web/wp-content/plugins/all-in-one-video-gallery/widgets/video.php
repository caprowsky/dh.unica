<?php

/**
 * Video Player Widget.
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
 * AIOVG_Widget_Video class.
 *
 * @since 1.0.0
 */
class AIOVG_Widget_Video extends WP_Widget {
	
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
		$this->widget_slug = 'aiovg-widget-video';
		
		$options = array( 
			'classname'   => $this->widget_slug,
			'description' => __( 'Display a video player.', 'all-in-one-video-gallery' ),
		);
		
		parent::__construct( $this->widget_slug, __( 'AIOVG - Video Player', 'all-in-one-video-gallery' ), $options );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ), 11 );	
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since 1.0.0
	 * @param array	$args	  The array of form elements.
	 * @param array $instance The current instance of the widget.
	 */
	public function widget( $args, $instance ) {
		// Vars
		$post_id = 0;
				
		if ( ! empty( $instance['id'] ) ) {
			$post_id = (int) $instance['id'];
		} else {
			$query_args = array(				
				'post_type' => 'aiovg_videos',			
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'fields' => 'ids',
				'no_found_rows' => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false
			);
	
			$aiovg_query = new WP_Query( $query_args );
			
			if ( $aiovg_query->have_posts() ) {
				$posts = $aiovg_query->posts;
				$post_id = (int) $posts[0];
			}
		}

		// Process output
		echo $args['before_widget'];
		
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		the_aiovg_player( $post_id, $instance );
	
		echo $args['after_widget'];
	}
	
	/**
	 * Processes the widget's options to be saved.
	 *
	 * @since 1.0.0
	 * @param array $new_instance The new instance of values to be generated via the update.
	 * @param array $old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title']      = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['id']         = isset( $new_instance['id'] ) ? (int) $new_instance['id'] : '';
		$instance['width']      = isset( $new_instance['width'] ) ? sanitize_text_field( $new_instance['width'] ) : '';
		$instance['ratio']      = isset( $new_instance['ratio'] ) ? (float) $new_instance['ratio'] : 0;		
		$instance['autoplay']   = isset( $new_instance['autoplay'] ) ? 1 : 0;	
		$instance['loop']       = isset( $new_instance['loop'] ) ? 1 : 0;	
		$instance['playpause']  = isset( $new_instance['playpause'] ) ? 1 : 0;
		$instance['current']    = isset( $new_instance['current'] ) ? 1 : 0;
		$instance['progress']   = isset( $new_instance['progress'] ) ? 1 : 0;	
		$instance['duration']   = isset( $new_instance['duration'] ) ? 1 : 0;
		$instance['tracks']     = isset( $new_instance['tracks'] ) ? 1 : 0;
		$instance['volume']     = isset( $new_instance['volume'] ) ? 1 : 0;
		$instance['fullscreen'] = isset( $new_instance['fullscreen'] ) ? 1 : 0;
		
		return $instance;
	}
	
	/**
	 * Generates the administration form for the widget.
	 *
	 * @since 1.0.0
	 * @param array $instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {
		$player_settings = get_option( 'aiovg_player_settings' );
		
		// Define the array of defaults
		$defaults = array(
			'title'      => '',
			'id'         => 0,
			'width'      => $player_settings['width'],
			'ratio'      => $player_settings['ratio'],
			'autoplay'   => $player_settings['autoplay'],
			'loop'       => $player_settings['loop'],
			'playpause'  => isset( $player_settings['controls']['playpause'] ) ? 1 : 0,
			'current'    => isset( $player_settings['controls']['current'] ) ? 1 : 0,
			'progress'   => isset( $player_settings['controls']['progress'] ) ? 1 : 0,
			'duration'   => isset( $player_settings['controls']['duration'] ) ? 1 : 0,
			'tracks'     => isset( $player_settings['controls']['tracks'] ) ? 1 : 0,
			'volume'     => isset( $player_settings['controls']['volume'] ) ? 1 : 0,
			'fullscreen' => isset( $player_settings['controls']['fullscreen'] ) ? 1 : 0
		);
		
		// Parse incoming $instance into an array and merge it with $defaults
		$instance = wp_parse_args(
			(array) $instance,
			$defaults
		);
			
		// Display the admin form
		include AIOVG_PLUGIN_DIR . 'widgets/forms/video.php';
	}
	
	/**
	 * Enqueues widget-specific styles & scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles_scripts() {	
		if ( is_active_widget( false, $this->id, $this->id_base, true ) ) {
			wp_enqueue_style( AIOVG_PLUGIN_SLUG . '-public' );
		}
	}
	
}