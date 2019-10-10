<?php

if (! defined('ABSPATH')) {
	exit;
}

function helppress_assets() {
	$min = helppress_is_script_debug() ? '' : '.min';

	wp_enqueue_script(
		'jquery-devbridge-autocomplete',
		esc_url(HELPPRESS_URL . "assets/vendor/jquery.autocomplete{$min}.js"),
		['jquery'],
		HELPPRESS_VERSION
	);

	wp_enqueue_script(
		'helppress',
		esc_url(HELPPRESS_URL . "assets/dist/helppress{$min}.js"),
		['jquery', 'jquery-devbridge-autocomplete'],
		HELPPRESS_VERSION
	);

	wp_localize_script('helppress', 'helppressL10n', [
		'adminAjax' => esc_url(admin_url('admin-ajax.php')),
	]);

	$disable_css = apply_filters('helppress_disable_css', false);
	$disable_css_option = helppress_get_option('disable_css');

	if (! $disable_css && ! $disable_css_option) {
		wp_enqueue_style(
			'helppress',
			esc_url(HELPPRESS_URL . "assets/dist/helppress{$min}.css"),
			[],
			HELPPRESS_VERSION
		);
	}
}
add_action('wp_enqueue_scripts', 'helppress_assets');
