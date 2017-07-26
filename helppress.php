<?php
/**
 * Plugin Name: HelpPress
 */

if ( ! defined( 'HELPPRESS_PATH' ) ) define( 'HELPPRESS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
if ( ! defined( 'HELPPRESS_URL' ) )  define( 'HELPPRESS_URL',  untrailingslashit( plugin_dir_url( __FILE__ ) ) );

include HELPPRESS_PATH . '/inc/vendor/gamajo/template-loader/class-gamajo-template-loader.php';
include HELPPRESS_PATH . '/inc/vendor/gambitph/titan-framework/titan-framework.php';

include HELPPRESS_PATH . '/inc/classes/class-helppress-template-loader.php';
include HELPPRESS_PATH . '/inc/classes/class-helppress-search-autocomplete.php';
include HELPPRESS_PATH . '/inc/classes/class-helppress-menu-archive-link.php';
include HELPPRESS_PATH . '/inc/classes/class-helppress-post-types.php';
include HELPPRESS_PATH . '/inc/classes/class-helppress-taxonomies.php';

include HELPPRESS_PATH . '/inc/admin.php';
include HELPPRESS_PATH . '/inc/assets.php';
include HELPPRESS_PATH . '/inc/functions.php';
include HELPPRESS_PATH . '/inc/options.php';
include HELPPRESS_PATH . '/inc/templates.php';
