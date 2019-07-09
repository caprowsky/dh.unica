<?php
/**
 * YouTube video preview.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.1.0
 */ 
?>
<iframe width="560"
    height="315"
    src="https://www.youtube.com/embed/<?= $id ?>"
    <?php if ( isset( $model ) ) : ?>
        class="attachment-<?= $model->ID ?>"
        img="<?= $model->edit_url ?>"
    <?php endif ?>
    frameborder="0"
    allow="autoplay; encrypted-media" allowfullscreen
></iframe>
<?php do_action( 'post_gallery_video_importer_preview_youtube' ) ?>