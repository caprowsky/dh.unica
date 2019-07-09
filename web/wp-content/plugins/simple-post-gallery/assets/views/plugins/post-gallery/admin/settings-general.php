<?php
/**
 * Settings view/template.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 2.2.0
 */ 
?>
<section id="general"
    <?php if ( $tab != 'general' ) : ?>style="display: none;"<?php endif ?>
>
    <h2>
        <?php _e( 'General', 'simple-post-gallery' ) ?>
    </h2>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Enqueue assets', 'simple-post-gallery' ) ?></th>
            <td>
                <input type="checkbox"
                    name="can_enqueue"
                    value="1"
                    <?php if ( $postGallery->can_enqueue ) : ?>checked<?php endif ?>
                />
                <br>
                <span class="description">
                    <?php _e( 'Indicates whether or not to enqueue default scripts and styles when displaying generated gallery.', 'simple-post-gallery' ) ?>
                </span>
                <br>
                <span class="description">
                    <?php _e( 'This plugin uses lightbox by default to display the gallery.', 'simple-post-gallery' ) ?>
                </span>
            </td>
        </tr>

    </table>

    <h3>
        <?php _e( 'Post types', 'simple-post-gallery' ) ?>
    </h3>

    <p class="description">
        <?php _e( 'Select the post types that will support galleries:', 'simple-post-gallery' ) ?>
    </p>

    <div class="types">

        <?php foreach ( $types as $type ) : ?>

            <div class="type">

                <input type="checkbox"
                    name="types[]"
                    value="<?php echo $type ?>"
                    <?php if ( $postGallery->has_type( $type ) ) : ?>checked<?php endif ?>
                /> <?php echo $type ?>

            </div>

        <?php endforeach ?>

    </div>

    <h3>
        <?php _e( 'Gallery metabox', 'simple-post-gallery' ) ?>
    </h3>

    <p class="description">
        <?php _e( 'Properties of the metabox that will appear when creating or editing a new post.', 'simple-post-gallery' ) ?>
    </p>

    <table class="form-table">

        <tr valign="top">
            <th scope="row"><?php _e( 'Context', 'simple-post-gallery' ) ?></th>
            <td>
                <select name="metabox_context">
                    <option value="advanced"
                        <?php if ( $postGallery->metabox_context == 'advanced' ) : ?>selected<?php endif ?>
                    >
                        Advanced
                    </option>
                    <option value="normal"
                        <?php if ( $postGallery->metabox_context == 'normal' ) : ?>selected<?php endif ?>
                    >
                        Normal
                    </option>
                    <option value="side"
                        <?php if ( $postGallery->metabox_context == 'side' ) : ?>selected<?php endif ?>
                    >
                        Side
                    </option>
                </select>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><?php _e( 'Priority', 'simple-post-gallery' ) ?></th>
            <td>
                <select name="metabox_priority">
                    <option value="default"
                        <?php if ( $postGallery->metabox_priority == 'default' ) : ?>selected<?php endif ?>
                    >
                        Default
                    </option>
                    <option value="high"
                        <?php if ( $postGallery->metabox_priority == 'high' ) : ?>selected<?php endif ?>
                    >
                        High
                    </option>
                    <option value="low"
                        <?php if ( $postGallery->metabox_priority == 'low' ) : ?>selected<?php endif ?>
                    >
                        Low
                    </option>
                </select>
            </td>
        </tr>

    </table>

    <?php do_action( 'postgallery_settings_general_view' ) ?>

</section>