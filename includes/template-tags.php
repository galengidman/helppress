<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function helppress_genericon( $icon, $size = 16 ) {

	$svg_url = esc_url( HELPPRESS_URL . '/assets/img/genericons-neue.svg' );

	return "<svg class='helppress-genericon helppress-genericon--{$icon} helppress-genericon--{$size}' width='{$size}px' height='{$size}px'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='{$svg_url}#hp-genericon-{$icon}'></use></svg>";

}

function helppress_get_articles( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'post_type'      => 'hp_article',
		'orderby'        => helppress_get_option( 'orderby' ),
		'order'          => helppress_get_option( 'order' ),
		'posts_per_page' => helppress_get_option( 'posts_per_page' ),
	) );

	$args = apply_filters( 'helppress_get_articles_args', $args );

	$articles = new WP_Query( $args );

	return apply_filters( 'helppress_get_articles', $articles );

}

function helppress_get_breadcrumb() {

	$breadcrumb = new HelpPress_Breadcrumb();

	return $breadcrumb->get_trail();

}

function helppress_get_categories( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'taxonomy' => 'hp_category',
		'orderby'  => 'menu_order',
	) );

	$args = apply_filters( 'helppress_get_categories_args', $args );

	$terms = get_terms( $args );

	return apply_filters( 'helppress_get_categories', $terms );

}

function helppress_get_kb_url() {

	return get_post_type_archive_link( 'hp_article' );

}

function helppress_get_post_format( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_id();
	}

	$format = get_post_format( $post_id );
	$format = $format ? $format : 'standard';

	return apply_filters( 'helppress_get_post_format', $format );

}

function helppress_is_kb_article() {

	return is_singular( 'hp_article' );

}

function helppress_is_kb_archive() {

	return is_post_type_archive( 'hp_article' ) && ! is_search();

}

function helppress_is_kb_category() {

	return is_tax( 'hp_category' );

}

function helppress_is_kb_tag() {

	return is_tax( 'hp_tag' );

}

function helppress_is_kb_search() {

	return is_search() && get_query_var( 'helppress-search' );

}

function helppress_is_kb_page() {

	return helppress_is_kb_article()
		|| helppress_is_kb_archive()
		|| helppress_is_kb_category()
		|| helppress_is_kb_tag()
		|| helppress_is_kb_search();

}
