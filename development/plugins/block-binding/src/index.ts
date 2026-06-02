import domReady from '@wordpress/dom-ready';
import { registerBlockBindingsSource } from '@wordpress/blocks';

domReady( () => {
	registerBlockBindingsSource( {
		name: 'block-binding/old-school-ninja-turtle',
		label: 'Ninja Turtles',
		getValues( { bindings }: { bindings: any } ) {
			if ( bindings?.url?.args?.slug === 'old_school_ninja_turtles' ) {
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
						slug: 'old_school_ninja_turtles',
					},
				},
			];
		},
		canUserEditValue() {
			return true;
		},
	} );

	registerBlockBindingsSource( {
		name: 'block-binding/manipulated-text',
		label: 'Manipulated Text',
		getValues( { bindings }: { bindings: any } ) {
			return {
				title: bindings.title,
			};
		},
		getFieldsList() {
			return [
				{
					label: 'Manipulated Text',
					type: 'string',
					args: {
						slug: 'manipulated_text',
					},
				},
			];
		},
		canUserEditValue() {
			return true;
		},
		usesContext: [ 'postId' ],
	} );
} );
