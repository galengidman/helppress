<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hpkb_genericon( $icon, $size = 16 ) {

	$svg_url = esc_url( HPKB_URL . '/assets/img/genericons-neue.svg' );

	return "<svg class='hpkb-genericon hpkb-genericon--{$icon} hpkb-genericon--{$size}' width='{$size}px' height='{$size}px'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='{$svg_url}#hp-genericon-{$icon}'></use></svg>";

}

function hpkb_get_articles( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'post_type'      => 'hpkb_article',
		'orderby'        => hpkb_get_option( 'orderby' ),
		'order'          => hpkb_get_option( 'order' ),
		'posts_per_page' => hpkb_get_option( 'posts_per_page' ),
	) );

	$args = apply_filters( 'hpkb_get_articles_args', $args );

	$articles = new WP_Query( $args );

	return apply_filters( 'hpkb_get_articles', $articles );

}

function hpkb_get_breadcrumb() {

	$breadcrumb = new HPKB_Breadcrumb();

	return $breadcrumb->get_trail();

}

function hpkb_get_categories( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'taxonomy' => 'hpkb_category',
		'orderby'  => 'menu_order',
	) );

	$args = apply_filters( 'hpkb_get_categories_args', $args );

	$terms = get_terms( $args );

	return apply_filters( 'hpkb_get_categories', $terms );

}

function hpkb_get_kb_url() {

	return get_post_type_archive_link( 'hpkb_article' );

}

function hpkb_get_post_format( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_id();
	}

	$format = get_post_format( $post_id );
	$format = $format ? $format : 'standard';

	return apply_filters( 'hpkb_get_post_format', $format );

}

function hpkb_is_kb_article() {

	return is_singular( 'hpkb_article' );

}

function hpkb_is_kb_archive() {

	return is_post_type_archive( 'hpkb_article' ) && ! is_search();

}

function hpkb_is_kb_category() {

	return is_tax( 'hpkb_category' );

}

function hpkb_is_kb_tag() {

	return is_tax( 'hpkb_tag' );

}

function hpkb_is_kb_search() {

	return is_search() && get_query_var( 'hpkb-search' );

}

function hpkb_is_kb_page() {

	return hpkb_is_kb_article()
		|| hpkb_is_kb_archive()
		|| hpkb_is_kb_category()
		|| hpkb_is_kb_tag()
		|| hpkb_is_kb_search();

}
