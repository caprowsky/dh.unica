<?php

/**
 * The file that defines the core plugin class.
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
 * AIOVG_Init - The main plugin class.
 *
 * @since 1.0.0
 */
class AIOVG_Init {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    AIOVG_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Get things started.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->blocks_init();
		$this->widgets_init();
		$this->set_meta_caps();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once AIOVG_PLUGIN_DIR . 'includes/loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once AIOVG_PLUGIN_DIR . 'includes/i18n.php';
		
		/**
		 * The class responsibe for defining custom capabilities.
		 */
		 require_once AIOVG_PLUGIN_DIR . 'includes/roles.php';
		
		/**
		 * The class responsible for extending the 'wp_terms_checklist' function.
		 */
		require_once AIOVG_PLUGIN_DIR . 'includes/walker-terms-checklist.php';
		
		/**
		 * The file that holds the general helper functions.
		 */
		require_once AIOVG_PLUGIN_DIR . 'includes/functions.php';

		/**
		 * The classes responsible for defining all actions that occur in the admin area.
		 */
		require_once AIOVG_PLUGIN_DIR . 'admin/admin.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/welcome.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/videos.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/categories.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/settings.php';
		require_once AIOVG_PLUGIN_DIR . 'admin/shortcode-builder.php';

		/**
		 * The classes responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once AIOVG_PLUGIN_DIR . 'public/public.php';		
		require_once AIOVG_PLUGIN_DIR . 'public/categories.php';
		require_once AIOVG_PLUGIN_DIR . 'public/videos.php';		
		require_once AIOVG_PLUGIN_DIR . 'public/video.php';
		require_once AIOVG_PLUGIN_DIR . 'public/search.php';		
		
		/**
		 * The class responsible for defining actions that occur in the gutenberg blocks.
		 */
		require_once AIOVG_PLUGIN_DIR. 'blocks/blocks.php';

		/**
		 * The classes responsible for defining all actions that occur in the widgets.
		 */
		require_once AIOVG_PLUGIN_DIR . 'widgets/categories.php';
		require_once AIOVG_PLUGIN_DIR . 'widgets/videos.php';				
		require_once AIOVG_PLUGIN_DIR . 'widgets/video.php';
		require_once AIOVG_PLUGIN_DIR . 'widgets/search.php';			

		$this->loader = new AIOVG_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function set_locale() {
		$i18n = new AIOVG_i18n();
		$this->loader->add_action( 'plugins_loaded', $i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_admin_hooks() {
		// Hooks common to all admin pages
		$admin = new AIOVG_Admin();
				
		$this->loader->add_action( 'wp_loaded', $admin, 'wp_loaded' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_notices', $admin, 'admin_notice' );		
		$this->loader->add_action( 'wp_ajax_aiovg_dismiss_admin_notice', $admin, 'ajax_callback_dismiss_admin_notice' );		
		
		$this->loader->add_filter( 'plugin_action_links_' . AIOVG_PLUGIN_FILE_NAME, $admin, 'plugin_action_links' );
		$this->loader->add_filter( 'wp_check_filetype_and_ext', $admin, 'add_filetype_and_ext', 10, 4 );	
		
		// Hooks specific to the welcome page
		$welcome = new AIOVG_Admin_Welcome();
		
		$this->loader->add_action( 'admin_menu', $welcome, 'add_welcome_menus' );
		
		// Hooks specific to the videos page
		$videos = new AIOVG_Admin_Videos();
		
		$this->loader->add_action( 'init', $videos, 'register_post_type' );
		$this->loader->add_action( 'before_delete_post', $videos, 'before_delete_post' );
		
		if ( is_admin() ) {		
			$this->loader->add_action( 'admin_head', $videos, 'remove_media_buttons' );
			$this->loader->add_action( 'post_submitbox_misc_actions', $videos, 'post_submitbox_misc_actions' );
			$this->loader->add_action( 'add_meta_boxes', $videos, 'add_meta_boxes' );
			$this->loader->add_action( 'save_post', $videos, 'save_meta_data', 10, 2 );
			$this->loader->add_action( 'restrict_manage_posts', $videos, 'restrict_manage_posts' );
			$this->loader->add_action( 'manage_aiovg_videos_posts_custom_column', $videos, 'custom_column_content', 10, 2 );			
			
			$this->loader->add_filter( 'parse_query', $videos, 'parse_query' );
			$this->loader->add_filter( 'manage_edit-aiovg_videos_columns', $videos, 'get_columns' );			
		}
		
		// Hooks specific to the categories page
		$categories = new AIOVG_Admin_Categories();
		
		$this->loader->add_action( 'init', $categories, 'register_taxonomy' );
		$this->loader->add_action( 'aiovg_categories_add_form_fields', $categories, 'add_image_field' );		
		$this->loader->add_action( 'aiovg_categories_edit_form_fields', $categories, 'edit_image_field' );
		$this->loader->add_action( 'created_aiovg_categories', $categories, 'save_image_field' );
		$this->loader->add_action( 'edited_aiovg_categories', $categories, 'save_image_field' );		
		$this->loader->add_action( 'pre_delete_term', $categories, 'pre_delete_term', 10, 2 );	
		$this->loader->add_action( 'wp_ajax_aiovg_delete_category_image', $categories, 'ajax_callback_delete_category_image' );
		
		$this->loader->add_filter( "manage_edit-aiovg_categories_columns", $categories, 'get_columns' );
		$this->loader->add_filter( "manage_edit-aiovg_categories_sortable_columns", $categories, 'get_columns' );
		$this->loader->add_filter( "manage_aiovg_categories_custom_column", $categories, 'custom_column_content', 10, 3 );		
		
		// Hooks specific to the settings page
		$settings = new AIOVG_Admin_Settings();
		
		$this->loader->add_action( 'admin_menu', $settings, 'add_settings_menu' );
		$this->loader->add_action( 'admin_init', $settings, 'admin_init' );
		
		// Hooks specific to the shortcode builder
		$shortcode_builder = new AIOVG_Admin_Shortcode_Builder();
		
		$this->loader->add_action( 'media_buttons', $shortcode_builder, 'media_buttons', 11 );
		$this->loader->add_action( 'admin_footer', $shortcode_builder, 'admin_footer' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function define_public_hooks() {
		// Hooks common to all public pages
		$public = new AIOVG_Public();

		$this->loader->add_action( 'template_redirect', $public, 'template_redirect', 0 );
		$this->loader->add_action( 'init', $public, 'add_rewrites' );
		$this->loader->add_action( 'wp_loaded', $public, 'maybe_flush_rules' );
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );		
		$this->loader->add_action( 'wp_head', $public, 'og_metatags' );
		$this->loader->add_action( 'wp_ajax_aiovg_set_cookie', $public, 'set_cookie' );
		$this->loader->add_action( 'wp_ajax_nopriv_aiovg_set_cookie', $public, 'set_cookie' );
		
		if ( aiovg_can_use_yoast() ) {
			$this->loader->add_filter( 'wpseo_title', $public, 'wpseo_title' );
			$this->loader->add_filter( 'wpseo_metadesc', $public, 'wpseo_metadesc' );
			$this->loader->add_filter( 'wpseo_canonical', $public, 'wpseo_canonical' );
			$this->loader->add_filter( 'wpseo_opengraph_url', $public, 'wpseo_canonical' );
			$this->loader->add_filter( 'wpseo_breadcrumb_links', $public, 'wpseo_breadcrumb_links' );
		} else {
			$this->loader->add_filter( 'wp_title', $public, 'wp_title', 99, 3 );
			$this->loader->add_filter( 'document_title_parts', $public, 'document_title_parts' );
		}				
		$this->loader->add_filter( 'the_title', $public, 'the_title', 99 );
		$this->loader->add_filter( 'single_post_title', $public, 'the_title', 99 );
		$this->loader->add_filter( 'term_link', $public, 'term_link', 10, 3 );
		
		// Hooks specific to the categories page
		$categories = new AIOVG_Public_Categories();		
		
		// Hooks specific to the videos page
		$videos = new AIOVG_Public_Videos();
		
		// Hooks specific to the single video page
		$video = new AIOVG_Public_Video();
		
		$this->loader->add_action( 'template_include', $video, 'template_include', 999 );
		$this->loader->add_action( 'the_content', $video, 'the_content', 20 );
		$this->loader->add_action( 'wp_ajax_aiovg_update_views_count', $video, 'ajax_callback_update_views_count' );
		$this->loader->add_action( 'wp_ajax_nopriv_aiovg_update_views_count', $video, 'ajax_callback_update_views_count' );		
		
		// Hooks specific to the search form
		$search = new AIOVG_Public_Search();
	}

	/**
	 * Initialize Blocks.
	 *
	 * @since  1.5.6
	 * @access private
	 */
	private function blocks_init() {
		$blocks = new AIOVG_Blocks();

		$this->loader->add_action( 'init', $blocks, 'register_block_types' );
		$this->loader->add_action( 'enqueue_block_editor_assets', $blocks, 'enqueue_block_editor_assets' );

		$this->loader->add_filter( 'block_categories', $blocks, 'block_categories' );
	}
	
	/**
	 * Add hook to register widgets.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function widgets_init() {
		$this->loader->add_action( 'widgets_init', $this, 'register_widgets' );
	}
	
	/**
	 * Register widgets.
	 *
	 * @since 1.0.0
	 */
	public function register_widgets() {		
		register_widget( "AIOVG_Widget_Categories" );
		register_widget( "AIOVG_Widget_Videos" );		
		register_widget( "AIOVG_Widget_Video" );
		register_widget( "AIOVG_Widget_Search" );		
	}
	
	/**
	 * Map meta caps to primitive caps.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function set_meta_caps() {
		$roles = new AIOVG_Roles();
		$this->loader->add_filter( 'map_meta_cap', $roles, 'meta_caps', 10, 4 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

}
