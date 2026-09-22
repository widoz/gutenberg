<?php
/**
 * The single entry point of the design system.
 *
 * It holds everything that joins the design system to WordPress: the merge of
 * the JSON layer into global styles, and the utility stylesheet. It names no
 * theme and no project value, so the file moves with the directory.
 *
 * A theme or a plugin loads the design system with two lines:
 *
 *     require_once __DIR__ . '/design-system/load.php';
 *     WordPress\DesignSystem\boot();
 *
 * @package wordpress-design-system
 */

declare(strict_types=1);

namespace WordPress\DesignSystem;

/**
 * Register the hooks of the design system.
 *
 * It runs once. A second call returns without an effect, so several consumers
 * of the same copy can call it.
 */
function boot(): void {
	static $booted = false;

	if ( $booted ) {
		return;
	}

	$booted = true;

	add_filter( 'wp_theme_json_data_theme', __NAMESPACE__ . '\\merge_global_styles' );
	add_action( 'enqueue_block_assets', __NAMESPACE__ . '\\enqueue_utilities' );
}

/**
 * Merge the JSON layer into the global styles data.
 *
 * Each file is a theme.json fragment. WordPress merges it the same way as it
 * merges `theme.json`, so a later file overrides an earlier one, and the user
 * can override all of it.
 *
 * @param \WP_Theme_JSON_Data $theme_json Theme global styles data.
 * @return \WP_Theme_JSON_Data
 */
function merge_global_styles( $theme_json ) {
	foreach ( global_styles_files() as $file ) {
		$data = read_json( $file );

		if ( array() === $data ) {
			continue;
		}

		$theme_json = $theme_json->update_with( $data );
	}

	return $theme_json;
}

/**
 * Return the global styles files, in merge order.
 *
 * 1. The token contract, the presets, then the element defaults.
 * 2. The components, which consume the contract.
 *
 * Inside each directory the file name sets the order.
 *
 * @return string[] Absolute paths.
 */
function global_styles_files(): array {
	$layers = array(
		__DIR__ . '/tokens',
		__DIR__ . '/components',
	);

	$files = array();

	foreach ( $layers as $layer ) {
		$layer_files = glob( $layer . '/*.json' );

		if ( is_array( $layer_files ) ) {
			sort( $layer_files );
			$files = array_merge( $files, $layer_files );
		}
	}

	return $files;
}

/**
 * Load the utility stylesheet.
 *
 * It holds what theme.json cannot express: the hover elevation, and the layout
 * primitives. The hook runs on the front end and inside the editor.
 */
function enqueue_utilities(): void {
	$file = __DIR__ . '/assets/utilities.css';

	if ( ! file_exists( $file ) ) {
		return;
	}

	wp_enqueue_style(
		'design-system',
		asset_url( $file ),
		array(),
		(string) filemtime( $file )
	);
}

/**
 * Return the public URL of a file of this directory.
 *
 * The design system can live in a theme or in a plugin, so the URL comes from
 * the location of the file, not from a fixed root.
 *
 * @param string $file Absolute path.
 * @return string URL, or an empty string when the location is unknown.
 */
function asset_url( string $file ): string {
	$file = wp_normalize_path( $file );

	$roots = array(
		wp_normalize_path( get_stylesheet_directory() ) => 'get_theme_file_uri',
		wp_normalize_path( get_template_directory() )   => 'get_parent_theme_file_uri',
	);

	foreach ( $roots as $root => $to_url ) {
		if ( str_starts_with( $file, $root . '/' ) ) {
			return $to_url( substr( $file, strlen( $root ) + 1 ) );
		}
	}

	if ( str_starts_with( $file, wp_normalize_path( WP_PLUGIN_DIR ) . '/' ) ) {
		return plugins_url( basename( $file ), $file );
	}

	return '';
}

/**
 * Read a JSON file into an array.
 *
 * @param string $file Absolute path.
 * @return array Empty when the file is missing or invalid.
 */
function read_json( string $file ): array {
	$contents = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

	if ( false === $contents ) {
		return array();
	}

	$data = json_decode( $contents, true );

	return is_array( $data ) ? $data : array();
}
