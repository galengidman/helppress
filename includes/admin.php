<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function helppress_admin_panel() {

	$titan = TitanFramework::getInstance( 'helppress' );

	// ------------------------------------------------------------------------
	// ADMIN PANEL
	// ------------------------------------------------------------------------

	$admin_panel = $titan->createAdminPanel( array(
		'id'     => 'helppress',
		'name'   => esc_html__( 'Settings', 'helppress' ),
		'parent' => 'edit.php?post_type=helppress_article',
	) );

	$admin_panel->createOption( array(
		'type' => 'save',
	) );

	// ------------------------------------------------------------------------
	// TAB - GENERAL
	// ------------------------------------------------------------------------

	$tab_general = $admin_panel->createTab( array(
		'name' => esc_html__( 'General', 'helppress' ),
	) );

	// Knowledge Base URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'knowledge_base_slug',
		'name'               => esc_html__( 'Knowledge Base URL slug', 'helppress' ),
		'desc'               => sprintf( __( 'The URL slug of the Knowledge Base page. <code>%s</code>', 'helppress' ), home_url( '/' ) . '<ins>' . helppress_get_option( 'knowledge_base_slug' ) . '</ins>/' ),
		'default'            => helppress_get_option_default( 'knowledge_base_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
	) );

	// Article URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'article_slug',
		'name'               => esc_html__( 'Article URL slug', 'helppress' ),
		'desc'               => sprintf( __( 'The URL slug for single knowledge base articles. <code>%s</code>', 'helppress' ), home_url( '/' ) . '<ins>' . helppress_get_option( 'article_slug' ) . '</ins>/article-title/' ),
		'default'            => helppress_get_option_default( 'article_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
	) );

	// Category URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'category_slug',
		'name'               => esc_html__( 'Category URL slug', 'helppress' ),
		'desc'               => sprintf( __( 'The URL slug for knowledge base categories. <code>%s</code>', 'helppress' ), home_url( '/' ) . '<ins>' . helppress_get_option( 'category_slug' ) . '</ins>/category-title/' ),
		'default'            => helppress_get_option_default( 'category_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
	) );

	// Tag URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'tag_slug',
		'name'               => esc_html__( 'Tag URL slug', 'helppress' ),
		'desc'               => sprintf( __( 'The URL slug for knowledge base tags. <code>%s</code>', 'helppress' ), home_url( '/' ) . '<ins>' . helppress_get_option( 'tag_slug' ) . '</ins>/tag-title/' ),
		'default'            => helppress_get_option_default( 'tag_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
	) );

	// ------------------------------------------------------------------------
	// TAB - DISPLAY
	// ------------------------------------------------------------------------

	$tab_display = $admin_panel->createTab( array(
		'name' => esc_html__( 'Display', 'helppress' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'radio-image',
		'id'      => 'columns',
		'name'    => esc_html__( 'Columns', 'helppress' ),
		'desc'    => esc_html__( 'The number of columns to display on the Knowledge Base.', 'helppress' ),
		'options' => array(
			1 => esc_url( HELPPRESS_URL . '/assets/img/columns-1.svg' ),
			2 => esc_url( HELPPRESS_URL . '/assets/img/columns-2.svg' ),
			3 => esc_url( HELPPRESS_URL . '/assets/img/columns-3.svg' ),
		),
		'default' => helppress_get_option_default( 'columns' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'checkbox',
		'id'      => 'disable_css',
		'name'    => esc_html__( 'Disable CSS', 'helppress' ),
		'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'helppress' ),
		'default' => helppress_get_option_default( 'disable_css' ),
	) );

}
add_action( 'tf_create_options', 'helppress_admin_panel' );
add_action( 'tf_save_admin_helppress', 'flush_rewrite_rules' );

function helppress_admin_view_link() {

    global $submenu;

	$url   = helppress_get_knowledge_base_url();
	$label = esc_html__( 'View Live &rarr;', 'helppress' );

    $submenu['edit.php?post_type=helppress_article'][] = array( $label, 'manage_options', $url );

}
add_action( 'admin_menu', 'helppress_admin_view_link' );
