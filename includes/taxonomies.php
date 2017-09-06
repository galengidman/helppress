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
		'show_in_menu' => 'edit.php?post_type=hp_article',
		'hierarchical' => true,
		'rewrite'      => array(
			'slug'       => helppress_get_option( 'category_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'helppress_register_categories_args', $args );

	register_taxonomy( 'hp_category', 'hp_article', $args );

}
add_action( 'init', 'helppress_register_categories' );

function helppress_register_tags() {

	$labels = array(
		'name'          => esc_html__( 'Article Tags', 'helppress' ),
		'singular_name' => esc_html__( 'Article Tag',  'helppress' ),
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'show_in_menu' => 'edit.php?post_type=hp_article',
		'rewrite'      => array(
			'slug'       => helppress_get_option( 'tag_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'helppress_register_tags_args', $args );

	register_taxonomy( 'hp_tag', 'hp_article', $args );

}
add_action( 'init', 'helppress_register_tags' );
