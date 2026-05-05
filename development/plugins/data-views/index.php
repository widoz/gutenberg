<?php

declare(strict_types=1);

/**
 * Plugin Name: Data Views
 * Plugin Version: 1.0.0
 */

add_action('init', function () {
	add_menu_page('Data Views', 'Data Views', 'manage_options', 'data-views', function () {
		ob_start();
		require_once __DIR__ . '/views/admin-page.php';
		echo ob_get_clean();
	});
	add_submenu_page('data-views', 'Data Form', 'Data Form', 'manage_options', 'data-form', function () {
		ob_start();
		require_once __DIR__ . '/views/admin-page.php';
		echo ob_get_clean();
	});
});

add_action(
	'admin_enqueue_scripts',
	static function () {
		$page = filter_input(INPUT_GET, 'page');
		if ($page === 'data-views') {
			wp_enqueue_style('wp-editor');
			$conf = @include_once plugin_dir_path(__FILE__) . 'build/data-views.asset.php';
			wp_enqueue_script('data-views', plugin_dir_url(__FILE__) . 'build/data-views.js', $conf['dependencies'], $conf['version'], true);
		}

		if ($page === 'data-form') {
			wp_enqueue_style('wp-editor');
			$conf = @include_once plugin_dir_path(__FILE__) . 'build/data-form.asset.php';
			wp_enqueue_script('data-form', plugin_dir_url(__FILE__) . 'build/data-form.js', $conf['dependencies'], $conf['version'], true);
		}
	}
);
