<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_shortcode_helppress_search() {

	ob_start();

	helppress_get_template_part( 'shortcode', 'search-form' );

	return ob_get_clean();

}
add_shortcode( 'helppress-search', 'helppress_shortcode_helppress_search' );

function helppress_shortcode_helppress() {

	ob_start();

	helppress_get_template_part( 'shortcode', 'knowledge-base' );

	return ob_get_clean();

}
add_shortcode( 'helppress', 'helppress_shortcode_helppress' );
