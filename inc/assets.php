<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_assets_front() {

	wp_enqueue_style( 'helppress-full', HELPPRESS_URL . '/assets/css/full.css' );
	// wp_enqueue_style( 'helppress-lite', HELPPRESS_URL . '/assets/css/lite.css' );

}
add_action( 'wp_enqueue_scripts', 'helppress_assets_front' );
