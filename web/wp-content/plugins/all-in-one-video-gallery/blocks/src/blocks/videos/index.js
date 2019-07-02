/**
 * All-in-One Video Gallery: Video Gallery Block.
 */

// Import block dependencies and components
import { getVideoAttributes } from '../../utils/helper.js';
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
registerBlockType( 'aiovg/videos', {
	title: aiovg_blocks.i18n.block_videos_title,
	description: aiovg_blocks.i18n.block_videos_description,
	icon: 'playlist-video',
	category: 'all-in-one-video-gallery',
	keywords: [
		__( 'videos' ),
		__( 'gallery' ),
		__( 'all-in-one-video-gallery' ),
	],
	attributes: getVideoAttributes(),
	supports: {
		customClassName: false,
	},

	edit,

	// Render via PHP
	save: function( props ) {
		return null;
	},
} );
