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

	is_admin() and wp_enqueue_script(
		'block-binding',
		plugin_dir_url(__FILE__) . 'resources/js/block-binding.js',
		['wp-blocks', 'wp-element', 'wp-editor'],
		filemtime(plugin_dir_path(__FILE__) . 'resources/js/block-binding.js')
	);

	register_block_bindings_source(
		'block-binding/custom-url',
		[
			'label' => 'Custom URL',
			'get_value_callback' => static function (array $sourceArgs, $blockInstance, string $attributeName) {
				if (
					$sourceArgs['key'] !== 'custom_url' ||
					$attributeName !== 'url'
				) {
					return '';
				}

				return 'https://images6.alphacoders.com/135/1351738.jpeg';
			}
		]
	);
});
