<?php

namespace WPMVC\MVC;

/**
 * Controller base class.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license MIT
 * @package WPMVC\MVC
 * @version 2.0.4
 */
abstract class Controller
{
    /**
     * Logged user reference.
     * @since 1.0.0
     * @var object
     */
    protected $user;
    /**
     * View class object.
     * @since 1.0.0
     * @var object
     */
    protected $view;
    /**
     * Default construct.
     * @since 1.0.0
     * @since 2.0.4 Allows controller to be called prios wordpress init.
     *
     * @param object $view View class object.
     */
    public function __construct( $view )
    {
        if ( function_exists( 'get_userdata' ) )
            $this->user = \get_userdata( get_current_user_id() );
        $this->view = $view;
    }
}