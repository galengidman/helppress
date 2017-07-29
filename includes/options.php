<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_get_option_defaults() {

	$defaults = array(

		// Slugs
		'knowledge_base_slug' => 'knowledge-base',
		'category_slug'       => 'article-category',
		'tag_slug'            => 'article-tag',
		'article_slug'        => 'article',

		// Display
		'skin'                => 'full',
		'columns'             => 2,
		'color_accent'        => '#0099e5',
		'color_success'       => '#34bf49',
		'color_error'         => '#ff4c4c',
		'disable_css'         => false,

		// License
		'license_key'         => '',

	);

	return apply_filters( 'helppress_option_defaults', $defaults );

}

function helppress_get_option_default( $key = null ) {

	$defaults = helppress_get_option_defaults();
	$value    = false;

	if ( array_key_exists( $key, $defaults ) ) {
		$value = $defaults[ $key ];
	}

	return apply_filters( "helppress_get_option_default_{$key}", $value );

}

function helppress_get_option( $key = null ) {

	$options = maybe_unserialize( get_option( 'helppress_options' ) );
	$value   = false;

	if ( $options && array_key_exists( $key, $options ) ) {
		$value = $options[ $key ];
	} else {
		$value = helppress_get_option_default( $key );
	}

	return apply_filters( "helppress_get_option_{$key}", $value );

}
