<?php
/**
 * Plugin Name: HelpPress
 */

if ( ! class_exists( 'HelpPress' ) ) {

	class HelpPress {

		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'defineConstants' ) );
			add_action( 'plugins_loaded', array( $this, 'includes' ) );

		}

		public function defineConstants() {

			$constants = array(
				'HELPPRESS_PATH' => untrailingslashit( plugin_dir_path( __FILE__ ) ),
				'HELPPRESS_URL'  => untrailingslashit( plugin_dir_url( __FILE__ ) ),
			);

			$constants = apply_filters( 'helppress_constants', $constants );

			foreach ( $constants as $constant => $value ) {
				if ( ! defined( $constant ) ) {
					define( $constant, $value );
				}
			}

		}

		public function includes() {

			$includes = array(

				// Vendor
				'/inc/vendor/gamajo/template-loader/class-gamajo-template-loader.php',
				'/inc/vendor/gambitph/titan-framework/titan-framework.php',

				// Classes
				'/inc/classes/class-helppress-breadcrumb.php',
				'/inc/classes/class-helppress-menu-archive-link.php',
				'/inc/classes/class-helppress-post-types.php',
				'/inc/classes/class-helppress-search-autocomplete.php',
				'/inc/classes/class-helppress-taxonomies.php',
				'/inc/classes/class-helppress-template-loader.php',
				'/inc/classes/class-helppress-templates.php',

				// Other
				'/inc/admin.php',
				'/inc/assets.php',
				'/inc/functions.php',
				'/inc/options.php',

			);

			$includes = apply_filters( 'helppress_includes', $includes );

			foreach ( $includes as $file ) {
				include HELPPRESS_PATH . $file;
			}

		}

	}

}

new HelpPress();
