/**
 * Helper Functions
 */

 /**
 * Get video block attributes 
 *
 * @since 1.0.0
 */
export function getVideoAttributes() {
	var attributes = {};
	
	for ( var key in aiovg_blocks.videos ) {
		var fields = aiovg_blocks.videos[ key ].fields;

		for ( var field in fields ) {
			var name = fields[ field ].name;

			attributes[ name ] = {
				type: getAttributeType( fields[ field ].type ),
				default: fields[ field ].value
			};
		}
	}

	return attributes;
}

/**
 * Get attribute type
 *
 * @since 1.0.0
 */
function getAttributeType( type ) {
	var _type = 'string';

	if ( 'categories' == type ) {
		_type = 'array';
	} else if ( 'number' == type ) {
		_type = 'number';
	} else if ( 'checkbox' == type ) {
		_type = 'boolean';
	}

	return _type;
}

/**
 * Group terms by parent
 *
 * @since 1.0.0
 */
export function GroupByParent( terms ) {
	var map = {}, node, roots = [], i;
	
	for ( i = 0; i < terms.length; i += 1 ) {
		map[ terms[ i ].id ] = i; // initialize the map
		terms[ i ].children = []; // initialize the children		
	}	

	for ( i = 0; i < terms.length; i += 1 ) {
		node = terms[ i ];
		if ( node.parent > 0 ) {
			terms[ map[ node.parent ] ].children.push( node );
		} else {
			roots.push( node );
		}
	}	

	return roots;
}

/**
 * Build tree array from flat array
 *
 * @since 1.0.0
 */
export function BuildTree( terms, tree = [], prefix = '' ) {
	var i;
	
	for ( i = 0; i < terms.length; i += 1 ) {
		tree.push({
			label: prefix + terms[ i ].name,
			value: terms[ i ].id,
		});	

		if ( terms[ i ].children.length > 0 ) {
			BuildTree( terms[ i ].children, tree, prefix.trim() + '--- ' );
		}
	}	

	return tree;
}