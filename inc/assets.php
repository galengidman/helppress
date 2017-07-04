<?php


function wpkb_assets_front() {

	wp_enqueue_style( 'wpkb-full', WPKB_URL . 'assets/css/full.css' );
	// wp_enqueue_style( 'wpkb-lite', WPKB_URL . 'assets/css/lite.css' );

}
add_action( 'wp_enqueue_scripts', 'wpkb_assets_front' );
