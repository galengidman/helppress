<?php
/**
 * Template Tags
 *
 * @package HelpPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns a Genericon SVG snippet.
 *
 * @since 1.0.0
 *
 * @param string $icon Icon name.
 * @param integer $size Icon size in pixels.
 * @return string SVG icon code.
 */
if ( ! function_exists( 'helppress_genericon' ) ) :
function helppress_genericon( $icon, $size = 16 ) {

	$svg_url = esc_url( HELPPRESS_URL . '/assets/img/genericons-neue.svg' );

	return "<svg class='helppress-genericon helppress-genericon--{$icon} helppress-genericon--{$size}' width='{$size}px' height='{$size}px'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='{$svg_url}#hp-genericon-{$icon}'></use></svg>";

}
endif;

/**
 * Wrapper for article queries. Applies query args as configured in admin Settings.
 *
 * @since 1.0.0
 *
 * @param array $args Additional `WP_Query` args to apply to the article query.
 * @return object `WP_Query` object.
 */
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

/**
 * Returns breadcrumb trail data.
 *
 * @since 1.0.0
 *
 * @return array Breadcrumb trail.
 */
function helppress_get_breadcrumb() {

	$breadcrumb = new HelpPress_Breadcrumb();

	return $breadcrumb->get_trail();

}

/**
 * Helper for category query. Applies query args as configured in admin Settings.
 *
 * @since 1.0.0
 *
 * @param array $args Additional `get_terms()` args to apply to query.
 * @return array `get_terms()` result.
 */
function helppress_get_categories( $args = array() ) {

	$args = wp_parse_args( $args, array(
		'taxonomy' => 'hp_category',
		'orderby'  => 'menu_order',
	) );

	$args = apply_filters( 'helppress_get_categories_args', $args );

	$terms = get_terms( $args );

	return apply_filters( 'helppress_get_categories', $terms );

}

/**
 * Returns Knowledge base archive URL.
 *
 * @since 1.0.0
 *
 * @return string Archive URL.
 */
function helppress_get_kb_url() {

	return get_post_type_archive_link( 'hp_article' );

}

/**
 * Returns post format like `get_post_format()`, but returns `standard` if no format is set.
 *
 * @since 1.0.0
 *
 * @param integer $post_id Post ID to get format for.
 * @return string Post format.
 */
function helppress_get_post_format( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = get_the_id();
	}

	$format = get_post_format( $post_id );
	$format = $format ? $format : 'standard';

	return apply_filters( 'helppress_get_post_format', $format );

}

/**
 * Returns whether is KB article.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function helppress_is_kb_article() {

	return is_singular( 'hp_article' );

}

/**
 * Returns whether KB archive.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function helppress_is_kb_archive() {

	return is_post_type_archive( 'hp_article' ) && ! is_search();

}

/**
 * Returns whether KB category.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function helppress_is_kb_category() {

	return is_tax( 'hp_category' );

}

/**
 * Returns whether KB tag.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function helppress_is_kb_tag() {

	return is_tax( 'hp_tag' );

}

/**
 * Returns whether KB search.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function helppress_is_kb_search() {

	return is_search() && get_query_var( 'hps' );

}

/**
 * Returns whether KB page.
 *
 * @since 1.0.0
 *
 * @return bool
 */
function helppress_is_kb_page() {

	return helppress_is_kb_article()
		|| helppress_is_kb_archive()
		|| helppress_is_kb_category()
		|| helppress_is_kb_tag()
		|| helppress_is_kb_search();

}
