import type { DeepPartial, Fields, View } from '@wordpress/dataviews';

import { createRoot } from 'react-dom/client';

import domReady from '@wordpress/dom-ready';
import { useState, useMemo } from '@wordpress/element';
import { Icon, pencil } from '@wordpress/icons';
import { DataViews, filterSortAndPaginate } from '@wordpress/dataviews';

interface ItemWithId {
	id: string;
}
interface Item extends ItemWithId {
	title: string;
	date: string;
	author: number;
}

const AUTHORS = [
	{
		value: 1,
		label: 'Admin',
	},
	{
		value: 2,
		label: 'Jane',
	},
	{
		value: 3,
		label: 'Carlos',
	},
	{
		value: 4,
		label: 'Priya',
	},
];

const DATA: Array< Item > = [
	{
		id: '1',
		title: 'Apollo Mission Report',
		author: 1,
		date: '2024-11-15T09:30:00.000Z',
	},
	{
		id: '2',
		title: 'Quarterly Revenue Summary',
		author: 2,
		date: '2025-01-08T14:22:10.000Z',
	},
	{
		id: '3',
		title: 'Design System Guidelines',
		author: 3,
		date: '2024-06-03T11:05:33.000Z',
	},
	{
		id: '4',
		title: 'Bug Triage Notes',
		author: 1,
		date: '2025-03-20T16:45:00.000Z',
	},
	{
		id: '5',
		title: 'Onboarding Checklist',
		author: 4,
		date: '2024-09-12T08:00:00.000Z',
	},
	{
		id: '6',
		title: 'API Migration Plan',
		author: 3,
		date: '2025-02-28T10:15:00.000Z',
	},
	{
		id: '7',
		title: 'Launch Retrospective',
		author: 2,
		date: '2024-12-01T17:30:00.000Z',
	},
	{
		id: '8',
		title: 'Security Audit Findings',
		author: 1,
		date: '2025-04-10T13:00:00.000Z',
	},
	{
		id: '9',
		title: 'Component Library RFC',
		author: 4,
		date: '2024-08-19T09:45:00.000Z',
	},
	{
		id: '10',
		title: 'Infrastructure Cost Review',
		author: 2,
		date: '2025-01-25T15:10:00.000Z',
	},
];
//const SELECTION = [ '1', '3', '5' ];

const fields: Fields< Item > = [
	{
		id: 'title',
		type: 'text',
		label: 'Title',
		enableHiding: false,
	},
	{
		id: 'date',
		type: 'date',
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
		render: ( { item }: { item: Item } ) => {
			return AUTHORS.find( ( author ) => author.value === item.author )
				?.label;
		},
		filterBy: {
			operators: [ 'isAny', 'isNone', 'isAll' ],
		},
		elements: AUTHORS,
	},
];

const VIEW: View = {
	search: '',
	filters: [
		{
			field: 'author',
			operator: 'isAny',
			value: [ 1, 2 ],
		},
	],
	page: 1,
	perPage: 5,
	sort: {
		field: 'title',
		direction: 'desc',
	},
	titleField: 'title',
	fields: [ 'date', 'author' ],
	type: 'table',
	layout: {
		density: 'comfortable',
		enableMoving: true,
		styles: {
			author: {
				//maxWidth: 50,
			},
		},
	},
	//groupBy: {
	//	field: 'author',
	//	direction: 'desc',
	//	showLabel: true,
	//},
};

const ACTIONS = [
	{
		id: 'edit',
		label: 'Edit',
		icon: <Icon icon={ pencil } />,
		supportsBulk: true,
		callback: ( items: Array< Item > ) => {
			// eslint-disable-next-line no-console
			console.log( 'Editing items:', items );
		},
	},
];

const App = () => {
	const [ view, setView ] = useState< View >( VIEW );
	//const [ selection, setSelection ] =
	//	useState< Array< string > >( SELECTION );

	const { data: filteredData, paginationInfo } = useMemo(
		() => filterSortAndPaginate( DATA, view, fields ),
		[ view ]
	);

	const onChangeView = ( newView: View ) => {
		if ( newView.type === 'grid' ) {
			newView.layout = {
				badgeFields: [ 'author' ],
			};
		}
		setView( newView );
	};

	const onClickItem = ( item: Item ) => {
		// eslint-disable-next-line no-console
		console.log( 'Clicked item:', item );
	};

	//const onChangeSelection = ( newSelection: Array< string > ) => {
	//	setSelection( newSelection );
	//};

	const onReset = () => {
		setView( VIEW );
	};

	return (
		<DataViews
			//selection={ selection }
			//onChangeSelection={ onChangeSelection }
			onClickItem={ onClickItem }
			data={ filteredData }
			fields={ fields }
			view={ view }
			actions={ ACTIONS }
			paginationInfo={ paginationInfo }
			config={ {
				perPageSizes: [ 5, 10, 20 ],
			} }
			onChangeView={ onChangeView }
			onReset={ onReset }
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
