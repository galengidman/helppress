<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HelpPress_Custom_Content' ) ) {

	class HelpPress_Custom_Content {

		public function __construct() {

			add_filter( 'the_content', array( $this, 'custom_content' ) );
			add_filter( 'the_excerpt', array( $this, 'custom_content' ) );

		}

		public function custom_content( $content ) {

			if ( is_singular( 'helppress_article' ) ) {
				ob_start();
				remove_filter( 'the_content', array( $this, 'custom_content' ) );
				remove_filter( 'the_excerpt', array( $this, 'custom_content' ) );
				helppress_get_template_part( 'parts/content-article' );
				add_filter( 'the_content', array( $this, 'custom_content' ) );
				add_filter( 'the_excerpt', array( $this, 'custom_content' ) );
				$content = ob_get_clean();
			}

			return $content;

		}

	}

}

new HelpPress_Custom_Content();
