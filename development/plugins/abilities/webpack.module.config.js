const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );

const MODULES = [ '@wordpress/abilities', '@wordpress/core-abilities' ];

const [ moduleConfig ] = Array.isArray( defaultConfig )
	? defaultConfig
	: [ defaultConfig, null ];

const configs = [];

if ( moduleConfig ) {
	const pluginsWithoutDepExtraction = moduleConfig.plugins.filter(
		( p ) => ! ( p instanceof DependencyExtractionWebpackPlugin )
	);

	configs.push( {
		...moduleConfig,
		entry: {
			'core-abilities': path.resolve(
				__dirname,
				'src/core-abilities.ts'
			),
			'abilities-api-demo-front-office': path.resolve(
				__dirname,
				'src/frontoffice.ts'
			),
		},
		plugins: [
			...pluginsWithoutDepExtraction,
			new DependencyExtractionWebpackPlugin( {
				requestToExternal: ( request ) => {
					if ( MODULES.includes( request ) ) {
						return `module ${ request }`;
					}
					if ( request.includes( 'core-abilities' ) ) {
						return `module ${ request }`;
					}
				},
			} ),
		],
	} );
}

module.exports = configs;
