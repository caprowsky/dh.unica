<?php

namespace PostGallery\Controllers;

use WPMVC\Request;
use WPMVC\MVC\Controller;
/**
 * NoticeController controller.
 * Generated with ayuco.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 2.2.0
 */
class NoticeController extends Controller
{
    /**
     * Checks for dismissed notices.
     * Action "admin_init"
     * Wordpress hook
     * @since 2.1.2
     */
    public function check_dismissed()
    {
        $dismissed = Request::input( 'post-gallery-dismissed' );
        if ( $dismissed )
            update_option( 'postgallery_'.$dismissed.'_show', 0, true );
        unset( $dismissed );
    }
    /**
     * Display important admin notices.
     * Action "admin_notices"
     * Wordpress hook
     * @since 2.1.2
     * @since 2.2.0 Removed notice 0.
     */
    public function show()
    {
        /*
        if ( get_option( 'postgallery_notice_0_show', true ) ) {
            $this->view->show( 'plugins.post-gallery.admin.notices.lightbox-notice' );
        }
        */
        // TODO future notices
    }
}