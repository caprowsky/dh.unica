<?php

/**
 * Search form.
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
 * AIOVG_Public_Search class.
 *
 * @since 1.0.0
 */
class AIOVG_Public_Search {
	
	/**
	 * Get things started.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "aiovg_search_form", array( $this, "run_shortcode_search_form" ) );
	}

	/**
	 * Run the shortcode [aiovg_search_form].
	 *
	 * @since 1.0.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_search_form( $atts ) {	
		// Vars
		$page_settings = get_option( 'aiovg_page_settings' );
		
		$attributes = array(
			'template'       => isset( $atts['template'] ) ? sanitize_text_field( $atts['template'] ) : 'horizontal',
			'search_page_id' => $page_settings['search'],
			'has_category'   => isset( $atts['category'] ) ? (int) $atts['category'] : 0
		);
		
		// Enqueue style dependencies
		wp_enqueue_style( AIOVG_PLUGIN_SLUG . '-public' );
		
		// Process output
		ob_start();
		include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . 'public/templates/search-form-template-' . $attributes['template'] . '.php' );
		return ob_get_clean();		
	}
	
}
