<?php
/**
 * Post Types
 *
 * @package HelpPress
 * @since 3.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Register post types.
 *
 * @since 3.0.0
 */
function helppress_register_post_types() {
	register_post_type(
		'hp_article',
		apply_filters('helppress_register_articles_args', [
			'labels' => [
				'name' => esc_html__('Articles', 'helppress'),
				'singular_name' => esc_html__('Article', 'helppress'),
				'add_new' => esc_html__('Add New', 'helppress'),
				'add_new_item' => esc_html__('Add New Article', 'helppress'),
				'edit_item' => esc_html__('Edit Article', 'helppress'),
				'new_item' => esc_html__('New Article', 'helppress'),
				'view_item' => esc_html__('View Article', 'helppress'),
				'view_items' => esc_html__('View Articles', 'helppress'),
				'search_items' => esc_html__('Search Articles', 'helppress'),
				'not_found' => esc_html__('No articles found', 'helppress'),
				'not_found_in_trash' => esc_html__('No articles found in Trash', 'helppress'),
				'parent_item_colon' => esc_html__('Parent Article:', 'helppress'),
				'all_items' => esc_html__('All Articles', 'helppress'),
				'insert_into_item' => esc_html__('Insert into article', 'helppress'),
				'uploaded_to_this_item' => esc_html__('Uploaded to this article', 'helppress'),
				'menu_name' => esc_html__('HelpPress', 'helppress'),
			],
			'public' => true,
			'menu_position' => 25,
			'menu_icon' => 'dashicons-sos',
			'supports' => [
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'comments',
				'revisions',
				'post-formats',
			],
			'has_archive' => true,
			'rewrite' => [
				'slug' => helppress_get_option('knowledge_base_slug'),
				'with_front' => false,
			],
			'show_in_rest' => true,
		])
	);
}
add_action('init', 'helppress_register_post_types');

/**
 * Register taxonomies.
 *
 * @version 3.0.0
 */
function helppress_register_taxonomies() {
	register_taxonomy(
		'hp_category',
		'hp_article',
		apply_filters('helppress_register_categories_args', [
			'labels' => [
				'name' => esc_html__('Article Categories', 'helppress'),
				'singular_name' => esc_html__('Article Category', 'helppress'),
			],
			'public' => true,
			'show_in_menu' => 'edit.php?post_type=hp_article',
			'show_in_rest' => true,
			'show_admin_column' => true,
			'hierarchical' => true,
			'rewrite' => [
				'slug' => helppress_get_option('category_slug'),
				'with_front' => false,
			],
		]
	));

	register_taxonomy(
		'hp_tag',
		'hp_article',
		apply_filters('helppress_register_tags_args', [
			'labels' => [
				'name' => esc_html__('Article Tags', 'helppress'),
				'singular_name' => esc_html__('Article Tag', 'helppress'),
			],
			'public' => true,
			'show_in_menu' => 'edit.php?post_type=hp_article',
			'show_in_rest' => true,
			'show_admin_column' => true,
			'rewrite' => [
				'slug' => helppress_get_option('tag_slug'),
				'with_front' => false,
			],
		])
	);
}
add_action('init', 'helppress_register_taxonomies');

/**
 * Returns allowed `hp_article` post types.
 *
 * @since 2.0.0
 *
 * @return array Allowed post types.
 */
function helppress_get_article_post_formats() {
	return apply_filters('helppress_article_post_formats', [
		'gallery',
		'link',
		'image',
		'video',
		'audio',
	]);
}

/**
 * Adjusts the allowed post formats for articles.
 *
 * @since 2.0.0
 */
function helppress_add_article_post_formats_support() {
	$screen = get_current_screen();

	if ('hp_article' === $screen->post_type) {
		add_theme_support('post-formats', helppress_get_article_post_formats());
	}
}
add_action('load-post.php', 'helppress_add_article_post_formats_support');
add_action('load-post-new.php', 'helppress_add_article_post_formats_support');
