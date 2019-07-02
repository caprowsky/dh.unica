/**
 * All-in-One Video Gallery: Categories Block.
 */

// Import block dependencies and components
import edit from './edit';

// Components
const { __ } = wp.i18n;

const { registerBlockType } = wp.blocks;

/**
 * Register the block.
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'aiovg/categories', {
	title: aiovg_blocks.i18n.block_categories_title,
	description: aiovg_blocks.i18n.block_categories_description,
	icon: 'category',
	category: 'all-in-one-video-gallery',
	keywords: [
		__( 'categories' ),
		__( 'gallery' ),
		__( 'all-in-one-video-gallery' ),
	],
	attributes: {
		id: {
			type: 'number',
			default: aiovg_blocks.categories.id
		},
		template: {
			type: 'string',
			default: aiovg_blocks.categories.template
		},
		columns: {
			type: 'number',
			default: aiovg_blocks.categories.columns
		},
		orderby: {
			type: 'string',
			default: aiovg_blocks.categories.orderby
		},
		order: {
			type: 'string',
			default: aiovg_blocks.categories.order
		},
		hierarchical: {
			type: 'boolean',
			default: aiovg_blocks.categories.hierarchical
		},
		show_description: {
			type: 'boolean',
			default: aiovg_blocks.categories.show_description
		},
		show_count: {
			type: 'boolean',
			default: aiovg_blocks.categories.show_count
		},
		hide_empty: {
			type: 'boolean',
			default: aiovg_blocks.categories.hide_empty
		}
	},
	supports: {
		customClassName: false,
	},

	edit,

	// Render via PHP
	save: function( props ) {
		return null;
	},
} );
