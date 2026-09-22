<?php
/**
 * Theme setup for WP Features Testing.
 *
 * The theme keeps two sources apart:
 *
 * - `design-system/` is the scaffolded copy of the design system. It holds the
 *   token contract, the presets, the element and component defaults, the SCSS
 *   mixins, and the PHP that joins all of it to WordPress. The project owns
 *   this copy and edits it in place. `design-system/scaffold.json` records the
 *   version it came from.
 * - `styles/` holds what WordPress reads on its own: the block style
 *   variations in `styles/blocks/`, and the theme style variations.
 *
 * `theme.json` stays a thin manifest. It declares the template lists and
 * nothing else.
 *
 * @package wp-features-testing
 */

declare(strict_types=1);

require_once __DIR__ . '/design-system/load.php';

WordPress\DesignSystem\boot();

/**
 * Register the blocks that the theme ships in the `blocks` directory.
 */
function wp_features_testing_register_blocks(): void {
	$blocks_dir = __DIR__ . '/blocks';

	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	foreach ( glob( $blocks_dir . '/*', GLOB_ONLYDIR ) as $block_dir ) {
		if ( file_exists( $block_dir . '/block.json' ) ) {
			register_block_type( $block_dir );
		}
	}
}
add_action( 'init', 'wp_features_testing_register_blocks' );
