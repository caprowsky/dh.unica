<?php

use Ayuco\Listener;
use WPMVC\Resolver;
use WPMVC\Commands\SetNameCommand;
use WPMVC\Commands\SetupCommand;
use WPMVC\Commands\AddCommand;
use WPMVC\Commands\RegisterCommand;
use WPMVC\Commands\CreateCommand;
use WPMVC\Commands\SetCommand;

/**
 * CORE wordpress functions.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC
 * @version 3.1.0
 */

if ( ! function_exists( 'resize_image' ) ) {
    /**
     * Resizes image and returns URL path.
     * @since 1.0.1
     * @since 2.0.14 ID added as parameter to prevent duplicate entries by the same name.
     *
     * @param string  $url    Image URL path
     * @param int     $width  Width wanted.
     * @param int     $height Height wanted.
     * @param boolean $crop   Flag that indicates if resulting image should crop
     * @param mixed   $id     Unique identifier. (i.e. post_id)
     *
     * @return string URL
     */
    function resize_image( $url, $width, $height, $crop = true, $id = null )
    {
        $image = wp_get_image_editor( $url );
        if( is_wp_error( $image ) ) return;
        $image_name = explode( '/', $url );
        $image_name = explode( '.', $image_name[count( $image_name ) - 1] );
        $image_extension = strtolower( $image_name[count( $image_name ) - 1] );
        $image_name = $image_name[0];
        $upload_dir = wp_upload_dir();
        $filename = sprintf(
            '/%s%s-%sx%s.%s',
            ( $id === null ? '' : $id . '-' ),
            $image_name,
            $width,
            $height,
            $image_extension
        );
        $image->resize( $width, $height, $crop );
        $image->save( $upload_dir['path'] . $filename );
        return $upload_dir['url'] . $filename;
    }
}

if ( ! function_exists( 'assets_url' ) ) {
    /**
     * Returns url of asset located in a theme or plugin.
     * @since 1.0.1
     * @since 2.0.4 Refactored to work with new structure.
     * @since 2.0.15 Added scheme as paramete and network support.
     *
     * @link https://codex.wordpress.org/Function_Reference/home_url
     * @link https://codex.wordpress.org/Function_Reference/network_home_url
     * @param string $path       Asset relative path.
     * @param string $file       File location path.
     * @param string $scheme     Scheme to give the home url context. Currently 'http','https'.
     * @param bool   $is_network Flag that indicates if base url should be retrieved from a network setup.
     *
     * @return string URL
     */
    function assets_url( $path, $file, $scheme = null, $is_network = false )
    {
        // Preparation
        $route = preg_replace( '/\\\\/', '/', $file );
        $url = apply_filters(
            'asset_base_url',
            rtrim( $is_network ? network_home_url( '/', $scheme ) : home_url( '/', $scheme ), '/' )
        );
        // Clean base path
        $route = preg_replace( '/.+?(?=wp-content)/', '', $route );
        // Clean project relative path
        $route = preg_replace( '/\/app[\/\\A-Za-z0-9\.\\-]+/', '', $route );
        $route = preg_replace( '/\/assets[\/\\A-Za-z0-9\.\\-]+/', '', $route );
        $route = preg_replace( '/\/vendor[\/\\A-Za-z0-9\.\\-]+/', '', $route );
        return $url.'/'.apply_filters( 'app_route', $route ).'/assets/'.$path;
    }
}

if ( ! function_exists( 'get_ayuco' ) ) {
    /**
     * Returns ayuco.
     * @since 2.0.3
     * @since 2.0.4 Added new commands.
     * @since 2.0.13 Added SetCommand and sorts registration by name.
     *
     * @param string $path Project path.
     *
     * @return object
     */
    function get_ayuco($path)
    {
        $ayuco = new Listener();

        $ayuco->register(new AddCommand($path));
        $ayuco->register(new CreateCommand($path));
        $ayuco->register(new RegisterCommand($path));
        $ayuco->register(new SetCommand($path));
        $ayuco->register(new SetupCommand($path));
        $ayuco->register(new SetNameCommand($path));

        return $ayuco;
    }
}

if ( ! function_exists( 'get_wp_home_path' ) )
{
    /**
     * Returns wordpress root path.
     * @since 2.0.4
     * @since 2.0.10 Force file update on repository.
     * @since 3.0.5 Added filters to support path customization. 
     *
     * @return string
     */
    function get_wp_home_path()
    {
        return apply_filters(
            'home_path',
            function_exists( 'get_home_path' )
                ? apply_filters( 'get_home_path', get_home_path() )
                : preg_replace(
                    apply_filters( 'wpmvc_home_path_regex_rule', '/wp-content[\s\S]+/' ),
                    apply_filters( 'wpmvc_home_path_regex_replacement', '' ),
                    __DIR__
                )
        );
    }
}

if ( ! function_exists( 'assets_path' ) ) {
    /**
     * Returns path of asset located in a theme or plugin.
     * @since 1.0.1
     * @since 2.0.4 Refactored to work with new structure.
     * @since 3.0.5 Uses get_wp_home_path instead.
     *
     * @param string  $relative Asset relative path.
     * @param string  $file     File location path.
     *
     * @return string URL
     */
    function assets_path( $relative, $file )
    {
        // Preparation
        $route = preg_replace( '/\\\\/', '/', $file );
        $path = rtrim( preg_replace( '/\\\\/', '/', get_wp_home_path() ), '/' );
        // Clean base path
        $route = preg_replace( '/.+?(?=wp-content)/', '', $route );
        // Clean project relative path
        $route = preg_replace( '/\/app[\/\\A-Za-z0-9\.\\-]+/', '', $route );
        $route = preg_replace( '/\/assets[\/\\A-Za-z0-9\.\\-]+/', '', $route );
        $route = preg_replace( '/\/vendor[\/\\A-Za-z0-9\.\\-]+/', '', $route );
        return $path.'/'.apply_filters( 'app_route_path', $route ).'/assets/'.$relative;
    }
}

if ( ! function_exists( 'exists_bridge' ) ) {
    /**
     * Returns flag indicating if a bridge instace exists.
     * @since 3.1.0
     *
     * @param string $namespace Namespace.
     * 
     * @return bool
     */
    function exists_bridge( $namespace )
    {
        return Resolver::exists( $namespace );
    }
}

if ( ! function_exists( 'get_bridge' ) ) {
    /**
     * Returns a bridge.
     * @since 3.1.0
     *
     * @param string $namespace Namespace.
     * 
     * @return WPMVC\Bridge|object
     */
    function get_bridge( $namespace )
    {
        return Resolver::get( $namespace );
    }
}

if ( ! function_exists( 'theme_view' ) ) {
    /**
     * Prints / echos a view located in the theme.
     * @since 3.1.0
     *
     * @param string $key    View key.
     * @param array  $params View params.
     */
    function theme_view( $key, $params = [] )
    {
        if ( Resolver::exists( 'theme' ) )
            Resolver::get( 'theme' )->view( $key, $params );
    }
}