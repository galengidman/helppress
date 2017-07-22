<?php

if ( ! defined( 'ABSPATH' ) ) exit;

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
