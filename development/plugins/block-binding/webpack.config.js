const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const [ scriptConfig ] = Array.isArray( defaultConfig )
	? defaultConfig
	: [ defaultConfig, null ];

const configs = [];

if ( scriptConfig ) {
	configs.push( {
		...scriptConfig,
		entry: {
			'block-bindings': path.resolve( __dirname, 'src/index.ts' ),
		},
	} );
}

module.exports = configs;
