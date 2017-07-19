<?php

function wpkb_get_categories( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'taxonomy' => 'wpkb_article_category',
		'orderby' => 'menu_order',
	) );

	$args = apply_filters( 'wpkb_get_categories_args', $args );

	$terms = get_terms( $args );

	return apply_filters( 'wpkb_get_categories', $terms );

}

function wpkb_get_articles( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'post_type' => 'wpkb_article',
		'orderby' => 'menu_order',
	) );

	$args = apply_filters( 'wpkb_get_articles_args', $args );

	$articles = new WP_Query( $args );

	return apply_filters( 'wpkb_get_articles', $articles );

}
