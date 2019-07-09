<?php

namespace WPMVC;

/**
 * Request class.
 * Used to get web input from query string or wordpress' query vars.
 *
 * @link https://github.com/amostajo/lightweight-mvc/blob/v1.0/src/Request.php
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC
 * @version 1.0.0
 */
class Request
{
    /**
     * Gets input from either wordpress query vars or request's POST or GET.
     * @since 1.0.0
     *
     * @global object $wp_query Wordpress query.
     *
     * @param string $key     Name of the input.
     * @param mixed  $default Default value if data is not found.
     * @param bool   $Clear   Clears out source value.
     *
     * @return mixed
     */
    public static function input ( $key, $default = null, $clear = false )
    {
        global $wp_query;
        $value = null;
        // Check if it exists in wp_query
        if ( array_key_exists( $key, $wp_query->query_vars ) ) {
            $value = $wp_query->query_vars[$key];
            if ( $clear ) unset( $wp_query->query_vars[$key] );
        } else if ( $_POST && array_key_exists( $key, $_POST ) ) {
            $value = $_POST[$key];
            if ( $clear ) unset( $_POST[$key] );
        } else if ( array_key_exists( $key, $_GET ) ) {
            $value = $_GET[$key];
            if ( $clear ) unset( $_GET[$key] );
        }
        if ( ! is_array( $value ) ) $value = trim( $value );
        return $value == null 
            ? $default
            : ( is_array( $value )
                ? $value
                : ( is_int( $value )
                    ? intval( $value )
                    : ( is_float( $value )
                        ? floatval( $value )
                        : ( strtolower( $value ) == 'true' || strtolower( $value ) == 'false'
                            ? strtolower( $value ) == 'true'
                            : $value
                        )
                    )
                )
            );
    }
}