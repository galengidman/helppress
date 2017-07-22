<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_register_category() {

	$labels = array(
		'name' => esc_html__( 'Article Categories', 'helppress' ),
		'singular_name' => esc_html__( 'Article Category', 'helppress' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_in_menu' => 'edit.php?post_type=helppress_article',
		'hierarchical' => true,
		'rewrite' => array(
			'slug' => helppress_get_option( 'category_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'helppress_register_category_args', $args );

	register_taxonomy( 'helppress_article_category', 'helppress_article', $args );

}
add_action( 'after_setup_theme', 'helppress_register_category' );

function helppress_register_tag() {

	if ( ! helppress_get_option( 'enable_tags' ) ) {
		return;
	}

	$labels = array(
		'name' => esc_html__( 'Article Tags', 'helppress' ),
		'singular_name' => esc_html__( 'Article Tag', 'helppress' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_in_menu' => 'edit.php?post_type=helppress_article',
		'rewrite' => array(
			'slug' => helppress_get_option( 'tag_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'helppress_register_tag_args', $args );

	register_taxonomy( 'helppress_article_tag', 'helppress_article', $args );

}
add_action( 'after_setup_theme', 'helppress_register_tag' );
