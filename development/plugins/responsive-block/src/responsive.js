/**
 * Helpers for attributes that hold one value per viewport state.
 *
 * WordPress generates responsive CSS for the `style` attribute only. A custom
 * attribute needs its own resolution rules. The value of such an attribute is
 * an object keyed by state name:
 *
 *     { default: 3, '@tablet': 2, '@mobile': 1 }
 *
 * Only public APIs are used here.
 */

import { useSelect } from '@wordpress/data';
import { store as editorStore } from '@wordpress/editor';
import { useSettings } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export const DEFAULT_STATE = 'default';

/**
 * Viewport state of each device preview of the editor.
 *
 * @type {Object}
 */
export const STATE_BY_DEVICE_TYPE = {
	Desktop: DEFAULT_STATE,
	Tablet: '@tablet',
	Mobile: '@mobile',
};

/**
 * Description of every viewport state.
 *
 * @type {Array}
 */
export const VIEWPORT_STATES = [
	{ value: DEFAULT_STATE, label: __( 'Default' ) },
	{ value: '@tablet', label: __( 'Tablet' ), setting: 'tablet' },
	{ value: '@mobile', label: __( 'Mobile' ), setting: 'mobile' },
];

/**
 * Reads the value of a responsive attribute for one state.
 *
 * A state without an own value falls back to the default state. The tablet
 * value is not a fallback for mobile, because the tablet media query stops at
 * the mobile breakpoint.
 *
 * @param {Object} value Responsive attribute value.
 * @param {string} state Viewport state.
 * @return {any} Value of the state.
 */
export function getResponsiveValue( value, state ) {
	return value?.[ state ] ?? value?.[ DEFAULT_STATE ];
}

/**
 * Returns true when the state holds an own value.
 *
 * @param {Object} value Responsive attribute value.
 * @param {string} state Viewport state.
 * @return {boolean} Whether the state holds an own value.
 */
export function hasResponsiveValue( value, state ) {
	return value?.[ state ] !== undefined;
}

/**
 * Writes the value of a responsive attribute for one state.
 *
 * An undefined value removes the state, so the default state applies again.
 *
 * @param {Object} value    Responsive attribute value.
 * @param {string} state    Viewport state.
 * @param {any}    newValue New value of the state.
 * @return {Object} Updated responsive attribute value.
 */
export function setResponsiveValue( value, state, newValue ) {
	const nextValue = { ...value };

	if ( undefined === newValue ) {
		delete nextValue[ state ];
	} else {
		nextValue[ state ] = newValue;
	}

	return nextValue;
}

/**
 * Returns the states that the theme breakpoints make available.
 *
 * @return {Array} Available viewport states.
 */
export function useAvailableViewportStates() {
	const [ mobileBreakpoint, tabletBreakpoint ] = useSettings(
		'viewport.mobile',
		'viewport.tablet'
	);
	const breakpoints = {
		mobile: mobileBreakpoint,
		tablet: tabletBreakpoint,
	};

	// A theme without breakpoints falls back to the WordPress defaults.
	if ( ! breakpoints.mobile && ! breakpoints.tablet ) {
		return VIEWPORT_STATES;
	}

	return VIEWPORT_STATES.filter(
		( state ) => ! state.setting || !! breakpoints[ state.setting ]
	);
}

/**
 * Returns the viewport state that the block edits.
 *
 * The state comes from the device preview of the editor, which the View menu
 * changes. The block needs no device control of its own, and the canvas always
 * shows the values that the user edits.
 *
 * @return {string} The current viewport state.
 */
export function useViewportState() {
	const deviceType = useSelect(
		( select ) => select( editorStore )?.getDeviceType?.(),
		[]
	);

	return STATE_BY_DEVICE_TYPE[ deviceType ] ?? DEFAULT_STATE;
}
