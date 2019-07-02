<?php

/**
 * The public-facing functionality of the plugin.
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
 * AIOVG_Public class.
 *
 * @since 1.0.0
 */
class AIOVG_Public {
	
	/**
	 * Remove 'redirect_canonical' hook to fix secondary loop pagination issue on single video 
	 * pages.
	 *
	 * @since 1.5.5
	 */
	public function template_redirect() {	
		if ( is_singular( 'aiovg_videos' ) ) {		
			global $wp_query;
			
			$page = (int) $wp_query->get( 'page' );
			if ( $page > 1 ) {
		  		// Convert 'page' to 'paged'
		 	 	$query->set( 'page', 1 );
		 	 	$query->set( 'paged', $page );
			}
			
			// Prevent redirect
			remove_action( 'template_redirect', 'redirect_canonical' );		
	  	}	
	}
	
	/**
	 * Add rewrite rules.
	 *
	 * @since 1.0.0
	 */
	public function add_rewrites() {
		$page_settings = get_option( 'aiovg_page_settings' );
		$url = home_url();
		
		// Single category page
		$id = $page_settings['category'];
		if ( $id > 0 ) {
			$link = str_replace( $url, '', get_permalink( $id ) );			
			$link = trim( $link, '/' );		
			
			add_rewrite_rule( "$link/([^/]+)/page/?([0-9]{1,})/?$", 'index.php?page_id=' . $id . '&aiovg_category=$matches[1]&paged=$matches[2]', 'top' );
			add_rewrite_rule( "$link/([^/]+)/?$", 'index.php?page_id=' . $id . '&aiovg_category=$matches[1]', 'top' );
		}
		
		// User videos page
		$id = $page_settings['user_videos'];
		if ( $id > 0 ) {
			$link = str_replace( $url, '', get_permalink( $id ) );			
			$link = trim( $link, '/' );		
			
			add_rewrite_rule( "$link/([^/]+)/page/?([0-9]{1,})/?$", 'index.php?page_id=' . $id . '&aiovg_user=$matches[1]&paged=$matches[2]', 'top' );
			add_rewrite_rule( "$link/([^/]+)/?$", 'index.php?page_id=' . $id . '&aiovg_user=$matches[1]', 'top' );
		}
		
		// Player page
		$id = $page_settings['player'];
		if ( $id > 0 ) {
			$link = str_replace( $url, '', get_permalink( $id ) );			
			$link = trim( $link, '/' );		
			
			add_rewrite_rule( "$link/id/([^/]+)/?$", 'index.php?page_id=' . $id . '&aiovg_type=id&aiovg_video=$matches[1]', 'top' );
		}
		
		// Rewrite tags
		add_rewrite_tag( '%aiovg_category%', '([^/]+)' );
		add_rewrite_tag( '%aiovg_user%', '([^/]+)' );
		add_rewrite_tag( '%aiovg_type%', '([^/]+)' );
		add_rewrite_tag( '%aiovg_video%', '([^/]+)' );	
	}
	
	/**
	 * Flush rewrite rules when it's necessary.
	 *
	 * @since 1.0.0
	 */
	 public function maybe_flush_rules() {
		$rewrite_rules = get_option( 'rewrite_rules' );
				
		if ( $rewrite_rules ) {		
			global $wp_rewrite;
			
			foreach ( $rewrite_rules as $rule => $rewrite ) {
				$rewrite_rules_array[ $rule ]['rewrite'] = $rewrite;
			}
			$rewrite_rules_array = array_reverse( $rewrite_rules_array, true );
		
			$maybe_missing = $wp_rewrite->rewrite_rules();
			$missing_rules = false;		
		
			foreach ( $maybe_missing as $rule => $rewrite ) {
				if ( ! array_key_exists( $rule, $rewrite_rules_array ) ) {
					$missing_rules = true;
					break;
				}
			}
		
			if ( true === $missing_rules ) {
				flush_rewrite_rules();
			}		
		}	
	}
	
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		$general_settings = get_option( 'aiovg_general_settings' );
		
		wp_register_style( 
			AIOVG_PLUGIN_SLUG . '-magnific-popup', 
			AIOVG_PLUGIN_URL . 'public/assets/css/magnific-popup.css', 
			array(), 
			'1.1.0', 
			'all' 
		);

		wp_register_style( 
			AIOVG_PLUGIN_SLUG . '-backward-compatibility', 
			AIOVG_PLUGIN_URL . 'public/assets/css/backward-compatibility.css', 
			array(), 
			AIOVG_PLUGIN_VERSION, 
			'all' 
		);

		wp_register_style( 
			AIOVG_PLUGIN_SLUG . '-public', 
			AIOVG_PLUGIN_URL . 'public/assets/css/public.css', 
			array( AIOVG_PLUGIN_SLUG . '-backward-compatibility' ), 
			AIOVG_PLUGIN_VERSION, 
			'all' 
		);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {	
		wp_register_script( 
			AIOVG_PLUGIN_SLUG . '-magnific-popup', 
			AIOVG_PLUGIN_URL . 'public/assets/js/magnific-popup.min.js', 
			array( 'jquery' ), 
			'1.1.0', 
			false 
		);
		
		wp_register_script( 
			AIOVG_PLUGIN_SLUG . '-public', 
			AIOVG_PLUGIN_URL . 'public/assets/js/public.js', 
			array( 'jquery' ), 
			AIOVG_PLUGIN_VERSION, 
			false 
		);

		wp_localize_script( 
			AIOVG_PLUGIN_SLUG . '-public', 
			'aiovg', 
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' )				
			)
		);		
	}
	
	/**		 
	 * Override the default page/post title.
	 *		
	 * @since  1.0.0
	 * @param  string $title       The document title.	 
     * @param  string $sep         Title separator.
     * @param  string $seplocation Location of the separator (left or right).		 
	 * @return string              The filtered title.		 
	*/
	public function wp_title( $title, $sep, $seplocation ) {		
		global $post;
		
		if ( ! isset( $post ) ) return $title;
		
		$page_settings = get_option( 'aiovg_page_settings' );
		$site_name     = get_bloginfo( 'name' );
		$custom_title  = '';		
		
		// Get category page title
		if ( $post->ID == $page_settings['category'] ) {			
			if ( $slug = get_query_var( 'aiovg_category' ) ) {
				$term = get_term_by( 'slug', $slug, 'aiovg_categories' );
				$custom_title = $term->name;			
			}				
		}
		
		// Get user videos page title
		if ( $post->ID == $page_settings['user_videos'] ) {		
			if ( $slug = get_query_var( 'aiovg_user' ) ) {
				$user = get_user_by( 'slug', $slug );
				$custom_title = $user->display_name;		
			}			
		}
		
		// ...
		if ( ! empty( $custom_title ) ) {
			$title = ( 'left' == $seplocation ) ? "$site_name $sep $custom_title" : "$custom_title $sep $site_name";
		}
		
		return $title;		
	}
	
	/**
	 * Override the default post/page title depending on the AIOVG view.
	 *
	 * @since  1.0.0
	 * @param  array $title The document title parts.
	 * @return              Filtered title parts.
	 */
	public function document_title_parts( $title ) {	
		global $post;
		
		if ( ! isset( $post ) ) return $title;
		
		$page_settings = get_option( 'aiovg_page_settings' );
		
		// Get category page title
		if ( $post->ID == $page_settings['category'] ) {			
			if ( $slug = get_query_var( 'aiovg_category' ) ) {
				$term = get_term_by( 'slug', $slug, 'aiovg_categories' );
				$title['title'] = $term->name;			
			}				
		}
		
		// Get user videos page title
		if ( $post->ID == $page_settings['user_videos'] ) {		
			if ( $slug = get_query_var( 'aiovg_user' ) ) {
				$user = get_user_by( 'slug', $slug );
				$title['title'] = $user->display_name;		
			}			
		}
		
		// Return
		return $title;	
	}

	/**
	 * Construct Yoast SEO title for our category and user videos pages.
	 *
	 * @since  1.5.6
	 * @param  array $title The Yoast title.
	 * @return              Modified title.
	 */
	public function wpseo_title( $title ) {	
		global $post;

		if ( ! isset( $post ) ) {
			return $title;
		}

		$page_settings = get_option( 'aiovg_page_settings' );

		if ( $post->ID != $page_settings['category'] && $post->ID != $page_settings['user_videos'] ) {
			return $title;
		}

		$wpseo_titles = get_option( 'wpseo_titles' );

		$sep_options = WPSEO_Option_Titles::get_instance()->get_separator_options();

		if ( isset( $wpseo_titles['separator'] ) && isset( $sep_options[ $wpseo_titles['separator'] ] ) ) {
			$sep = $sep_options[ $wpseo_titles['separator'] ];
		} else {
			$sep = '-'; // Setting default separator if Admin didn't set it from backed
		}

		$replacements = array(
			'%%sep%%'              => $sep,						
			'%%page%%'             => '',
			'%%primary_category%%' => '',
			'%%sitename%%'         => get_bloginfo( 'name' )
		);

		$title_template = '';
		
		// Category page
		if ( $post->ID == $page_settings['category'] ) {			
			if ( $slug = get_query_var( 'aiovg_category' ) ) {
				$term = get_term_by( 'slug', $slug, 'aiovg_categories' );			
				$replacements['%%term_title%%'] = $term->name;
				
				// Get Archive SEO title
				if ( array_key_exists( 'title-tax-aiovg_categories', $wpseo_titles ) ) {
					$title_template = $wpseo_titles['title-tax-aiovg_categories'];
				}				

				// Get Term SEO title
				$meta = get_option( 'wpseo_taxonomy_meta' );

				if ( array_key_exists( 'aiovg_categories', $meta ) ) {
					if ( array_key_exists( $term->term_id, $meta['aiovg_categories'] ) ) {
						if ( array_key_exists( 'wpseo_title', $meta['aiovg_categories'][ $term->term_id ] ) ) {
							$title_template = $meta['aiovg_categories'][ $term->term_id ]['wpseo_title'];
						}
					}
				}
			}				
		}
		
		// User videos page
		if ( $post->ID == $page_settings['user_videos'] ) {		
			if ( $slug = get_query_var( 'aiovg_user' ) ) {
				$user = get_user_by( 'slug', $slug );
				$replacements['%%title%%'] = $user->display_name;
				
				// Get Archive SEO title
				if ( array_key_exists( 'title-page', $wpseo_titles ) ) {
					$title_template = $wpseo_titles['title-page'];
				}		
				
				// Get page meta title
				$meta = get_post_meta( $post->ID, '_yoast_wpseo_title', true );

				if ( ! empty( $meta ) ) {
					$title_template = $meta;
				}
			}			
		}

		// Return
		if ( ! empty( $title_template ) ) {
			$title = strtr( $title_template, $replacements );
		}

		return $title;	
	}

	/**
	 * Construct Yoast SEO description for our category and user videos pages.
	 *
	 * @since  1.5.6
	 * @param  array $desc The Yoast description.
	 * @return             Modified description.
	 */
	public function wpseo_metadesc( $desc ) {	
		global $post;

		if ( ! isset( $post ) ) {
			return $desc;
		}

		$page_settings = get_option( 'aiovg_page_settings' );
		
		if ( $post->ID != $page_settings['category'] && $post->ID != $page_settings['user_videos'] ) {
			return $desc;
		}

		$wpseo_titles = get_option( 'wpseo_titles' );

		$sep_options = WPSEO_Option_Titles::get_instance()->get_separator_options();

		if ( isset( $wpseo_titles['separator'] ) && isset( $sep_options[ $wpseo_titles['separator'] ] ) ) {
			$sep = $sep_options[ $wpseo_titles['separator'] ];
		} else {
			$sep = '-'; // Setting default separator if Admin didn't set it from backed
		}

		$replacements = array(
			'%%sep%%'              => $sep,						
			'%%page%%'             => '',
			'%%primary_category%%' => '',
			'%%sitename%%'         => get_bloginfo( 'name' )
		);

		$desc_template = '';

		// Category page
		if ( $post->ID == $page_settings['category'] ) {			
			if ( $slug = get_query_var( 'aiovg_category' ) ) {
				$term = get_term_by( 'slug', $slug, 'aiovg_categories' );
				$replacements['%%term_title%%'] = $term->name;	
				
				// Get Archive SEO desc
				if ( array_key_exists( 'metadesc-tax-aiovg_categories', $wpseo_titles ) ) {
					$desc_template = $wpseo_titles['metadesc-tax-aiovg_categories'];
				}				

				// Get Term SEO desc
				$meta = get_option( 'wpseo_taxonomy_meta' );

				if ( array_key_exists( 'aiovg_categories', $meta ) ) {
					if ( array_key_exists( $term->term_id, $meta['aiovg_categories'] ) ) {
						if ( array_key_exists( 'wpseo_desc', $meta['aiovg_categories'][ $term->term_id ] ) ) {
							$desc_template = $meta['aiovg_categories'][ $term->term_id ]['wpseo_desc'];
						}
					}
				}
			}				
		}
		
		// User videos page
		if ( $post->ID == $page_settings['user_videos'] ) {		
			if ( $slug = get_query_var( 'aiovg_user' ) ) {
				$user = get_user_by( 'slug', $slug );
				$replacements['%%title%%'] = $user->display_name;
				
				// Get Archive SEO desc				
				if ( array_key_exists( 'metadesc-page', $wpseo_titles ) ) {
					$desc_template = $wpseo_titles['metadesc-page'];
				}		
				
				// Get page meta desc
				$meta = get_post_meta( $post->ID, '_yoast_wpseo_metadesc', true );

				if ( ! empty( $meta ) ) {
					$desc_template = $meta;
				}
			}			
		}
		
		// Return
		if ( ! empty( $desc_template ) ) {
			$desc = strtr( $desc_template, $replacements );
		}

		return $desc;	
	}

	/**
	 * Override the Yoast SEO canonical URL on our category and user videos pages.
	 *
	 * @since  1.5.6
	 * @param  array $url The Yoast canonical URL.
	 * @return            Modified canonical URL.
	 */
	public function wpseo_canonical( $url ) {	
		global $post;

		if ( ! isset( $post ) ) {
			return $url;
		}
		
		$page_settings = get_option( 'aiovg_page_settings' );

		// Category page
		if ( $post->ID == $page_settings['category'] ) {			
			if ( $slug = get_query_var( 'aiovg_category' ) ) {
				$term = get_term_by( 'slug', $slug, 'aiovg_categories' );
				$url = aiovg_get_category_page_url( $term );
			}				
		}
		
		// User videos page
		if ( $post->ID == $page_settings['user_videos'] ) {		
			if ( $slug = get_query_var( 'aiovg_user' ) ) {
				$user = get_user_by( 'slug', $slug );
				$url = aiovg_get_user_videos_page_url( $user->ID );
			}			
		}
		
		// Return
		return $url;	
	}

	/**
	 * Filter Yoast SEO breadcrumbs.
	 *
	 * @since  1.6.2
	 * @param  array $crumbs Array of crumbs.
	 * @return array $crumbs Filtered array of crumbs.
	 */
	public function wpseo_breadcrumb_links( $crumbs ) {
		global $post;

		if ( is_singular( 'aiovg_videos' ) ) {
			foreach ( $crumbs as $index => $crumb ) {
				if ( ! empty( $crumb['ptarchive'] ) && 'aiovg_videos' == $crumb['ptarchive'] ) {
					$obj = get_post_type_object( 'aiovg_videos' );

					$crumbs[ $index ] = array(
						'text' => $obj->labels->name,
						'url'  => aiovg_get_search_page_url()
					);
				}
			}
		} else {
			$page_settings = get_option( 'aiovg_page_settings' );

			if ( $post->ID == $page_settings['category'] ) {
				if ( $slug = get_query_var( 'aiovg_category' ) ) {
					$term = get_term_by( 'slug', $slug, 'aiovg_categories' );
					$crumbs[] = array(
						'text' => $term->name
					);			
				}
			}
			
			if ( $post->ID == $page_settings['user_videos'] ) {				
				if ( $slug = get_query_var( 'aiovg_user' ) ) {
					$user = get_user_by( 'slug', $slug );
					$crumbs[] = array(
						'text' => $user->display_name
					);			
				}	
			}
		}

		return $crumbs;
	}
	
	/**
	 * Adds the Facebook OG tags and Twitter Cards.
	 *
	 * @since 1.0.0
	 */
	public function og_metatags() {	
		global $post;
			
		if ( isset( $post ) && is_singular( 'aiovg_videos' ) ) {			
			printf( '<meta property="og:url" content="%s" />', get_permalink() );
			echo '<meta property="og:type" content="article" />';	
			printf( '<meta property="og:title" content="%s" />', get_the_title() );
			if ( ! empty( $post->post_content ) ) printf( '<meta property="og:description" content="%s" />', aiovg_get_excerpt() );
			
			$image = get_post_meta( $post->ID, 'image', true );
			$image_id = get_post_meta( $post->ID, 'image_id', true );
			
			$image = aiovg_get_image_url( $image_id, 'large', $image, 'player' );						
			if ( ! empty( $image ) ) printf( '<meta property="og:image" content="%s" />', $image );
				
			printf( '<meta property="og:site_name" content="%s" />', get_bloginfo( 'name' ) );
			echo '<meta name="twitter:card" content="summary">';				
		}		
	}
	
	/**
	 * Change the current page title if applicable.
	 *
	 * @since  1.0.0
	 * @param  string $title Current page title.
	 * @return string $title Modified page title.
	 */
	public function the_title( $title ) {
		if ( ! in_the_loop() || ! is_main_query() ) {
			return $title;
		}

		global $post;
		
		$page_settings = get_option( 'aiovg_page_settings' );
		
		// Change category page title
		if ( $post->ID == $page_settings['category'] ) {		
			if ( $slug = get_query_var( 'aiovg_category' ) ) {
				$term = get_term_by( 'slug', $slug, 'aiovg_categories' );
				$title = $term->name;			
			}			
		}
		
		// Change search page title
		if ( $post->ID == $page_settings['search'] ) {		
			$queries = array();
			
			if ( ! empty( $_GET['vi'] ) ) {
				$queries[] = sanitize_text_field( $_GET['vi'] );				
			}
			
			if ( ! empty( $_GET['ca'] ) ) {
				$term = get_term_by( 'id', (int) $_GET['ca'], 'aiovg_categories' );
				$queries[] = $term->name;				
			}
			
			if ( ! empty( $queries ) ) {
				$title = sprintf( __( 'Showing results for "%s"', 'all-in-one-video-gallery' ), implode( ', ', $queries ) );	
			}			
		}
		
		// Change user videos page title
		if ( $post->ID == $page_settings['user_videos'] ) {		
			if ( $slug = get_query_var( 'aiovg_user' ) ) {
				$user = get_user_by( 'slug', $slug );
				$title = $user->display_name;		
			}			
		}
		
		return $title;	
	}

	/**
	 * Always use our custom page for AIOVG categories.
	 *
	 * @since  1.0.0
	 * @param  string $url      The term URL.
	 * @param  object $term     The term object.
	 * @param  string $taxonomy The taxonomy slug.
	 * @return string $url      Filtered term URL.
	 */
	public function term_link( $url, $term, $taxonomy ) {	
		if ( 'aiovg_categories' == $taxonomy ) {
			$url = aiovg_get_category_page_url( $term );
		}
		
		return $url;		
	}
	
	/**
	 * Set cookie for accepting the privacy consent.
	 *
	 * @since 1.0.0
	 */
	public function set_cookie() {	
		setcookie( 'aiovg_gdpr_consent', 1, time() + ( 30 * 24 * 60 * 60 ), COOKIEPATH, COOKIE_DOMAIN );		
		echo 'success';		
	}

}
