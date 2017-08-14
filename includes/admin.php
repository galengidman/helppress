<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function hpkb_admin_panel() {

	$titan = TitanFramework::getInstance( 'hpkb' );

	// ------------------------------------------------------------------------
	// ADMIN PANEL
	// ------------------------------------------------------------------------

	$admin_panel = $titan->createAdminPanel( array(
		'id'     => 'hpkb',
		'name'   => esc_html__( 'Settings', 'hpkb' ),
		'parent' => 'edit.php?post_type=hpkb_article',
	) );

	$admin_panel->createOption( array(
		'type' => 'save',
	) );

	// ------------------------------------------------------------------------
	// TAB - GENERAL
	// ------------------------------------------------------------------------

	$tab_general = $admin_panel->createTab( array(
		'name' => esc_html__( 'General', 'hpkb' ),
	) );

	// Knowledge Base URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'knowledge_base_slug',
		'name'               => esc_html__( 'Knowledge Base URL slug', 'hpkb' ),
		'desc'               => sprintf( __( 'The URL slug of the Knowledge Base page. <code>%s</code>', 'hpkb' ), home_url( '/' ) . '<ins>' . hpkb_get_option( 'knowledge_base_slug' ) . '</ins>/' ),
		'default'            => hpkb_get_option_default( 'knowledge_base_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'hpkb_sanitize_slug' ),
	) );

	// Article URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'article_slug',
		'name'               => esc_html__( 'Article URL slug', 'hpkb' ),
		'desc'               => sprintf( __( 'The URL slug for single knowledge base articles. <code>%s</code>', 'hpkb' ), home_url( '/' ) . '<ins>' . hpkb_get_option( 'article_slug' ) . '</ins>/article-title/' ),
		'default'            => hpkb_get_option_default( 'article_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'hpkb_sanitize_slug' ),
	) );

	// Category URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'category_slug',
		'name'               => esc_html__( 'Category URL slug', 'hpkb' ),
		'desc'               => sprintf( __( 'The URL slug for knowledge base categories. <code>%s</code>', 'hpkb' ), home_url( '/' ) . '<ins>' . hpkb_get_option( 'category_slug' ) . '</ins>/category-title/' ),
		'default'            => hpkb_get_option_default( 'category_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'hpkb_sanitize_slug' ),
	) );

	// Tag URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'tag_slug',
		'name'               => esc_html__( 'Tag URL slug', 'hpkb' ),
		'desc'               => sprintf( __( 'The URL slug for knowledge base tags. <code>%s</code>', 'hpkb' ), home_url( '/' ) . '<ins>' . hpkb_get_option( 'tag_slug' ) . '</ins>/tag-title/' ),
		'default'            => hpkb_get_option_default( 'tag_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'hpkb_sanitize_slug' ),
	) );

	// ------------------------------------------------------------------------
	// TAB - DISPLAY
	// ------------------------------------------------------------------------

	$tab_display = $admin_panel->createTab( array(
		'name' => esc_html__( 'Display', 'hpkb' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'radio-image',
		'id'      => 'columns',
		'name'    => esc_html__( 'Columns', 'hpkb' ),
		'desc'    => esc_html__( 'The number of columns to display on the Knowledge Base.', 'hpkb' ),
		'options' => array(
			1 => esc_url( HPKB_URL . '/assets/img/columns-1.svg' ),
			2 => esc_url( HPKB_URL . '/assets/img/columns-2.svg' ),
			3 => esc_url( HPKB_URL . '/assets/img/columns-3.svg' ),
		),
		'default' => hpkb_get_option_default( 'columns' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'checkbox',
		'id'      => 'disable_css',
		'name'    => esc_html__( 'Disable CSS', 'hpkb' ),
		'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'hpkb' ),
		'default' => hpkb_get_option_default( 'disable_css' ),
	) );

}
add_action( 'tf_create_options', 'hpkb_admin_panel' );
add_action( 'tf_save_admin_hpkb', 'flush_rewrite_rules' );

function hpkb_admin_view_link() {

    global $submenu;

	$url   = hpkb_get_knowledge_base_url();
	$label = esc_html__( 'View Live &rarr;', 'hpkb' );

    $submenu['edit.php?post_type=hpkb_article'][] = array( $label, 'manage_options', $url );

}
add_action( 'admin_menu', 'hpkb_admin_view_link' );
