<?php
/**
 * Plugin Name:       Plugin Templates
 * Description:       Example code for registering plugin block templates with WordPress 6.7+.
 * Version:           1.0.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Text Domain:       templates
 */

namespace Plugin\Templates;

function load_template(string $templateName): string {
	ob_start();
	include plugin_dir_path(__FILE__) . '/templates/' . $templateName . '.php';
	return ob_get_clean();
}

add_action( 'init', static function() {
	register_block_template(
		'templates//page',
		[
			'title' => 'My Single Page',
			'description' => 'This is template 1',
			'content' => load_template('page'),
			'post_types' => [ 'page' ],
		]
	);
} );
