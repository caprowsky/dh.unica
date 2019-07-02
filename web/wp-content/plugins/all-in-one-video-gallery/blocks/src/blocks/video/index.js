/**
 * All-in-One Video Gallery: Video Block.
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
registerBlockType( 'aiovg/video', {
	title: aiovg_blocks.i18n.block_video_title,
	description: aiovg_blocks.i18n.block_video_description,
	icon: 'format-video',
	category: 'all-in-one-video-gallery',
	keywords: [
		__( 'video' ),
		__( 'player' ),
		__( 'all-in-one-video-gallery' ),
	],
	attributes: {
		src: {
			type: 'string'
		},
		poster: {
			type: 'string'
		},
		width: {
			type: 'number',
			default: aiovg_blocks.video.width
		},
		ratio: {
			type: 'number',
			default: aiovg_blocks.video.ratio
		},
		autoplay: {
			type: 'boolean',
			default: aiovg_blocks.video.autoplay
		},
		loop: {
			type: 'boolean',
			default: aiovg_blocks.video.loop
		},
		playpause: {
			type: 'boolean',
			default: aiovg_blocks.video.playpause
		},
		current: {
			type: 'boolean',
			default: aiovg_blocks.video.current
		},
		progress: {
			type: 'boolean',
			default: aiovg_blocks.video.progress
		},
		duration: {
			type: 'boolean',
			default: aiovg_blocks.video.duration
		},		
		volume: {
			type: 'boolean',
			default: aiovg_blocks.video.volume
		},
		fullscreen: {
			type: 'boolean',
			default: aiovg_blocks.video.fullscreen
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
