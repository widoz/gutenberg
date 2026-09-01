import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import './style.scss';
import metadata from './block.json';
import Edit from './edit';
import Save from './save';

/**
 * Inner blocks that a new instance starts with. The editor applies the template
 * at insertion, so the edit component passes no template of its own.
 *
 * @type {Array}
 */
const TEMPLATE = [
	[
		'core/paragraph',
		{
			placeholder: __(
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
			),
		},
	],
	[
		'core/paragraph',
		{
			placeholder: __(
				'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
			),
		},
	],
	[
		'core/paragraph',
		{
			placeholder: __(
				'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
			),
		},
	],
];

registerBlockType( metadata.name, {
	edit: Edit,
	save: Save,
	template: TEMPLATE,
	templateInsertUpdatesSelection: true,
} );
