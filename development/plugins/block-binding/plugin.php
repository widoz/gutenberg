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
		'block-binding/old-school-ninja-turtles',
		[
			'label' => 'Old School Ninja Turtles',
			'get_value_callback' => static function (array $sourceArgs, \WP_Block $block, string $attributeName) {
				if ($attributeName !== 'url') {
					return '';
				}

				switch ($sourceArgs['url']) {
					case 'old_school_ninja_turtles':
						return 'https://i1.sndcdn.com/artworks-000157290951-wydoxo-t500x500.jpg';
					default:
						return $block->attributes['url'];
				}
			}
		]
	);

	is_admin() and wp_enqueue_script(
		'block-binding',
		plugin_dir_url(__FILE__) . 'resources/js/block-binding.js',
		['wp-blocks', 'wp-element', 'wp-editor'],
		filemtime(plugin_dir_path(__FILE__) . 'resources/js/block-binding.js')
	);
});
