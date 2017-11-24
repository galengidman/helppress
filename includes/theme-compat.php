<?php
/**
 * Theme Compatibility
 *
 * @package HelpPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filters `post_content()` and `post_excerpt()` to add HelpPress content template.
 *
 * Applies custom content template if:
 *
 * - Is *not* admin
 * - Is *not* feed
 * - Is *not* JSON API
 * - Is singular `hp_article`
 * - Content comes from `hp_article` post type
 *
 * @since 1.0.0
 *
 * @param string $content Default post content.
 * @return string Potentially modified post content.
 */
function helppress_content( $content ) {

	global $post;

	if ( is_admin() ) {
		return $content;
	}

	if ( is_feed() ) {
		return $content;
	}

	if ( defined( 'JSON_REQUEST' ) && JSON_REQUEST ) {
		return $content;
	}

	if ( helppress_is_kb_article() && 'hp_article' === $post->post_type ) {
		ob_start();
		remove_filter( 'the_content', 'helppress_content' );
		remove_filter( 'the_excerpt', 'helppress_content' );
		helppress_get_template_part( 'parts/helppress-content-article' );
		add_filter( 'the_content', 'helppress_content' );
		add_filter( 'the_excerpt', 'helppress_content' );
		$content = ob_get_clean();
	}

	return $content;

}
add_filter( 'the_content', 'helppress_content' );
add_filter( 'the_excerpt', 'helppress_content' );

/**
 * Filters document title to make adjustments where needed.
 *
 * - Updates title on main KB archive to KB title as configured in admin Settings.
 * - Updates title on KB taxonomy pages to single term title.
 *
 * @since 1.0.0
 *
 * @param array $title_parts Document title parts.
 * @return array Potentially modified title parts.
 */
function helppress_document_title( $title_parts ) {

	if ( helppress_is_kb_archive() ) {
		$title_parts['title'] = helppress_get_option( 'title' );
	}

	elseif ( helppress_is_kb_category() || helppress_is_kb_tag() ) {
		$title_parts['title'] = single_term_title( '', false );
	}

	return $title_parts;

}
add_filter( 'document_title_parts', 'helppress_document_title' );

/**
 * Filters template_include to power built-in theme compatibility.
 *
 * For most themes, it works best to adjust the default template hierarchy for HelpPress. It will
 * first attempt to find one of the following in the active theme (or child theme) folder.
 *
 * - `helppress/helppress-article.php`
 * - `helppress/helppress-archive.php`
 * - `helppress/helppress-category.php`
 * - `helppress/helppress-tag.php`
 * - `helppress/helppress-search.php`
 *
 * If none of the above are found, it defaults to the first found fallback template from
 * `helppress_get_compat_templates()`.
 *
 * @see helppress_get_compat_templates()
 * @since 1.0.0
 *
 * @param string $template Default template.
 * @return string Potentially modified template
 */
function helppress_template_include( $template ) {

	if ( helppress_is_kb_article() ) {
		$custom_template = helppress_get_template( 'helppress-article.php' );
	}

	elseif ( helppress_is_kb_archive() ) {
		remove_all_filters( 'the_content' );

		helppress_reset_post( array(
			'post_title'   => helppress_get_option( 'title' ),
			'post_content' => helppress_buffer_template_part( 'parts/helppress-content-archive' ),
		) );

		$custom_template = helppress_get_template( 'helppress-archive.php' );
	}

	elseif ( helppress_is_kb_category() ) {
		remove_all_filters( 'the_content' );

		helppress_reset_post( array(
			'post_title'   => single_term_title( '', false ),
			'post_content' => helppress_buffer_template_part( 'parts/helppress-content-category' ),
			'is_archive'   => true,
			'is_tax'       => true,
		) );

		$custom_template = helppress_get_template( 'helppress-category.php' );
	}

	elseif ( helppress_is_kb_tag() ) {
		remove_all_filters( 'the_content' );

		helppress_reset_post( array(
			'post_title'   => single_term_title( '', false ),
			'post_content' => helppress_buffer_template_part( 'parts/helppress-content-tag' ),
			'is_archive'   => true,
			'is_tax'       => true,
		) );

		$custom_template = helppress_get_template( 'helppress-tag.php' );
	}

	elseif ( helppress_is_kb_search() ) {
		remove_all_filters( 'the_content' );

		helppress_reset_post( array(
			'post_title'   => sprintf(
				esc_html__( 'Search results: &ldquo;%s&rdquo;' ),
				get_search_query()
			),
			'post_content' => helppress_buffer_template_part( 'parts/helppress-content-search' ),
		) );

		$custom_template = helppress_get_template( 'helppress-search.php' );
	}

	if ( isset( $custom_template ) ) {
		$template = locate_template( $custom_template );
	}

	return $template;

}
add_action( 'template_include', 'helppress_template_include' );

/**
 * Returns fallback theme compatibility templates to use custom templates aren't found.
 *
 * Returns, in order:
 *
 * - `helppress.php`
 * - `page.php`
 * - `single.php`
 * - `index.php`
 *
 * @since 1.0.0
 *
 * @return array Theme compatiblity templates.
 */
function helppress_get_compat_templates() {

	$templates = array(
		'helppress.php',
		'page.php',
		'single.php',
		'index.php',
	);

	$page_template         = helppress_get_option( 'page_template' );
	$disable_page_template = apply_filters( 'helppress_disable_page_template', false );

	if ( $page_template !== 'default' && ! $disable_page_template ) {
		$templates = array_merge( array( $page_template ), $templates );
	}

	return apply_filters( 'helppress_get_compat_templates', $templates );

}

/**
 * Fills up some WordPress globals with dummy data to stop your average page template from
 * complaining about it missing.
 *
 * Straight up ripped from bbPress. :)
 *
 * @since 1.0.0
 *
 * @param array $args WP_Query arguments to override default, dummy query with.
 */
function helppress_reset_post( $args = array() ) {

	global $wp_query, $post;

	if ( isset( $wp_query->post ) ) {
		$dummy = wp_parse_args( $args, array(
			'ID'                    => $wp_query->post->ID,
			'post_status'           => $wp_query->post->post_status,
			'post_author'           => $wp_query->post->post_author,
			'post_parent'           => $wp_query->post->post_parent,
			'post_type'             => $wp_query->post->post_type,
			'post_date'             => $wp_query->post->post_date,
			'post_date_gmt'         => $wp_query->post->post_date_gmt,
			'post_modified'         => $wp_query->post->post_modified,
			'post_modified_gmt'     => $wp_query->post->post_modified_gmt,
			'post_content'          => $wp_query->post->post_content,
			'post_title'            => $wp_query->post->post_title,
			'post_excerpt'          => $wp_query->post->post_excerpt,
			'post_content_filtered' => $wp_query->post->post_content_filtered,
			'post_mime_type'        => $wp_query->post->post_mime_type,
			'post_password'         => $wp_query->post->post_password,
			'post_name'             => $wp_query->post->post_name,
			'guid'                  => $wp_query->post->guid,
			'menu_order'            => $wp_query->post->menu_order,
			'pinged'                => $wp_query->post->pinged,
			'to_ping'               => $wp_query->post->to_ping,
			'ping_status'           => $wp_query->post->ping_status,
			'comment_status'        => $wp_query->post->comment_status,
			'comment_count'         => $wp_query->post->comment_count,
			'filter'                => $wp_query->post->filter,

			'is_404'                => false,
			'is_page'               => false,
			'is_single'             => false,
			'is_archive'            => false,
			'is_tax'                => false,
		) );
	} else {
		$dummy = wp_parse_args( $args, array(
			'ID'                    => -9999,
			'post_status'           => 'publish',
			'post_author'           => 0,
			'post_parent'           => 0,
			'post_type'             => 'page',
			'post_date'             => 0,
			'post_date_gmt'         => 0,
			'post_modified'         => 0,
			'post_modified_gmt'     => 0,
			'post_content'          => '',
			'post_title'            => '',
			'post_excerpt'          => '',
			'post_content_filtered' => '',
			'post_mime_type'        => '',
			'post_password'         => '',
			'post_name'             => '',
			'guid'                  => '',
			'menu_order'            => 0,
			'pinged'                => '',
			'to_ping'               => '',
			'ping_status'           => '',
			'comment_status'        => 'closed',
			'comment_count'         => 0,
			'filter'                => 'raw',

			'is_404'                => false,
			'is_page'               => false,
			'is_single'             => false,
			'is_archive'            => false,
			'is_tax'                => false,
		) );
	}

	if ( empty( $dummy ) ) {
		return;
	}

	$post = new WP_Post( (object) $dummy );

	$wp_query->post       = $post;
	$wp_query->posts      = array( $post );

	$wp_query->post_count = 1;
	$wp_query->is_404     = $dummy['is_404'];
	$wp_query->is_page    = $dummy['is_page'];
	$wp_query->is_single  = $dummy['is_single'];
	$wp_query->is_archive = $dummy['is_archive'];
	$wp_query->is_tax     = $dummy['is_tax'];

	unset( $dummy );

	if ( ! $wp_query->is_404() ) {
		status_header( 200 );
	}

}

/**
 * Prepends a preferred template file in the theme (or child theme) directory to the default theme
 * compatiblity templates.
 *
 * @see helppress_get_compat_templates()
 * @since 1.0.0
 *
 * @param string $preferred Preferred template.
 * @return array Preferred template prepended to the default theme compatiblity templates.
 */
function helppress_get_template( $preferred = null ) {

	$preferred = 'helppress/' . $preferred;
	$compat_templates = helppress_get_compat_templates();

	$templates = $compat_templates;
	array_unshift( $templates, $preferred );

	return $templates;

}

/**
 * Filters default post queries to apply custom sorting and other functionality needed for built-in
 * theme compatibility.
 *
 * Only applies if:
 *
 * - Is *not* admin.
 * - Is main query
 *
 * Makes the following modifications:
 *
 * - Updates `orderby`, `order`, and `posts_per_page` params as configured in admin Settings.
 * - Limits search results on KB searches to `hp_article` post type.
 *
 * @since 1.0.0
 *
 * @param object $query Default WP_Query.
 * @return object Potentially adjusted WP_Query.
 */
function helppress_pre_get_posts( $query ) {

	if ( is_admin() ) {
		return $query;
	}

	if ( ! $query->is_main_query() ) {
		return $query;
	}

	/**
	 * Modifies query to show front page if enabled in settings.
	 *
	 * @since 1.5.0
	 */
	if ( helppress_get_option( 'show_on_front' ) ) {
		$front_page = get_option( 'page_on_front' );

		if ( $front_page && $front_page == $query->get( 'page_id' ) || is_front_page() ) {
			$query->set( 'page_id',   0 );
			$query->set( 'paged',     helppress_page_num() );
			$query->set( 'post_type', 'hp_article' );

			$query->is_archive           = true;
			$query->is_home              = false;
			$query->is_page              = false;
			$query->is_post_type_archive = true;
			$query->is_singular          = false;
		}
	}

	/**
	 * Updates order and ppp params whatever is configured in settings on KB pages.
	 *
	 * @since 1.0.0
	 */
	if ( is_archive() && helppress_is_kb_page() ) {
		$query->set( 'orderby',        helppress_get_option( 'orderby' ) );
		$query->set( 'order',          helppress_get_option( 'order' ) );
		$query->set( 'posts_per_page', helppress_get_option( 'posts_per_page' ) );
	}

	/**
	 * Limits KB search to only articles.
	 *
	 * @since 1.0.0
	 */
	if ( helppress_is_kb_search() ) {
		$query->set( 'post_type',      'hp_article' );
		$query->set( 'posts_per_page', helppress_get_option( 'posts_per_page' ) );
	}

	return $query;

}
add_filter( 'pre_get_posts', 'helppress_pre_get_posts' );

/**
 * Adds additional query vars to WP_Query.
 *
 * @since 1.0.0
 *
 * @param array $vars Default query vars.
 * @return array Extended query vars.
 */
function helppress_query_vars( $vars = [] ) {

	$vars[] = 'hps';

	return $vars;

}
add_action( 'query_vars', 'helppress_query_vars' );

/**
 * Adds custom body classes.
 *
 * @see body_class()
 * @since 1.4.0
 *
 * @param array $classes Default WP body classes.
 * @return array Filtered body classes.
 */
function helppress_body_class( $classes ) {

	if ( helppress_is_kb_page() ) {
		$classes[] = 'helppress';
		$classes[] = sanitize_html_class( 'helppress-' . helppress_get_kb_context() );
	}

	// Mimic the WordPress body classes for page templates to help with theme styling
	if ( helppress_is_kb_page() && helppress_get_option( 'page_template' ) !== 'default' ) {

		$classes[] = 'page-template';

		$template_slug  = helppress_get_option( 'page_template' );
		$template_parts = explode( '/', $template_slug );

		foreach ( $template_parts as $part ) {
			$classes[] = 'page-template-' . sanitize_html_class( str_replace( array( '.', '/' ), '-', basename( $part, '.php' ) ) );
		}

		$classes[] = 'page-template-' . sanitize_html_class( str_replace( '.', '-', $template_slug ) );

	}

	return $classes;

}
add_action( 'body_class', 'helppress_body_class' );
