// Import block dependencies and components
import { 
	BuildTree,
	GroupByParent
 } from '../../utils/helper.js';

// Components
const {
	Disabled,
	PanelBody,
	RangeControl,
	SelectControl,
	ServerSideRender,
	ToggleControl	
} = wp.components; 

const { 
	Component,
	Fragment
} = wp.element;

const {	InspectorControls } = wp.editor;

const { withSelect } = wp.data;

/**
 * Create an AIOVGCategoriesEdit Component.
 */
class AIOVGCategoriesEdit extends Component {

	constructor() {
		super( ...arguments );
		this.toggleAttribute = this.toggleAttribute.bind( this );
	}

	getCategoriesTree() {
		const { categoriesList } = this.props;

		let categories = [{ 
			label: '-- ' + aiovg_blocks.i18n.top_categories + ' --', 
			value: 0
		}];

		if ( categoriesList && categoriesList.length > 0 ) {		
			let grouped = GroupByParent( categoriesList );
			let tree = BuildTree( grouped );
			
			categories = [ ...categories, ...tree ];
		}

		return categories;
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
			id,
			template, 
			columns, 
			orderby, 
			order,
			hierarchical, 
			show_description, 
			show_count, 
			hide_empty 
		} = attributes;

		const categories = this.getCategoriesTree();

		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title={ aiovg_blocks.i18n.categories_settings }>
						<SelectControl
							label={ aiovg_blocks.i18n.select_parent }
							value={ id }
							options={ categories }
							onChange={ ( value ) => setAttributes( { id: Number( value ) } ) }
						/>

						<SelectControl
							label={ aiovg_blocks.i18n.select_template }
							value={ template }
							options={ [
								{ label: aiovg_blocks.i18n.grid, value: 'grid' },
								{ label: aiovg_blocks.i18n.list, value: 'list' }
							] }
							onChange={ ( value ) => setAttributes( { template: value } ) }
						/>

						{'grid' == template && <RangeControl
							label={ aiovg_blocks.i18n.columns }
							value={ columns }							
							min={ 1 }
							max={ 12 }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
						/>}

						<SelectControl
							label={ aiovg_blocks.i18n.order_by }
							value={ orderby }
							options={ [
								{ label: aiovg_blocks.i18n.id, value: 'id' },
								{ label: aiovg_blocks.i18n.count, value: 'count' },
								{ label: aiovg_blocks.i18n.name, value: 'name' },
								{ label: aiovg_blocks.i18n.slug, value: 'slug' }
							] }
							onChange={ ( value ) => setAttributes( { orderby: value } ) }
						/>

						<SelectControl
							label={ aiovg_blocks.i18n.order }
							value={ order }
							options={ [
								{ 
									label: aiovg_blocks.i18n.asc, 
									value: 'asc' 
								},
								{ 
									label: aiovg_blocks.i18n.desc, 
									value: 'desc' 
								}
							] }
							onChange={ ( value ) => setAttributes( { order: value } ) }
						/>

						{'list' == template && <ToggleControl
							label={ aiovg_blocks.i18n.show_hierarchy }
							checked={ hierarchical }
							onChange={ this.toggleAttribute( 'hierarchical' )  }
						/>}

						{'grid' == template && <ToggleControl
							label={ aiovg_blocks.i18n.show_description }
							checked={ show_description }
							onChange={ this.toggleAttribute( 'show_description' )  }
						/>}

						<ToggleControl
							label={ aiovg_blocks.i18n.show_videos_count }
							checked={ show_count }
							onChange={ this.toggleAttribute( 'show_count' ) }
						/>

						<ToggleControl
							label={ aiovg_blocks.i18n.hide_empty_categories }
							checked={ hide_empty }
							onChange={ this.toggleAttribute( 'hide_empty' ) }
						/>
					</PanelBody>
				</InspectorControls>

				<Disabled>
					<ServerSideRender
						block="aiovg/categories"
						attributes={ attributes }
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
} )( AIOVGCategoriesEdit );