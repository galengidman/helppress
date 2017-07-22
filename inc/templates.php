<?php

if ( ! defined( 'ABSPATH' ) ) exit;

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

function helppress_override_template( $template = '' ) {

	if ( is_tax( 'helppress_article_category' ) ) {
		helppress_reset_post( array(
			'ID'             => 0,
			'post_author'    => 0,
			'post_date'      => 0,
			'post_content'   => helppress_buffer_template_part( 'content', 'category' ),
			'post_type'      => '',
			'post_title'     => single_term_title( '', false ),
			'is_archive'     => false,
			'comment_status' => 'closed'
		) );

		$template = trailingslashit( get_template_directory() ) . 'page.php';
	}

	return $template;

}
add_action( 'template_include', 'helppress_override_template' );

function helppress_get_theme_templates_path() {

	return trailingslashit( get_template_directory() ) . 'helppress-templates';

}

function helppress_get_plugin_templates_path() {

	return trailingslashit( HELPPRESS_PATH ) . 'templates';

}

function helppress_buffer_template_part( $slug, $name = null ) {

	ob_start();

	helppress_get_template_part( $slug, $name );

	return ob_get_clean();

}

function helppress_get_template_part( $slug, $name = null ) {

	$templates = new HelpPress_Template_Loader;

	$templates->get_template_part( $slug, $name );

}
