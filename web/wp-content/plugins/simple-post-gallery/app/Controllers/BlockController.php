<?php

namespace PostGallery\Controllers;

use WPMVC\MVC\Controller;

/**
 * Handles gutenberg related hooks.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.3.0
 */
class BlockController extends Controller
{
    /**
     * Registers gutenbergs blocks.
     * @since 2.3.0
     * 
     * @link https://www.youtube.com/watch?v=Qsf4YODc-cQ
     * 
     * @global PostGallery\Main $postgallery
     */
    public function register()
    {
        global $postgallery;
        // --- POST GALLERY BLOCK
        wp_register_script(
            'post-gallery-block-editor',
            assets_url( 'blocks/gallery/editor.js', __DIR__ ),
            [ 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-api-fetch' ],
            $postgallery->config->get( 'version' )
        );
        wp_register_style(
            'post-gallery-block-editor',
            assets_url( 'blocks/gallery/editor.css', __DIR__ ),
            [ 'wp-edit-blocks' ],
            $postgallery->config->get( 'version' )
        );
        register_block_type( 'simple-post-gallery/gallery', [
            'editor_script' => 'post-gallery-block-editor',
            'editor_style'  => 'post-gallery-block-editor',
        ] );
    }
}