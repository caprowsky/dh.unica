<?php
/**
 * Video Importer form.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.2.0
 */ 
?>
<div class="container">
    <?php do_action( 'post_gallery_video_importer_before_form' ) ?>
    <form id="video-importer" action="<?= admin_url( '/admin-ajax.php' ) ?>">
        <label class="embed-url">
            <input id="embed-url" class="url" name="url" type="url" placeholder="<?php _e( 'Paste video link here', 'simple-post-gallery' ) ?>">
            <i class="loader fa fa-spinner fa-spin" style="display:none"></i>
            <p class="description">
                <?php _e( 'Supported:', 'simple-post-gallery' ) ?>
                <i class="fa fa-youtube" title="YouTube"></i> 
                <i class="fa fa-vimeo" title="Vimeo"></i> 
                <?php do_action( 'post_gallery_video_importer_providers' ) ?>
            </p>
        </label>
        <?php do_action( 'post_gallery_video_importer_form' ) ?>
        <div class="actions" style="display: none">
            <button type="submit" name="import" class="import button button-primary">
                <?= apply_filters( 'post_gallery_video_importer_button_label', __( 'Import', 'simple-post-gallery' ) ) ?>
            </button>
        </div>
        <div class="notice error" style="display: none"></div>
        <div class="preview" style="display: none"></div>
    </form>
    <?php do_action( 'post_gallery_video_importer_after_form' ) ?>
</div>