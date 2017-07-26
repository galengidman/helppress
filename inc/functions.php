<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_article_format_icon( $post_id, $size = 16 ) {

	$format = helppress_get_post_format( $post_id );

	return helppress_genericon( $format, $size );

}

function helppress_genericon( $icon, $size = 16 ) {

	$svg_url = esc_url( HELPPRESS_URL . '/assets/img/genericons-neue.svg' );

	return "<svg class='genericons-neue genericons-neue-{$icon}' width='{$size}px' height='{$size}px'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='{$svg_url}#{$icon}'></use></svg>";

}

function helppress_get_articles( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'post_type' => 'helppress_article',
		'orderby'   => 'menu_order',
	) );

	$args = apply_filters( 'helppress_get_articles_args', $args );

	$articles = new WP_Query( $args );

	return apply_filters( 'helppress_get_articles', $articles );

}

function helppress_get_categories( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'taxonomy' => 'helppress_article_category',
		'orderby'  => 'menu_order',
	) );

	$args = apply_filters( 'helppress_get_categories_args', $args );

	$terms = get_terms( $args );

	return apply_filters( 'helppress_get_categories', $terms );

}

function helppress_get_post_format( $post_id ) {

	$format = get_post_format( $post_id );
	$format = $format ? $format : 'standard';

	return apply_filters( 'helppress_get_post_format', $format );

}
