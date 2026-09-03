<?php

declare(strict_types=1);

/**
 * Plugin Name: Data Views
 * Plugin Version: 1.0.0
 */

require_once __DIR__ . '/build/build.php';

add_action('admin_menu', static function () {
	// The page slug must match an entry in `wpPlugin.pages`. Without a menu
	// registration, `user_can_access_admin_page()` denies the request before
	// the generated interceptor runs on `admin_init`.
	add_menu_page(
		'Data Views',
		'Data Views',
		'manage_options',
		'data-views',
		'data_views_data_views_render_page'
	);
});

// The page template dequeues every admin style, so the `.js .hide-if-js` rule
// from `common.css` is missing and the no-JavaScript notice stays visible.
// The `data-views_init` hook runs after the dequeue loop and before `print_admin_styles()`.
add_action('data-views_init', static function () {
	wp_enqueue_style('common');

	// The `@my-plugin/my-page-init` module only updates existing menu items.
	// Register each item here first, or the sidebar stays empty.
	data_views_register_data_views_menu_item('data-views', 'Data Views', '/');
	data_views_register_data_views_menu_item('posts-views', 'Post Views', '/posts-views');
});
