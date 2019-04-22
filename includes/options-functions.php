<?php
/**
 * Options
 *
 * @package HelpPress
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Returns default values for plugin options.
 *
 * @since 1.0.0
 *
 * @return array Option defaults.
 */
function helppress_get_option_defaults() {
	$defaults = [

		// Text
		'title' => esc_html__('Knowledge Base', 'helppress'),

		// Homepage
		'show_on_front' => false,

		// Queries
		'orderby' => 'date',
		'order' => 'ASC',
		'posts_per_page' => 5,

		// Slugs
		'knowledge_base_slug' => 'kb',
		'category_slug' => 'kb-category',
		'tag_slug' => 'kb-tag',

		// Display
		'page_template' => 'default',
		'columns' => 2,
		'disable_css' => false,

		// Breadcrumb
		'breadcrumb' => true,
		'breadcrumb_home' => false,
		'breadcrumb_sep' => '/',

		// Search
		'search' => true,
		'search_placeholder' => esc_attr__('Search the knowledge base …', 'helppress'),
		'search_autofocus' => false,
		'search_suggestions' => true,
		'search_suggestions_number' => 5,

	];

	return apply_filters('helppress_option_defaults', $defaults);
}

/**
 * Returns the default value for a given option key.
 *
 * @since 1.0.0
 *
 * @param string $key Option key to return default value for.
 * @return mixed Default option value.
 */
function helppress_get_option_default($key = null) {
	$defaults = helppress_get_option_defaults();
	$value = false;

	if (array_key_exists($key, $defaults)) {
		$value = $defaults[$key];
	}

	return apply_filters('helppress_get_option_default', $value, $key);
}

/**
 * Returns the default `orderby` option value.
 *
 * Used to get around CMB2 calling any callable string value in `default` arg.
 *
 * @since 3.0.0
 *
 * @return string Default `orderby` value.
 */
function helppress_get_orderby_option_default() {
	return helppress_get_option_default('orderby');
}

/**
 * Returns the value for a value for a given option key.
 *
 * @since 1.0.0
 *
 * @param string $key Option key to return value for.
 * @return mixed Option value if it exists; default value if not.
 */
function helppress_get_option($key = null) {
	$options = maybe_unserialize(get_option('helppress_options'));
	$value = false;

	if ($options && array_key_exists($key, $options)) {
		$value = $options[$key];
	} else {
		$value = helppress_get_option_default($key);
	}

	return apply_filters('helppress_get_option', $value, $key);
}
