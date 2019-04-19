<?php

function helppress_do_auto_upgrades() {
	$version = get_option( 'helppress_version' );

	if ( version_compare( $version, '3.0', '<' ) ) {
		helppress_v3_0_upgrades();
	}
}
add_action( 'admin_init', 'helppress_do_auto_upgrades' );

function helppress_v3_0_upgrades() {
	$options = maybe_unserialize( get_option( 'helppress_options' ) );

	if ( $options ) {
		update_option( 'helppress_options', $options );
	}
}
