<?php
/**
 * Sanitization
 *
 * @package HelpPress
 * @since 3.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Sanitizes slug by ensuring it doesn't conflict with one of WordPress's reserved terms.
 *
 * If slug does conflict with a reserved term, the slug is prefixed with `kb-`.
 *
 * @since 1.0.0
 * @see helppress_get_reserved_terms()
 *
 * @param string $slug Slug to sanitize.
 * @return string Sanitized slug.
 */
function helppress_sanitize_slug($slug) {
	$slug = sanitize_title($slug);

	if (in_array($slug, helppress_get_reserved_terms())) {
		$slug = 'kb-' . $slug;
	}

	return apply_filters('helppress_sanitize_slug', $slug);
}

/**
 * Sanitizes the posts_per_page option to ensure a intval between -1 and 50.
 *
 * @since 3.0.0
 *
 * @param string $number String to sanitize.
 * @return int Sanitized integer.
 */
function helppress_sanitize_posts_per_page($number) {
	$number = intval($number);

	if ($number < -1) {
		$number = -1;
	} elseif ($number > 50) {
		$number = 50;
	}

	return apply_filters('helppress_sanitize_posts_per_page', $number);
}

/**
 * Sanitizes the search_suggestions_number option to ensure a intval between 1 and 10.
 *
 * @since 3.0.0
 *
 * @param string $number String to sanitize.
 * @return int Sanitized integer.
 */
function helppress_sanitize_search_suggestions_number($number) {
	$number = intval($number);

	if ($number < 1) {
		$number = 1;
	} elseif ($number > 10) {
		$number = 10;
	}

	return apply_filters('helppress_sanitize_search_suggestions_number', $number);
}

/**
 * Returns WordPress's reserved terms.
 *
 * https://codex.wordpress.org/Reserved_Terms
 *
 * @since 1.0.0
 *
 * @return array WordPress's reserved terms.
 */
function helppress_get_reserved_terms() {
	$terms = [
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
	];

	return apply_filters('helppress_reserved_terms', $terms);
}
