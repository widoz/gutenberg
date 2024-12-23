window.wp.domReady( () => {
	window.wp.blocks.registerBlockBindingsSource( {
		name: 'block-binding/custom-url',
		label: 'Custom URL',
		getValues( { bindings } ) {
			if ( bindings?.url?.args?.key === 'custom_url' ) {
				return {
					url: 'https://images6.alphacoders.com/135/1351738.jpeg',
				};
			}

			return undefined;
		},
		getFieldsList() {
			return {
				custom_url: {
					label: 'Custom Url',
					type: 'string',
				},
			};
		},
		canUserEditValue() {
			return true;
		},
	} );
} );
