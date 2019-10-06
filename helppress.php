<?php
/**
 * Plugin Name: HelpPress
 * Description: A powerful and easy-to-use knowledge base plugin for WordPress, compatible with 99% of themes.
 * Version: 3.0.0
 * Author: Galen Gidman
 * Author URI: https://galengidman.com/
 * License: GPL2+
 * Text Domain: helppress
 */

if (! class_exists('HelpPress_Plugin')) :

final class HelpPress_Plugin {

	protected static $instance;

	public static function instance() {
		if (empty(self::$instance)) {
			self::$instance = new self();

			self::$instance->constants();

			if (! version_compare(PHP_VERSION, HELPPRESS_MIN_PHP, '>=')) {
				add_action('admin_notices', [self::$instance, 'fail_php_version']);
			} elseif (! version_compare(get_bloginfo('version'), HELPPRESS_MIN_WP, '>=')) {
				add_action('admin_notices', [self::$instance, 'fail_wp_version']);
			} else {
				self::$instance->includes();
				add_action('plugins_loaded', [self::$instance, 'load_textdomain']);
			}
		}

		return self::$instance;
	}

	protected function constants() {
		define('HELPPRESS_VERSION', '3.0.0');
		define('HELPPRESS_FILE', __FILE__);
		define('HELPPRESS_PATH', plugin_dir_path(HELPPRESS_FILE));
		define('HELPPRESS_URL', plugin_dir_url(HELPPRESS_FILE));
		define('HELPPRESS_BASENAME', plugin_basename(HELPPRESS_FILE));
		define('HELPPRESS_MIN_PHP', '5.4');
		define('HELPPRESS_MIN_WP', '4.5');
	}

	protected function includes() {
		$includes = apply_filters('helppress_includes', [
			'includes/vendor/cmb2/cmb2/init.php',
			'includes/vendor/gamajo/template-loader/class-gamajo-template-loader.php',
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
			'includes/options-functions.php',
			'includes/post-types.php',
			'includes/install.php',
			'includes/sanitization-functions.php',
			'includes/template-functions.php',
			'includes/upgrade.php',
		]);

		foreach ($includes as $file) {
			include HELPPRESS_PATH . $file;
		}
	}

	public function load_textdomain() {
		load_plugin_textdomain('helppress');
	}

	public function fail_php_version() {
		$message = sprintf(
			esc_html__('HelpPress requires PHP version %s+, plugin is currently NOT ACTIVE.', 'helppress'),
			HELPPRESS_MIN_PHP
		);

		$message = sprintf('<div class="error">%s</div>', wpautop($message));

		echo wp_kses_post($message);
	}

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

function helppress() {
	return HelpPress_Plugin::instance();
}

helppress();
