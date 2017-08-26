<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HPKB_Custom_Content' ) ) {

class HPKB_Custom_Content {

	public function __construct() {

		add_filter( 'the_content', array( $this, 'custom_content' ) );
		add_filter( 'the_excerpt', array( $this, 'custom_content' ) );

	}

	public function custom_content( $content ) {

		if ( is_singular( 'hpkb_article' ) ) {
			ob_start();
			remove_filter( 'the_content', array( $this, 'custom_content' ) );
			remove_filter( 'the_excerpt', array( $this, 'custom_content' ) );
			hpkb_get_template_part( 'parts/hpkb-content-article' );
			add_filter( 'the_content', array( $this, 'custom_content' ) );
			add_filter( 'the_excerpt', array( $this, 'custom_content' ) );
			$content = ob_get_clean();
		}

		return $content;

	}

}

}

new HPKB_Custom_Content();
