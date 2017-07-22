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

	// Knowledge Base page
	$tab_general->createOption( array(
		'type' => 'select-pages',
		'id'   => 'knowledge_base_page',
		'name' => esc_html__( 'Knowledge Base page', 'helppress' ),
		'desc' => esc_html__( 'This page was created for you when activated the plugin. If you&rsquo;re using a different page, please select it here.', 'helppress' ),
	) );

	// Knowledge Base URL slug
	// $tab_general->createOption( array(
	// 	'type'               => 'text',
	// 	'id'                 => 'knowledge_base_slug',
	// 	'name'               => esc_html__( 'Knowledge Base URL slug', 'helppress' ),
	// 	'desc'               => sprintf( __( 'The URL slug of the Knowledge Base page. <code>%s</code>', 'helppress' ), trailingslashit( home_url() ) . '<ins>' . helppress_get_option( 'knowledge_base_slug' ) . '</ins>/' ),
	// 	'default'            => helppress_get_option_default( 'knowledge_base_slug' ),
	// 	'sanitize_callbacks' => array( 'sanitize_title' ),
	// ) );

	// Article URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'article_slug',
		'name'               => esc_html__( 'Article URL slug', 'helppress' ),
		'desc'               => sprintf( __( 'The URL slug for single knowledge base articles. <code>%s</code>', 'helppress' ), trailingslashit( home_url() ) . '<ins>' . helppress_get_option( 'article_slug' ) . '</ins>/article-title/' ),
		'default'            => helppress_get_option_default( 'article_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title' ),
	) );

	// Category URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'category_slug',
		'name'               => esc_html__( 'Category URL slug', 'helppress' ),
		'desc'               => sprintf( __( 'The URL slug for knowledge base categories. <code>%s</code>', 'helppress' ), trailingslashit( home_url() ) . '<ins>' . helppress_get_option( 'category_slug' ) . '</ins>/category-title/' ),
		'default'            => helppress_get_option_default( 'category_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'helppress_ensure_safe_tax_slug' ),
	) );

	// Tag URL slug
	$tab_general->createOption( array(
		'type'               => 'text',
		'id'                 => 'tag_slug',
		'name'               => esc_html__( 'Tag URL slug', 'helppress' ),
		'desc'               => sprintf( __( 'The URL slug for knowledge base tags. <code>%s</code>', 'helppress' ), trailingslashit( home_url() ) . '<ins>' . helppress_get_option( 'tag_slug' ) . '</ins>/tag-title/' ),
		'default'            => helppress_get_option_default( 'tag_slug' ),
		'sanitize_callbacks' => array( 'sanitize_title', 'helppress_ensure_safe_tax_slug' ),
	) );

	// Enable tags
	$tab_general->createOption( array(
		'type'    => 'checkbox',
		'id'      => 'enable_tags',
		'name'    => esc_html__( 'Enable Tags', 'helppress' ),
		'default' => helppress_get_option_default( 'enable_tags' ),
	) );

	// ------------------------------------------------------------------------
	// TAB - DISPLAY
	// ------------------------------------------------------------------------

	$tab_display = $admin_panel->createTab( array(
		'name' => esc_html__( 'Display', 'helppress' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'radio',
		'id'      => 'skin',
		'name'    => esc_html__( 'Skin', 'helppress' ),
		'options' => array(
			'full' => __( '<strong>Full</strong>: A fully-designed and styled knowledge base.', 'helppress' ),
			'lite' => __( '<strong>Lite</strong>: Just enough styling to make it work. Inherits most things from your theme.', 'helppress' ),
		),
		'default' => helppress_get_option_default( 'skin' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'radio-image',
		'id'      => 'columns',
		'name'    => esc_html__( 'Columns', 'helppress' ),
		'desc'    => esc_html__( 'The number of columns to display on the Knowledge Base page.', 'helppress' ),
		'options' => array(
			1 => esc_url( HELPPRESS_URL . '/assets/img/columns-1.svg' ),
			2 => esc_url( HELPPRESS_URL . '/assets/img/columns-2.svg' ),
			3 => esc_url( HELPPRESS_URL . '/assets/img/columns-3.svg' ),
		),
		'default' => helppress_get_option_default( 'columns' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'color',
		'id'      => 'color_accent',
		'name'    => esc_html__( 'Accent color', 'helppress' ),
		'default' => helppress_get_option_default( 'color_accent' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'color',
		'id'      => 'color_success',
		'name'    => esc_html__( 'Success color', 'helppress' ),
		'default' => helppress_get_option_default( 'color_success' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'color',
		'id'      => 'color_error',
		'name'    => esc_html__( 'Error color', 'helppress' ),
		'default' => helppress_get_option_default( 'color_error' ),
	) );

	$tab_display->createOption( array(
		'type'    => 'checkbox',
		'id'      => 'disable_css',
		'name'    => esc_html__( 'Disable CSS', 'helppress' ),
		'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'helppress' ),
		'default' => helppress_get_option_default( 'disable_css' ),
	) );

	// ------------------------------------------------------------------------
	// TAB - LICENSE
	// ------------------------------------------------------------------------

	$tab_license = $admin_panel->createTab( array(
		'name' => esc_html__( 'License', 'helppress' ),
	) );

	// License Key
	$tab_license->createOption( array(
		'type'    => 'edd-license',
		'name'    => esc_html__( 'License key', 'helppress' ),
		'id'      => 'license_key',
		'default' => helppress_get_option_default( 'license_key' ),
	) );

}
add_action( 'tf_create_options', 'helppress_admin_panel' );
add_action( 'tf_save_admin_helppress', 'flush_rewrite_rules' );

function helppress_ensure_safe_tax_slug( $slug ) {

	// https://codex.wordpress.org/Reserved_Terms
	$reserved_terms = array(
		'attachment',
		'attachment_id',
		'author',
		'author_name',
		'calendar',
		'cat',
		'category',
		'category__and',
		'category__in',
		'category__not_in',
		'category_name',
		'comments_per_page',
		'comments_popup',
		'custom',
		'customize_messenger_channel',
		'customized',
		'cpage',
		'day',
		'debug',
		'embed',
		'error',
		'exact',
		'feed',
		'hour',
		'link_category',
		'm',
		'minute',
		'monthnum',
		'more',
		'name',
		'nav_menu',
		'nonce',
		'nopaging',
		'offset',
		'order',
		'orderby',
		'p',
		'page',
		'page_id',
		'paged',
		'pagename',
		'pb',
		'perm',
		'post',
		'post__in',
		'post__not_in',
		'post_format',
		'post_mime_type',
		'post_status',
		'post_tag',
		'post_type',
		'posts',
		'posts_per_archive_page',
		'posts_per_page',
		'preview',
		'robots',
		's',
		'search',
		'second',
		'sentence',
		'showposts',
		'static',
		'subpost',
		'subpost_id',
		'tag',
		'tag__and',
		'tag__in',
		'tag__not_in',
		'tag_id',
		'tag_slug__and',
		'tag_slug__in',
		'taxonomy',
		'tb',
		'term',
		'terms',
		'theme',
		'title',
		'type',
		'w',
		'withcomments',
		'withoutcomments',
		'year',
	);

	if ( in_array( $slug, $reserved_terms ) ) {
		$slug = 'kb-' . $slug;
	}

	return $slug;

}
