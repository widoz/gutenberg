const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );

const MODULES = [ '@wordpress/abilities', '@wordpress/core-abilities' ];

const [ , moduleConfig ] = Array.isArray( defaultConfig )
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
			'abilities-api-demo-front-office': path.resolve(
				__dirname,
				'src/frontoffice.ts'
			),
		},
		plugins: [
			...pluginsWithoutDepExtraction,
			new DependencyExtractionWebpackPlugin( {
				requestToExternalModule: ( request ) => {
					if ( MODULES.includes( request ) ) {
						return request;
					}
				},
			} ),
		],
		output: {
			...moduleConfig.output,
			path: path.resolve( __dirname, 'build-module' ),
		},
	} );
}

module.exports = configs;
