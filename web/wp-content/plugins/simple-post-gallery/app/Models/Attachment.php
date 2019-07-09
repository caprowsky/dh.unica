<?php

namespace PostGallery\Models;

use Exception;
use WPMVC\Cache;
use WPMVC\Log;
use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\Common\Attachment as Model;

/**
 * Attachment model.
 *
 * @link http://wordpress-dev.evopiru.com/documentation/models/
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 2.2.4
 */
class Attachment extends Model
{
    use FindTrait;
    /**
     * Aliases.
     * @since 1.0.0
     * @since 1.0.1 Added title, date and mime
     * @since 2.0.0 Following parent.
     * @since 2.1.0 Added embed for video.
     * @since 2.2.0 Added video_thumb.
     * @since 2.2.1 Added is_lightbox and no_thumb_url.
     * @since 2.2.4 Added is_uploaded.
     * @var array
     */
    protected $aliases = [
        'title'             => 'post_title',
        'date'              => 'post_date',
        'mime'              => 'post_mime_type',
        'mime_type'         => 'func_get_mime_type',
        'url'               => 'guid',
        'caption'           => 'func_get_caption',
        'alt'               => 'meta__wp_attachment_image_alt',
        'path'              => 'func_get_path',
        'thumb_url'         => 'func_get_thumb_url',
        'large_url'         => 'func_get_large_url',
        'medium_url'        => 'func_get_medium_url',
        'edit_url'          => 'func_get_edit_url',
        'embed'             => 'meta_embed',
        'embed_size'        => 'meta_video_embed_size',
        'is_video'          => 'func_get_is_video',
        'video_id'          => 'meta_video_id',
        'video_url'         => 'meta_video_url',
        'video_provider'    => 'meta_video_provider',
        'is_uploaded'       => 'func_get_is_uploaded',
        'is_lightbox'       => 'func_get_is_lightbox',
        'video_thumb'       => 'func_get_video_thumb',
        'no_thumb_path'     => 'func_get_no_thumb_path',
        'no_thumb_url'      => 'func_get_no_thumb_url',
    ];
    /**
     * Hidden attributes in Array and JSON casting.
     * @since 2.0.0
     * @since 2.2.1 Added is_lightbox, video_thumb and no_thumb_url.
     * @var array
     */
    protected $hidden = [
        'post_author',
        'post_title',
        'post_name',
        'post_content',
        'post_date',
        'post_date_gmt',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count',
        'filter',
        'page_template',
        'post_category',
        'tags_input',
        'is_lightbox',
        'video_thumb',
        'no_thumb_path',
        'no_thumb_url',
    ];
    /**
     * Returns image with proper edit resolution.
     * @since 1.0.0
     * @since 1.0.3 Adds ID on resize.
     * @since 1.0.5 ID passed as reference.
     *
     * @return string
     */
    protected function get_edit_url()
    {
        $path = $this->path;
        $ID = $this->ID;
        return Cache::remember(
            'attachment_' . $this->ID . '_edit',
            43200,
            function() use( &$path, &$ID ) {
                try {
                    return resize_image(
                        $path,
                        170,
                        65,
                        false,
                        $ID
                    );
                } catch ( Exception $e ) {
                    Log::error( $e );
                }
                return;
            }
        );
    }
    /**
     * Returns flag indicating if attachement is a supported video.
     * @since 2.1.0
     * @since 2.2.1 Added video/mp4.
     *
     * @return bool
     */
    protected function get_is_video()
    {
        return in_array( $this->mime , apply_filters(
            'post_gallery_video_mimes',
            ['video/youtube', 'video/vimeo', 'video/mp4']
        ) );
    }
    /**
     * Returns mime type.
     * i.e. 'image/jpg' => 'image'
     * i.e. 'video/youtube' => 'video'
     * @since 2.1.0
     *
     * @return string
     */
    protected function get_mime_type()
    {
        return preg_replace( '/\/[\s\S]+/', '', $this->mime );
    }
    /**
     * Returns attachment url at a specified resolution.
     * @since 2.0.0
     * @since 2.2.1 Support for no thumb media.
     *
     * @param int  $width  Resolution width.
     * @param int  $height Resolution height.
     * @param bool $crop   Flag that indiates if should be cropped.
     * @param bool $cache  Flag that indiates if resulting url should be cached.
     *
     * @return string
     */
    public function get_res( $width, $height, $crop = true, $cache = true )
    {
        $path = $this->thumb_url ? $this->path : $this->no_thumb_path;
        $ID = $this->ID;
        if ( $cache === false ) {
            try {
                return resize_image(
                    $path,
                    $width,
                    $height,
                    $crop,
                    $ID
                );
            } catch ( Exception $e ) {
                Log::error( $e );
            }
            return;
        }
        return Cache::remember(
            'attachment_' . $ID . '_' . $width . 'x' . $height . ( $crop ? '_crop' : '' ),
            43200,
            function() use( &$path, &$ID, &$width, &$height, &$crop ) {
                try {
                    return resize_image(
                        $path,
                        $width,
                        $height,
                        $crop,
                        $ID
                    );
                } catch ( Exception $e ) {
                    Log::error( $e );
                }
                return;
            }
        );
    }
    /**
     * Returns video thumbnail URL (for uploaded MP4).
     * @since 2.2.0
     *
     * @return string
     */
    public function get_video_thumb()
    {
        return assets_url( 'images/default-video.jpg', __DIR__ );
    }
    /**
     * Returns flag indicating if media is supported by lightbox solution.
     * @since 2.2.1
     * @since 2.2.4 All current are supported.
     *
     * @return bool
     */
    public function get_is_lightbox()
    {
        return true;
    }
    /**
     * Returns path to where video thumb is located.
     * @since 2.2.1
     *
     * @global object $postgallery Main class.
     *
     * @return string
     */
    public function get_no_thumb_path()
    {
        global $postgallery;
        return $postgallery->config->get( 'paths.base' ).'../assets/images/default-video.jpg';
    }
    /**
     * Returns no thumb image url.
     * @since 2.2.1
     *
     * @return string
     */
    public function get_no_thumb_url()
    {
        return $this->get_res( get_option( 'thumbnail_size_w' ), get_option( 'thumbnail_size_h' ) );
    }
    /**
     * Returns flag indicating attachent is an uploaded video.
     * @since 2.2.4
     *
     * @return bool
     */
    protected function get_is_uploaded()
    {
        return in_array( $this->mime, ['video/mp4'] );
    }
}