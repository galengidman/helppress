<?php
/**
 * Plugin Name: HelpPress
 */

if ( ! class_exists( 'HPKB' ) ) {

	class HPKB {

		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'define_constants' ) );
			add_action( 'plugins_loaded', array( $this, 'includes' ) );

		}

		public function define_constants() {

			$constants = array(
				'HPKB_PATH' => untrailingslashit( plugin_dir_path( __FILE__ ) ),
				'HPKB_URL'  => untrailingslashit( plugin_dir_url( __FILE__ ) ),
			);

			$constants = apply_filters( 'hpkb_constants', $constants );

			foreach ( $constants as $constant => $value ) {
				if ( ! defined( $constant ) ) {
					define( $constant, $value );
				}
			}

		}

		public function includes() {

			$includes = array(

				// Vendor
				'/includes/vendor/gamajo/template-loader/class-gamajo-template-loader.php',
				'/includes/vendor/gambitph/titan-framework/titan-framework.php',

				// Classes
				'/includes/class-hpkb-assets.php',
				'/includes/class-hpkb-breadcrumb.php',
				'/includes/class-hpkb-custom-content.php',
				'/includes/class-hpkb-menu-archive-link.php',
				'/includes/class-hpkb-post-types.php',
				'/includes/class-hpkb-search-autocomplete.php',
				'/includes/class-hpkb-taxonomies.php',
				'/includes/class-hpkb-template-loader.php',
				'/includes/class-hpkb-templates.php',

				// Other
				'/includes/admin.php',
				'/includes/functions.php',
				'/includes/options.php',

			);

			$includes = apply_filters( 'hpkb_includes', $includes );

			foreach ( $includes as $file ) {
				include HPKB_PATH . $file;
			}

		}

	}

}

new HPKB();
