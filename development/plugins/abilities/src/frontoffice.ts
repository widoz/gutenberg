import { executeAbility } from '@wordpress/abilities';
import './core-abilities';

executeAbility( 'my-plugin/simple-ability', { id: 1 } ).then( ( result ) =>
	// eslint-disable-next-line no-console
	console.log( result )
);
