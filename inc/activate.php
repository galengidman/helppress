<?php

function wpkb_activate() {

	$knowledge_base_page = wp_insert_post( [
		'post_title' => esc_html__( 'Knowledge Base', 'wpkb' ),
		'post_content' => '[wpkb]',
		'post_status' => 'publish',
		'post_type' => 'page',
	] );

	$knowledge_base_page = 5;

	$titan = TitanFramework::getInstance( 'wpkb' );

	// $titan->setOption( 'knowledge_base_page', $knowledge_base_page );

}
register_activation_hook( __FILE__, 'wpkb_activate' );
