<?php
/**
 * Taxonomies
 */

/**
 * Register Article Category taxonomy.
 */
function wpkb_register_category() {

	$labels = array(
		'name' => esc_html__( 'Article Categories', 'wpkb' ),
		'singular_name' => esc_html__( 'Article Category', 'wpkb' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_in_menu' => 'edit.php?post_type=wpkb_article',
		'hierarchical' => true,
		'rewrite' => array(
			'slug' => wpkb_get_option( 'category_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'wpkb_register_category_args', $args );

	register_taxonomy( 'wpkb_article_category', 'wpkb_article', $args );

}
add_action( 'after_setup_theme', 'wpkb_register_category' );

/**
 * Register Article Tag taxonomy.
 */
function wpkb_register_tag() {

	if ( ! wpkb_get_option( 'enable_tags' ) ) {
		return;
	}

	$labels = array(
		'name' => esc_html__( 'Article Tags', 'wpkb' ),
		'singular_name' => esc_html__( 'Article Tag', 'wpkb' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_in_menu' => 'edit.php?post_type=wpkb_article',
		'rewrite' => array(
			'slug' => wpkb_get_option( 'tag_slug' ),
			'with_front' => false,
		),
	);

	$args = apply_filters( 'wpkb_register_tag_args', $args );

	register_taxonomy( 'wpkb_article_tag', 'wpkb_article', $args );

}
add_action( 'after_setup_theme', 'wpkb_register_tag' );
