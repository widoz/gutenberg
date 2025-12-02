window.wp.domReady( () => {
	window.wp.blocks.registerBlockBindingsSource( {
		name: 'block-binding/ninja-turtles',
		label: 'Ninja Turtles',
		getValues( { bindings } ) {
			if ( bindings?.url?.args?.url === 'original_ninja_turtles' ) {
				return {
					url: 'https://i1.sndcdn.com/artworks-000157290951-wydoxo-t500x500.jpg',
				};
			}
			if ( bindings?.url?.args?.url === 'movie_2012' ) {
				return {
					url: 'https://m.media-amazon.com/images/I/91OWuXWQQnL._UF1000,1000_QL80_.jpg',
				};
			}

			return {
				url: bindings.url,
			};
		},
		getFieldsList() {
			return [
				{
					label: 'Original Ninja Turtles',
					type: 'string',
					args: {
						url: 'original_ninja_turtles',
					},
				},
				{
					label: '2012 Movie',
					type: 'string',
					args: {
						url: 'movie_2012',
					},
				},
			];
		},
		canUserEditValue() {
			return true;
		},
	} );
	window.wp.blocks.registerBlockBindingsSource( {
		name: 'block-binding/custom-title',
		label: 'Custom Title',
		getValues( { bindings } ) {
			if ( bindings?.alt?.args?.title === 'custom_title' ) {
				return {
					alt: 'Custom Title',
				};
			}

			return {
				alt: bindings.alt,
			};
		},
		getFieldsList() {
			return [
				{
					label: 'Custom Title',
					type: 'string',
					args: {
						title: 'custom_title',
					},
				},
			];
		},
		canUserEditValue() {
			return true;
		},
	} );
} );
