<?php

namespace WPMVC;

use ReflectionClass;
use WPMVC\Contracts\Plugable;
use WPMVC\MVC\Engine;

/**
 * Addon abstract class.
 *
 * @link https://github.com/amostajo/wordpress-plugin-core/blob/v1.0/src/psr4/Addon.php
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC
 * @version 3.0.0
 */
abstract class Addon implements Plugable
{
    /**
     * Plugin object reference.
     * @var object Plugin
     * @since 1.0.0
     */
    protected $main;

    /**
     * MVC engine.
     * @var object Plugin
     * @since 1.0.0
     */
    protected $mvc;

    /**
     * Default constructor.
     * @since 1.0.0
     * @since 3.0.0 Main as reference, new addon MVC location.
     * @since 3.0.1 Fixes paths.
     *
     * @see https://github.com/10quality/wpmvc-addon-template
     *
     * @param object $main Plugin object.
     */
    public function __construct( &$main )
    {
        $reflection = new ReflectionClass( $this );
        $this->main = $main;
        $this->mvc = new Engine(
            dirname( $reflection->getFileName() ) . '/../assets/views/',
            dirname( $reflection->getFileName() ) . '/Controllers/',
            $reflection->getNamespaceName()
        );
    }

    /**
     * Called on init.
     * @since 1.0.0
     *
     * @param object &$main Main plugin object as reference.
     *
     * @return void
     */
    public function init()
    {
        // TODO custom code.
    }

    /**
     * Called on admin.
     * @since 1.0.0
     *
     * @param object &$main Main plugin object as reference.
     *
     * @return void
     */
    public function on_admin()
    {
        // TODO custom code.
    }
}
