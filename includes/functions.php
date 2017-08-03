<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_article_format_icon( $post_id, $size = 16 ) {

	$format = helppress_get_post_format( $post_id );

	return helppress_genericon( $format, $size );

}

function helppress_buffer_template_part( $slug, $name = null ) {

	ob_start();

	helppress_get_template_part( $slug, $name );

	return ob_get_clean();

}

function helppress_genericon( $icon, $size = 16 ) {

	$svg_url = esc_url( HELPPRESS_URL . '/assets/img/genericons-neue.svg' );

	return "<svg class='genericons-neue genericons-neue-{$icon}' width='{$size}px' height='{$size}px'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='{$svg_url}#hp-{$icon}'></use></svg>";

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

function helppress_get_breadcrumb() {

	$breadcrumb = new HelpPress_Breadcrumb();

	return $breadcrumb->get_trail();
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

function helppress_get_knowledge_base_url() {

	return get_post_type_archive_link( 'helppress_article' );

}

function helppress_get_post_format( $post_id ) {

	$format = get_post_format( $post_id );
	$format = $format ? $format : 'standard';

	return apply_filters( 'helppress_get_post_format', $format );

}

function helppress_get_reserved_terms() {

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

	return apply_filters( 'helppress_get_reserved_terms', $terms );

}

function helppress_get_template_part( $slug, $name = null ) {

	$templates = new HelpPress_Template_Loader;

	$templates->get_template_part( $slug, $name );

}

function helppress_is_knowledge_base_archive() {

	return is_post_type_archive( 'helppress_article' ) && ! is_search();

}

function helppress_is_knowledge_base_search() {

	return is_search() && get_query_var( 'post_type' ) === 'helppress_article';

}

function helppress_sanitize_slug( $slug ) {

	$reserved_terms = helppress_get_reserved_terms();

	if ( in_array( $slug, $reserved_terms ) ) {
		$slug = 'kb-' . $slug;
	}

	return apply_filters( 'helppress_sanitize_slug', $slug );

}
