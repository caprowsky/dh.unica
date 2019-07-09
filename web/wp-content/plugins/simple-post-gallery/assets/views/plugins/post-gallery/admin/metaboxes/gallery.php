<?php
/**
 * Metabox gallery view/template.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.2.1
 */
?>
<?php use PostGallery\Controllers\AdminController as Software ?>
<div id="post-gallery">
    <?php do_action( 'post_gallery_before_metabox' ) ?>
    <!-- Button -->
    <div class="heading">
        <?php if ( apply_filters( 'post_gallery_metabox_button_add', true ) ) : ?>
            <a href="#add-gallery-media"
                data-editor="post-gallery"
                class="button insert-media"
            >
                <i class="fa fa-picture-o" aria-hidden="true"></i> <?php _e( 'Add Media', 'simple-post-gallery' ) ?>
            </a>
        <?php endif ?>
        <?php do_action( 'post_gallery_metabox_header' ) ?>
        <?php if ( apply_filters( 'post_gallery_metabox_loader', true ) ) : ?>
            <span class="media-loader" style="display:none">
                <i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>
            </span>
        <?php endif ?>
    </div>

    <!-- Caller -->
    <span class="gallery-uploader"
        style="display: none;"
        data-editor="post-gallery"
        data-target="#post-gallery-media"
    >
        <?php $view->show( 'plugins.post-gallery.admin.metaboxes.input-attachment', ['post' => $post] ) ?>
    </span>

    <!-- Results placeholder -->
    <div id="post-gallery-media"
        class="body sortable"
    >
        <?php if ( $post->gallery ) : ?>
            <?php foreach ( $post->gallery as $attachment ) : ?>
                <?php $view->show( 'plugins.post-gallery.admin.metaboxes.input-attachment', [
                    'attachment'    => $attachment,
                    'post'          => $post,
                ] ) ?>
            <?php endforeach ?>
        <?php endif ?>
    </div>

    <?php if ( apply_filters( 'post_gallery_metabox_allow_formats', true ) ) : ?>
        <div class="formats">
            <?php if ( apply_filters( 'post_gallery_metabox_formats_header_show', true ) ) : ?>
                <div class="formats-header heading">
                    <?php _e( 'Formats and layouts', 'simple-post-gallery' ) ?>
                    <?php do_action( 'post_gallery_metabox_formats_header' ) ?>
                </div>
            <?php endif ?>
            <div class="formats-body body">
                <div class="selection">
                    <?php foreach ( $formats as $format => $title ) : ?>
                        <label id="<?php echo $format ?>"
                            class="format format-<?php echo $format ?> <?php if ( $post->format && $post->format === $format ) : ?>active<?php endif ?>"
                        >
                            <input type="radio"
                                name="gallery_format"
                                value="<?php echo $format ?>"
                                <?php if ( $post->format && $post->format === $format ) : ?>checked<?php endif ?>
                            />
                            <span class="icon">
                                <?php if ( $format === 'default' ) : ?>
                                    <img src="<?php echo assets_url( 'svgs/default.svg', __FILE__ ) ?>"
                                        alt="<?php echo $format ?>"
                                        class="img-responsive"
                                        title="<?php echo $title ?>"
                                    />
                                <?php else : ?>
                                    <?php do_action( 'postgallery_format_icon_' . $format, $post->data, $title ) ?>
                                <?php endif ?>
                                <span class="title"><?php echo $title ?></span>
                            </span>
                        </label>
                    <?php endforeach ?>
                    <?php if ( apply_filters( 'post_gallery_advertise_extended_features', true ) ) : ?>
                        <?php do_action( 'post_gallery_extended_formats' ) ?>
                    <?php endif ?>
                </div>
                <div class="data">
                    <?php foreach ( $formats as $format => $title ) : ?>
                        <div class="form if-reactive form-<?php echo $format ?> if-<?php echo $format ?>">
                            <?php do_action(
                                'postgallery_format_form_' . $format,
                                isset( $post->format_data[$format] ) ? $post->format_data[$format] : []
                            ) ?>
                        </div>
                    <?php endforeach ?>
                    <?php do_action( 'post_gallery_metabox_formats_forms', $post->format_data ) ?>
                </div>
                <?php do_action( 'post_gallery_metabox_formats_body' ) ?>
            </div>
        </div>
    <?php endif ?>

    <div class="footer">
        <?php if ( apply_filters( 'post_gallery_metabox_templates_link', true ) ) : ?>
            <span class="pull-left">
                <?php _e( 'Display in', 'simple-post-gallery' ) ?>
                <a href="<?php echo admin_url( 'options-general.php?page=' . Software::ADMIN_MENU_SETTINGS . '&tab=docs' ) ?>"
                ><?php _e( 'templates', 'simple-post-gallery' ) ?></a><?php _e( '?', 'simple-post-gallery' ) ?>
            </span>
        <?php endif ?>
        <?php if ( apply_filters( 'post_gallery_metabox_shortcode_code', true ) ) : ?>
            <span class="pull-right">
                <?php _e( 'Shortcode:', 'simple-post-gallery' ) ?>
                <code id="post-gallery-shortcode">[post_gallery]</code>
                <?php if ( apply_filters( 'post_gallery_metabox_shortcode_options', true ) ) : ?>
                    <span class="shortcode-actions">
                        <?php foreach ( apply_filters( 'post_gallery_metabox_shortcode_actions', [] ) as $key => $attributes ) : ?>
                            <a class="action action-<?php echo $key ?> <?php if ( isset( $attributes['class'] ) ) : ?><?php echo $attributes['class'] ?><?php endif ?>"
                                <?php if ( isset( $attributes['id'] ) ) : ?>id="<?php echo $attributes['id'] ?>"<?php endif ?>
                                <?php if ( isset( $attributes['style'] ) ) : ?>style="<?php echo $attributes['style'] ?>"<?php endif ?>
                                <?php if ( isset( $attributes['name'] ) ) : ?>title="<?php echo $attributes['name'] ?>"<?php endif ?>
                                <?php if ( isset( $attributes['attr'] ) ) : ?><?php echo $attributes['attr'] ?><?php endif ?>
                            >
                                <?php if ( isset( $attributes['fa'] ) ) : ?>
                                    <i class="fa <?php echo $attributes['fa'] ?>"></i>
                                <?php else : ?>
                                    <?php echo isset( $attributes['name'] ) ? $attributes['name'] : $key ?>
                                <?php endif ?>
                            </a>
                        <?php endforeach ?>
                    </span>
                <?php endif ?>
            </span>
        <?php endif ?>
        <?php do_action( 'post_gallery_metabox_footer' ) ?>
    </div>

    <?php do_action( 'post_gallery_after_metabox' ) ?>
</div>