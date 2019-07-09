<?php

namespace PostGallery\Models;

use WPMVC\Cache;
use WPMVC\MVC\Traits\FindTrait;
use WPMVC\MVC\Models\OptionModel as Model;

/**
 * PostGallery Settings model.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 2.0.0
 */
class PostGallery extends Model
{
    use FindTrait;
    /**
     * Instance information.
     * @since 1.0.0
     * @var object
     */
    protected static $instance;

    /**
     * Model id.
     * @since 1.0.0
     * @var string
     */
    protected $id = 'post_gallery';

    /**
     * Field aliases and definitions.
     * @since 1.0.0
     * @since 2.0.0 Added extra for custom data.
     * @var array
     */
    protected $aliases = [
        'can_enqueue'       => 'field_can_enqueue',
        'types'             => 'field_types',
        'metabox_context'   => 'field_metabox_context',
        'metabox_priority'  => 'field_metabox_priority',
        'extra'             => 'field_extra',
    ];

    /**
     * Instance constructor.
     * @since 1.0.0
     * @since 2.0.0 Cached removed.
     *
     * @return this for chaining
     */
    public static function instance()
    {
        if ( isset( self::$instance ) )
            return self::$instance;
        self::$instance = self::find();
        return self::$instance;
    }

    /**
     * Returns flag indicating if model has a specific post type configured.
     * @since 1.0.0
     *
     * @param string $type Post type slug.
     *
     * @return bool
     */
    public function has_type( $type )
    {
        if ( ! $this->types && ! is_array( $this->types ) ) return false;
        for ( $i = count( $this->types ) - 1; $i >= 0; --$i ) {
            if ( $this->types[$i] == $type )
                return true;
        }
        return false;
    }

    /**
     * Clears models cache.
     * @since 1.0.0
     */
    public function clear()
    {
        Cache::forget( 'post_gallery' );
    }
}