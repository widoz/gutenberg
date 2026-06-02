import type { JSX } from 'react';

import type { BlockEditProps } from '@wordpress/blocks';
import { RichText, useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

import metadata from './block.json';

interface Props extends BlockEditProps< { content: string } > {}

function Edit( props: Props ): JSX.Element {
	return (
		<div { ...useBlockProps() }>
			<RichText
				tagName="p"
				value={ props.attributes.content }
				onChange={ ( content: string ) => {
					props.setAttributes( { content } );
				} }
			/>
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
