<?php
/**
 * Vimeo video preview.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.1.0
 */ 
?>
<iframe src="https://player.vimeo.com/video/<?= $id ?>"
    <?php if ( isset( $model ) ) : ?>
        class="attachment-<?= $model->ID ?>"
        img="<?= $model->edit_url ?>"
    <?php endif ?>
    width="640"
    height="368"
    frameborder="0"
    webkitallowfullscreen mozallowfullscreen allowfullscreen
></iframe>
<?php do_action( 'post_gallery_video_importer_preview_vimeo' ) ?>