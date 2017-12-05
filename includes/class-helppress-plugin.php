<?php
/**
 * Plugin
 *
 * @package HelpPress
 * @since 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HelpPress_Plugin' ) ) :

/**
 * Main plugin class.
 */
class HelpPress_Plugin {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function __construct() {

		$includes = [

			'includes/vendor/gamajo/template-loader/class-gamajo-template-loader.php',
			'includes/vendor/gambitph/titan-framework/titan-framework.php',
			'includes/vendor/yahnis-elsts/admin-notices/AdminNotice.php',

			'includes/class-helppress-breadcrumb.php',
			'includes/class-helppress-demo-content.php',
			'includes/class-helppress-menu-archive-link.php',
			'includes/class-helppress-search.php',
			'includes/class-helppress-settings.php',
			'includes/class-helppress-template-loader.php',
			'includes/class-helppress-theme-compat.php',

			'includes/formatting.php',
			'includes/options.php',
			'includes/post-types.php',
			'includes/taxonomies.php',
			'includes/template-tags.php',

		];

		$includes = apply_filters( 'helppress_includes', $includes );

		foreach ( $includes as $file ) {
			include HELPPRESS_PATH . $file;
		}

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );

	}

	/**
	 * Enqueues assets.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function enqueue_assets() {

		$min = helppress_is_debug() ? ''  : '.min';

		wp_enqueue_script(
			'jquery-devbridge-autocomplete',
			esc_url( HELPPRESS_URL . "/assets/vendor/jquery.autocomplete{$min}.js" ),
			array( 'jquery' ),
			HELPPRESS_VERSION
		);

		wp_enqueue_script(
			'helppress',
			esc_url( HELPPRESS_URL . "/assets/dist/helppress{$min}.js" ),
			array( 'jquery', 'jquery-devbridge-autocomplete' ),
			HELPPRESS_VERSION
		);

		wp_localize_script( 'helppress', 'helppressL10n', array(
			'adminAjax' => esc_url( admin_url( 'admin-ajax.php' ) ),
		) );

		$disable_css        = apply_filters( 'helppress_disable_css', false );
		$disable_css_option = helppress_get_option( 'disable_css' );

		if ( ! $disable_css && ! $disable_css_option ) {
			wp_enqueue_style(
				'helppress',
				esc_url( HELPPRESS_URL . "/assets/dist/helppress{$min}.css" ),
				array(),
				HELPPRESS_VERSION
			);
		}

	}

}

endif;

new HelpPress_Plugin();
