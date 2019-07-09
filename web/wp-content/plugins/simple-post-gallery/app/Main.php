<?php

namespace PostGallery;

use WPMVC\Bridge;
/**
 * Main class.
 * Bridge between Wordpress and App.
 * Class contains declaration of hooks and filters.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 2.3.2
 */
class Main extends Bridge
{
    /**
     * Declaration of public wordpress hooks.
     * @since 2.3.0
     */
    public function init()
    {
        $this->add_shortcode('post_gallery', 'GalleryController@show');
        $this->add_action('wp_enqueue_scripts', 'ConfigController@enqueue');
        $this->add_filter('plugin_action_links_simple-post-gallery/plugin.php', 'ConfigController@plugin_links');
        // -- Video importer
        $this->add_filter('media_upload_tabs', 'VideoController@media_tabs');
        $this->add_action('media_upload_video_importer', 'VideoController@media_tab');
        $this->add_filter('post_gallery_video_preview', 'VideoController@preview', 10, 3);
        $this->add_filter('post_gallery_import_video', 'VideoController@import', 10, 2);
        $this->add_filter('media_send_to_editor', 'VideoController@send_to_editor', 10, 2);
        $this->add_filter('attachment_fields_to_edit', 'VideoController@fields', 10, 2);
        $this->add_filter('attachment_fields_to_save', 'VideoController@fields_save', 10, 2);
        $this->add_action('wp_ajax_video_importer_validate', 'VideoController@ajax_validate');
        $this->add_action('wp_ajax_video_importer_import', 'VideoController@ajax_import');
        // -- Gutenberg
        if ( function_exists( 'register_block_type' ) )
            $this->add_action('init', 'BlockController@register');
    }
    /**
     * Declaration of admin only wordpress hooks.
     * For Wordpress admin dashboard.
     * @since 2.3.0
     */
    public function on_admin()
    {
        $this->add_action('admin_menu', 'AdminController@menu');
        $this->add_action('admin_enqueue_scripts', 'AdminController@enqueue');
        $this->add_action('add_meta_boxes', 'GalleryController@add_metabox', 10);
        $this->add_action('save_post', 'GalleryController@save', 20);
        $this->add_action('post_gallery_extended_formats', 'view@plugins.post-gallery.admin.extended-formats');
        $this->add_filter('post_gallery_metabox_shortcode_actions', 'AdminController@shortcode_actions', 1);
        // -- Notices
        //$this->add_action('admin_init', 'NoticeController@check_dismissed');
        //$this->add_action('admin_notices', 'NoticeController@show');
    }
}