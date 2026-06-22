<?php

declare(strict_types=1);

/**
 * Plugin Name: AI Client
 * Description: A plugin to integrate AI capabilities into WordPress.
 * Version: 1.0.0
 * Author: Me
 * License: GPL2
 * Text Domain: ai-client
 */

add_action('init', function () {
	$builder = wp_ai_client_prompt();
	$builder->
});
