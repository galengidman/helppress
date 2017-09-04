<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HelpPress_Template_Loader' ) ) {

class HelpPress_Template_Loader extends Gamajo_Template_Loader {

	protected $filter_prefix = 'helppress';

	protected $theme_template_directory = 'helppress';

	protected $plugin_directory = HELPPRESS_PATH;

}

}
