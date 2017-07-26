<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HelpPress_Taxonomies' ) ) {

	class HelpPress_Taxonomies {

		public function __construct() {

			add_action( 'after_setup_theme', array( $this, 'registerCategories' ) );
			add_action( 'after_setup_theme', array( $this, 'registerTags' ) );

		}

		public function registerCategories() {

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

			$args = apply_filters( 'helppress_register_category_args', $args );

			register_taxonomy( 'helppress_article_category', 'helppress_article', $args );

		}

		public function registerTags() {

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

			$args = apply_filters( 'helppress_register_tag_args', $args );

			register_taxonomy( 'helppress_article_tag', 'helppress_article', $args );

		}

	}

}

new HelpPress_Taxonomies();
