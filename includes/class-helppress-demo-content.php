<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HelpPress_Demo_Content' ) ) {

class HelpPress_Demo_Content {

	protected $categories = array(
		esc_html__( 'Getting Started', 'helppress' ),
		esc_html__( 'Tutorials',       'helppress' ),
		esc_html__( 'FAQs',            'helppress' ),
		esc_html__( 'Help Files',      'helppress' ),
		esc_html__( 'Developers',      'helppress' ),
		esc_html__( 'Integrations',    'helppress' ),
	);

	public function __construct() {

	}

	public function register_settings() {

	}

}

}

new HelpPress_Demo_Content();
