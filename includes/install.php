<?php
/**
 * Install
 *
 * @package HelpPress
 * @since 3.0.0
 */

/**
 * Installation routine.
 *
 * @since 3.0.0
 */
function helppress_install() {
	// Store which version we are upgrading from
	$current_version = get_option('helppress_version');
	if ($current_version) {
		update_option('helppress_version_upgraded_from', $current_version);
	}

	// Registering CPTs right away so we can regenerate rewrite rules to avoid initial 404
	helppress_register_post_types();

	// Flush rewrite rules but don't regenerate .htaccess
	flush_rewrite_rules(false);

	// Store current version
	update_option('helppress_version', HELPPRESS_VERSION);
}
register_activation_hook(HELPPRESS_FILE, 'helppress_install');
