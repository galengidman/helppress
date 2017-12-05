<?php
/**
 * Plugin Name: HelpPress
 * Description: A powerful and easy-to-use knowledge base plugin for WordPress, compatible with 99% of themes.
 * Version:     2.0.0
 * Author:      helppresswp
 * Author URI:  https://helppresswp.com/
 * License:     GPL2+
 * Text Domain: helppress
 */

define( 'HELPPRESS_VERSION',  '2.0.0' );
define( 'HELPPRESS_FILE',     __FILE__ );
define( 'HELPPRESS_PATH',     plugin_dir_path( HELPPRESS_FILE ) );
define( 'HELPPRESS_URL',      plugin_dir_url( HELPPRESS_FILE ) );
define( 'HELPPRESS_BASENAME', plugin_basename( HELPPRESS_FILE ) );
define( 'HELPPRESS_MIN_PHP',  '5.4' );
define( 'HELPPRESS_MIN_WP',   '4.5' );

register_activation_hook( HELPPRESS_FILE, 'flush_rewrite_rules' );
register_deactivation_hook( HELPPRESS_FILE, 'flush_rewrite_rules' );

add_action( 'plugins_loaded', 'helppress_init' );
add_action( 'plugins_loaded', 'helppress_load_plugin_textdomain' );

function helppress_init() {

	if ( ! version_compare( PHP_VERSION, HELPPRESS_MIN_PHP, '>=' ) ) {
		add_action( 'admin_notices', 'helppress_fail_php_version' );
	} elseif ( ! version_compare( get_bloginfo( 'version' ), HELPPRESS_MIN_WP, '>=' ) ) {
		add_action( 'admin_notices', 'helppress_fail_wp_version' );
	} else {
		include HELPPRESS_PATH . 'includes/class-helppress-plugin.php';
	}

}

function helppress_load_plugin_textdomain() {

	load_plugin_textdomain( 'helppress' );

}

function helppress_fail_php_version() {

	$message = sprintf( esc_html__( 'HelpPress requires PHP version %s+, plugin is currently NOT ACTIVE.', 'helppress' ), HELPPRESS_MIN_PHP );
	$message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );

	echo wp_kses_post( $message );

}

function helppress_fail_wp_version() {

	$message = sprintf( esc_html__( 'HelpPress requires WordPress version %s+, plugin is currently NOT ACTIVE.', 'helppress' ), HELPPRESS_MIN_WP );
	$message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );

	echo wp_kses_post( $message );

}
