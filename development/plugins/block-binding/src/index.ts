import domReady from '@wordpress/dom-ready';
import { registerBlockBindingsSource } from '@wordpress/blocks';
import { store as coreStore } from '@wordpress/core-data';

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
				url: undefined,
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
		getValues( {
			select,
			context,
		}: {
			bindings: any;
			context: any;
			select: any;
		} ) {
			const { postId, postType } = context;
			if ( ! postId || ! postType ) {
				return {
					content: undefined,
				};
			}

			const post = select( coreStore ).getEntityRecord(
				'postType',
				postType,
				postId
			);

			const title = String( post?.title?.rendered );

			return {
				content: `This is a manipulated text: ${ title }`,
			};
		},
		getFieldsList() {
			return [
				{
					label: 'Manipulated Text',
					type: 'string',
					args: {},
				},
			];
		},
		canUserEditValue() {
			return true;
		},
		usesContext: [ 'postId', 'postType' ],
	} );
} );
