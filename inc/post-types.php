<?php
/**
 * Post Types
 */

/**
 * Registers the article post type.
 */
function wpkb_register_article() {

	$labels = array(
		'name' => esc_html__( 'Articles', 'wpkb' ),
		'singular_name' => esc_html__( 'Article', 'wpkb' ),
		'menu_name' => esc_html__( 'HelpPress', 'wpkb' ),
		'all_items' => esc_html__( 'All Articles', 'wpkb' ),
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
			'slug' => wpkb_get_option( 'article_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'wpkb_register_article_args', $args );

	register_post_type( 'wpkb_article', $args );

}
add_action( 'after_setup_theme', 'wpkb_register_article' );
