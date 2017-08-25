<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hpkb_assets() {

	wp_enqueue_script(
		'jquery-devbridge-autocomplete',
		esc_url( HPKB_URL . '/assets/vendor/jquery.autocomplete.js' ),
		array( 'jquery' ),
		HPKB_VERSION
	);

	wp_enqueue_script(
		'hpkb',
		esc_url( HPKB_URL . '/assets/js/helppress.js' ),
		array( 'jquery', 'jquery-devbridge-autocomplete' ),
		HPKB_VERSION
	);

	wp_localize_script( 'hpkb', 'hpkb_l10n', array(
		'admin_ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
	) );

	wp_enqueue_style(
		'hpkb',
		esc_url( HPKB_URL . '/assets/css/helppress.css' ),
		array(),
		HPKB_VERSION
	);

}
add_action( 'wp_enqueue_scripts', 'hpkb_assets' );
