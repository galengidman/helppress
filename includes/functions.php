<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hpkb_article_format_genericon( $post_id = null, $size = 16 ) {

	if ( ! $post_id ) {
		$post_id = get_the_id();
	}

	$format = hpkb_get_post_format( $post_id );

	return hpkb_genericon( $format, $size );

}

function hpkb_buffer_template_part( $slug, $name = null ) {

	ob_start();

	hpkb_get_template_part( $slug, $name );

	return ob_get_clean();

}

function hpkb_genericon( $icon, $size = 16 ) {

	$svg_url = esc_url( HPKB_URL . '/assets/img/genericons-neue.svg' );

	return "<svg class='hpkb-genericon hpkb-genericon--{$icon} hpkb-genericon--{$size}' width='{$size}px' height='{$size}px'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='{$svg_url}#hp-genericon-{$icon}'></use></svg>";

}

function hpkb_get_articles( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'post_type' => 'hpkb_article',
		'orderby'   => 'menu_order',
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

function hpkb_get_knowledge_base_url() {

	return get_post_type_archive_link( 'hpkb_article' );

}

function hpkb_get_post_format( $post_id ) {

	$format = get_post_format( $post_id );
	$format = $format ? $format : 'standard';

	return apply_filters( 'hpkb_get_post_format', $format );

}

function hpkb_get_reserved_terms() {

	// https://codex.wordpress.org/Reserved_Terms
	$terms = array(
		'attachment',
		'attachment_id',
		'author',
		'author_name',
		'calendar',
		'cat',
		'category',
		'category__and',
		'category__in',
		'category__not_in',
		'category_name',
		'comments_per_page',
		'comments_popup',
		'custom',
		'customize_messenger_channel',
		'customized',
		'cpage',
		'day',
		'debug',
		'embed',
		'error',
		'exact',
		'feed',
		'hour',
		'link_category',
		'm',
		'minute',
		'monthnum',
		'more',
		'name',
		'nav_menu',
		'nonce',
		'nopaging',
		'offset',
		'order',
		'orderby',
		'p',
		'page',
		'page_id',
		'paged',
		'pagename',
		'pb',
		'perm',
		'post',
		'post__in',
		'post__not_in',
		'post_format',
		'post_mime_type',
		'post_status',
		'post_tag',
		'post_type',
		'posts',
		'posts_per_archive_page',
		'posts_per_page',
		'preview',
		'robots',
		's',
		'search',
		'second',
		'sentence',
		'showposts',
		'static',
		'subpost',
		'subpost_id',
		'tag',
		'tag__and',
		'tag__in',
		'tag__not_in',
		'tag_id',
		'tag_slug__and',
		'tag_slug__in',
		'taxonomy',
		'tb',
		'term',
		'terms',
		'theme',
		'title',
		'type',
		'w',
		'withcomments',
		'withoutcomments',
		'year',
	);

	return apply_filters( 'hpkb_get_reserved_terms', $terms );

}

function hpkb_get_template_part( $slug, $name = null ) {

	$templates = new HPKB_Template_Loader;

	$templates->get_template_part( $slug, $name );

}

function hpkb_is_knowledge_base_archive() {

	return is_post_type_archive( 'hpkb_article' ) && ! is_search();

}

function hpkb_is_knowledge_base_search() {

	return is_search() && get_query_var( 'hpkb-search' );

}

function hpkb_sanitize_slug( $slug ) {

	$reserved_terms = hpkb_get_reserved_terms();

	if ( in_array( $slug, $reserved_terms ) ) {
		$slug = 'kb-' . $slug;
	}

	return apply_filters( 'hpkb_sanitize_slug', $slug );

}
