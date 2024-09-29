<?php
/**
 * Plugin Name:       Block Binding
 * Description:       Block binding examples
 * Version:           1.0.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Text Domain:       block-binding
 */

namespace Plugin\BlockBinding;

add_action('init', static function () {
	register_block_pattern(
		'block-binding/pattern',
		[
			'title' => 'Block Binding Pattern',
			'blockTypes' => ['core/image'],
			'filePath' => plugin_dir_path(__FILE__) . 'patterns/random-image.php',
		]
	);

	register_block_bindings_source(
		'block-binding/image-source',
		[
			'label' => 'http://localhost:8888/wp-content/uploads/2024/09/962264.png',
			'get_value_callback' => static function () {
				return 'http://localhost:8888/wp-content/uploads/2024/09/962264.png';
			}
		]
	);

	register_block_bindings_source(
		'block-binding/image-title',
		[
			'label' => 'Image Title',
			'get_value_callback' => static function () {
				return 'Image Title';
			}
		]
	);
});
