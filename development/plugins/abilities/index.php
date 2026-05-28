<?php

declare(strict_types=1);

/**
 * Abilities API plugin bootstrap file.
 *
 * Plugin Name: Abilities API
 * Description: A plugin to demonstrate the Abilities API in WordPress.
 * Version: 1.0.0
 * Author: Me
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: abilities-api
 *
 * @package WordPress
 * @subpackage Abilities_API
 * @since 6.9.0
 */

add_action('wp_abilities_api_categories_init', function () {
	wp_register_ability_category('demo', [
		'label' => 'Demo',
		'description' => 'A category for demonstration abilities.',
	]);
});

add_action('wp_abilities_api_init', function () {
	wp_register_ability(
		'my-plugin/simple-ability',
		[
			'label' => 'Simple Ability',
			'description' => 'A simple ability for demonstration purposes.',
			'category' => 'demo',
			'input_schema' => [
				'type' => 'object',
				'properties' => [
					'id' => [
						'type' => 'number',
						'description' => 'An integer input for demonstration purposes.',
					]
				]
			],
			'output_schema' => [
				'type' => 'object',
				'properties' => [
					'title' => [
						'type' => 'string',
						'description' => 'A title generated from the input integer.'
					],
					'content' => [
						'type' => 'string',
						'description' => 'The content generated from the input integer.'
					]
				]
			],
			'execute_callback' => function (array $input): array {
				$id = $input['id'] ?? 0;

				// In a real implementation, you would have more complex logic here.
				return [
					'title' => "Generated Title for ID: $id",
					'content' => "Generated content based on the input integer: $id"
				];
			},
			'permission_callback' => fn() => current_user_can('edit_posts'),
			'meta' => [
				'show_in_rest' => true,
				'annotations' => [
					'readonly' => true,
				],
			]
		]
	);
});

add_action('enqueue_block_assets', function () {
	$asset = require __DIR__ . '/build/abilities-api-demo.asset.php';
	wp_enqueue_script_module('@wordpress/core-abilities');
	wp_enqueue_script(
		'abilities-api-demo',
		plugin_dir_url(__FILE__) . 'build/abilities-api-demo.js',
		$asset['dependencies'],
		$asset['version'],
		true
	);
});

add_action('wp_enqueue_scripts', function () {
	wp_enqueue_script('wp-data');
	wp_enqueue_script('wp-url');
	wp_enqueue_script('wp-api-fetch');
	wp_enqueue_script_module( '@wordpress/core-abilities' );
	wp_enqueue_script_module(
		'abilities-api-demo-front-office',
		plugin_dir_url(__FILE__) . 'build-module/abilities-api-demo-front-office.js',
		['@wordpress/core-abilities'],
		null,
		[
			'in_footer' => true
		]
	);
});
