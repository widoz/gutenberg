import { registerPlugin } from '@wordpress/plugins';
import { ClientComponent } from '@build-experiments/client-package-lib';
import { PluginSidebar } from '@wordpress/editor';
import { __ } from '@wordpress/i18n';

const EditorPlugin = () => {
	return (
		<PluginSidebar
			name="my-plugin-panel"
			title={ __( 'My Plugin Panel' ) }
			className="my-plugin-panel"
		>
			<ClientComponent />
		</PluginSidebar>
	);
};

registerPlugin( 'my-plugin', {
	render: EditorPlugin,
} );
