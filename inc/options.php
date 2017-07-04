<?php

function wpkb_get_option_defaults() {

	$defaults = array(
		// 'knowledge_base_slug' => 'knowledge-base',
		'category_slug' => 'article-category',
		'tag_slug' => 'article-tag',
		'article_slug' => 'article',
		'enable_tags' => true,
		'skin' => 'full',
		'columns' => 2,
		'color_accent' => '#0099e5',
		'color_success' => '#34bf49',
		'color_error' => '#ff4c4c',
		'disable_css' => false,
		'license_key' => '',
	);

	return apply_filters( 'wpkb_option_defaults', $defaults );

}

function wpkb_get_option_default( $key = null ) {

	$defaults = wpkb_get_option_defaults();
	$value = false;

	if ( array_key_exists( $key, $defaults ) ) {
		$value = $defaults[ $key ];
	}

	return apply_filters( "wpkb_get_option_default_$key", $value );

}

function wpkb_get_option( $key = null ) {

	$options = maybe_unserialize( get_option( 'wpkb_options' ) );
	$value = false;

	if ( $options && array_key_exists( $key, $options ) ) {
		$value = $options[ $key ];
	} else {
		$value = wpkb_get_option_default( $key );
	}

	return apply_filters( "wpkb_get_option_$key", $value );

}
