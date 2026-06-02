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
		'block-binding/old-school-ninja-turtle',
		[
			'label' => 'Old School Ninja Turtles',
			'get_value_callback' => static function (array $sourceArgs, \WP_Block $block, string $attributeName) {
				if ($attributeName !== 'url') {
					return '';
				}

				switch ($sourceArgs['slug']) {
					case 'old_school_ninja_turtles':
						return 'https://i1.sndcdn.com/artworks-000157290951-wydoxo-t500x500.jpg';
					default:
						return $block->attributes['url'];
				}
			}
		]
	);

	register_block_bindings_source(
		'block-binding/manipulated-text',
		[
			'label' => __('Manipulated Text', 'block-binding'),
			'get_value_callback' => static function (array $sourceArgs, \WP_Block $block, string $attributeName) {
				$postId = $block->context['postId'];
				$post = get_post($postId);

				if (!$post instanceof \WP_Post) {
					return $block->attributes['content'];
				}

				return 'This is a manipulated text: ' . $post->post_title . '.';
			},
			'uses_context' => ['postId'],
		]
	);
	register_block_type_from_metadata(plugin_dir_path(__FILE__) . 'build', [
		'render_callback' => static function (array $attributes): string {
			ob_start();
			?>
			<div class="block-binding-block">
				<p><?= wp_kses_post($attributes['content']) ?></p>
			</div>
			<?php
			return ob_get_clean();
		}
	]);
	add_filter(
		'block_bindings_supported_attributes_block-binding/block',
		static function (array $supportedAttributes): array {
			return array_merge($supportedAttributes, ['content']);
		}
	);
});

add_action('admin_enqueue_scripts', static function () {
	$conf = require_once plugin_dir_path(__FILE__) . 'build/block-bindings.asset.php';
	is_admin() and wp_enqueue_script(
		'block-binding',
		plugin_dir_url(__FILE__) . 'build/block-bindings.js',
		$conf['dependencies'],
		$conf['version'],
	);

	$conf = require_once plugin_dir_path(__FILE__) . 'build/block-bindings-block.asset.php';
	is_admin() and wp_enqueue_script(
		'block-bindings-block',
		plugin_dir_url(__FILE__) . 'build/block-bindings-block.js',
		$conf['dependencies'],
		$conf['version'],
	);
});
