// Components
const {
	Disabled,
	PanelBody,
	SelectControl,
	ServerSideRender,
	ToggleControl	
} = wp.components;

const { 
	Component,
	Fragment
} = wp.element;

const {	InspectorControls } = wp.editor;

/**
 * Create an AIOVGSearchEdit Component.
 */
class AIOVGSearchEdit extends Component {

	constructor() {
		super( ...arguments );		
		this.toggleAttribute = this.toggleAttribute.bind( this );
	}

	toggleAttribute( attribute ) {
		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};
	}

	render() {		
		const { 
			attributes, 
			setAttributes 
		} = this.props;

		const { 
			template, 
			category 
		} = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ aiovg_blocks.i18n.search_form_settings }>
						<SelectControl
							label={ aiovg_blocks.i18n.select_template }
							value={ template }
							options={ [
								{ 
									label: aiovg_blocks.i18n.vertical, 
									value: 'vertical' 
								},
								{ 
									label: aiovg_blocks.i18n.horizontal, 
									value: 'horizontal' 
								}
							] }
							onChange={ ( value ) => setAttributes( { template: value } ) }
						/>
	
						<ToggleControl
							label={ aiovg_blocks.i18n.search_by_categories }
							checked={ category }
							onChange={ this.toggleAttribute( 'category' ) }
						/>
					</PanelBody>
				</InspectorControls>

				<Disabled>
					<ServerSideRender
						block="aiovg/search"
						attributes={ attributes }
					/>
				</Disabled>
			</Fragment>
		);
	}	

}

export default AIOVGSearchEdit;