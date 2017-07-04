<?php

function wpkb_shortcode_wpkb_search() {

	ob_start();
	wpkb_get_template( 'shortcodes/search-form.php' );
	return ob_get_clean();

}
add_shortcode( 'wpkb-search', 'wpkb_shortcode_wpkb_search' );

function wpkb_shortcode_wpkb() {

	ob_start();
	wpkb_get_template( 'shortcodes/knowledge-base.php' );
	return ob_get_clean();

}
add_shortcode( 'wpkb', 'wpkb_shortcode_wpkb' );
