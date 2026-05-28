import { executeAbility } from '@wordpress/abilities';
import { initialize } from '@wordpress/core-abilities';

await initialize();
executeAbility( 'my-plugin/simple-ability', { id: 1 } ).then( ( result ) =>
	// eslint-disable-next-line no-console
	console.log( result )
);

// ( async () => {
// 	const coreAbilities = ( await import( '@wordpress/core-abilities' ) ) as {
// 		initialize?: () => Promise< void >;
// 		ready?: Promise< void >;
// 	};
//
// 	if ( typeof coreAbilities.initialize === 'function' ) {
// 		await coreAbilities.initialize();
// 	} else if ( coreAbilities.ready ) {
// 		await coreAbilities.ready;
// 	}
//
// 	const { executeAbility } = await import( '@wordpress/abilities' );
// 	const result = await executeAbility( 'my-plugin/simple-ability', {
// 		id: 1,
// 	} );
// 	// eslint-disable-next-line no-console
// 	console.log( result );
// } )();

export {};
