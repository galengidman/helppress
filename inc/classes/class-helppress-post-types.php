<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HelpPress_Post_Types' ) ) {

	class HelpPress_Post_Types {

		public function __construct() {

			add_action( 'after_setup_theme', array( $this, 'registerArticles' ) );

		}

		public function registerArticles() {

			$labels = array(
				'name'          => esc_html__( 'Articles',     'helppress' ),
				'singular_name' => esc_html__( 'Article',      'helppress' ),
				'menu_name'     => esc_html__( 'HelpPress',    'helppress' ),
				'all_items'     => esc_html__( 'All Articles', 'helppress' ),
			);

			$args = array(
				'labels'        => $labels,
				'public'        => true,
				'menu_position' => 25,
				'menu_icon'     => 'dashicons-sos',
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

			$args = apply_filters( 'helppress_register_article_args', $args );

			register_post_type( 'helppress_article', $args );

		}

	}

}

new HelpPress_Post_Types();
