<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function helppress_get_option_defaults() {

	$defaults = array(

		// Text
		'title'                     => esc_html__( 'Knowledge Base', 'helppress' ),

		// Queries
		'orderby'                   => 'date',
		'order'                     => 'ASC',
		'posts_per_page'            => 5,

		// Slugs
		'knowledge_base_slug'       => 'kb',
		'category_slug'             => 'kb-category',
		'tag_slug'                  => 'kb-tag',

		// Display
		'columns'                   => 2,
		'disable_css'               => false,

		// Breadcrumb
		'breadcrumb'                => true,
		'breadcrumb_home'           => true,
		'breadcrumb_sep'            => '/',

		// Search
		'search'                    => true,
		'search_placeholder'        => esc_attr__( 'Search the knowledge base …', 'helppress' ),
		'search_autofocus'          => false,
		'search_suggestions'        => true,
		'search_suggestions_number' => 5,

	);

	return apply_filters( 'helppress_option_defaults', $defaults );

}

function helppress_get_option_default( $key = null ) {

	$defaults = helppress_get_option_defaults();
	$value    = false;

	if ( array_key_exists( $key, $defaults ) ) {
		$value = $defaults[ $key ];
	}

	return apply_filters( 'helppress_get_option_default', $value, $key );

}

function helppress_get_option( $key = null ) {

	$options = maybe_unserialize( get_option( 'helppress_options' ) );
	$value   = false;

	if ( $options && array_key_exists( $key, $options ) ) {
		$value = $options[ $key ];
	} else {
		$value = helppress_get_option_default( $key );
	}

	return apply_filters( 'helppress_get_option', $value, $key );

}
