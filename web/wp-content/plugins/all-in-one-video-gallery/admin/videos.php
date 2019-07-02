<?php

/**
 * Videos
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
 * AIOVG_Admin_Videos class.
 *
 * @since 1.0.0
 */
class AIOVG_Admin_Videos {

	/**
	 * Register the custom post type "aiovg_videos".
	 *
	 * @since 1.0.0
	 */
	public function register_post_type() {	
		$video_settings     = get_option( 'aiovg_video_settings' );
		$permalink_settings = get_option( 'aiovg_permalink_settings' );
		
		$labels = array(
			'name'                  => _x( 'Videos', 'Post Type General Name', 'all-in-one-video-gallery' ),
			'singular_name'         => _x( 'Video', 'Post Type Singular Name', 'all-in-one-video-gallery' ),
			'menu_name'             => __( 'Video Gallery', 'all-in-one-video-gallery' ),
			'name_admin_bar'        => __( 'Video', 'all-in-one-video-gallery' ),
			'archives'              => __( 'Video Archives', 'all-in-one-video-gallery' ),
			'attributes'            => __( 'Video Attributes', 'all-in-one-video-gallery' ),
			'parent_item_colon'     => __( 'Parent Video:', 'all-in-one-video-gallery' ),
			'all_items'             => __( 'All Videos', 'all-in-one-video-gallery' ),
			'add_new_item'          => __( 'Add New Video', 'all-in-one-video-gallery' ),
			'add_new'               => __( 'Add New', 'all-in-one-video-gallery' ),
			'new_item'              => __( 'New Video', 'all-in-one-video-gallery' ),
			'edit_item'             => __( 'Edit Video', 'all-in-one-video-gallery' ),
			'update_item'           => __( 'Update Video', 'all-in-one-video-gallery' ),
			'view_item'             => __( 'View Video', 'all-in-one-video-gallery' ),
			'view_items'            => __( 'View Videos', 'all-in-one-video-gallery' ),
			'search_items'          => __( 'Search Video', 'all-in-one-video-gallery' ),
			'not_found'             => __( 'Not found', 'all-in-one-video-gallery' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'all-in-one-video-gallery' ),
			'featured_image'        => __( 'Featured Image', 'all-in-one-video-gallery' ),
			'set_featured_image'    => __( 'Set featured image', 'all-in-one-video-gallery' ),
			'remove_featured_image' => __( 'Remove featured image', 'all-in-one-video-gallery' ),
			'use_featured_image'    => __( 'Use as featured image', 'all-in-one-video-gallery' ),
			'insert_into_item'      => __( 'Insert into video', 'all-in-one-video-gallery' ),
			'uploaded_to_this_item' => __( 'Uploaded to this video', 'all-in-one-video-gallery' ),
			'items_list'            => __( 'Videos list', 'all-in-one-video-gallery' ),
			'items_list_navigation' => __( 'Videos list navigation', 'all-in-one-video-gallery' ),
			'filter_items_list'     => __( 'Filter videos list', 'all-in-one-video-gallery' ),
		);
		
		$supports = array( 'title', 'editor', 'author', 'excerpt' );			
		if ( ! empty( $video_settings['has_comments'] ) ) {
			$supports[] = 'comments';
		}	
		
		$args = array(
			'label'                 => __( 'Video', 'all-in-one-video-gallery' ),
			'description'           => __( 'Video Description', 'all-in-one-video-gallery' ),
			'labels'                => $labels,
			'supports'              => $supports,
			'taxonomies'            => array( ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => current_user_can( 'administrator' ) ? true : false,
			'show_in_menu'          => true,
			'menu_position'         => 10,
			'menu_icon'             => 'dashicons-playlist-video',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'show_in_rest'          => false,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'aiovg_video',
			'map_meta_cap'          => true,
		);
		
		if ( ! empty( $permalink_settings['video'] ) ) {
			$args['rewrite'] = array(
				'slug' => $permalink_settings['video']
			);
		}
		
		register_post_type( 'aiovg_videos', $args );	
	}
	
	/**
	 * Remove 'Add Media' button from the WP editor.
	 *
	 * @since 1.0.0
	 */
	public function remove_media_buttons() {		
		global $current_screen;
		if ( 'aiovg_videos' == $current_screen->post_type ) remove_action( 'media_buttons', 'media_buttons' );		
	}
	
	/**
	 * Adds custom meta fields in the "Publish" meta box.
	 *
	 * @since 1.0.0
	 */
	public function post_submitbox_misc_actions() {	
		global $post, $post_type;
		
		if ( 'aiovg_videos' == $post_type ) {
			$post_id  = $post->ID;
			$featured = get_post_meta( $post_id, 'featured', true );

			require_once AIOVG_PLUGIN_DIR . 'admin/partials/video-submitbox.php';
		}		
	}
	
	/**
	 * Register meta boxes.
	 *
	 * @since 1.0.0
	 */
	public function add_meta_boxes() {
		add_meta_box( 
			'aiovg-video-sources', 
			__( 'Video Sources', 'all-in-one-video-gallery' ), 
			array( $this, 'display_meta_box_video_sources' ), 
			'aiovg_videos', 
			'normal', 
			'high' 
		);
		
		add_meta_box( 
			'aiovg-video-tracks', 
			__( 'Subtitles', 'all-in-one-video-gallery' ), 
			array( $this, 'display_meta_box_video_tracks' ), 
			'aiovg_videos', 
			'normal', 
			'high' 
		);		
	}

	/**
	 * Display "Video Sources" meta box.
	 *
	 * @since 1.0.0
	 * @param WP_Post $post WordPress Post object.
	 */
	public function display_meta_box_video_sources( $post ) {		
		$post_meta = get_post_meta( $post->ID );
		
		$type        = isset( $post_meta['type'] ) ? $post_meta['type'][0] : 'default';
		$mp4         = isset( $post_meta['mp4'] ) ? $post_meta['mp4'][0] : '';
		$has_webm    = isset( $post_meta['has_webm'] ) ? $post_meta['has_webm'][0] : 0;
		$webm        = isset( $post_meta['webm'] ) ? $post_meta['webm'][0] : '';
		$has_ogv     = isset( $post_meta['has_ogv'] ) ? $post_meta['has_ogv'][0] : 0;
		$ogv         = isset( $post_meta['ogv'] ) ? $post_meta['ogv'][0] : '';
		$youtube     = isset( $post_meta['youtube'] ) ? $post_meta['youtube'][0] : '';
		$vimeo       = isset( $post_meta['vimeo'] ) ? $post_meta['vimeo'][0] : '';
		$dailymotion = isset( $post_meta['dailymotion'] ) ? $post_meta['dailymotion'][0] : '';
		$facebook    = isset( $post_meta['facebook'] ) ? $post_meta['facebook'][0] : '';
		$embedcode   = isset( $post_meta['embedcode'] ) ? $post_meta['embedcode'][0] : '';
		$image       = isset( $post_meta['image'] ) ? $post_meta['image'][0] : '';
		$duration    = isset( $post_meta['duration'] ) ? $post_meta['duration'][0] : '';
		$views       = isset( $post_meta['views'] ) ? $post_meta['views'][0] : '';

		require_once AIOVG_PLUGIN_DIR . 'admin/partials/video-sources.php';
	}
	
	/**
	 * Display "Subtitles" meta box.
	 *
	 * @since 1.0.0
	 * @param WP_Post $post WordPress Post object.
	 */
	public function display_meta_box_video_tracks( $post ) {		
		$tracks = get_post_meta( $post->ID, 'track' );
		require_once AIOVG_PLUGIN_DIR . 'admin/partials/video-tracks.php';
	}
	
	/**
	 * Save meta data.
	 *
	 * @since  1.0.0
	 * @param  int     $post_id Post ID.
	 * @param  WP_Post $post    The post object.
	 * @return int     $post_id If the save was successful or not.
	 */
	public function save_meta_data( $post_id, $post ) {	
		if ( ! isset( $_POST['post_type'] ) ) {
        	return $post_id;
    	}
	
		// Check this is the "aiovg_videos" custom post type
    	if ( 'aiovg_videos' != $post->post_type ) {
        	return $post_id;
    	}
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return $post_id;
		}
		
		// Check the logged in user has permission to edit this post
    	if ( ! aiovg_current_user_can( 'edit_aiovg_video', $post_id ) ) {
        	return $post_id;
    	}
		
		// Check if "aiovg_video_submitbox_nonce" nonce is set
    	if ( isset( $_POST['aiovg_video_submitbox_nonce'] ) ) {		
			// Verify that the nonce is valid
    		if ( wp_verify_nonce( $_POST['aiovg_video_submitbox_nonce'], 'aiovg_save_video_submitbox' ) ) {			
				// OK to save meta data.
				$featured = isset( $_POST['featured'] ) ? 1 : 0;
    			update_post_meta( $post_id, 'featured', $featured );				
			}			
		}
		
		// Check if "aiovg_video_sources_nonce" nonce is set
    	if ( isset( $_POST['aiovg_video_sources_nonce'] ) ) {		
			// Verify that the nonce is valid
    		if ( wp_verify_nonce( $_POST['aiovg_video_sources_nonce'], 'aiovg_save_video_sources' ) ) {			
				// OK to save meta data		
				$type = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : 'default';
				update_post_meta( $post_id, 'type', $type );
				
				$mp4 = isset( $_POST['mp4'] ) ? sanitize_text_field( $_POST['mp4'] ) : '';
				update_post_meta( $post_id, 'mp4', $mp4 );
				update_post_meta( $post_id, 'mp4_id', aiovg_get_attachment_id( $mp4, 'video' ) );
				
				$has_webm = isset( $_POST['has_webm'] ) ? 1 : 0;
				update_post_meta( $post_id, 'has_webm', $has_webm );
				
				$webm = isset( $_POST['webm'] ) ? sanitize_text_field( $_POST['webm'] ) : '';
				update_post_meta( $post_id, 'webm', $webm );
				update_post_meta( $post_id, 'webm_id', aiovg_get_attachment_id( $webm, 'video' ) );
				
				$has_ogv = isset( $_POST['has_ogv'] ) ? 1 : 0;
				update_post_meta( $post_id, 'has_ogv', $has_ogv );
				
				$ogv = isset( $_POST['ogv'] ) ? sanitize_text_field( $_POST['ogv'] ) : '';
				update_post_meta( $post_id, 'ogv', $ogv );
				update_post_meta( $post_id, 'ogv_id', aiovg_get_attachment_id( $ogv, 'video' ) );
				
				$youtube = isset( $_POST['youtube'] ) ? esc_url_raw( $_POST['youtube'] ) : '';
				update_post_meta( $post_id, 'youtube', $youtube );
				
				$vimeo = '';
				if ( isset( $_POST['vimeo'] ) ) {
					$vimeo = aiovg_get_vimeo_url_oembed( $_POST['vimeo'] );
					$vimeo = esc_url_raw( $vimeo );
				}
				update_post_meta( $post_id, 'vimeo', $vimeo );
				
				$dailymotion = isset( $_POST['dailymotion'] ) ? esc_url_raw( $_POST['dailymotion'] ) : '';
				update_post_meta( $post_id, 'dailymotion', $dailymotion );
				
				$facebook = isset( $_POST['facebook'] ) ? esc_url_raw( $_POST['facebook'] ) : '';
				update_post_meta( $post_id, 'facebook', $facebook );
				
				add_filter( 'wp_kses_allowed_html', 'aiovg_allow_iframes_filter' );
				$embedcode = isset( $_POST['embedcode'] ) ? wp_kses_post( $_POST['embedcode'] ) : '';
				update_post_meta( $post_id, 'embedcode', $embedcode );
				remove_filter( 'wp_kses_allowed_html', 'aiovg_allow_iframes_filter' );
				
				$image = '';
				if ( ! empty( $_POST['image'] ) ) {
					$image = sanitize_text_field( $_POST['image'] );
				} else {
					if ( 'youtube' == $type && ! empty( $youtube ) ) {
						$image = aiovg_get_youtube_image_url( $youtube );
					} elseif ( 'vimeo' == $type && ! empty( $vimeo ) ) {
						$image = aiovg_get_vimeo_image_url( $vimeo );
					} elseif ( 'dailymotion' == $type && ! empty( $dailymotion ) ) {
						$image = aiovg_get_dailymotion_image_url( $dailymotion );
					} elseif ( 'embedcode' == $type && ! empty( $embedcode ) ) {
						$image = aiovg_get_embedcode_image_url( $embedcode );
					}
				}
				update_post_meta( $post_id, 'image', $image );
				update_post_meta( $post_id, 'image_id', aiovg_get_attachment_id( $image, 'image' ) );
				
				$duration = isset( $_POST['duration'] ) ? sanitize_text_field( $_POST['duration'] ) : '';
				update_post_meta( $post_id, 'duration', $duration );
				
				$views = isset( $_POST['views'] ) ? (int) $_POST['views'] : 0;
				update_post_meta( $post_id, 'views', $views );				
			}			
		}
		
		// Check if "aiovg_video_tracks_nonce" nonce is set
    	if ( isset( $_POST['aiovg_video_tracks_nonce'] ) ) {		
			// Verify that the nonce is valid
    		if ( wp_verify_nonce( $_POST['aiovg_video_tracks_nonce'], 'aiovg_save_video_tracks' ) ) {			
				// OK to save meta data
				delete_post_meta( $post_id, 'track' );
				
				if ( ! empty( $_POST['track_src'] ) ) {				
					$sources = $_POST['track_src'];
					$sources = array_map( 'trim', $sources );	
					$sources = array_filter( $sources );
					
					foreach ( $sources as $key => $source ) {
						$track = array(
							'src'     => sanitize_text_field( $source ),
							'src_id'  => aiovg_get_attachment_id( $source, 'track' ),  
							'label'   => sanitize_text_field( $_POST['track_label'][ $key ] ),
							'srclang' => sanitize_text_field( $_POST['track_srclang'][ $key ] )
						);
						
						add_post_meta( $post_id, 'track', $track );
					}					
				}				
			}			
		}
		
		return $post_id;	
	}
	
	/**
	 * Add custom filter options.
	 *
	 * @since 1.0.0
	 */
	public function restrict_manage_posts() {	
		global $typenow, $wp_query;
		
		if ( 'aiovg_videos' == $typenow ) {			
			// Restrict by category
        	wp_dropdown_categories(array(
            	'show_option_none'  => __( "All Categories", 'all-in-one-video-gallery' ),
				'option_none_value' => 0,
            	'taxonomy'          => 'aiovg_categories',
            	'name'              => 'aiovg_categories',
            	'orderby'           => 'name',
            	'selected'          => isset( $wp_query->query['aiovg_categories'] ) ? $wp_query->query['aiovg_categories'] : '',
            	'hierarchical'      => true,
            	'depth'             => 3,
            	'show_count'        => false,
            	'hide_empty'        => false,
        	));			
			
			// Restrict by custom filtering options	
			$selected = isset( $_GET['aiovg_filter'] ) ? sanitize_text_field( $_GET['aiovg_filter'] ) : '';		
			$options  = array(
				''         => __( "All Videos", 'all-in-one-video-gallery' ),
				'featured' => __( "Featured only", 'all-in-one-video-gallery' )
			);
			$options = apply_filters( 'aiovg_admin_videos_custom_filters', $options );

			echo '<select name="aiovg_filter">';
			foreach ( $options as $value => $label ) {
				printf( '<option value="%s"%s>%s</option>', $value, selected( $value, $selected, false ), $label );
			}
			echo '</select>';
    	}	
	}
	
	/**
	 * Parse a query string and filter listings accordingly.
	 *
	 * @since 1.0.0
	 * @param WP_Query $query WordPress Query object.
	 */
	public function parse_query( $query ) {	
		global $pagenow, $post_type;
		
    	if ( 'edit.php' == $pagenow && 'aiovg_videos' == $post_type ) {			
			// Convert category id to taxonomy term in query
			if ( isset( $query->query_vars['aiovg_categories'] ) && ctype_digit( $query->query_vars['aiovg_categories'] ) && 0 != $query->query_vars['aiovg_categories'] ) {		
        		$term = get_term_by( 'id', $query->query_vars['aiovg_categories'], 'aiovg_categories' );
        		$query->query_vars['aiovg_categories'] = $term->slug;			
    		}

			// Set featured meta in query
			if ( isset( $_GET['aiovg_filter'] ) && 'featured' == $_GET['aiovg_filter'] ) {		
        		$query->query_vars['meta_key']   = 'featured';
        		$query->query_vars['meta_value'] = 1;			
    		}			
		}	
	}
	
	/**
	 * Retrieve the table columns.
	 *
	 * @since  1.0.0
	 * @param  array $columns Array of default table columns.
	 * @return array          Filtered columns array.
	 */
	public function get_columns( $columns ) {			
		$new_columns = array(
			'views'    => __( 'Views', 'all-in-one-video-gallery' ),
			'featured' => __( 'Featured', 'all-in-one-video-gallery' ),
			'post_id'  => __( 'ID', 'all-in-one-video-gallery' )
		);
		
		$taxonomy_column = 'taxonomy-aiovg_categories';
		
		return aiovg_insert_array_after( $taxonomy_column, $columns, $new_columns );		
	}
	
	/**
	 * This function renders the custom columns in the list table.
	 *
	 * @since 1.0.0
	 * @param string $column  The name of the column.
	 * @param string $post_id Post ID.
	 */
	public function custom_column_content( $column, $post_id ) {	
		switch ( $column ) {
			case 'views':
				echo get_post_meta( $post_id, 'views', true );
				break;
			case 'featured':
				$value = get_post_meta( $post_id, 'featured', true );
				printf( '<span class="aiovg-tick-cross">%s</span>', ( 1 == $value ? '&#x2713;' : '&#x2717;' ) );
				break;
			case 'post_id':
				echo $post_id;
				break;
		}		
	}
	
	/**
	 * Delete video attachments.
	 *
	 * @since 1.0.0
	 * @param int   $post_id Post ID.
	 */
	public function before_delete_post( $post_id ) {		
		if ( 'aiovg_videos' != get_post_type( $post_id ) ) {
			return;
		}
		  
		aiovg_delete_video_attachments( $post_id );	
	}

}
