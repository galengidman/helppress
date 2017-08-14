<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function hpkb_get_option_defaults() {

	$defaults = array(

		// Slugs
		'knowledge_base_slug' => 'knowledge-base',
		'category_slug'       => 'article-category',
		'tag_slug'            => 'article-tag',
		'article_slug'        => 'article',

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

	return apply_filters( "hpkb_get_option_default_{$key}", $value );

}

function hpkb_get_option( $key = null ) {

	$options = maybe_unserialize( get_option( 'hpkb_options' ) );
	$value   = false;

	if ( $options && array_key_exists( $key, $options ) ) {
		$value = $options[ $key ];
	} else {
		$value = hpkb_get_option_default( $key );
	}

	return apply_filters( "hpkb_get_option_{$key}", $value );

}
