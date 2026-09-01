<?php
/**
 * Viewport helpers for the Responsive Block plugin.
 *
 * The helpers read the theme breakpoints and build the media queries that the
 * frontend uses. They mirror the rules that WordPress applies to responsive
 * style states, so the custom attribute reacts at the same widths.
 *
 * @package responsive-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default breakpoints, used when the theme declares none.
 */
const RESPONSIVE_BLOCK_DEFAULT_BREAKPOINTS = array(
	'mobile' => '480px',
	'tablet' => '782px',
);

/**
 * Converts a breakpoint value to pixels.
 *
 * @param mixed $value Breakpoint value.
 * @return float|null Value in pixels, or null when the value is invalid.
 */
function responsive_block_breakpoint_to_pixels( $value ) {
	if ( ! is_string( $value ) || ! preg_match( '/^(\d+|\d*\.\d+)(px|em|rem)$/', trim( $value ), $matches ) ) {
		return null;
	}

	return 'px' === $matches[2] ? (float) $matches[1] : (float) $matches[1] * 16;
}

/**
 * Returns the viewport breakpoints of the theme.
 *
 * An invalid breakpoint is ignored. If the tablet breakpoint is not larger than
 * the mobile breakpoint, only the mobile breakpoint is used.
 *
 * @return array Breakpoints keyed by `mobile` and `tablet`.
 */
function responsive_block_get_breakpoints() {
	$settings    = function_exists( 'wp_get_global_settings' ) ? wp_get_global_settings( array( 'viewport' ) ) : array();
	$breakpoints = array();

	foreach ( array( 'mobile', 'tablet' ) as $breakpoint ) {
		if ( null !== responsive_block_breakpoint_to_pixels( $settings[ $breakpoint ] ?? null ) ) {
			$breakpoints[ $breakpoint ] = $settings[ $breakpoint ];
		}
	}

	if ( empty( $breakpoints ) ) {
		return RESPONSIVE_BLOCK_DEFAULT_BREAKPOINTS;
	}

	if ( isset( $breakpoints['mobile'], $breakpoints['tablet'] )
		&& responsive_block_breakpoint_to_pixels( $breakpoints['tablet'] ) <= responsive_block_breakpoint_to_pixels( $breakpoints['mobile'] )
	) {
		unset( $breakpoints['tablet'] );
	}

	return $breakpoints;
}

/**
 * Returns the media query of each viewport state.
 *
 * @return array Media queries keyed by state name, without the `@media` prefix.
 */
function responsive_block_get_media_queries() {
	$breakpoints = responsive_block_get_breakpoints();
	$queries     = array();

	if ( isset( $breakpoints['mobile'] ) ) {
		$queries['@mobile'] = "(width <= {$breakpoints['mobile']})";
	}

	if ( isset( $breakpoints['tablet'] ) ) {
		$queries['@tablet'] = isset( $breakpoints['mobile'] )
			? "({$breakpoints['mobile']} < width <= {$breakpoints['tablet']})"
			: "(width <= {$breakpoints['tablet']})";
	}

	return $queries;
}
