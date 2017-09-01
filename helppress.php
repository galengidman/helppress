<?php
/**
 * Plugin Name: HelpPress
 * Plugin URI:  https://helppresswp.com/
 * Description: A powerful and easy-to-use knowledge base plugin for WordPress. Compatible with 99% of themes out-of-the-box, or override with custom templates to futher customize. Includes categories and tags to organize content and live search to help your users find relevant content quicker.
 * Version:     1.0.0
 * Author:      ThemeBright
 * Author URI:  https://themebright.com/
 * License:     GPL2+
 * Domain Path: /languages/
 */

function hpkb_constants() {

	$constants = array(

		'HPKB_VERSION' => '1.0.0',

		'HPKB_PATH'    => untrailingslashit( plugin_dir_path( __FILE__ ) ),
		'HPKB_URL'     => untrailingslashit( plugin_dir_url( __FILE__ ) ),

	);

	$constants = apply_filters( 'hpkb_constants', $constants );

	foreach ( $constants as $constant => $value ) {
		if ( ! defined( $constant ) ) {
			define( $constant, $value );
		}
	}
}
add_action( 'plugins_loaded', 'hpkb_constants' );

function hpkb_includes() {

	$includes = array(

		// Vendor
		'/includes/vendor/gamajo/template-loader/class-gamajo-template-loader.php',
		'/includes/vendor/gambitph/titan-framework/titan-framework.php',

		// Classes
		'/includes/class-hpkb-breadcrumb.php',
		'/includes/class-hpkb-menu-archive-link.php',
		'/includes/class-hpkb-search-autocomplete.php',
		'/includes/class-hpkb-settings.php',
		'/includes/class-hpkb-template-loader.php',

		// General
		'/includes/assets.php',
		'/includes/formatting.php',
		'/includes/options.php',
		'/includes/post-types.php',
		'/includes/taxonomies.php',
		'/includes/template-tags.php',
		'/includes/theme-compat.php',

	);

	$includes = apply_filters( 'hpkb_includes', $includes );

	foreach ( $includes as $file ) {
		include HPKB_PATH . $file;
	}

}
add_action( 'plugins_loaded', 'hpkb_includes' );
