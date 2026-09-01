<?php
/**
 * Plugin Name:       Responsive Block
 * Description:       An example block with a custom attribute that changes per viewport state.
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Version:           1.0.0
 * Author:            responsive-block
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       responsive-block
 *
 * @package responsive-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/inc/viewport.php';
require_once __DIR__ . '/inc/styles.php';

/**
 * Registers the block from the metadata in the build directory.
 *
 * @return void
 */
function responsive_block_init() {
	register_block_type( __DIR__ . '/build' );

	/*
	 * A dynamic block cannot print a stylesheet on its own. The block registers
	 * an empty handle here, and render.php adds one inline rule for each block
	 * instance to it.
	 */
	wp_register_style( 'responsive-block-instances', false, array(), '1.0.0' );
}
add_action( 'init', 'responsive_block_init' );
