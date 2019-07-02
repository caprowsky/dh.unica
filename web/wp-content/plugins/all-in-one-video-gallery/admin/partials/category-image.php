<?php

/**
 * Categories: Image Field.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<?php if ( 'add' == $form ) : ?>
    <div class="form-field term-group">
        <label for="aiovg-categories-image-id"><?php esc_html_e( 'Image', 'all-in-one-video-gallery' ); ?></label>
        <input type="hidden" name="image_id" id="aiovg-categories-image-id" />
        <div id="aiovg-categories-image-wrapper"></div>
        <p>
            <input type="button" id="aiovg-categories-upload-image" class="button button-secondary" value="<?php esc_attr_e( 'Add Image', 'all-in-one-video-gallery' ); ?>" />
            <input type="button" id="aiovg-categories-remove-image" class="button button-secondary" value="<?php esc_attr_e( 'Remove Image', 'all-in-one-video-gallery' ); ?>" style="display: none;" />
        </p>
    </div>
<?php elseif ( 'edit' == $form ) : ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="aiovg-categories-image-id"><?php esc_html_e( 'Image', 'all-in-one-video-gallery' ); ?></label>
        </th>
        <td>
            <input type="hidden" name="image_id" id="aiovg-categories-image-id" value="<?php echo esc_attr( $image_id ); ?>" />
            <div id="aiovg-categories-image-wrapper">
				<?php if ( $image_url ) : ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" />
                <?php endif; ?>
            </div>
            <p>
                <input type="button" id="aiovg-categories-upload-image" class="button button-secondary" value="<?php esc_attr_e( 'Add Image', 'all-in-one-video-gallery' ); ?>" <?php if ( $image_url ) echo 'style="display: none;"'; ?>/>
                <input type="button" id="aiovg-categories-remove-image" class="button button-secondary" value="<?php esc_attr_e( 'Remove Image', 'all-in-one-video-gallery' ); ?>" <?php if ( ! $image_url ) echo 'style="display: none;"'; ?>/>
            </p>
        </td>
    </tr>
<?php endif;
// Add a nonce field
wp_nonce_field( 'aiovg_process_category_image', 'aiovg_category_image_nonce' );