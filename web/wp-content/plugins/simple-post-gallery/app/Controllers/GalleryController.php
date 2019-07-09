<?php

namespace PostGallery\Controllers;

use WPMVC\Log;
use WPMVC\Cache;
use WPMVC\Request;
use WPMVC\MVC\Controller;
use PostGallery\Models\Post;
use PostGallery\Models\PostGallery;

/**
 * Gallery Controller.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.2.6
 */
class GalleryController extends Controller
{
    /**
     * Returns a post gallery.
     * @since 1.0.0
     * @since 2.0.0 WPMVC compatibility and hooks.
     * @since 2.1.5 Hot fix to allow PHP 5.4 compatibility.
     *
     * @param mixed $post_id Post ID.
     *
     * @return array
     */
    public function get( $post_id = null )
    {
        try
        {
            if ( empty( $post_id ) )
                $post_id = get_the_ID();
            $post = call_user_func_array(
                [apply_filters( 'post_gallery_model_class', '\PostGallery\Models\Post' ), 'find'],
                [$post_id]
            );
            if ( $post->gallery )
                return $post->gallery;
        } catch (Exception $e) {
            Log::error( $e );
        }
        return;
    }

    /**
     * Displays a post gallery.
     * @since 1.0.0
     * @since 2.0.0 WPMVC compatibility, format customization.
     * @since 2.1.2 Adds gallery scripta and swipebox support.
     * @since 2.1.5 Hot fix to allow PHP 5.4 compatibility.
     * @since 2.2.2 Checks for shortcode attributes.
     * @since 2.2.6 Lightbox removed.
     *
     * @param mixed $post_id Post ID.
     */
    public function show( $post_id = null )
    {
        try
        {
            // Direct parameter
            if ( empty( $post_id ) )
                $post_id = get_the_ID();
            // ID parameter from shortcode attributes.
            if ( is_array( $post_id ) )
                $post_id = isset( $post_id['id'] ) ? $post_id['id'] : get_the_ID();
            // Prepare
            $post = call_user_func_array(
                [apply_filters( 'post_gallery_model_class', '\PostGallery\Models\Post' ), 'find'],
                [$post_id]
            );
            if ( $post->gallery ) {
                // Enqueue
                $post_gallery = PostGallery::instance();
                if ( $post_gallery->can_enqueue ) {
                    wp_enqueue_script( 'swipebox' );
                    wp_enqueue_style( 'swipebox' );
                    wp_add_inline_script( 'swipebox', $this->view->get( 'plugins.post-gallery.gallery-script' ) );
                    do_action( 'post_gallery_can_enqueue', $post_gallery );
                }
                do_action( 'post_gallery_enqueue', $post_gallery );
                do_action( 'post_gallery_enqueue_' . $post->format, $post );

                // Render
                return apply_filters(
                    $post->format === null || $post->format === 'default'
                        ? 'gallery_view'
                        : 'gallery_view_'.$post->format,
                    $this->view->get('plugins.post-gallery.gallery', [
                        'post'   => $post,
                    ] ),
                    $post
                );
            }
        } catch (Exception $e) {
            Log::error( $e );
        }
    }

    /**
     * Registers metaboxes.
     * @since 1.0.0
     *
     * @param string $post_type Post type to validate.
     */
    public function add_metabox( $post_type )
    {
        $post_gallery = PostGallery::find();
        if ( ! $post_gallery->has_type( $post_type ) )
            return;
        add_meta_box( 
            '10q-post-gallery',
            __( 'Gallery', 'simple-post-gallery' ),
            [ &$this, 'metabox' ],
            $post_type,
            $post_gallery->metabox_context ? $post_gallery->metabox_context : 'advanced',
            $post_gallery->metabox_priority ? $post_gallery->metabox_priority : 'default'
        );
    }

    /**
     * Displays gallery metabox.
     * @since 1.0.0
     * @since 2.0.0 Added hooks.
     *
     * @param object $post Post object WP_Post.
     */
    public function metabox( $post )
    {
        // Enqueue
        wp_enqueue_media();
        wp_enqueue_style( 'admin-post-gallery' );
        wp_enqueue_script( 'admin-post-gallery' );
        do_action( 'postgallery_enqueue_metabox' );
        // Nonce control
        wp_nonce_field( 'metabox_gallery', 'metabox_gallery_nonce' );
        // Render
        $model = apply_filters(
            'postgallery_model',
            Post::findWithType( $post->ID, $post->post_type ),
            $post->id
        );
        $model->format_data = apply_filters(
            'postgallery_format_data_default',
            $model->format_data,
            $model,
            PostGallery::find()
        );
        $this->view->show( 'plugins.post-gallery.admin.metaboxes.gallery', [
            'post'          => $model,
            'view'          => $this->view,
            'formats'       => apply_filters( 'postgallery_formats', ['default' => __( 'Thumbnails', 'simple-post-gallery' ) ] ),
        ] );
    }
    /**
     * Saves gallery information.
     * @since 1.0.0
     * @since 2.0.0 Formats support.
     * @since 2.2.4 Fixed missing $model bug.
     *
     * @param int $post_id Post id.
     */
    public function save( $post_id )
    {
        $post_gallery = PostGallery::find();
        $post_type = get_post_type( $post_id );
        if ( ! $post_gallery->has_type( $post_type ) )
            return;

        $nonce = Request::input( 'metabox_gallery_nonce', '', true );

        if ( (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            || empty($nonce) 
            || ! wp_verify_nonce( $nonce, 'metabox_gallery' ) 
        ) {
            return;
        }

        try {
            $post = apply_filters(
                'postgallery_model',
                Post::findWithType( $post_id, $post_type ),
                $post_id
            );

            // Gallery
            $input = Request::input( 'media', [] );
            $media = [];
            // Check and remove duplicates
            foreach ( $input as $attachment ) {
                if ( ! in_array( $attachment, $media ) )
                    $media[] = $attachment;
            }
            $post->media = $media;

            // Save selected formats
            $post->format = Request::input( 'gallery_format', 'default' );

            // Data
            $data = $post->format_data;
            foreach ( apply_filters( 'postgallery_formats', ['default' => __( 'Thumbnails', 'simple-post-gallery' ) ] ) as $format => $title ) { 
                $data[$format] = apply_filters(
                    'postgallery_save_format_'.$format,
                    isset( $data[$format] ) ? $data[$format] : [],
                    $post
                );
            }
            $post->format_data = apply_filters( 'postgallery_save_format_data', $data, $post );

            $post->save();
            $post->clear();

            do_action( 'postgallery_save', $post, $post_id );
        } catch ( Exception $e ) {
            Log::error( $e );
        }
    }
}