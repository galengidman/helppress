<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HelpPress_Breadcrumb' ) ) {

	class HelpPress_Breadcrumb {

		public function __construct() {

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
				$trail[] = array(
					'label' => get_the_title(),
					'url'   => get_permalink(),
				);
			}

			if ( is_tax( array( 'helppress_article_category', 'helppress_article_tag' ) ) ) {
				$qo        = get_queried_object();
				$tree      = array( $qo->term_id );
				$ancestors = get_ancestors( $qo->term_id, $qo->term_slug, 'taxonomy' );

				if ( $ancestors ) {
					$tree = array_merge( $ancestors, $tree );
				}

				foreach ( $tree as $term_id ) {
					$term = get_term( $term_id );

					$trail[] = array(
						'label' => $term->name,
						'url'   => get_term_link( $term ),
					);
				}
			}

			elseif ( is_search() ) {
				$trail[] = array(
					'label' => sprintf( __( 'Results for <em>%s</em>', 'helppress' ), get_search_query() ),
					'url'   => add_query_arg( 's', $_GET['S'], home_url() ),
				);
			}

			var_dump( $trail );

		}

	}

}

// Search results:
// Home > KB > Results for 'term'
//
// Index
// Home > KB
//
// Article
// Home > KB > Cat[0] > Article
//
// Tax
// Home > KB > Tax
