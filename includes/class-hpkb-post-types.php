<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HPKB_Post_Types' ) ) {

	class HPKB_Post_Types {

		public function __construct() {

			add_action( 'after_setup_theme', array( $this, 'register_articles' ) );

		}

		public function register_articles() {

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
					'slug'       => hpkb_get_option( 'knowledge_base_slug' ),
					'with_front' => false,
				),
			);

			$args = apply_filters( 'hpkb_register_article_args', $args );

			register_post_type( 'hpkb_article', $args );

		}

	}

}

new HPKB_Post_Types();
