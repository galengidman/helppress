<?php
/**
 * Plugin Name: Knowledge Base
 */

if ( ! defined( 'WPKB_PATH' ) ) define( 'WPKB_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
if ( ! defined( 'WPKB_URL' ) ) define( 'WPKB_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

include WPKB_PATH . 'inc/vendor/gambitph/titan-framework/titan-framework.php';

include WPKB_PATH . 'inc/activate.php';
include WPKB_PATH . 'inc/admin.php';
include WPKB_PATH . 'inc/api.php';
include WPKB_PATH . 'inc/assets.php';
include WPKB_PATH . 'inc/options.php';
include WPKB_PATH . 'inc/post-types.php';
include WPKB_PATH . 'inc/shortcodes.php';
include WPKB_PATH . 'inc/taxonomies.php';
include WPKB_PATH . 'inc/templates.php';
