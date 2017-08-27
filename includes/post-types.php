<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hpkb_register_articles() {

	$labels = array(
		'name'          => esc_html__( 'Articles',     'hpkb' ),
		'singular_name' => esc_html__( 'Article',      'hpkb' ),
		'menu_name'     => esc_html__( 'HelpPress',    'hpkb' ),
		'all_items'     => esc_html__( 'All Articles', 'hpkb' ),
	);

	$args = array(
		'labels'        => $labels,
		'public'        => true,
		'menu_position' => 25,
		'menu_icon'     => 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( HPKB_PATH . '/assets/img/menu-icon.svg' ) ),
		'supports'      => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'comments',
			'revisions',
			'post-formats',
		),
		'has_archive'   => true,
		'rewrite'       => array(
			'slug'       => hpkb_get_option( 'knowledge_base_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'hpkb_register_articles_args', $args );

	register_post_type( 'hpkb_article', $args );

}
add_action( 'after_setup_theme', 'hpkb_register_articles' );
