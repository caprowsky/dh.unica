<?php
/**
 * Media tab: Video Importer
 *
 * @link https://codex.wordpress.org/Function_Reference/wp_iframe
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.1.0
 */ 
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?= assets_url( 'css/font-awesome.min.css', __FILE__ ) ?>">
        <?php $view->show( 'media.video-importer-styles' ) ?>
        <?php do_action( 'post_gallery_video_importer_html_head' ) ?>
    </head>
    <body>
        <div class="media-embed">
            <?php $view->show( 'media.video-importer-form' ) ?>
        </div>
        <script src="<?= assets_url( 'js/jquery.min.js', __FILE__ ) ?>"></script>
        <?php $view->show( 'media.video-importer-scripts' ) ?>
        <?php do_action( 'post_gallery_video_importer_html_foot' ) ?>
    </body>
</html>