<?php
/**
 * Plugin Name: HelpPress
 */

if ( ! class_exists( 'HelpPress' ) ) {

	class HelpPress {

		public function __construct() {

			add_action( 'plugins_loaded', array( $this, 'define_constants' ) );
			add_action( 'plugins_loaded', array( $this, 'includes' ) );

		}

		public function define_constants() {

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
				'/includes/vendor/gamajo/template-loader/class-gamajo-template-loader.php',
				'/includes/vendor/gambitph/titan-framework/titan-framework.php',

				// Classes
				'/includes/class-helppress-assets.php',
				'/includes/class-helppress-breadcrumb.php',
				'/includes/class-helppress-menu-archive-link.php',
				'/includes/class-helppress-post-types.php',
				'/includes/class-helppress-search-autocomplete.php',
				'/includes/class-helppress-taxonomies.php',
				'/includes/class-helppress-template-loader.php',
				'/includes/class-helppress-templates.php',

				// Other
				'/includes/admin.php',
				'/includes/assets.php',
				'/includes/functions.php',
				'/includes/options.php',

			);

			$includes = apply_filters( 'helppress_includes', $includes );

			foreach ( $includes as $file ) {
				include HELPPRESS_PATH . $file;
			}

		}

	}

}

new HelpPress();

function asdf( $content ) {

	if ( is_singular( 'helppress_article' ) ) {
		ob_start();
		remove_filter( 'the_content', 'asdf' );
		helppress_get_template_part( 'partials/helppress-content-article' );
		add_filter( 'the_content', 'asdf' );
		$content = ob_get_clean();
	}

	return $content;

}
add_filter( 'the_content', 'asdf' );
