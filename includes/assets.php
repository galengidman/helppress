<?php
/**
 * Assets
 *
 * @package HelpPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues and registers scripts and styles for the front-end of the site.
 *
 * @since 1.0.0
 */
function helppress_assets() {

	wp_enqueue_script(
		'jquery-devbridge-autocomplete',
		esc_url( HELPPRESS_URL . '/assets/vendor/jquery.autocomplete.js' ),
		array( 'jquery' ),
		HELPPRESS_VERSION
	);

	wp_enqueue_script(
		'helppress',
		esc_url( HELPPRESS_URL . '/assets/js/helppress.js' ),
		array( 'jquery', 'jquery-devbridge-autocomplete' ),
		HELPPRESS_VERSION
	);

	wp_localize_script( 'helppress', 'helppress_l10n', array(
		'admin_ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
	) );

	$disable_css = apply_filters( 'helppress_disable_css', false );
	$disable_css_option = helppress_get_option( 'disable_css' );

	if ( ! $disable_css && ! $disable_css_option ) {
		wp_enqueue_style(
			'helppress',
			esc_url( HELPPRESS_URL . '/assets/css/helppress.css' ),
			array(),
			HELPPRESS_VERSION
		);
	}

}
add_action( 'wp_enqueue_scripts', 'helppress_assets' );
