<?php
/**
 * Global functions.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 1.0.0
 */

if ( ! function_exists( 'post_gallery' ) ) {
    /**
     * Make global plugin variable reachable for global usage.
     * @since 1.0.0
     *
     * @return object Main class.
     */
    function post_gallery()
    {
        global $postgallery;
        return $postgallery;
    }
}

if ( ! function_exists( 'get_gallery' ) ) {
    /**
     * Returns a post gallery.
     * @since 1.0.0
     *
     * @param int $post_id Post ID.
     *
     * @return array
     */
    function get_gallery( $post_id = null )
    {
        return post_gallery()->{'_c_return_GalleryController@get'}( $post_id );
    }
}

if ( ! function_exists( 'the_gallery' ) ) {
    /**
     * Templating function.
     * Displays a post gallery.
     * @since 1.0.0
     *
     * @param int $post_id Post ID.
     */
    function the_gallery( $post_id = null )
    {
        post_gallery()->{'_c_void_GalleryController@show'}( $post_id );
    }
}