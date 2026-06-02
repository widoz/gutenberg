import type { JSX } from 'react';

import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';

type Props = {
	attributes: {
		content: string;
	};
};

function Edit( props: Props ): JSX.Element {
	return (
		<div { ...useBlockProps() }>
			<p>{ props.attributes.content }</p>
		</div>
	);
}

// @ts-ignore
registerBlockType( metadata.name, {
	edit: Edit,
	save() {
		return null;
	},
} );
