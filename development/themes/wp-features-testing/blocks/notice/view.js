/**
 * Front end behaviour of the Notice block.
 */
import { store, getContext } from '@wordpress/interactivity';

store( 'wp-features-testing/notice', {
	actions: {
		dismiss() {
			getContext().isOpen = false;
		},
	},
} );
