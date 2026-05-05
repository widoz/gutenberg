const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

module.exports = {
	...defaultConfig,
	entry: {
		'data-views': './src/data-views.tsx',
		'data-form': './src/data-form.tsx',
	},
};
