import type { DeepPartial, Fields, Form } from '@wordpress/dataviews';

import { createRoot } from 'react-dom/client';

import domReady from '@wordpress/dom-ready';
import { DataForm, useFormValidity } from '@wordpress/dataviews';
import { useState } from '@wordpress/element';

const DATA: Record< string, any > = {
	title: 'Apollo Mission Report',
	date: '2024-11-15T09:30:00.000Z',
	author: 1,
};

const FIELDS: Fields< Record< string, any > > = [
	{
		id: 'title',
		type: 'text',
		label: 'Title',
		isValid: {
			required: true,
		},
	},
	{
		id: 'date',
		type: 'datetime',
		label: 'Date',
	},
	{
		id: 'author',
		type: 'integer',
		label: 'Author',
		setValue: ( {
			item,
			value,
		}: {
			item: Record< string, any >;
			value: string;
		} ): DeepPartial< Record< string, any > > => {
			const author = Number( value );
			return { ...item, author };
		},
		elements: [
			{ value: 1, label: 'Admin' },
			{ value: 2, label: 'User' },
		],
	},
];

const FORM: Form = {
	layout: {
		type: 'panel',
		labelPosition: 'side',
	},
	fields: [ 'title', 'date', 'author' ],
};

const App = () => {
	const [ state, setState ] = useState< Record< string, any > >( DATA );

	const { validity } = useFormValidity( state, FIELDS, FORM );

	const onChange = ( newData: Record< string, any > ) => {
		setState( { ...state, ...newData } );
		// eslint-disable-next-line no-console
		console.log( { ...state, ...newData } );
	};

	return (
		<DataForm
			data={ state }
			fields={ FIELDS }
			validity={ validity }
			form={ FORM }
			onChange={ onChange }
		/>
	);
};

domReady( () => {
	const containerElement = document.getElementById(
		'g-data-views-admin-page'
	);
	if ( ! containerElement ) {
		return;
	}

	const root = createRoot( containerElement );
	root.render( <App /> );
} );
