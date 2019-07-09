<?php

namespace WPMVC;

/**
 * Resolver holds reference to any global instace created in Wordpress.
 * Allows for easy access to any instance initialized.
 *
 * @author Cami Mostajo <info@10quality.com>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC
 * @version 3.1.0
 */
class Resolver
{
    /**
     * Bridges instantiated.
     * @since 3.1.0
     * @var array
     */
    protected static $instances = [];

    /**
     * Adds a new instance to the resolver.
     * @since 3.1.0
     * 
     * @param string              $key     Instance key (namespace or other).
     * @param WPMVC\Bridge|object &$bridge Bridge instace to keep referece of.
     */
    public static function add( $key, &$bridge )
    {
        static::$instances[$key] = $bridge;
    }

    /**
     * Returns any instantiated instence stored in resolver.
     * @since 3.1.0
     * 
     * @param string $key Instance key (namespace or other).
     * 
     * @return WPMVC\Bridge|object
     */
    public static function get( $key )
    {
        return isset( static::$instances[$key] ) ? static::$instances[$key] : null;
    }

    /**
     * Returns flag indicating if an instance exists under a given key.
     * @since 3.1.0
     * 
     * @param string $key Instance key (namespace or other).
     * 
     * @return bool
     */
    public static function exists( $key )
    {
        return isset( static::$instances[$key] );
    }
}