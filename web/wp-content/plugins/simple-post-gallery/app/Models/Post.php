<?php

namespace PostGallery\Models;

use WPMVC\Cache;
use WPMVC\Log;
use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\PostModel as Model;

/**
 * Post model.
 *
 * @link https://www.wordpress-mvc.com/v1/models/post-models/
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 2.1.6
 */
class Post extends Model
{
    use FindTrait;

    /**
     * Default post status.
     * @since 1.0.0
     * @var string
     */
    protected $status = 'publish';

    /**
     * Model property alieases.
     * @since 1.0.0
     * @var array
     */
    protected $aliases = [
        'media'         => 'meta__gallery',
        'format'        => 'meta__gallery_format',
        'format_data'   => 'meta__gallery_format_data',
    ];

    /**
     * Returns relationship between post and attachments.
     * @since 2.0.0
     * @since 2.1.6 Fixes compatibility with php 5.4.
     *
     * @return Relationship
     */
    protected function gallery()
    {
        return $this->has_many( '\PostGallery\Models\Attachment', 'media' );
    }

    /**
     * Extension of normal find() constructor with the addition of a type.
     * The types is override to enable any post type modification.
     * @since 1.0.0
     *
     * @param int    $ID   Post ID.
     * @param string $type Post Type.
     *
     * @return object this
     */
    public static function findWithType( $ID, $type )
    {
        $model = self::find( $ID );
        $model->set_type( $type );
        return $model;
    }

    /**
     * Sets post type.
     * @since 1.0.0
     *
     * @param string $type Post Type.
     */
    public function set_type( $type )
    {
        $this->type = $type;
    }

    /** 
     * Clears model cache.
     * @since 1.0.0
     */
    public function clear()
    {
        Cache::forget( 'gallery_post_' . $this->ID );
        Cache::forget( 'gallery_' . $this->ID );
    }
}