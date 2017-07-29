<?php

if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'HelpPress_Assets' ) ) {

	class HelpPress_Assets {

		public function __construct() {

			add_action( 'wp_enqueue_scripts', array( $this, 'front_end_assets' ) );

		}

		public function front_end_assets() {

			wp_enqueue_script(
				'jquery-devbridge-autocomplete',
				esc_url( HELPPRESS_URL . '/assets/vendor/jquery.autocomplete.js' ),
				array( 'jquery' )
			);

			wp_enqueue_script(
				'helppress',
				esc_url( HELPPRESS_URL . '/assets/js/helppress.js' ),
				array( 'jquery', 'jquery-devbridge-autocomplete' )
			);

			wp_localize_script( 'helppress', 'hpLocalization', array(
				'adminAjax' => esc_url( admin_url( 'admin-ajax.php' ) ),
			) );

			wp_enqueue_style(
				'helppress-full',
				esc_url( HELPPRESS_URL . '/assets/css/full.css' )
			);

			// wp_enqueue_style(
			// 	'helppress-lite',
			// 	esc_url( HELPPRESS_URL . '/assets/css/lite.css' )
			// );

		}

	}

}

new HelpPress_Assets();
