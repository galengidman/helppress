<?php

function wpkb_shortcode_wpkb_search() {

	ob_start();

	wpkb_get_template_part( 'shortcode', 'search-form' );

	return ob_get_clean();

}
add_shortcode( 'wpkb-search', 'wpkb_shortcode_wpkb_search' );

function wpkb_shortcode_wpkb() {

	ob_start();

	wpkb_get_template_part( 'shortcode', 'knowledge-base' );

	return ob_get_clean();

}
add_shortcode( 'wpkb', 'wpkb_shortcode_wpkb' );
