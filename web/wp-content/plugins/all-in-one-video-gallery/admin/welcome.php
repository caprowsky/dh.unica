<?php

/**
 * Welcome page.
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
 * AIOVG_Admin_Welcome class.
 *
 * @since 1.0.0
 */
class AIOVG_Admin_Welcome {
	
	/**
	 * Add welcome page sub menus.
	 *
	 * @since 1.0.0
	 */
	public function add_welcome_menus() {	
		add_dashboard_page(
			__( 'Welcome - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			__( 'Welcome - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			'manage_aiovg_options',
			'aiovg_welcome',
			array( $this, 'display_welcome_content' )
		);
		
		add_dashboard_page(
			__( 'Welcome - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			__( 'Welcome - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			'manage_aiovg_options',
			'aiovg_new',
			array( $this, 'display_welcome_content' )
		);

		add_dashboard_page(
			__( 'Welcome - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			__( 'Welcome - All-in-One Video Gallery', 'all-in-one-video-gallery' ),
			'manage_aiovg_options',
			'aiovg_support',
			array( $this, 'display_welcome_content' )
		);
		
		// Now remove the menus so plugins that allow customizing the admin menu don't show them
		remove_submenu_page( 'index.php', 'aiovg_welcome' );
		remove_submenu_page( 'index.php', 'aiovg_new' );
		remove_submenu_page( 'index.php', 'aiovg_support' );	
	}
	
	/**
	 * Display welcome page content.
	 *
	 * @since 1.0.0
	 */
	public function display_welcome_content() {	
		$tabs = array(
			'aiovg_welcome' => __( 'Getting Started', 'all-in-one-video-gallery' ),
			'aiovg_new'     => __( 'New', 'all-in-one-video-gallery' ),
			'aiovg_support' => __( 'Support', 'all-in-one-video-gallery' )
		);
		
		$active_tab = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : 'aiovg_welcome';
		
		require_once AIOVG_PLUGIN_DIR . 'admin/partials/welcome.php';		
	}
	
}