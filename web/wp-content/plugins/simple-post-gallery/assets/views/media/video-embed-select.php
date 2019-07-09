<?php
/**
 * Video embed sizes.
 *
 * @author Cami Mostajo
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.2.0
 */ 
?>
<select name="attachments[<?= $post->ID ?>][embed_size]" id="embed_size">
    <?php foreach ( apply_filters( 'post_gallery_video_embed_sizes', ['default' => __( 'Standard', 'simple-post-gallery' )] ) as $key => $value ) : ?>
        <option value="<?= $key ?>" <?php if ( $attachment->embed_size === $key ) : ?>selected<?php endif ?>><?= $value ?></option>
    <?php endforeach ?>
</select>