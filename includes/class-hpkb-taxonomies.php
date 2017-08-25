<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HPKB_Taxonomies' ) ) {

	class HPKB_Taxonomies {

		public function __construct() {

			add_action( 'after_setup_theme', array( $this, 'register_categories' ) );
			add_action( 'after_setup_theme', array( $this, 'register_tags' ) );

		}

		public function register_categories() {

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

			$args = apply_filters( 'hpkb_register_category_args', $args );

			register_taxonomy( 'hpkb_category', 'hpkb_article', $args );

		}

		public function register_tags() {

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

			$args = apply_filters( 'hpkb_register_tag_args', $args );

			register_taxonomy( 'hpkb_tag', 'hpkb_article', $args );

		}

	}

}

new HPKB_Taxonomies();
