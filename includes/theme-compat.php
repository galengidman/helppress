<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hpkb_content( $content ) {

	if ( hpkb_is_kb_article() ) {
		ob_start();
		remove_filter( 'the_content', 'hpkb_content' );
		remove_filter( 'the_excerpt', 'hpkb_content' );
		hpkb_get_template_part( 'parts/hpkb-content-article' );
		add_filter( 'the_content', 'hpkb_content' );
		add_filter( 'the_excerpt', 'hpkb_content' );
		$content = ob_get_clean();
	}

	return $content;

}
add_filter( 'the_content', 'hpkb_content' );
add_filter( 'the_excerpt', 'hpkb_content' );

function hpkb_document_title( $title_parts ) {

	if ( hpkb_is_kb_archive() ) {
		$title_parts['title'] = hpkb_get_option( 'title' );
	}

	elseif ( hpkb_is_kb_category() || hpkb_is_kb_tag() ) {
		$title_parts['title'] = single_term_title( '', false );
	}

	return $title_parts;
}
add_filter( 'document_title_parts', 'hpkb_document_title' );

function hpkb_template_include( $template ) {

	if ( hpkb_is_kb_article() ) {
		$custom_template = hpkb_get_template( 'hpkb-article.php' );
	}

	elseif ( hpkb_is_kb_archive() ) {
		remove_all_filters( 'the_content' );

		hpkb_reset_post( array(
			'post_title'   => hpkb_get_option( 'title' ),
			'post_content' => hpkb_buffer_template_part( 'parts/hpkb-content-archive' ),
		) );

		$custom_template = hpkb_get_template( 'hpkb-archive.php' );
	}

	elseif ( hpkb_is_kb_category() ) {
		remove_all_filters( 'the_content' );

		hpkb_reset_post( array(
			'post_title'   => single_term_title( '', false ),
			'post_content' => hpkb_buffer_template_part( 'parts/hpkb-content-category' ),
			'is_archive'   => true,
			'is_tax'       => true,
		) );

		$custom_template = hpkb_get_template( 'hpkb-category.php' );
	}

	elseif ( hpkb_is_kb_tag() ) {
		remove_all_filters( 'the_content' );

		hpkb_reset_post( array(
			'post_title'   => single_term_title( '', false ),
			'post_content' => hpkb_buffer_template_part( 'parts/hpkb-content-tag' ),
			'is_archive'   => true,
			'is_tax'       => true,
		) );

		$custom_template = hpkb_get_template( 'hpkb-tag.php' );
	}

	elseif ( hpkb_is_kb_search() ) {
		remove_all_filters( 'the_content' );

		hpkb_reset_post( array(
			'post_title'   => sprintf(
				esc_html__( 'Search results: &ldquo;%s&rdquo;' ),
				get_search_query()
			),
			'post_content' => hpkb_buffer_template_part( 'parts/hpkb-content-search' ),
		) );

		$custom_template = hpkb_get_template( 'hpkb-search.php' );
	}

	if ( isset( $custom_template ) ) {
		$template = locate_template( $custom_template );
	}

	return $template;

}
add_action( 'template_include', 'hpkb_template_include' );

function hpkb_get_compat_templates() {

	$templates = array(
		'helppress.php',
		'page.php',
		'single.php',
		'index.php',
	);

	return apply_filters( 'hpkb_get_compat_templates', $templates );

}

function hpkb_reset_post( $args = array() ) {

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

function hpkb_get_template( $preferred = null ) {

	$preferred = 'helppress/' . $preferred;
	$compat_templates = hpkb_get_compat_templates();

	$templates = $compat_templates;
	array_unshift( $templates, $preferred );

	return $templates;

}

function hpkb_pre_get_posts( $query ) {

	if ( is_admin() ) {
		return $query;
	}

	if (
		$query->is_main_query()
		&& (
			hpkb_is_kb_archive()
			|| hpkb_is_kb_category()
			|| hpkb_is_kb_tag()
			|| hpkb_is_kb_search()
		) ) {
		$query->set( 'orderby',        hpkb_get_option( 'orderby' ) );
		$query->set( 'order',          hpkb_get_option( 'order' ) );
		$query->set( 'posts_per_page', hpkb_get_option( 'posts_per_page' ) );
	}

	return $query;

}
add_filter( 'pre_get_posts', 'hpkb_pre_get_posts' );

function hpkb_query_vars( $vars = [] ) {

	$vars[] = 'hpkb-search';

	return $vars;

}
add_action( 'query_vars', 'hpkb_query_vars' );
