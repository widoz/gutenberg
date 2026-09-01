<?php
/**
 * Instance styles for the Responsive Grid block.
 *
 * WordPress emits responsive CSS for the `style` attribute only. A custom
 * attribute needs its own CSS, so this file builds one rule for the default
 * state, and one rule inside a media query for each viewport state that holds
 * an own value.
 *
 * @package responsive-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Builds the CSS declarations of one viewport state.
 *
 * @param array  $attributes Block attributes.
 * @param string $state      Viewport state.
 * @param bool   $is_default Whether the state is the default state.
 * @return string CSS declarations, or an empty string when the state has none.
 */
function responsive_block_get_state_declarations( $attributes, $state, $is_default ) {
	$declarations = array();
	$columns      = $attributes['columns'][ $state ] ?? null;
	$gap          = $attributes['gap'][ $state ] ?? null;

	if ( $is_default ) {
		$columns = null === $columns ? 3 : $columns;
		$gap     = null === $gap ? '1.5rem' : $gap;
	}

	if ( is_numeric( $columns ) ) {
		$columns        = max( 1, min( 6, (int) $columns ) );
		$declarations[] = "grid-template-columns:repeat({$columns},minmax(0,1fr))";
	}

	// Only a plain CSS length reaches the stylesheet.
	if ( is_string( $gap ) && preg_match( '/^\d+(\.\d+)?(px|em|rem|%)?$/', $gap ) ) {
		$declarations[] = "gap:{$gap}";
	}

	return empty( $declarations ) ? '' : implode( ';', $declarations ) . ';';
}

/**
 * Adds the CSS of one block instance, and returns its class name.
 *
 * Two instances with the same values share one class and one rule.
 *
 * @param array $attributes Block attributes.
 * @return string Class name of the instance.
 */
function responsive_block_enqueue_instance_styles( $attributes ) {
	static $rendered = array();

	$values = array(
		'columns' => $attributes['columns'] ?? null,
		'gap'     => $attributes['gap'] ?? null,
	);
	$class  = 'wp-responsive-block-' . substr( md5( wp_json_encode( $values ) ), 0, 8 );

	if ( isset( $rendered[ $class ] ) ) {
		return $class;
	}

	$rendered[ $class ] = true;
	$css                = '';
	$default            = responsive_block_get_state_declarations( $attributes, 'default', true );

	if ( '' !== $default ) {
		$css .= ".{$class}{{$default}}";
	}

	foreach ( responsive_block_get_media_queries() as $state => $query ) {
		$declarations = responsive_block_get_state_declarations( $attributes, $state, false );

		if ( '' === $declarations ) {
			continue;
		}

		$css .= "@media {$query}{.{$class}{{$declarations}}}";
	}

	if ( '' !== $css ) {
		wp_enqueue_style( 'responsive-block-instances' );
		wp_add_inline_style( 'responsive-block-instances', $css );
	}

	return $class;
}
