<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function helppress_register_articles() {

	$labels = array(
		'name'                  => esc_html__( 'Articles',                   'helppress' ),
		'singular_name'         => esc_html__( 'Article',                    'helppress' ),
		'add_new'               => esc_html__( 'Add New',                    'helppress' ),
		'add_new_item'          => esc_html__( 'Add New Article',            'helppress' ),
		'edit_item'             => esc_html__( 'Edit Article',               'helppress' ),
		'new_item'              => esc_html__( 'New Article',                'helppress' ),
		'view_item'             => esc_html__( 'View Article',               'helppress' ),
		'view_items'            => esc_html__( 'View Articles',              'helppress' ),
		'search_items'          => esc_html__( 'Search Articles',            'helppress' ),
		'not_found'             => esc_html__( 'No articles found',          'helppress' ),
		'not_found_in_trash'    => esc_html__( 'No articles found in Trash', 'helppress' ),
		'parent_item_colon'     => esc_html__( 'Parent Article:',            'helppress' ),
		'all_items'             => esc_html__( 'All Articles',               'helppress' ),
		'insert_into_item'      => esc_html__( 'Insert into article',        'helppress' ),
		'uploaded_to_this_item' => esc_html__( 'Uploaded to this article',   'helppress' ),
		'menu_name'             => esc_html__( 'HelpPress',                  'helppress' ),
	);

	$menu_icon = file_get_contents( HELPPRESS_PATH . '/assets/img/menu-icon.svg' );

	$args = array(
		'labels'        => $labels,
		'public'        => true,
		'menu_position' => 25,
		'menu_icon'     => 'data:image/svg+xml;base64,' . base64_encode( $menu_icon ),
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
			'slug'       => helppress_get_option( 'knowledge_base_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'helppress_register_articles_args', $args );

	register_post_type( 'hp_article', $args );

}
add_action( 'init', 'helppress_register_articles' );

function helppress_article_post_formats() {

	$screen = get_current_screen();

	if ( $screen->post_type === 'hp_article' ) {
		$post_formats = array( 'gallery', 'link', 'image', 'video', 'audio' );
		$post_formats = apply_filters( 'helppress_article_post_formats', $post_formats );
		add_theme_support( 'post-formats', $post_formats );
	}

}
add_action( 'load-post.php',     'helppress_article_post_formats' );
add_action( 'load-post-new.php', 'helppress_article_post_formats' );
