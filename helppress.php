<?php
/**
 * Plugin Name: HelpPress
 */

if ( ! defined( 'HELPPRESS_PATH' ) ) define( 'HELPPRESS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
if ( ! defined( 'HELPPRESS_URL' ) ) define( 'HELPPRESS_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

include HELPPRESS_PATH . '/inc/vendor/gamajo/template-loader/class-gamajo-template-loader.php';
include HELPPRESS_PATH . '/inc/vendor/gambitph/titan-framework/titan-framework.php';

include HELPPRESS_PATH . '/inc/classes/class-helppress-template-loader.php';

include HELPPRESS_PATH . '/inc/admin.php';
include HELPPRESS_PATH . '/inc/assets.php';
include HELPPRESS_PATH . '/inc/functions.php';
include HELPPRESS_PATH . '/inc/options.php';
include HELPPRESS_PATH . '/inc/post-types.php';
include HELPPRESS_PATH . '/inc/shortcodes.php';
include HELPPRESS_PATH . '/inc/taxonomies.php';
include HELPPRESS_PATH . '/inc/templates.php';
include HELPPRESS_PATH . '/inc/search.php';

function helppress_activate() {

	$knowledge_base_page = wp_insert_post( [
		'post_title' => esc_html__( 'Knowledge Base', 'helppress' ),
		'post_content' => '[helppress]',
		'post_status' => 'publish',
		'post_type' => 'page',
	] );

	$knowledge_base_page = 5;

	$titan = TitanFramework::getInstance( 'helppress' );

	// $titan->setOption( 'knowledge_base_page', $knowledge_base_page );

}
register_activation_hook( __FILE__, 'helppress_activate' );
