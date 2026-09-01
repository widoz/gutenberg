/**
 * Editor interface of the Responsive Grid block.
 */

import {
	InspectorControls,
	useBlockProps,
	useInnerBlocksProps,
} from '@wordpress/block-editor';
import {
	Button,
	PanelBody,
	RangeControl,
	SelectControl,
} from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';
import './editor.scss';
import {
	DEFAULT_STATE,
	getResponsiveValue,
	hasResponsiveValue,
	setResponsiveValue,
	useAvailableViewportStates,
	useViewportState,
} from './responsive';

const GAP_OPTIONS = [
	{ label: __( 'None' ), value: '0' },
	{ label: __( 'Small' ), value: '0.75rem' },
	{ label: __( 'Medium' ), value: '1.5rem' },
	{ label: __( 'Large' ), value: '3rem' },
];

export default function Edit( { attributes, setAttributes } ) {
	const { columns, gap } = attributes;

	/*
	 * The View menu of the editor already switches between Desktop, Tablet and
	 * Mobile. The block reads that choice, so it needs no device control of its
	 * own.
	 */
	const state = useViewportState();
	const availableStates = useAvailableViewportStates();

	const stateLabel =
		availableStates.find( ( item ) => item.value === state )?.label ??
		__( 'Default' );

	const isDefaultState = state === DEFAULT_STATE;
	const isOverridden =
		hasResponsiveValue( columns, state ) ||
		hasResponsiveValue( gap, state );

	const blockProps = useBlockProps( {
		style: {
			display: 'grid',
			gridTemplateColumns: `repeat(${ getResponsiveValue(
				columns,
				state
			) }, minmax(0, 1fr))`,
			gap: getResponsiveValue( gap, state ),
		},
	} );
	const innerBlocksProps = useInnerBlocksProps( blockProps );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Layout' ) }>
					<p className="responsive-block-state-help">
						{ isDefaultState
							? __(
									'These values apply to every viewport that has no own value. Change the device in the View menu to edit one viewport.'
							  )
							: sprintf(
									/* translators: %s: viewport state name. */
									__( 'These values apply to %s only.' ),
									stateLabel
							  ) }
					</p>
					<RangeControl
						label={ __( 'Columns' ) }
						min={ 1 }
						max={ 6 }
						value={ getResponsiveValue( columns, state ) }
						onChange={ ( value ) =>
							setAttributes( {
								columns: setResponsiveValue(
									columns,
									state,
									value
								),
							} )
						}
					/>
					<SelectControl
						label={ __( 'Gap' ) }
						options={ GAP_OPTIONS }
						value={ getResponsiveValue( gap, state ) }
						onChange={ ( value ) =>
							setAttributes( {
								gap: setResponsiveValue( gap, state, value ),
							} )
						}
					/>
					{ ! isDefaultState && isOverridden && (
						<Button
							variant="tertiary"
							onClick={ () =>
								setAttributes( {
									columns: setResponsiveValue(
										columns,
										state,
										undefined
									),
									gap: setResponsiveValue(
										gap,
										state,
										undefined
									),
								} )
							}
						>
							{ sprintf(
								/* translators: %s: viewport state name. */
								__( 'Reset %s' ),
								stateLabel
							) }
						</Button>
					) }
				</PanelBody>
			</InspectorControls>
			<div { ...innerBlocksProps } />
		</>
	);
}
