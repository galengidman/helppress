<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hpkb_register_categories() {

	$labels = array(
		'name'          => esc_html__( 'Article Categories', 'hpkb' ),
		'singular_name' => esc_html__( 'Article Category',   'hpkb' ),
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'show_in_menu' => 'edit.php?post_type=hpkb_article',
		'hierarchical' => true,
		'rewrite'      => array(
			'slug'       => hpkb_get_option( 'category_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'hpkb_register_categories_args', $args );

	register_taxonomy( 'hpkb_category', 'hpkb_article', $args );

}
add_action( 'after_setup_theme', 'hpkb_register_categories' );

function hpkb_register_tags() {

	$labels = array(
		'name'          => esc_html__( 'Article Tags', 'hpkb' ),
		'singular_name' => esc_html__( 'Article Tag',  'hpkb' ),
	);

	$args = array(
		'labels'       => $labels,
		'public'       => true,
		'show_in_menu' => 'edit.php?post_type=hpkb_article',
		'rewrite'      => array(
			'slug'       => hpkb_get_option( 'tag_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'hpkb_register_tags_args', $args );

	register_taxonomy( 'hpkb_tag', 'hpkb_article', $args );

}
add_action( 'after_setup_theme', 'hpkb_register_tags' );
