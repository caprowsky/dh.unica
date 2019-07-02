<?php

/**
 * Video
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
 * AIOVG_Public_Video class.
 *
 * @since 1.0.0
 */
class AIOVG_Public_Video {
	
	/**
	 * Get things started.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "aiovg_video", array( $this, "run_shortcode_video" ) );
	}
	
	/**
	 * Always keep using our custom template for AIOVG player page.
	 *
	 * @since  1.0.0
	 * @param  string $template The path of the template to include.
	 * @return string $template Filtered template path.
	 */
	public function template_include( $template ) {	
		$page_settings = get_option( 'aiovg_page_settings' );

		if ( is_page( (int) $page_settings['player'] ) ) {
			$template = apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . 'public/templates/player.php' );
		}
		
		return $template;		
	}	
	
	/**
	 * Run the shortcode [aiovg_video].
	 *
	 * @since 1.0.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_video( $atts ) {		
		// Vars
		if ( ! $atts ) {
			$atts = array();
		}
		
		$post_id = 0;
		
		if ( ! empty( $atts['id'] ) ) {
			$post_id = (int) $atts['id'];
		} else {			
			$supported_formats = array( 'mp4', 'webm', 'ogv', 'youtube', 'vimeo', 'dailymotion', 'facebook', 'dash', 'hls' );
			$is_video_available = 0;
			
			foreach ( $supported_formats as $format ) {			
				if ( array_key_exists( $format, $atts ) ) {
					$is_video_available = 1;
				}				
			}
			
			if ( 0 == $is_video_available ) {			
				$args = array(				
					'post_type' => 'aiovg_videos',			
					'post_status' => 'publish',
					'posts_per_page' => 1,
					'fields' => 'ids',
					'no_found_rows' => true,
					'update_post_term_cache' => false,
					'update_post_meta_cache' => false
				);
		
				$aiovg_query = new WP_Query( $args );
				
				if ( $aiovg_query->have_posts() ) {
					$posts = $aiovg_query->posts;
					$post_id = (int) $posts[0];
				}			
			}			
		}
		
		// Enqueue dependencies
		wp_enqueue_style( AIOVG_PLUGIN_SLUG . '-public' );		
			
		// Return
		return aiovg_get_player_html( $post_id, $atts );		
	}
	
	/**
	 * Filter the post content.
	 *
	 * @since  1.0.0
	 * @param  string $content Content of the current post.
	 * @return string $content Modified Content.
	 */
	public function the_content( $content ) {	
		if ( is_singular( 'aiovg_videos' ) && in_the_loop() && is_main_query() ) {		
			global $post;
			
			// Vars
			$video_settings = get_option( 'aiovg_video_settings' );
			
			$attributes = array(
				'id'            => $post->ID,				
				'show_category' => isset( $video_settings['display']['category'] ),
				'show_date'     => isset( $video_settings['display']['date'] ),
				'show_user'     => isset( $video_settings['display']['user'] ),
				'show_views'    => isset( $video_settings['display']['views'] ),
				'related'       => isset( $video_settings['display']['related'] )
			);
			
			$attributes['categories'] = get_the_terms( get_the_ID(), 'aiovg_categories' );
			
			// Enqueue dependencies
			wp_enqueue_style( AIOVG_PLUGIN_SLUG . '-public' );
			
			// Process output
			ob_start();
			include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . 'public/templates/single-video.php' );
			$content = ob_get_clean();			
		}
		
		return $content;	
	}

	/**
	 * Update video views count.
	 *
	 * @since 1.0.0
	 */
	public function ajax_callback_update_views_count() {
		if ( isset( $_REQUEST['post_id'] ) ) {		
			$post_id = (int) $_REQUEST['post_id'];
						
			if ( $post_id > 0 ) {
				check_ajax_referer( 'aiovg_video_{$post_id}_views_nonce', 'security' );
				aiovg_update_views_count( $post_id );
			}		
		}
		
		wp_send_json_success();	
	}
	
}
