<?php

/**
 * Shortcode Builder.
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
 * AIOVG_Admin_Shortcode_Builder class.
 *
 * @since 1.0.0
 */
class AIOVG_Admin_Shortcode_Builder {
	
	/**
	 * Adds an "Video Player & Gallery" button above the TinyMCE Editor on add/edit screens.
	 *
	 * @since 1.0.0
	 */
	public function media_buttons() {
		global $pagenow, $typenow;
		
		// Only run in post/page creation and edit screens
		if ( ! in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
			return;
		}		
		
		//  check if this is our custom post type page
		if ( in_array( $typenow, array( 'aiovg_videos', 'aiovg_automations' ) ) ) {
			return;
		}

		// check if the post/page uses Gutenberg editor
		if ( aiovg_is_gutenberg_page() ) {
			return;
		}

		printf( '<a href="#aiovg-shortcode-builder" class="button button-primary aiovg-media-button" id="aiovg-media-button"><span class="wp-media-buttons-icon dashicons dashicons-playlist-video"></span> %s</a>', __( 'Video Player & Gallery', 'all-in-one-video-gallery' ) );
	}
	
	/**
	 * Prints the footer code needed for the "AIO Video Gallery" TinyMCE button.
	 *
	 * @since 1.0.0
	 */
	public function admin_footer() {
		global $pagenow, $typenow;
		
		// Only run in post/page creation and edit screens
		if ( ! in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) ) {
			return;
		}		
		
		//  check if this is our custom post type page
		if ( in_array( $typenow, array( 'aiovg_videos', 'aiovg_automations' ) ) ) {
			return;
		}

		// check if the post/page uses Gutenberg editor
		if ( aiovg_is_gutenberg_page() ) {
			return;
		}

		// Shortcodes
		$shortcodes = array(				
			'categories'  => __( 'Video Categories', 'all-in-one-video-gallery' ) . ' - [aiovg_categories]',
			'videos'      => __( 'Video Gallery', 'all-in-one-video-gallery' ) . ' - [aiovg_videos]',
			'video'       => __( 'Single Video', 'all-in-one-video-gallery' ) . ' - [aiovg_video]',
			'search_form' => __( 'Search Form', 'all-in-one-video-gallery' ) . ' - [aiovg_search_form]'			
		);
		
		// Fields
		$fields = aiovg_get_block_fields();			
		
		// ...
		require_once AIOVG_PLUGIN_DIR . 'admin/partials/shortcode-builder.php';
	}

}