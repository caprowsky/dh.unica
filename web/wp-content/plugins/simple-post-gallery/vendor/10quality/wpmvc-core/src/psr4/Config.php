<?php

namespace WPMVC;

/**
 * Config class.
 * Part of the core library of Wordpress Plugin.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC
 * @version 1.0.0
 */
class Config
{
	/**
	 * Raw config array.
	 * @var array
	 * @since 1.0.0
	 */
	protected $raw;

	/**
	 * Constructor.
	 * @since 1.0.0
	 *
	 * @param array $raw Raw config array.
	 */
	public function __construct( $raw )
	{
		$this->raw = $raw;
	}

	/**
	 * Returns value stored in given key.
	 * Can acces multidimenssional array values with a DOT(.)
	 * i.e. paypal.client_id
	 * @since 1.0.0
	 *
	 * @param string $key Key.
	 * @param string $sub Child array
	 *
	 * @return mixed
	 */
	public function get( $key, $sub = null )
	{
		if ( empty( $sub ) ) $sub = $this->raw;

		$keys = explode( '.', $key );
		if ( empty( $keys ) ) return;

		if ( array_key_exists( $keys[0], $sub ) ) {
			if ( count( $keys ) == 1 ) {
				return $sub[$keys[0]];
			} else if ( is_array( $sub[$keys[0]] ) ) {
				$sub = $sub[$keys[0]];
				unset( $keys[0] );
				return $this->get( implode( '.', $keys), $sub );
			}
		}
		return;
	}
}
