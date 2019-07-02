<?php

/**
 * Categories
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
 * AIOVG_Public_Categories class.
 *
 * @since 1.0.0
 */
class AIOVG_Public_Categories {

	/**
	 * The detault shortcode attribute values.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    array     $defaults An associative array of defaults.
	 */
	protected $defaults = array();
	
	/**
	 * Get things started.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Register shortcode(s)
		add_shortcode( "aiovg_categories", array( $this, "run_shortcode_categories" ) );
	}
	
	/**
	 * Run the shortcode [aiovg_categories].
	 *
	 * @since 1.0.0
	 * @param array $atts An associative array of attributes.
	 */
	public function run_shortcode_categories( $atts ) {	
		// Vars
		$attributes = shortcode_atts( $this->get_defaults(), $atts );	
		$attributes['ratio'] = ! empty( $attributes['ratio'] ) ? (float) $attributes['ratio'] . '%' : '56.25%';
		
		// Enqueue style dependencies
		wp_enqueue_style( AIOVG_PLUGIN_SLUG . '-public' );
		
		// Process output
		$template = sanitize_text_field( $attributes['template'] );

		if ( 'grid' == $template ) {
			$args = array(			
				'parent'       => (int) $attributes['id'],
				'orderby'      => sanitize_text_field( $attributes['orderby'] ), 
				'order'        => sanitize_text_field( $attributes['order'] ),
				'hide_empty'   => (int) $attributes['hide_empty'],
				'hierarchical' => false
			);

			$terms = get_terms( 'aiovg_categories', $args );			
			
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				ob_start();
				include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . "public/templates/categories-template-grid.php" );
				return ob_get_clean();		
			} else {
				return aiovg_get_message( 'empty' );
			}			
		} else {
			ob_start();
			include apply_filters( 'aiovg_load_template', AIOVG_PLUGIN_DIR . "public/templates/categories-template-list.php" );
			return ob_get_clean();
		}		
	}	

	/**
	 * Get the default shortcode attribute values.
	 *
	 * @since  1.0.0
	 * @return array $atts An associative array of attributes.
	 */
	public function get_defaults() {	
		if ( empty( $this->defaults ) ) {			
			$fields = aiovg_get_block_fields();

			foreach ( $fields['categories'] as $section ) {
				foreach ( $section['fields'] as $field ) {
					$this->defaults[ $field['name'] ] = $field['value'];
				}
			}			
		}
		
		return $this->defaults;
	}
	
}
