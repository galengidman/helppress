<?php

function helppress_install() {
	$current_version = get_option( 'edd_version' );
	if ( $current_version ) {
		update_option( 'helppress_version_upgraded_from', $current_version );
	}

	helppress_register_post_types();

	flush_rewrite_rules( false );

	update_option( 'helppress_version', HELPPRESS_VERSION );
}
register_activation_hook( HELPPRESS_FILE, 'helppress_install' );
