<?php
/**
 * Admin
 */

function wpkb_admin_panel() {

	$titan = TitanFramework::getInstance( 'wpkb' );

	// ------------------------------------------------------------------------
	// ADMIN PANEL
	// ------------------------------------------------------------------------

	$admin_panel = $titan->createAdminPanel( array(
		'id' => 'wpkb',
		'name' => esc_html__( 'Settings', 'wpkb' ),
		'parent' => 'edit.php?post_type=wpkb_article',
	) );

	$admin_panel->createOption( array(
		'type' => 'save',
	) );

	// ------------------------------------------------------------------------
	// TAB - GENERAL
	// ------------------------------------------------------------------------

	$tab_general = $admin_panel->createTab( array(
		'name' => esc_html__( 'General', 'wpkb' ),
	) );

	// Knowledge Base page
	$tab_general->createOption( array(
		'type' => 'select-pages',
		'id' => 'knowledge_base_page',
		'name' => esc_html__( 'Knowledge Base page', 'wpkb' ),
		'desc' => esc_html__( 'This page was created for you when activated the plugin. If you&rsquo;re using a different page, please select it here.', 'wpkb' ),
	) );

	// Knowledge Base URL slug
	// $tab_general->createOption( array(
	// 	'type' => 'text',
	// 	'id' => 'knowledge_base_slug',
	// 	'name' => esc_html__( 'Knowledge Base URL slug', 'wpkb' ),
	// 	'desc' => sprintf( __( 'The URL slug of the Knowledge Base page. <code>%s</code>', 'wpkb' ), trailingslashit( home_url() ) . '<ins>' . wpkb_get_option( 'knowledge_base_slug' ) . '</ins>/' ),
	// 	'default' => wpkb_get_option_default( 'knowledge_base_slug' ),
	// 	'sanitize_callbacks' => array( 'sanitize_title' ),
	// ) );

	// Article URL slug
	$tab_general->createOption( array(
		'type' => 'text',
		'id' => 'article_slug',
		'name' => esc_html__( 'Article URL slug', 'wpkb' ),
		'desc' => sprintf( __( 'The URL slug for single knowledge base articles. <code>%s</code>', 'wpkb' ), trailingslashit( home_url() ) . '<ins>' . wpkb_get_option( 'article_slug' ) . '</ins>/article-title/' ),
		'default' => wpkb_get_option_default( 'article_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title' ),
	) );

	// Category URL slug
	$tab_general->createOption( array(
		'type' => 'text',
		'id' => 'category_slug',
		'name' => esc_html__( 'Category URL slug', 'wpkb' ),
		'desc' => sprintf( __( 'The URL slug for knowledge base categories. <code>%s</code>', 'wpkb' ), trailingslashit( home_url() ) . '<ins>' . wpkb_get_option( 'category_slug' ) . '</ins>/category-title/' ),
		'default' => wpkb_get_option_default( 'category_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'wpkb_ensure_unique_category_slug' ),
	) );

	// Tag URL slug
	$tab_general->createOption( array(
		'type' => 'text',
		'id' => 'tag_slug',
		'name' => esc_html__( 'Tag URL slug', 'wpkb' ),
		'desc' => sprintf( __( 'The URL slug for knowledge base tags. <code>%s</code>', 'wpkb' ), trailingslashit( home_url() ) . '<ins>' . wpkb_get_option( 'tag_slug' ) . '</ins>/tag-title/' ),
		'default' => wpkb_get_option_default( 'tag_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'wpkb_ensure_unique_tag_slug' ),
	) );

	// Enable tags
	$tab_general->createOption( array(
		'type' => 'checkbox',
		'id' => 'enable_tags',
		'name' => esc_html__( 'Enable Tags', 'wpkb' ),
		'default' => wpkb_get_option_default( 'enable_tags' ),
	) );

	// ------------------------------------------------------------------------
	// TAB - DISPLAY
	// ------------------------------------------------------------------------

	$tab_display = $admin_panel->createTab( array(
		'name' => esc_html__( 'Display', 'wpkb' ),
	) );

	$tab_display->createOption( array(
		'type' => 'radio',
		'id' => 'skin',
		'name' => esc_html__( 'Skin', 'wpkb' ),
		'options' => array(
			'full' => __( '<strong>Full</strong>: A fully-designed and styled knowledge base.', 'wpkb' ),
			'lite' => __( '<strong>Lite</strong>: Just enough styling to make it work. Inherits most things from your theme.', 'wpkb' ),
		),
		'default' => wpkb_get_option_default( 'skin' ),
	) );

	$tab_display->createOption( array(
		'type' => 'radio-image',
		'id' => 'columns',
		'name' => esc_html__( 'Columns', 'wpkb' ),
		'desc' => esc_html__( 'The number of columns to display on the Knowledge Base page.', 'wpkb' ),
		'options' => array(
			1 => WPKB_URL . 'assets/img/columns-1.svg',
			2 => WPKB_URL . 'assets/img/columns-2.svg',
			3 => WPKB_URL . 'assets/img/columns-3.svg',
		),
		'default' => wpkb_get_option_default( 'columns' ),
	) );

	$tab_display->createOption( array(
		'type' => 'color',
		'id' => 'color_accent',
		'name' => esc_html__( 'Accent color', 'wpkb' ),
		'default' => wpkb_get_option_default( 'color_accent' ),
	) );

	$tab_display->createOption( array(
		'type' => 'color',
		'id' => 'color_success',
		'name' => esc_html__( 'Success color', 'wpkb' ),
		'default' => wpkb_get_option_default( 'color_success' ),
	) );

	$tab_display->createOption( array(
		'type' => 'color',
		'id' => 'color_error',
		'name' => esc_html__( 'Error color', 'wpkb' ),
		'default' => wpkb_get_option_default( 'color_error' ),
	) );

	$tab_display->createOption( array(
		'type' => 'checkbox',
		'id' => 'disable_css',
		'name' => esc_html__( 'Disable CSS', 'wpkb' ),
		'desc' => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'wpkb' ),
		'default' => wpkb_get_option_default( 'disable_css' ),
	) );

	// ------------------------------------------------------------------------
	// TAB - LICENSE
	// ------------------------------------------------------------------------

	$tab_license = $admin_panel->createTab( array(
		'name' => esc_html__( 'License', 'wpkb' ),
	) );

	// License Key
	$tab_license->createOption( array(
		'type' => 'edd-license',
		'name' => esc_html__( 'License key', 'wpkb' ),
		'id' => 'license_key',
		'default' => wpkb_get_option_default( 'license_key' ),
	) );

}
add_action( 'tf_create_options', 'wpkb_admin_panel' );

add_action( 'tf_save_admin_wpkb', 'flush_rewrite_rules' );

function wpkb_ensure_unique_category_slug( $slug ) {

	// "category" is already in use by WordPress core
	if ( $slug === 'category' ) {
		$slug = 'kb-category';
	}

	return $slug;

}

function wpkb_ensure_unique_tag_slug( $slug ) {

	// "tag" is already in use by WordPress core
	if ( $slug === 'tag' ) {
		$slug = 'kb-tag';
	}

	return $slug;

}
