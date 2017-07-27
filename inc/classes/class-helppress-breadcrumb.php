<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HelpPress_Breadcrumb' ) ) {

	class HelpPress_Breadcrumb {

		public function get_trail() {

			$trail = array();

			$trail[] = array(
				'label' => esc_html__( 'Home', 'helppress' ),
				'url'   => home_url( '/' ),
			);

			$trail[] = array(
				'label' => esc_html__( 'Knowledge Base', 'helppress' ),
				'url'   => helppress_get_knowledge_base_url(),
			);

			if ( is_singular( 'helppress_article' ) ) {
				$article_categories = wp_get_post_terms( get_the_id(), 'helppress_article_category', array( 'fields' => 'ids' ) );
				if ( $article_categories ) {
					$trail = array_merge( $trail, $this->build_tax_tree( $article_categories[0] ) );
				}

				$trail[] = array(
					'label' => get_the_title(),
					'url'   => get_permalink(),
				);
			}

			if ( is_tax( array( 'helppress_article_category', 'helppress_article_tag' ) ) ) {
				$trail = array_merge( $trail, $this->build_tax_tree( get_queried_object_id() ) );
			}

			elseif ( is_search() ) {
				$trail[] = array(
					'label' => get_search_query(),
					'url'   => get_search_link(),
				);
			}

			return $trail;

		}

		public function build_tax_tree( $term_id = null ) {

			$trail = [];

			if ( term_exists( $term_id ) ) {

				$term      = get_term( $term_id );
				$tree      = array( $term->term_id );
				$ancestors = get_ancestors( $term->term_id, $term->term_slug, 'taxonomy' );

				if ( $ancestors ) {
					$tree = array_merge( $ancestors, $tree );

					foreach ( $tree as $term_id ) {
						$term = get_term( $term_id );

						$trail[] = array(
							'label' => $term->name,
							'url'   => get_term_link( $term ),
						);
					}
				}

			}

			return $trail;

		}

	}

}
