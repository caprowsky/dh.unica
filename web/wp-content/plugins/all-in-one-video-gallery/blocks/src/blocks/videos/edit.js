// Import block dependencies and components
import { 
	BuildTree, 
	GroupByParent 
} from '../../utils/helper.js';

import AIOVGServerSideRender from '../../utils/server-side-render';

// Components
const {
	Disabled,
	PanelBody,
	RangeControl,
	SelectControl,
	TextControl,
	TextareaControl,
	ToggleControl	
} = wp.components; 

const { 
	Component,
	Fragment
} = wp.element;

const {	
	InspectorControls, 
	PanelColorSettings 
} = wp.editor;

const {	applyFilters } = wp.hooks;

const { withSelect } = wp.data;

/**
 * Create an AIOVGVideosEdit Component.
 */
class AIOVGVideosEdit extends Component {

	constructor() {
		super( ...arguments );

		this.onChange = this.onChange.bind( this );
		this.toggleAttribute = this.toggleAttribute.bind( this );
		this.initializeGallery = this.initializeGallery.bind( this );
	}

	getControl( field, index ) {
		const { attributes } = this.props;

		const placeholder = field.placeholder ? field.placeholder : '';
		const description = field.description ? field.description : '';

		switch ( field.type ) {	
			case 'categories':
				const categories = this.getCategoriesTree();

				return this.canShowControl( field.name ) && <SelectControl
					multiple
					key={ index }						
					label={ field.label }
					help={ description }						
					options={ categories }
					value={ attributes[ field.name ] }
					onChange={ this.onChange( field.name ) }
				/>	
			case 'number':
				return this.canShowControl( field.name ) && <RangeControl	
					key={ index }					
					label={ field.label }
					help={ description }
					placeholder={ placeholder }
					value={ attributes[ field.name ] }
					min={ field.min }
					max={ field.max }
					onChange={ this.onChange( field.name ) }
				/>
			case 'textarea':
				return this.canShowControl( field.name ) && <TextareaControl
					key={ index }					
					label={ field.label }
					help={ description }
					placeholder={ placeholder }
					value={ attributes[ field.name ] }
					onChange={ this.onChange( field.name ) }
				/>
			case 'select':
			case 'radio':
				let options = [];

				for ( let key in field.options ) {
					options.push({
						label: field.options[ key ],
						value: key
					});
				};

				return this.canShowControl( field.name ) && <SelectControl
					key={ index }						
					label={ field.label }
					help={ description }						
					options={ options }
					value={ attributes[ field.name ] }
					onChange={ this.onChange( field.name ) }
				/>
			case 'checkbox':
				return this.canShowControl( field.name ) && <ToggleControl
					key={ index }
					label={ field.label }
					help={ description }
					checked={ attributes[ field.name ] }
					onChange={ this.toggleAttribute( field.name ) }
				/>
			case 'color':
				return this.canShowControl( field.name ) && <PanelColorSettings
					key={ index }
					title={ field.label }
					colorSettings={ [
						{
							label: aiovg_blocks.i18n.select_color,
							value: attributes[ field.name ],
							onChange: this.onChange( field.name ),							
						}
					] }
				></PanelColorSettings>
			default:
				return this.canShowControl( field.name ) && <TextControl	
					key={ index }					
					label={ field.label }
					help={ description }
					placeholder={ placeholder }
					value={ attributes[ field.name ] }
					onChange={ this.onChange( field.name ) }
				/>
		}		
	}

	canShowPanel( panel ) {
		const { attributes } = this.props;
		let value = true;

		return applyFilters( 'aiovg_block_toggle_panels', value, panel, attributes );
	}

	canShowControl( control ) {
		const { attributes } = this.props;
		let value = true;
		return applyFilters( 'aiovg_block_toggle_controls', value, control, attributes );
	}	

	onChange( attribute ) {
		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};
	}

	toggleAttribute( attribute ) {
		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};
	}

	getCategoriesTree() {
		const { categoriesList } = this.props;

		let categories = [];

		if ( categoriesList && categoriesList.length > 0 ) {		
			let grouped = GroupByParent( categoriesList );
			let tree = BuildTree( grouped );
			
			categories = [ ...categories, ...tree ];
		}

		return categories;
	}

	initializeGallery() {
		applyFilters( 'aiovg_block_init', this.props.attributes );
	}

	render() {
		const { attributes } = this.props;
		let videos = aiovg_blocks.videos;		

		return (
			<Fragment>
				<InspectorControls>
					{Object.keys( videos ).map(( key, index ) => {
						return (
							this.canShowPanel( key ) && <PanelBody 
								key={ 'aiovg-block-panel-' + index } 
								title={ videos[ key ].title }
								initialOpen={ 0 == index ? true : false }
								className="aiovg-block-panel">

								{Object.keys( videos[ key ].fields ).map(( _key, _index ) => {
									return this.getControl( videos[ key ].fields[ _key ], 'aiovg-block-control-' + _index );
								})}

							</PanelBody>
						)
					})}
				</InspectorControls>
				
				<Disabled>
					<AIOVGServerSideRender
						block="aiovg/videos"
						attributes={ attributes }
						onChange={ this.initializeGallery }
					/>
				</Disabled>
			</Fragment>
		);
	}

}

export default withSelect( ( select ) => {
	const { getEntityRecords } = select( 'core' );

	const categoriesListQuery = {
		per_page: 100
	};

	return {
		categoriesList: getEntityRecords( 'taxonomy', 'aiovg_categories', categoriesListQuery )
	};
} )( AIOVGVideosEdit );