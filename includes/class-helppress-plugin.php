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
		$this->include_files();
	}

	/**
	 * Includes plugin files.
	 *
	 * @access protected
	 * @since 2.0.0
	 */
	protected function include_files() {
		$includes = [
			'includes/vendor/cmb2/cmb2/init.php',
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

			'includes/assets.php',
			'includes/deprecated-functions.php',
			'includes/install.php',
			'includes/options-functions.php',
			'includes/post-types.php',
			'includes/sanitization-functions.php',
			'includes/template-functions.php',
			'includes/upgrade.php',
		];

		$includes = apply_filters( 'helppress_includes', $includes );

		foreach ( $includes as $file ) {
			include HELPPRESS_PATH . $file;
		}
	}

}

endif;

new HelpPress_Plugin();
