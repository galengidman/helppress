<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_assets_front() {

	wp_enqueue_script( 'jquery-devbridge-autocomplete', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.1/jquery.autocomplete.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'helppress', esc_url( HELPPRESS_URL . '/assets/js/helppress.js' ), array( 'jquery' ) );

	wp_localize_script( 'helppress', 'hpLocalization', array(
		'adminAjax' => esc_url( admin_url( 'admin-ajax.php' ) ),
	) );

	wp_enqueue_style( 'helppress-full', esc_url( HELPPRESS_URL . '/assets/css/full.css' ) );
	// wp_enqueue_style( 'helppress-lite', esc_url( HELPPRESS_URL . '/assets/css/lite.css' ) );

}
add_action( 'wp_enqueue_scripts', 'helppress_assets_front' );
