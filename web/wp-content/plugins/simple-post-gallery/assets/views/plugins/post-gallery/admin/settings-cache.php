<?php
/**
 * Settings cache view/template.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.2.0
 */ 
?>
<section id="cache"
    <?php if ( $tab != 'cache' ) : ?>style="display: none;"<?php endif ?>
>
    <h1 id="top"><?php _e( 'Cache', 'simple-post-gallery' ) ?></h1>

    <p><?php _e( 'Force cache clean up. This tool can be used especially when migrating to a new wordpress setup. Alternatively, you can manually do this by deleting the cache folder inside the plugin.', 'simple-post-gallery' ) ?></p>

    <?php do_action( 'postgallery_settings_cache_view' ) ?>

    <button type="submit"
        name="submit"
        class="button  button-primary"
        value="cache.flush"
    >
        <?php _e( 'Clean cache', 'simple-post-gallery' ) ?>
    </button>

</section>