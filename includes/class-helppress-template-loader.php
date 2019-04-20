<?php
/**
 * Template Loader
 *
 * @package HelpPress
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('HelpPress_Template_Loader')) :

/**
 * Template loader class.
 *
 * @since 1.0.0
 */
class HelpPress_Template_Loader extends Gamajo_Template_Loader {

	/**
	 * apply_filters() prefix to use throughout.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @var string
	 */
	protected $filter_prefix = 'helppress';

	/**
	 * Directory to look for override templates in, relative to active theme or child theme.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @var string
	 */
	protected $theme_template_directory = 'helppress';

	/**
	 * Plugin directory.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @var string
	 */
	protected $plugin_directory = HELPPRESS_PATH;

}

endif;
