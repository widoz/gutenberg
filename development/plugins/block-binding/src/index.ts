import domReady from '@wordpress/dom-ready';
import { registerBlockBindingsSource } from '@wordpress/blocks';

domReady( () => {
	registerBlockBindingsSource( {
		name: 'block-binding/old-school-ninja-turtle',
		label: 'Ninja Turtles',
		getValues( { bindings }: { bindings: any } ) {
			if ( bindings?.url?.args?.url === 'old_school_ninja_turtles' ) {
				return {
					url: 'https://i1.sndcdn.com/artworks-000157290951-wydoxo-t500x500.jpg',
				};
			}

			return {
				url: bindings.url,
			};
		},
		getFieldsList() {
			return [
				{
					label: 'Old School Ninja Turtles',
					type: 'string',
					args: {
						url: 'old_school_ninja_turtles',
					},
				},
			];
		},
		canUserEditValue() {
			return true;
		},
	} );

	registerBlockBindingsSource( {
		name: 'block-binding/custom-title',
		label: 'Custom Title',
		getValues( { bindings }: { bindings: any } ) {
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
