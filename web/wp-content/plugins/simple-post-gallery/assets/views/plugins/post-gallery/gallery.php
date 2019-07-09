<?php
/**
 * Gallery view/template.
 *
 * COPY THIS FILE IN YOUR THEME FOR CUSTOMIZATIONS. LOCATION:
 * [theme-folder]/views/plugins/post-gallery/gallery.php
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.2.4
 */ 
?>
<style type="text/css">
.post-gallery a {position: relative; display: inline-flex;}
.post-gallery .is-video:before {
    content: "\f236"; position: absolute; font-family: Dashicons; font-size: 50px;
    color: #fff; align-self: center; left: calc(50% - 25px); text-shadow: 0 0 4px #000;
}
.post-gallery .is-video:hover:before {color: rgba(255,255,255,0.8); text-shadow: none;}
</style>
<div class="post-gallery">
    <?php foreach ( $post->gallery as $attachment ) : ?>
        <a href="<?php echo $attachment->is_video && !$attachment->is_uploaded ? $attachment->video_url : $attachment->url ?>"
            class="<?php if ( $attachment->is_lightbox ) : ?>swipebox<?php endif ?> <?php if ( $attachment->is_video ) : ?>is-video<?php endif ?>"
            rel="post-gallery-<?php echo $post->ID ?>"
            title="<?php echo $attachment->caption ?>"
        >
            <img src="<?php echo $attachment->thumb_url ? $attachment->thumb_url : $attachment->no_thumb_url ?>"
                alt="<?php echo $attachment->alt ?>"
            />
        </a>
    <?php endforeach ?>
</div>