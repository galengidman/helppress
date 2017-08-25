<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HPKB_Assets' ) ) {

	class HPKB_Assets {

		public function __construct() {

			add_action( 'wp_enqueue_scripts', array( $this, 'front_end_assets' ) );

		}

		public function front_end_assets() {

			wp_enqueue_script(
				'jquery-devbridge-autocomplete',
				esc_url( HPKB_URL . '/assets/vendor/jquery.autocomplete.js' ),
				array( 'jquery' )
			);

			wp_enqueue_script(
				'hpkb',
				esc_url( HPKB_URL . '/assets/js/helppress.js' ),
				array( 'jquery', 'jquery-devbridge-autocomplete' )
			);

			wp_localize_script( 'hpkb', 'hpkb_l10n', array(
				'admin_ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
			) );

			wp_enqueue_style(
				'hpkb',
				esc_url( HPKB_URL . '/assets/css/helppress.css' )
			);

		}

	}

}

new HPKB_Assets();
