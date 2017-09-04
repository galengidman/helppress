<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function helppress_register_categories() {

	$labels = array(
		'name'          => esc_html__( 'Article Categories', 'helppress' ),
		'singular_name' => esc_html__( 'Article Category',   'helppress' ),
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'show_in_menu' => 'edit.php?post_type=helppress_article',
		'hierarchical' => true,
		'rewrite'      => array(
			'slug'       => helppress_get_option( 'category_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'helppress_register_categories_args', $args );

	register_taxonomy( 'helppress_category', 'helppress_article', $args );

}
add_action( 'after_setup_theme', 'helppress_register_categories' );

function helppress_register_tags() {

	$labels = array(
		'name'          => esc_html__( 'Article Tags', 'helppress' ),
		'singular_name' => esc_html__( 'Article Tag',  'helppress' ),
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'show_in_menu' => 'edit.php?post_type=helppress_article',
		'rewrite'      => array(
			'slug'       => helppress_get_option( 'tag_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'helppress_register_tags_args', $args );

	register_taxonomy( 'helppress_tag', 'helppress_article', $args );

}
add_action( 'after_setup_theme', 'helppress_register_tags' );
