<?php
/**
 * Plugin Name: HelpPress
 * Description: A powerful and easy-to-use knowledge base plugin for WordPress, compatible with 99% of themes.
 * Version: 3.1.4
 * Author: Galen Gidman
 * Author URI: https://galengidman.com/
 * License: GPL2+
 * Text Domain: helppress
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Add item to the container.
 *
 * @since 3.1.0
 * @param string $key Key to access item.
 * @param mixed $value Value to add to the container.
 */
function helppress_set($key, $value) {
	$GLOBALS['helppress'][$key] = $value;
}

/**
 * Get item from the container.
 *
 * @since 3.1.0
 *
 * @param string $key Key to access item.
 * @return mixed Item from container.
 */
function helppress_get($key) {
	return $GLOBALS['helppress'][$key];
}

if (! class_exists('HelpPress_Plugin')) :

/**
 * Plugin class
 *
 * @since 2.0.0
 */
final class HelpPress_Plugin {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->constants();

		if (version_compare(PHP_VERSION, HELPPRESS_MIN_PHP, '<')) {
			add_action('admin_notices', [$this, 'fail_php_version']);
		} elseif (version_compare(get_bloginfo('version'), HELPPRESS_MIN_WP, '<')) {
			add_action('admin_notices', [$this, 'fail_wp_version']);
		} else {
			$this->includes();
			add_action('plugins_loaded', [$this, 'load_textdomain']);
		}
	}

	/**
	 * Define constants.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function constants() {
		define('HELPPRESS_VERSION', '3.1.4');
		define('HELPPRESS_FILE', __FILE__);
		define('HELPPRESS_PATH', plugin_dir_path(HELPPRESS_FILE));
		define('HELPPRESS_URL', plugin_dir_url(HELPPRESS_FILE));
		define('HELPPRESS_BASENAME', plugin_basename(HELPPRESS_FILE));
		define('HELPPRESS_MIN_PHP', '5.4');
		define('HELPPRESS_MIN_WP', '4.5');
	}

	/**
	 * Define constants.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function includes() {
		require_once HELPPRESS_PATH . 'includes/vendor/cmb2/cmb2/init.php';
		require_once HELPPRESS_PATH . 'includes/vendor/gamajo/template-loader/class-gamajo-template-loader.php';
		require_once HELPPRESS_PATH . 'includes/vendor/yahnis-elsts/admin-notices/AdminNotice.php';

		require_once HELPPRESS_PATH . 'includes/class-helppress-breadcrumb.php';
		require_once HELPPRESS_PATH . 'includes/class-helppress-demo-content.php';
		require_once HELPPRESS_PATH . 'includes/class-helppress-menu-archive-link.php';
		require_once HELPPRESS_PATH . 'includes/class-helppress-search.php';
		require_once HELPPRESS_PATH . 'includes/class-helppress-settings.php';
		require_once HELPPRESS_PATH . 'includes/class-helppress-template-loader.php';
		require_once HELPPRESS_PATH . 'includes/class-helppress-theme-compat.php';

		require_once HELPPRESS_PATH . 'includes/assets.php';
		require_once HELPPRESS_PATH . 'includes/deprecated-functions.php';
		require_once HELPPRESS_PATH . 'includes/options-functions.php';
		require_once HELPPRESS_PATH . 'includes/post-types.php';
		require_once HELPPRESS_PATH . 'includes/install.php';
		require_once HELPPRESS_PATH . 'includes/sanitization-functions.php';
		require_once HELPPRESS_PATH . 'includes/template-functions.php';
		require_once HELPPRESS_PATH . 'includes/upgrade.php';
	}

	/**
	 * Load textdomain.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain('helppress');
	}

	/**
	 * Check for compatible PHP version.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function fail_php_version() {
		$message = sprintf(
			esc_html__('HelpPress requires PHP version %s+, plugin is currently NOT ACTIVE.', 'helppress'),
			HELPPRESS_MIN_PHP
		);

		$message = sprintf('<div class="error">%s</div>', wpautop($message));

		echo wp_kses_post($message);
	}

	/**
	 * Check for compatible WordPress version.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function fail_wp_version() {
		$message = sprintf(
			esc_html__('HelpPress requires WordPress version %s+, plugin is currently NOT ACTIVE.', 'helppress'),
			HELPPRESS_MIN_WP
		);

		$message = sprintf('<div class="error">%s</div>', wpautop($message));

		echo wp_kses_post($message);
	}

}

endif;

helppress_set('plugin', new HelpPress_Plugin());
