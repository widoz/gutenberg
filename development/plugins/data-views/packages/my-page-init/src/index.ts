import { home, styles } from '@wordpress/icons';
import { dispatch } from '@wordpress/data';
import { store as bootStore } from '@wordpress/boot';

/**
 * Initialize page - this function is mandatory.
 * All init modules must export an 'init' function.
 */
export async function init() {
	// Add icons to menu items
	dispatch( bootStore ).updateMenuItem( 'home', { icon: home } );
	dispatch( bootStore ).updateMenuItem( 'styles', { icon: styles } );
}
