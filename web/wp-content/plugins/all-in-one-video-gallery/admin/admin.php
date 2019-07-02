<?php

/**
 * The admin-specific functionality of the plugin.
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
 * AIOVG_Admin class.
 *
 * @since 1.0.0
 */
class AIOVG_Admin {
	
	/**
	 * Insert missing plugin options.
	 *
	 * @since 1.5.2
	 */
	public function wp_loaded() {		
		if ( AIOVG_PLUGIN_VERSION !== get_option( 'aiovg_version' ) ) {	
			$defaults = aiovg_get_default_settings();
			
			// Update the plugin version		
			update_option( 'aiovg_version', AIOVG_PLUGIN_VERSION );			

			// Insert the missing general settings
			$general_settings = get_option( 'aiovg_general_settings' );

			if ( ! array_key_exists( 'delete_media_files', $general_settings ) ) {
				$general_settings['delete_media_files'] = $defaults['aiovg_general_settings']['delete_media_files'];
				update_option( 'aiovg_general_settings', $general_settings );				
			}
			
			// Insert the missing player settings
			$player_settings = get_option( 'aiovg_player_settings' );

			$new_player_settings = array();

			if ( ! array_key_exists( 'use_native_controls', $player_settings ) ) {
				$new_player_settings['use_native_controls'] = $defaults['aiovg_player_settings']['use_native_controls'];				
			}

			if ( count( $new_player_settings ) ) {
				update_option( 'aiovg_player_settings', array_merge( $player_settings, $new_player_settings ) );
			}
			
			// Insert the missing categories settings
			$categories_settings = get_option( 'aiovg_categories_settings' );

			$new_categories_settings = array();

			if ( ! array_key_exists( 'template', $categories_settings ) ) {
				$new_categories_settings['template'] = $defaults['aiovg_categories_settings']['template'];				
			}

			if ( ! array_key_exists( 'hierarchical', $categories_settings ) ) {
				$new_categories_settings['hierarchical'] = $defaults['aiovg_categories_settings']['hierarchical'];				
			}

			if ( count( $new_categories_settings ) ) {
				update_option( 'aiovg_categories_settings', array_merge( $categories_settings, $new_categories_settings ) );
			}

			// Insert the missing videos settings
			$videos_settings = get_option( 'aiovg_videos_settings' );

			$new_videos_settings = array();

			if ( ! array_key_exists( 'template', $videos_settings ) ) {
				$new_videos_settings['template'] = $defaults['aiovg_videos_settings']['template'];				
			}

			if ( ! array_key_exists( 'thumbnail_style', $videos_settings ) ) {
				$new_videos_settings['thumbnail_style'] = $defaults['aiovg_videos_settings']['thumbnail_style'];
			}

			if ( count( $new_videos_settings ) ) {
				update_option( 'aiovg_videos_settings', array_merge( $videos_settings, $new_videos_settings ) );
			}
			
			// Insert the privacy settings			
			if ( false == get_option( 'aiovg_privacy_settings' ) ) {
				add_option( 'aiovg_privacy_settings', $defaults['aiovg_privacy_settings'] );
			}					
		}
	}
	
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'wp-color-picker' );
		
		wp_enqueue_style( 
			AIOVG_PLUGIN_SLUG . '-magnific-popup', 
			AIOVG_PLUGIN_URL . 'public/assets/css/magnific-popup.css', 
			array(), 
			'1.1.0', 
			'all' 
		);

		wp_enqueue_style( 
			AIOVG_PLUGIN_SLUG . '-admin', 
			AIOVG_PLUGIN_URL . 'admin/assets/css/admin.css', 
			array(), 
			AIOVG_PLUGIN_VERSION, 
			'all' 
		);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
		
		wp_enqueue_script( 
			AIOVG_PLUGIN_SLUG . '-magnific-popup', 
			AIOVG_PLUGIN_URL . 'public/assets/js/magnific-popup.min.js', 
			array( 'jquery' ), 
			'1.1.0', 
			false 
		);

		wp_enqueue_script( 
			AIOVG_PLUGIN_SLUG . '-admin', 
			AIOVG_PLUGIN_URL . 'admin/assets/js/admin.js', 
			array( 'jquery' ), 
			AIOVG_PLUGIN_VERSION, 
			false 
		);

		wp_localize_script( 
			AIOVG_PLUGIN_SLUG . '-admin', 
			'aiovg_admin', 
			array(
				'ajax_nonce' => wp_create_nonce( 'aiovg_admin_ajax_nonce' )				
			)
		);
	}
	
	/**
	 * Add a settings link on the plugin listing page.
	 *
	 * @since  1.0.0
	 * @param  array  $links An array of plugin action links.
	 * @return string $links Array of filtered plugin action links.
	 */
	public function plugin_action_links( $links ) {
		$settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php?post_type=aiovg_videos&page=aiovg_settings' ), __( 'Settings', 'all-in-one-video-gallery' ) );
        array_unshift( $links, $settings_link );
		
    	return $links;
	}
	
	/**
	 * Display admin notice.
	 *
	 * @since 1.0.0
	 */
	public function admin_notice() {
		if ( false == get_option( 'aiovg_admin_notice_dismissed' ) ) : ?>    
            <div id="aiovg-admin-notice" class="notice notice-info is-dismissible" data-security="<?php echo wp_create_nonce( 'aiovg_admin_notice_nonce' ); ?>">
                <p>
					<span class="dashicons-before dashicons-playlist-video"></span> <strong><?php _e( 'All-in-One Video Gallery', 'all-in-one-video-gallery' ); ?></strong>
					<span class="aiovg-admin-notice-separator"> - </span>
                    <a href="https://plugins360.com/all-in-one-video-gallery/documentation/" target="_blank"><?php _e( 'Getting Started', 'all-in-one-video-gallery' ); ?></a>
					<span class="aiovg-admin-notice-separator"> | </span>
                    <a href="<?php echo admin_url( 'admin.php?page=all-in-one-video-gallery-contact' ); ?>"><?php _e( 'Contact Us', 'all-in-one-video-gallery' ); ?></a>
					<?php if ( aiovg_fs()->is_not_paying() ) : ?>
						<span class="aiovg-admin-notice-separator"> | </span>
                    	<a href="<?php echo esc_url( aiovg_fs()->get_upgrade_url() ); ?>" class="aiovg-upgrade-link"><?php _e( 'Upgrade Pro', 'all-in-one-video-gallery' ); ?></a>
					<?php endif; ?>
                </p>
            </div>        
		<?php endif;		
	}
	
	/**
	 * Dismiss admin notice.
	 *
	 * @since 1.0.0
	 */
	public function ajax_callback_dismiss_admin_notice() {	
		check_ajax_referer( 'aiovg_admin_notice_nonce', 'security' );
		
		add_option( 'aiovg_admin_notice_dismissed', 1 );
		wp_die();	
	}
	
	/**
	 * Sets the extension and mime type for .vtt files.
	 *
	 * @since  1.5.7
	 * @param  array  $types    File data array containing 'ext', 'type', and 'proper_filename' keys.
     * @param  string $file     Full path to the file.
     * @param  string $filename The name of the file (may differ from $file due to $file being in a tmp directory).
     * @param  array  $mimes    Key is the file extension with value as the mime type.
	 * @return array  $types    Filtered file data array.
	 */
	public function add_filetype_and_ext( $types, $file, $filename, $mimes ) {
		if ( false !== strpos( $filename, '.vtt' ) ) {			
			$types['ext']  = 'vtt';
			$types['type'] = 'text/vtt';
		}
	
		return $types;
	}

}