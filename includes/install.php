<?php
/**
 * Install
 *
 * @package HelpPress
 * @since 3.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Installation routine.
 *
 * @since 3.0.0
 */
function helppress_install() {
	// Registering CPTs right away so we can regenerate rewrite rules to avoid initial 404
	helppress_register_post_types();

	// Flush rewrite rules but don't regenerate .htaccess
	flush_rewrite_rules(false);
}
register_activation_hook(HELPPRESS_FILE, 'helppress_install');
