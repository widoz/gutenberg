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
			'abilities-api-demo': path.resolve( __dirname, 'src/index.tsx' ),
		},
	} );
}

module.exports = configs;
