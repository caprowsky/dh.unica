<?php

namespace PostGallery\Controllers;

use WPMVC\Log;
use WPMVC\Cache;
use WPMVC\Request;
use WPMVC\MVC\Controller;
use PostGallery\Models\PostGallery;

/**
 * Handles admin methods.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.1.8
 */
class AdminController extends Controller
{
    /**
     * Admin menu settings key.
     * @since 2.0.0
     * @var string
     */
    const ADMIN_MENU_SETTINGS = 'post-gallery-settings';
    /**
     * Enqueues and registers scripts.
     * @since 1.0.0
     * @since 1.0.4 Updated to version 1.0.4.
     * @since 2.0.0 Works with new framework.
     * @since 2.1.0 Normalized font-awesome location.
     * @since 2.1.1 Updated dependency version.
     *
     * @global object $postgallery Main class.
     */
    public function enqueue()
    {
        global $postgallery;
        wp_register_style(
            'font-awesome',
            assets_url( 'css/font-awesome.min.css', __FILE__ ),
            [],
            '4.7.0'
        );
        wp_register_style(
            'admin-post-gallery',
            assets_url( 'css/app.css', __FILE__ ),
            [ 'font-awesome' ],
            $postgallery->config->get( 'version' )
        );
        wp_register_script(
            'wp-media-uploader',
            assets_url( 'js/jquery.wp-media-uploader.min.js', __FILE__ ),
            [ 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ],
            '1.1.1',
            true
        );
        wp_register_script(
            'admin-post-gallery',
            assets_url( 'js/app.js', __FILE__ ),
            [ 'wp-media-uploader' ],
            $postgallery->config->get( 'version' ),
            true
        );
    }
    /**
     * Registers admin menus.
     * @since 1.0.0
     */
    public function menu()
    {
        add_submenu_page(
            'options-general.php',
            __( 'Post Gallery Settings', 'simple-post-gallery' ),
            __( 'Galleries', 'simple-post-gallery' ),
            'manage_options',
            self::ADMIN_MENU_SETTINGS,
            [ &$this, 'view_settings' ]
        );
    }
    /**
     * Displays admin settings.
     * @since 1.0.0
     * @since 1.0.3 Added cache tab.
     * @since 2.0.0 Hooks modified.
     */
    public function view_settings()
    {
        // Enqueue
        wp_enqueue_style( 'font-awesome' );
        wp_enqueue_style( 'admin-post-gallery' );
        wp_enqueue_script( 'admin-post-gallery' );
        do_action( 'postgallery_settings_enqueue' );
        // Render
        $postGallery = PostGallery::find();
        $this->view->show( 'plugins.post-gallery.admin.settings', [
            'notice'        => $this->save( $postGallery ),
            'error'         => Request::input( 'error' ),
            'tab'           => Request::input( 'tab', 'general' ),
            'tabs'          => apply_filters( 'postgallery_settings_tabs', [
                                'general'   => __( 'General', 'simple-post-gallery' ),
                                'cache'     => __( '<i class="fa fa-cog" aria-hidden="true"></i> Cache', 'simple-post-gallery' ),
                                'docs'      => __( '<i class="fa fa-book" aria-hidden="true"></i> Documentation', 'simple-post-gallery' ),
                            ] ),
            'view'          => $this->view,
            'types'         => get_post_types(
                                [
                                    'public'   => true,
                                ],
                                'names'
                            ),
            'postGallery'   => $postGallery,
        ] );
    }
    /**
     * Saves settings.
     * Returns flag indicating success operation
     * @since 1.0.0
     * @since 1.0.3 Added cache flush.
     * @since 2.0.0 Hook added.
     *
     * @param object $socialFeeder Social Feeder model
     */
    protected function save( &$model )
    {
        $notice = Request::input( 'notice' );
        // Check action
        if ( !empty( $notice ) ) return $notice;
        // Save form
        if ( $_POST ) {
            try {
                if ( $_POST['submit'] === 'cache.flush' ) {
                    Cache::flush();
                    return __( 'Cache cleared.', 'simple-post-gallery' );
                }
                // General tab information
                $model->can_enqueue         = Request::input( 'can_enqueue', 0 );
                $model->types               = Request::input( 'types', [] );
                $model->metabox_context     = Request::input( 'metabox_context', 'advanced' );
                $model->metabox_priority    = Request::input( 'metabox_priority', 'default' );

                $model = apply_filters( 'postgallery_settings_before_save', $model );
                $model->save();
                $model->clear();

                do_action( 'postgallery_settings_saved' );
                return __( 'Settings saved.', 'simple-post-gallery' );

            } catch (Exception $e) {
                Log::error($e);
            }
        }
        return;
    }
    /**
     * Returns shorcode actions.
     * Filter "post_gallery_metabox_shortcode_actions"
     * @since 2.1.8
     *
     * @param array $actions Shortcode actions.
     *
     * @return array
     */
    public function shortcode_actions( $actions = [] )
    {
        // Copy to clipboard
        $actions['copy'] = [
            'name'  => __( 'Copy', 'simple-post-gallery' ),
            'fa'    => 'fa-files-o',
        ];
        // Append / insert into editor
        $actions['editor'] = [
            'name'  => __( 'Insert into content (current cursor position)', 'simple-post-gallery' ),
            'fa'    => 'fa-sign-in',
        ];
        return $actions;
    }
}