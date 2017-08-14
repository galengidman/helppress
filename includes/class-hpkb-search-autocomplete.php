<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HPKB_Search_Autocomplete' ) ) {

	class HPKB_Search_Autocomplete {

		protected $action_name = 'hpkb_autocomplete_suggestions';

		public function __construct() {

			add_action( "wp_ajax_{$this->action_name}",        array( $this, 'suggestions' ) );
			add_action( "wp_ajax_nopriv_{$this->action_name}", array( $this, 'suggestions' ) );

		}

		public function suggestions() {

			$articles = new WP_Query( array(
				's'             => $_REQUEST['query'],
				'post_type'     => 'hpkb_article',
				'fields'        => 'ids',
				'no_found_rows' => true,
			) );

			$suggestions = array( 'suggestions' => array() );

			foreach ( $articles->posts as $article_id ) {
				$suggestions['suggestions'][] = array(
					'value' => get_the_title( $article_id ),
					'data'  => esc_url( get_permalink( $article_id ) ),
				);
			}

			echo json_encode( $suggestions );

			exit;

		}

	}

}

new HPKB_Search_Autocomplete();
