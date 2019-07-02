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
 * AIOVG_Admin_Categories class.
 *
 * @since 1.0.0
 */
class AIOVG_Admin_Categories {

	/**
	 * Register the custom taxonomy "aiovg_categories".
	 *
	 * @since 1.0.0
	 */
	public function register_taxonomy() {	
		$labels = array(
			'name'                       => _x( 'Categories', 'Taxonomy General Name', 'all-in-one-video-gallery' ),
			'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'all-in-one-video-gallery' ),
			'menu_name'                  => __( 'Categories', 'all-in-one-video-gallery' ),
			'all_items'                  => __( 'All Categories', 'all-in-one-video-gallery' ),
			'parent_item'                => __( 'Parent Category', 'all-in-one-video-gallery' ),
			'parent_item_colon'          => __( 'Parent Category:', 'all-in-one-video-gallery' ),
			'new_item_name'              => __( 'New Category Name', 'all-in-one-video-gallery' ),
			'add_new_item'               => __( 'Add New Category', 'all-in-one-video-gallery' ),
			'edit_item'                  => __( 'Edit Category', 'all-in-one-video-gallery' ),
			'update_item'                => __( 'Update Category', 'all-in-one-video-gallery' ),
			'view_item'                  => __( 'View Category', 'all-in-one-video-gallery' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'all-in-one-video-gallery' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'all-in-one-video-gallery' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'all-in-one-video-gallery' ),
			'popular_items'              => __( 'Popular Categories', 'all-in-one-video-gallery' ),
			'search_items'               => __( 'Search Categories', 'all-in-one-video-gallery' ),
			'not_found'                  => __( 'Not Found', 'all-in-one-video-gallery' ),
			'no_terms'                   => __( 'No categories', 'all-in-one-video-gallery' ),
			'items_list'                 => __( 'Categories list', 'all-in-one-video-gallery' ),
			'items_list_navigation'      => __( 'Categories list navigation', 'all-in-one-video-gallery' ),
		);
		
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => false,
			'show_in_rest'               => true,
			'show_tagcloud'              => false,
			'capabilities'               => array(
				'manage_terms' => 'manage_aiovg_options',
				'edit_terms'   => 'manage_aiovg_options',				
				'delete_terms' => 'manage_aiovg_options',
				'assign_terms' => 'edit_aiovg_videos'
			)
		);
		
		register_taxonomy( 'aiovg_categories', array( 'aiovg_videos' ), $args );	
	}
	
	/**
	 * Add image field.
	 *
	 * @since 1.0.0
	 */
	public function add_image_field() {	
		$form = 'add';		
		require_once AIOVG_PLUGIN_DIR . 'admin/partials/category-image.php';	
	}
	
	/**
	 * Edit image field.
	 *
	 * @since 1.0.0
	 * @param object $term Taxonomy term object.
	 */
	public function edit_image_field( $term ) {	
		$form = 'edit';
		
		$image_id  = get_term_meta( $term->term_id, 'image_id', true );
		$image_url = $image_id ? wp_get_attachment_url( (int) $image_id ) : '';
		
		require_once AIOVG_PLUGIN_DIR . 'admin/partials/category-image.php';	
	}
	
	/**
	 * Save the image field.
	 *
	 * @since 1.0.0
	 * @param int   $term_id Term ID.
	 */
	public function save_image_field( $term_id ) {	
		// Check if "aiovg_category_image_nonce" nonce is set
    	if ( isset( $_POST['aiovg_category_image_nonce'] ) ) {		
			// Verify that the nonce is valid
    		if ( wp_verify_nonce( $_POST['aiovg_category_image_nonce'], 'aiovg_process_category_image' ) ) {			
				// OK to save meta data
				$image_id = isset( $_POST['image_id'] ) ? (int) $_POST['image_id'] : 0;
				update_term_meta( $term_id, 'image_id', $image_id );			
			}		
		}   
	}
	
	/**
	 * Retrieve the table columns.
	 *
	 * @since  1.0.0
	 * @param  array $columns Array of default table columns.
	 * @return array $columns Updated list of table columns.
	 */
	public function get_columns( $columns ) {	
		$columns['tax_id'] = __( 'ID', 'all-in-one-video-gallery' );
    	return $columns;		
	}
	
	/**
	 * This function renders the custom columns in the list table.
	 *
	 * @since 1.0.0
	 * @param string $content Content of the column.
	 * @param string $column  Name of the column.
	 * @param string $term_id Term ID.
	 */
	public function custom_column_content( $content, $column, $term_id ) {		
		if ( 'tax_id' == $column ) {
        	$content = $term_id;
    	}
		
		return $content;	
	}
	
	/**
	 * Delete attachments.
	 *
	 * @since 1.0.0
	 * @param int    $term_id  Term ID.
	 * @param string $taxonomy Taxonomy Name.
	 */
	public function pre_delete_term( $term_id, $taxonomy ) {		
		if ( 'aiovg_categories' != $taxonomy ) {
			return;
		}
		  
		aiovg_delete_category_attachments( $term_id );
	}
	
	/**
	 * Delete category image.
	 *
	 * @since 1.0.0
	 */
	public function ajax_callback_delete_category_image() {	
		check_ajax_referer( 'aiovg_process_category_image', 'security' );
		
		$general_settings = get_option( 'aiovg_general_settings' );

		if ( ! empty( $general_settings['delete_media_files'] ) ) {
			if ( isset( $_POST['attachment_id'] ) ) {
				wp_delete_attachment( (int) $_POST['attachment_id'], true );
			}
		}
		
		wp_die();	
	}

}
