<?php
/**
 * Plugin Name:       Build
 * Description:       Experimenting with the WordPress Build Package
 * Version:           1.0.0
 * Requires at least: 6.8
 * Requires PHP:      7.4
 * Text Domain:       build
 */

namespace Plugin\Build;

require_once plugin_dir_path( __FILE__ ) . 'build/build.php';

add_action(
	'enqueue_block_editor_assets',
	function() {
		wp_enqueue_script('be-client-package');
	}
);
