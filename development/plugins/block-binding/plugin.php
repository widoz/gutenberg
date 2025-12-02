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
		'block-binding/ninja-turtles',
		[
			'label' => 'Ninja Turtles',
			'get_value_callback' => static function (array $sourceArgs, $blockInstance, string $attributeName) {
				if ($attributeName !== 'url') {
					return '';
				}

				switch ($sourceArgs['url']) {
					case 'original_ninja_turtles':
						return 'https://i1.sndcdn.com/artworks-000157290951-wydoxo-t500x500.jpg';
					case 'movie_2012':
						return 'https://m.media-amazon.com/images/I/91OWuXWQQnL._UF1000,1000_QL80_.jpg';
					default:
						return 'https://picsum.photos/200';
				}
			}
		]
	);

	register_block_bindings_source(
		'block-binding/custom-title',
		[
			'label' => 'Custom Title',
			'get_value_callback' => static function () {
				return get_option('custom_image_title', 'Custom Title');
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
