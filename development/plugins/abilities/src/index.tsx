import { useSelect } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';

const STORE_NAME = 'core/abilities';

const AbilityComponent = () => {
	const [ state, setState ] = useState< {
		title: string;
		content: string;
	} | null >( null );

	const ability = useSelect(
		( select ) =>
			select( STORE_NAME ).getAbility( 'my-plugin/simple-ability' ),
		[]
	);

	useEffect( () => {
		if ( ! ability ) {
			return;
		}

		ability
			.callback( { id: 1 } )
			.then( ( result: any ) => setState( result ) )
			.catch( ( error: { message: string } ) =>
				setState( { title: 'Error', content: error.message } )
			);
	}, [ ability ] );

	return (
		<PluginDocumentSettingPanel
			name="abilities-demo-panel"
			title="Abilities Demo"
		>
			{ state && (
				<div>
					<h3>{ state.title }</h3>
					<p>{ state.content }</p>
				</div>
			) }
		</PluginDocumentSettingPanel>
	);
};

registerPlugin( 'abilities-demo', {
	render: () => <AbilityComponent />,
} );
