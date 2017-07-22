<?php
/**
 * Post Types
 */

/**
 * Registers the article post type.
 */
function helppress_register_article() {

	$labels = array(
		'name' => esc_html__( 'Articles', 'helppress' ),
		'singular_name' => esc_html__( 'Article', 'helppress' ),
		'menu_name' => esc_html__( 'HelpPress', 'helppress' ),
		'all_items' => esc_html__( 'All Articles', 'helppress' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'menu_position' => 25,
		'menu_icon' => 'dashicons-schedule',
		'supports' => array(
			'title',
			'editor',
			'author',
			'thumbnail',
			'excerpt',
			'comments',
			'revisions',
		),
		'rewrite' => array(
			'slug' => helppress_get_option( 'article_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'helppress_register_article_args', $args );

	register_post_type( 'helppress_article', $args );

}
add_action( 'after_setup_theme', 'helppress_register_article' );
