<?php

/**
 * Blocks Initializer.
 *
 * @link    https://plugins360.com
 * @since   1.5.6
 *
 * @package All_In_One_Video_Gallery
 */

// Exit if accessed directly
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * AIOVG_Blocks class.
 *
 * @since 1.5.6
 */
class AIOVG_Blocks {

	/**
	 * Register our custom Gutenberg block category.
	 *
	 * @since  1.5.6
	 * @param  array $categories Default Gutenberg block categories.
	 * @return array             Modified Gutenberg block categories.
	 */
	public function block_categories( $categories ) {		
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'all-in-one-video-gallery',
					'title' => __( 'All-in-One Video Gallery', 'all-in-one-video-gallery' ),
				),
			)
		);		
	}

	/**
	 * Enqueue Gutenberg block assets for backend editor.
	 *
	 * @since 1.5.6
	 */
	public function enqueue_block_editor_assets() {
		$categories_settings = get_option( 'aiovg_categories_settings' );
		$videos_settings     = get_option( 'aiovg_videos_settings' );
		$player_settings     = get_option( 'aiovg_player_settings' );

		$fields = aiovg_get_block_fields();
		$videos = $fields['videos'];

		foreach ( $videos as $key => $section ) {
			foreach ( $section['fields'] as $_key => $field ) {
				if ( in_array( $field['name'], array( 'title', 'exclude', 'ratio', 'excerpt_length', 'show_more', 'more_label', 'more_link' ) ) ) {
					unset( $videos[ $key ]['fields'][ $_key ] );
					continue;
				}

				if ( isset( $field['description'] ) ) {
					$videos[ $key ]['fields'][ $_key ]['description'] = strip_tags( $field['description'] );
				}
			}
		}

		$attributes = array(
			'i18n'       => array(
				'block_categories_title'       => __( 'AIOVG - Video Categories', 'all-in-one-video-gallery' ),
				'block_categories_description' => __( 'Display a list of video categories.', 'all-in-one-video-gallery' ),
				'top_categories'               => __( 'Top Categories', 'all-in-one-video-gallery' ),
				'categories_settings'          => __( 'Categories Settings', 'all-in-one-video-gallery' ),
				'select_parent'                => __( 'Select Parent', 'all-in-one-video-gallery' ),
				'select_template'              => __( 'Select Template', 'all-in-one-video-gallery' ),
				'grid'                         => __( 'Grid', 'all-in-one-video-gallery' ),
				'list'                         => __( 'List', 'all-in-one-video-gallery' ),
				'columns'                      => __( 'Columns', 'all-in-one-video-gallery' ),
				'order_by'                     => __( 'Order By', 'all-in-one-video-gallery' ),
				'id'                           => __( 'ID', 'all-in-one-video-gallery' ),
				'count'                        => __( 'Count', 'all-in-one-video-gallery' ),
				'name'                         => __( 'Name', 'all-in-one-video-gallery' ),
				'slug'                         => __( 'Slug', 'all-in-one-video-gallery' ),
				'order'                        => __( 'Order', 'all-in-one-video-gallery' ),
				'asc'                          => __( 'ASC', 'all-in-one-video-gallery' ),
				'desc'                         => __( 'DESC', 'all-in-one-video-gallery' ),
				'show_hierarchy'               => __( 'Show Hierarchy', 'all-in-one-video-gallery' ),
				'show_description'             => __( 'Show Description', 'all-in-one-video-gallery' ),
				'show_videos_count'            => __( 'Show Videos Count', 'all-in-one-video-gallery' ),
				'hide_empty_categories'        => __( 'Hide Empty Categories', 'all-in-one-video-gallery' ),
				'block_videos_title'           => __( 'AIOVG - Video Gallery', 'all-in-one-video-gallery' ),
				'block_videos_description'     => __( 'Display a Video gallery.', 'all-in-one-video-gallery' ),
				'select_color'                 => __( 'Selected Color', 'all-in-one-video-gallery' ),
				'block_search_title'           => __( 'AIOVG - Search Form', 'all-in-one-video-gallery' ),
				'block_search_description'     => __( 'A videos search form for your site.', 'all-in-one-video-gallery' ),
				'search_form_settings'         => __( 'Search Form Settings', 'all-in-one-video-gallery' ),
				'vertical'                     => __( 'Vertical', 'all-in-one-video-gallery' ),
				'horizontal'                   => __( 'Horizontal', 'all-in-one-video-gallery' ),
				'search_by_categories'         => __( 'Search By Categories', 'all-in-one-video-gallery' ),
				'block_video_title'            => __( 'AIOVG - Video Player', 'all-in-one-video-gallery' ),
				'block_video_description'      => __( 'Display a video player.', 'all-in-one-video-gallery' ),
				'media_placeholder_title'      => __( 'Add MP4, WebM, OGV, YouTube, Vimeo, Dailymotion, Facebook, etc.', 'all-in-one-video-gallery' ),
				'media_placeholder_name'       => __( 'a video', 'all-in-one-video-gallery' ),
				'edit_video'                   => __( 'Edit video', 'all-in-one-video-gallery' ),
				'general_settings'             => __( 'General Settings', 'all-in-one-video-gallery' ),
				'width'                        => __( 'Width', 'all-in-one-video-gallery' ),
				'width_help'                   => __( 'In pixels. Maximum width of the player. Leave this field empty to scale 100% of its enclosing container/html element.', 'all-in-one-video-gallery' ),
				'ratio'                        => __( 'Ratio', 'all-in-one-video-gallery' ),
				'ratio_help'                   => __( "In percentage. 1 to 100. Calculate player's height using the ratio value entered.", 'all-in-one-video-gallery' ),
				'autoplay'                     => __( 'Autoplay', 'all-in-one-video-gallery' ),
				'loop'                         => __( 'Loop', 'all-in-one-video-gallery' ),
				'poster_image'                 => __( 'Poster Image', 'all-in-one-video-gallery' ),
				'select_poster_image'          => __( 'Select Poster Image', 'all-in-one-video-gallery' ),
				'replace_image'                => __( 'Replace Image', 'all-in-one-video-gallery' ),
				'remove_poster_image'          => __( 'Remove Poster Image', 'all-in-one-video-gallery' ),
				'player_controls'              => __( 'Player Controls', 'all-in-one-video-gallery' ),
				'play_pause'                   => __( 'Play / Pause', 'all-in-one-video-gallery' ),
				'current_time'                 => __( 'Current Time', 'all-in-one-video-gallery' ),
				'progressbar'                  => __( 'Progressbar', 'all-in-one-video-gallery' ),
				'duration'                     => __( 'Duration', 'all-in-one-video-gallery' ),
				'volume'                       => __( 'Volume', 'all-in-one-video-gallery' ),
				'fullscreen'                   => __( 'Fullscreen', 'all-in-one-video-gallery' )
			),
			'categories' => array(
				'id'               => 0,
				'template'         => $categories_settings['template'],
				'columns'          => $categories_settings['columns'],
				'orderby'          => $categories_settings['orderby'],
				'order'            => $categories_settings['order'],
				'hierarchical'     => $categories_settings['hierarchical'],
				'show_description' => $categories_settings['show_description'],
				'show_count'       => $categories_settings['show_count'],
				'hide_empty'       => $categories_settings['hide_empty']
			),
			'videos' => $videos,
			'search' => array(
				'template'         => 'horizontal',
				'category'         => false
			),
			'video'	=> array(
				'src'              => '',
				'poster'           => '',
				'width'            => 0,
				'ratio'            => $player_settings['ratio'],
				'autoplay'         => $player_settings['autoplay'] ? true : false,
				'loop'             => $player_settings['loop'] ? true : false,
				'playpause'        => isset( $player_settings['controls']['playpause'] ),
				'current'          => isset( $player_settings['controls']['current'] ),
				'progress'         => isset( $player_settings['controls']['progress'] ),
				'duration'         => isset( $player_settings['controls']['duration'] ),					
				'volume'           => isset( $player_settings['controls']['volume'] ),
				'fullscreen'       => isset( $player_settings['controls']['fullscreen'] )
			)
		);

		// Styles
		wp_enqueue_style( 
			AIOVG_PLUGIN_SLUG . '-public', 
			AIOVG_PLUGIN_URL . 'public/assets/css/public.css', 
			array(), 
			AIOVG_PLUGIN_VERSION
		);
		
		// Scripts
		wp_enqueue_script(
			'aiovg-guten-blocks-js',
			plugins_url( '/blocks/dist/blocks.build.js', dirname( __FILE__ ) ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element' ),
			filemtime( plugin_dir_path( __DIR__ ) . 'blocks/dist/blocks.build.js' ),
			true
		);

		wp_localize_script( 
			'aiovg-guten-blocks-js', 
			'aiovg_blocks', 
			$attributes
		);		

	}	

	/**
	 * Register our custom blocks.
	 * 
	 * @since 1.5.6
	 */
	public function register_block_types() {
		// Hook the post rendering to the block
		if ( function_exists( 'register_block_type' ) ) {
			// Hook a render function to the categories block
			$attributes = array(
				'id' => array(
					'type' => 'number'
				),
				'template' => array(
					'type' => 'string'
				),
				'columns' => array(
					'type' => 'number'
				),
				'orderby' => array(
					'type' => 'string'
				),
				'order' => array(
					'type' => 'string'
				),
				'hierarchical' => array(
					'type' => 'boolean'
				),
				'show_description' => array(
					'type' => 'boolean'
				),
				'show_count' => array(
					'type' => 'boolean'
				),
				'hide_empty' => array(
					'type' => 'boolean'
				)
			);

			register_block_type( 'aiovg/categories', array(
				'attributes' => $attributes,
				'render_callback' => array( $this, 'render_categories_block' ),
			) );

			// Hook a render function to the videos block			
			$fields = aiovg_get_block_fields();			
			$attributes = array();

			foreach ( $fields['videos'] as $key => $section ) {
				foreach ( $section['fields'] as $field ) {
					if ( in_array( $field['name'], array( 'title', 'exclude', 'ratio', 'excerpt_length', 'show_more', 'more_label', 'more_link' ) ) ) {
						continue;
					}

					if ( 'categories' == $field['type'] ) {
						$attributes[ $field['name'] ] = array(
							'type'  => 'array',
							'items' => array(
								'type' => 'integer',
							)
						);
					} else {
						$type = 'string';

						if ( 'number' == $field['type'] ) {
							$type = 'number';
						} elseif ( 'checkbox' == $field['type'] ) {
							$type = 'boolean';
						}

						$attributes[ $field['name'] ] = array(
							'type' => $type
						);
					}
				}
			}

			register_block_type( 'aiovg/videos', array(
				'attributes' => $attributes,
				'render_callback' => array( $this, 'render_videos_block' ),
			) );

			// Hook a render function to the search block
			$attributes = array(
				'template' => array(
					'type' => 'string'
				),
				'category' => array(
					'type' => 'boolean'
				)
			);

			register_block_type( 'aiovg/search', array(
				'attributes' => $attributes,
				'render_callback' => array( $this, 'render_search_block' ),
			) );

			// Hook a render function to the video player block
			$attributes = array(
				'src' => array(
					'type' => 'string'
				),
				'poster' => array(
					'type' => 'string'
				),
				'width' => array(
					'type' => 'number'
				),
				'ratio' => array(
					'type' => 'number'
				),
				'autoplay' => array(
					'type' => 'boolean'
				),
				'loop' => array(
					'type' => 'boolean'
				),
				'playpause' => array(
					'type' => 'boolean'
				),
				'current' => array(
					'type' => 'boolean'
				),
				'progress' => array(
					'type' => 'boolean'
				),
				'duration' => array(
					'type' => 'boolean'
				),					
				'volume' => array(
					'type' => 'boolean'
				),
				'fullscreen' => array(
					'type' => 'boolean'
				)
			);

			register_block_type( 'aiovg/video', array(
				'attributes' => $attributes,
				'render_callback' => array( $this, 'render_video_player_block' ),
			) );
		}
	}

	/**
	 * Render the categories block frontend.
	 *
	 * @since  1.5.6
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_categories_block( $atts ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		return do_shortcode( '[aiovg_categories ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Render the videos block frontend.
	 *
	 * @since  1.5.6
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_videos_block( $atts ) {		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		if ( isset( $atts['ratio'] ) ) {
			unset( $atts['ratio'] ); // Always get ratio from the global settings
		}	

		return do_shortcode( '[aiovg_videos ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Render the search block frontend.
	 *
	 * @since  1.5.6
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_search_block( $atts ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		return do_shortcode( '[aiovg_search_form ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Render the video player block frontend.
	 *
	 * @since  1.5.6
	 * @param  array  $atts An associative array of attributes.
	 * @return string       HTML output.
	 */
	public function render_video_player_block( $atts ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        	return;
		}

		if ( empty( $atts['src'] ) ) {
			return;
		}		

		if ( false !== strpos( $atts['src'], 'youtube.com' ) || false !== strpos( $atts['src'], 'youtu.be' ) ) {
			$atts['youtube'] = $atts['src'];

			if ( empty( $atts['poster'] ) ) {
				$atts['poster'] = aiovg_get_youtube_image_url( $atts['youtube'] );
			}
		} elseif ( false !== strpos( $atts['src'], 'vimeo.com' ) ) {
			$atts['vimeo'] = aiovg_get_vimeo_url_oembed( $atts['src'] );

			if ( empty( $atts['poster'] ) ) {
				$atts['poster'] = aiovg_get_vimeo_image_url( $atts['vimeo'] );
			}
		} elseif ( false !== strpos( $atts['src'], 'dailymotion.com' ) ) {
			$atts['dailymotion'] = $atts['src'];

			if ( empty( $atts['poster'] ) ) {
				$atts['poster'] = aiovg_get_dailymotion_image_url( $atts['dailymotion'] );
			}
		} elseif ( false !== strpos( $atts['src'], 'facebook.com' ) ) {
			$atts['facebook'] = $atts['src'];
		} else {
			$filetype = wp_check_filetype( $atts['src'] );

			if ( in_array( $filetype['ext'], array( 'mp4', 'webm', 'ogv' ) ) ) {
				$atts[ $filetype['ext'] ] = $atts['src'];
			} elseif ( 'm3u8' == $filetype['ext'] ) {
				$atts['hls'] = $atts['src'];
			} elseif ( 'mpd' == $filetype['ext'] ) {
				$atts['dash'] = $atts['src'];
			} else {
				return;
			}
		}

		unset( $atts['src'] );
		
		foreach ( $atts as $key => $value ) {
			if ( is_null( $value ) ) {
				unset( $atts[ $key ] );
			}
		}

		return do_shortcode( '[aiovg_video ' . $this->build_shortcode_attributes( $atts ) . ']' );
	}

	/**
	 * Build shortcode attributes string.
	 * 
	 * @since  1.5.6
	 * @access private
	 * @param  array   $atts Array of attributes.
	 * @return string        Shortcode attributes string.
	 */
	private function build_shortcode_attributes( $atts ) {
		$attributes = array();
		
		foreach ( $atts as $key => $value ) {
			if ( is_null( $value ) ) {
				continue;
			}

			if ( is_bool( $value ) ) {
				$value = ( true === $value ) ? 1 : 0;
			}

			if ( is_array( $value ) ) {
				$value = implode( ',', $value );
			}

			$attributes[] = sprintf( '%s="%s"', $key, $value );
		}
		
		return implode( ' ', $attributes );
	}

}