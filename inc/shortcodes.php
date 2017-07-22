<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_shortcode_helppress_search() {

	return helppress_buffer_template_part( 'search-form' );

}
add_shortcode( 'helppress-search', 'helppress_shortcode_helppress_search' );

function helppress_shortcode_helppress() {

	return helppress_buffer_template_part( 'knowledge-base' );

}
add_shortcode( 'helppress', 'helppress_shortcode_helppress' );
