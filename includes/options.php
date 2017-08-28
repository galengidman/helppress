<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hpkb_get_option_defaults() {

	$defaults = array(

		// Text
		'title'               => esc_html__( 'Knowledge Base', 'hpkb' ),

		// Queries
		'orderby'             => 'date',
		'order'               => 'ASC',
		'posts_per_page'      => 5,

		// Slugs
		'knowledge_base_slug' => 'kb',
		'category_slug'       => 'kb-category',
		'tag_slug'            => 'kb-tag',

		// Display
		'columns'             => 2,
		'disable_css'         => false,

	);

	return apply_filters( 'hpkb_option_defaults', $defaults );

}

function hpkb_get_option_default( $key = null ) {

	$defaults = hpkb_get_option_defaults();
	$value    = false;

	if ( array_key_exists( $key, $defaults ) ) {
		$value = $defaults[ $key ];
	}

	return apply_filters( 'hpkb_get_option_default', $value, $key );

}

function hpkb_get_option( $key = null ) {

	$options = maybe_unserialize( get_option( 'hpkb_options' ) );
	$value   = false;

	if ( $options && array_key_exists( $key, $options ) ) {
		$value = $options[ $key ];
	} else {
		$value = hpkb_get_option_default( $key );
	}

	return apply_filters( 'hpkb_get_option', $value, $key );

}
