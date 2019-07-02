/**
 * All-in-One Video Gallery: Search Block.
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
registerBlockType( 'aiovg/search', {
	title: aiovg_blocks.i18n.block_search_title,
	description: aiovg_blocks.i18n.block_search_description,
	icon: 'search',
	category: 'all-in-one-video-gallery',
	keywords: [
		__( 'search' ),
		__( 'videos' ),
		__( 'all-in-one-video-gallery' ),
	],
	attributes: {
		template: {
			type: 'string',
			default: aiovg_blocks.search.template
		},
		category: {
			type: 'boolean',
			default: aiovg_blocks.search.category
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
