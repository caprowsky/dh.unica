<?php
/**
 * Video Importer styles.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.1.0
 */ 
?>
<style type="text/css">
    body {
        background-color: #fff;
    }
    .container {
        margin: 0;
        padding: 16px;
    }
    .embed-url {
        position: relative;
        margin: 0;
        z-index: 250;
        font-size: 18px;
    }
    .embed-url input {
        font-size: 18px;
        padding: 12px 14px;
        width: 100%;
        min-width: 200px;
        box-shadow: inset 2px 2px 4px -2px rgba(0,0,0,.1);
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
        border-width: 1px;
        border-style: solid;
        border-color: #ddd;
        margin: 1px;
    }
    .description i.fa {
        font-size: 25px;
        margin-top: 4px;
    }
    .fa-spinner {
        position: absolute;
        top: 0;
        right: 10px;
        font-size: 25px;
    }
    .preview {
        float: none;
    }
    .actions {
        position: relative;
        overflow: hidden;
    }
    button {
        float: right;
    }
    <?php do_action( 'post_gallery_video_importer_styles' ) ?>
</style>