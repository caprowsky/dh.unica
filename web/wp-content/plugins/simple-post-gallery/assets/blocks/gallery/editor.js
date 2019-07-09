/**
 * Gutenberg block type.
 * Post Gallery block for gutenberg.
 *
 * @link https://www.smashingmagazine.com/2018/10/gutenberg-testimonials-sliderblock/
 *
 * @author Cami Mostajo
 * @copyright 10 Quality
 * @package PostGallery
 * @version 2.3.0
 */
wp.blocks.registerBlockType( 'simple-post-gallery/gallery', {
    /**
     * Block title.
     * @var string
     * @since 2.3.0
     */
    title: wp.i18n.__( 'Post Gallery', 'simple-post-gallery' ),
    /**
     * Block description.
     * @var string
     * @since 2.3.0
     */
    description: wp.i18n.__( 'Displays a post\'s gallery.', 'simple-post-gallery' ),
    /**
     * Block icon.
     * @var string
     * @since 2.3.0
     */
    icon: 'format-gallery',
    /**
     * Block category.
     * @var string
     * @since 2.3.0
     */
    category: 'common',
    /**
     * Keywords.
     * @var array
     * @since 2.3.0
     */
    keywords: [
        wp.i18n.__( 'gallery', 'simple-post-gallery' ),
        wp.i18n.__( 'media', 'simple-post-gallery' ),
        wp.i18n.__( 'video', 'simple-post-gallery' ),
    ],
    /**
     * Attributes / properties.
     */
    attributes:
    {
        /**
         * Gellery or Post ID to display.
         * If left blank, should use current.
         * @since 2.3.0
         * @var number
         */
        galleryID:
        {
            type: 'number'
        },
    },
    /**
     * Returns the editor display block and HTML markup.
     * The "edit" property must be a valid function.
     *
     * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
     *
     * @param {object} props
     *
     * @return {object} element
     */
    edit: function( props ) {

        return wp.element.createElement(
            'div',
            {
                className: props.className,
            },
            (props.attributes.galleryID
                ? 'Gallery [post_gallery id="'+props.attributes.galleryID+'"]'
                : 'Gallery [post_gallery]'
            )
        );

    },
    /**
     * Returns the HTML markup that will be rendered in live post.
     * The "save" property must be a valid function.
     *
     * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
     *
     * @param {object} props
     *
     * @return {object} element
     */
    save: function( props ) {

        return wp.element.createElement(
            'div',
            {
                className: props.className,
            },
            (props.attributes.galleryID
                ? '[post_gallery id="'+props.attributes.galleryID+'"]'
                : '[post_gallery]'
            )
        );
    },
} );