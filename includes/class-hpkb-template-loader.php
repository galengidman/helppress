<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HPKB_Template_Loader' ) ) {

	class HPKB_Template_Loader extends Gamajo_Template_Loader {

		protected $filter_prefix = 'hpkb';

		protected $theme_template_directory = 'helppress';

		protected $plugin_directory = HPKB_PATH;

	}

}
