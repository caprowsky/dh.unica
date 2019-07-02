// Components
const {	
	BaseControl,
	Button,
	Disabled,
	IconButton,
	PanelBody,	
	ServerSideRender,
	TextControl,	
	ToggleControl,
	Toolbar,	
	withNotices	
} = wp.components;

const { 
	Component,
	Fragment,
	createRef
} = wp.element;

const {
	BlockControls,	
	InspectorControls,
	MediaPlaceholder,
	MediaUpload,
} = wp.editor;

/**
 * Create an AIOVGVideoEdit Component.
 */
class AIOVGVideoEdit extends Component {

	constructor() {
		super( ...arguments );

		// edit component has its own src in the state so it can be edited
		// without setting the actual value outside of the edit UI
		this.state = {
			editing: ! this.props.attributes.src,
		};

		this.videoPlayer = createRef();
		this.toggleAttribute = this.toggleAttribute.bind( this );
		this.onSelectURL = this.onSelectURL.bind( this );
		this.onSelectPoster = this.onSelectPoster.bind( this );
		this.onRemovePoster = this.onRemovePoster.bind( this );
	}

	toggleAttribute( attribute ) {
		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};
	}

	onSelectURL( newSrc ) {
		const { 
			attributes, 
			setAttributes 
		} = this.props;

		const { src } = attributes;

		// Set the block's src from the edit component's state, and switch off
		// the editing UI.
		if ( newSrc !== src ) {
			setAttributes( { src: newSrc } );
		}

		this.setState( { editing: false } );
	}

	onSelectPoster( image ) {
		const { setAttributes } = this.props;
		setAttributes( { poster: image.url } );
	}

	onRemovePoster() {
		const { setAttributes } = this.props;
		setAttributes( { poster: '' } );
	}

	render() {		
		const { 
			attributes, 
			setAttributes, 
			className, 
			noticeOperations, 
			noticeUI 
		} = this.props;

		const {
			poster,
			width,
			ratio,
			autoplay,
			loop,
			playpause,
			current,
			progress,
			duration,
			volume,
			fullscreen
		} = attributes;

		const { editing } = this.state;

		const switchToEditing = () => {
			this.setState( { editing: true } );
		};

		const onSelectVideo = ( media ) => {
			if ( ! media || ! media.url ) {
				// in this case there was an error and we should continue in the editing state
				// previous attributes should be removed because they may be temporary blob urls
				setAttributes( { src: undefined } );
				switchToEditing();
				return;
			}
			// sets the block's attribute and updates the edit component from the
			// selected media, then switches off the editing UI
			setAttributes( { src: media.url } );
			this.setState( { src: media.url, editing: false } );
		};

		if ( editing ) {
			return (
				<MediaPlaceholder
					icon="media-video"
					labels={ {
						title: aiovg_blocks.i18n.media_placeholder_title,
						name: aiovg_blocks.i18n.media_placeholder_name
					} }
					className={ className }					
					accept="video/*"
					type="video"
					value={ attributes }
					onSelect={ onSelectVideo }
					onSelectURL={ this.onSelectURL }
					notices={ noticeUI }
					onError={ noticeOperations.createErrorNotice }
				/>
			);
		}

		return (
			<Fragment>
				<BlockControls>
					<Toolbar>
						<IconButton
							className="components-icon-button components-toolbar__control"
							label={ aiovg_blocks.i18n.edit_video }
							onClick={ switchToEditing }
							icon="edit"
						/>
					</Toolbar>
				</BlockControls>

				<InspectorControls>
					<PanelBody title={ aiovg_blocks.i18n.general_settings }>
						<TextControl
							label={ aiovg_blocks.i18n.width }
							help={ aiovg_blocks.i18n.width_help }
							value={ width > 0 ? width : '' }
							onChange={ ( value ) => setAttributes( { width: Number( value ) } ) }
						/>

						<TextControl
							label={ aiovg_blocks.i18n.ratio }
							help={ aiovg_blocks.i18n.ratio_help }
							value={ ratio }
							onChange={ ( value ) => setAttributes( { ratio: Number( value ) } ) }
						/>

						<ToggleControl
							label={ aiovg_blocks.i18n.autoplay }							
							checked={ autoplay }
							onChange={ this.toggleAttribute( 'autoplay' ) }
						/>

						<ToggleControl
							label={ aiovg_blocks.i18n.loop }							
							checked={ loop }
							onChange={ this.toggleAttribute( 'loop' ) }
						/>

						<BaseControl
							className="editor-video-poster-control"
							label={ aiovg_blocks.i18n.poster_image }
						>
							<MediaUpload
								title={ aiovg_blocks.i18n.select_poster_image }
								onSelect={ this.onSelectPoster }
								type="image"
								render={ ( { open } ) => (
									<Button isDefault onClick={ open }>
										{ ! poster ? aiovg_blocks.i18n.select_poster_image : aiovg_blocks.i18n.replace_image }
									</Button>
								) }
							/>
							{ !! poster &&
								<Button onClick={ this.onRemovePoster } isLink isDestructive>
									{ aiovg_blocks.i18n.remove_poster_image }
								</Button>
							}
						</BaseControl>
					</PanelBody>	

					<PanelBody title={ aiovg_blocks.i18n.player_controls }>
						<ToggleControl
							label={ aiovg_blocks.i18n.play_pause }							
							checked={ playpause }
							onChange={ this.toggleAttribute( 'playpause' ) }
						/>

						<ToggleControl
							label={ aiovg_blocks.i18n.current_time }							
							checked={ current }
							onChange={ this.toggleAttribute( 'current' ) }
						/>

						<ToggleControl
							label={ aiovg_blocks.i18n.progressbar }							
							checked={ progress }
							onChange={ this.toggleAttribute( 'progress' ) }
						/>

						<ToggleControl
							label={ aiovg_blocks.i18n.duration }							
							checked={ duration }
							onChange={ this.toggleAttribute( 'duration' ) }
						/>

						<ToggleControl
							label={ aiovg_blocks.i18n.volume }							
							checked={ volume }
							onChange={ this.toggleAttribute( 'volume' ) }
						/>

						<ToggleControl
							label={ aiovg_blocks.i18n.fullscreen }							
							checked={ fullscreen }
							onChange={ this.toggleAttribute( 'fullscreen' ) }
						/>							
					</PanelBody>
				</InspectorControls>
				
				<Disabled>
					<ServerSideRender
						block="aiovg/video"
						attributes={ attributes }
					/>
				</Disabled>
			</Fragment>
		);
	}	

}

export default withNotices( AIOVGVideoEdit );