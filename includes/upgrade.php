<?php
/**
 * Upgrade
 *
 * @package HelpPress
 * @since 3.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Handle automatic DB upgrades.
 *
 * @since 3.0.0
 */
function helppress_do_auto_upgrades() {
	$version = get_option('helppress_version');

	if (version_compare($version, '3.0', '<')) {
		helppress_v3_0_upgrades();
	}

	if (version_compare($version, HELPPRESS_VERSION, '<')) {
		update_option('helppress_version', HELPPRESS_VERSION);
	}
}
add_action('init', 'helppress_do_auto_upgrades');

/**
 * Version 3.0 database upgrades.
 *
 * Titan Framework mistakenly (?) double-serialized their options in the database, so fix that for CMB2.
 *
 * @since 3.0.0
 */
function helppress_v3_0_upgrades() {
	$options = maybe_unserialize(get_option('helppress_options'));

	if ($options) {
		update_option('helppress_options', $options);
	}
}
