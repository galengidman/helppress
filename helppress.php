<?php
/**
 * Plugin Name: HelpPress
 * Plugin URI:  https://helppresswp.com/
 * Description: A powerful and easy-to-use knowledge base plugin for WordPress. Compatible with 99% of themes out-of-the-box, or override with custom templates to futher customize. Includes categories and tags to organize content and live search to help your users find relevant content quicker.
 * Version:     1.0.0
 * Author:      ThemeBright
 * Author URI:  https://themebright.com/
 * License:     GPL2+
 * Text Domain: helppress
 * Domain Path: /languages/
 */

function helppress_constants() {

	$constants = array(
		'HELPPRESS_VERSION' => '1.0.0',
		'HELPPRESS_PATH'    => untrailingslashit( plugin_dir_path( __FILE__ ) ),
		'HELPPRESS_URL'     => untrailingslashit( plugin_dir_url( __FILE__ ) ),
	);

	$constants = apply_filters( 'helppress_constants', $constants );

	foreach ( $constants as $constant => $value ) {
		if ( ! defined( $constant ) ) {
			define( $constant, $value );
		}
	}

}
add_action( 'plugins_loaded', 'helppress_constants' );

function helppress_includes() {

	$includes = array(

		// Vendor
		'/includes/vendor/gamajo/template-loader/class-gamajo-template-loader.php',
		'/includes/vendor/gambitph/titan-framework/titan-framework.php',

		// Classes
		'/includes/class-helppress-breadcrumb.php',
		'/includes/class-helppress-menu-archive-link.php',
		'/includes/class-helppress-search-autocomplete.php',
		'/includes/class-helppress-settings.php',
		'/includes/class-helppress-template-loader.php',

		// General
		'/includes/assets.php',
		'/includes/formatting.php',
		'/includes/options.php',
		'/includes/post-types.php',
		'/includes/taxonomies.php',
		'/includes/template-tags.php',
		'/includes/theme-compat.php',

	);

	$includes = apply_filters( 'helppress_includes', $includes );

	foreach ( $includes as $file ) {
		include HELPPRESS_PATH . $file;
	}

}
add_action( 'plugins_loaded', 'helppress_includes' );

function helppress_load_textdomain() {

	load_plugin_textdomain( 'helppress', false, HELPPRESS_PATH . '/languages/' );

}
add_action( 'plugins_loaded', 'helppress_load_textdomain' );

function helppress_activate() {

	flush_rewrite_rules();

}
register_activation_hook( __FILE__, 'helppress_activate' );

function helppress_deactivate() {

	flush_rewrite_rules();

}
register_deactivation_hook( __FILE__, 'helppress_deactivate' );
