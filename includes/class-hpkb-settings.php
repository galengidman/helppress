<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HPKB_Settings' ) ) {

class HPKB_Settings {

	public function __construct() {

		add_action( 'tf_create_options', array( $this, 'register_settings' ) );
		add_action( 'tf_save_admin_hpkb', 'flush_rewrite_rules' );

		add_action( 'admin_menu', array( $this, 'view_live_link' ) );

	}

	public function register_settings() {

		$settings = array(
			'general' => array(
				'name'    => esc_html__( 'General', 'hpkb' ),
				'options' => array(
					'queries' => array(
						'name' => esc_html__( 'Queries', 'hpkb' ),
						'type' => 'heading',
					),
					'orderby' => array(
						'type'    => 'select',
						'id'      => 'orderby',
						'name'    => esc_html__( 'Sort by', 'hpkb' ),
						'desc'    => esc_html__( '', 'hpkb' ),
						'options' => array(
							'title'         => esc_html__( 'Title', 'hpkb' ),
							'date'          => esc_html__( 'Date', 'hpkb' ),
							'modified'      => esc_html__( 'Modified', 'hpkb' ),
							'rand'          => esc_html__( 'Random', 'hpkb' ),
							'comment_count' => esc_html__( 'Comment count', 'hpkb' ),
						),
						'default' => hpkb_get_option_default( 'orderby' ),
					),
					'order' => array(
						'type'    => 'select',
						'id'      => 'order',
						'name'    => esc_html__( 'Sort order', 'hpkb' ),
						'desc'    => esc_html__( '', 'hpkb' ),
						'options' => array(
							'ASC'  => esc_html__( 'Ascending', 'hpkb' ),
							'DESC' => esc_html__( 'Decending', 'hpkb' ),
						),
						'default' => hpkb_get_option_default( 'order' ),
					),
					'posts_per_page' => array(
						'type'    => 'number',
						'id'      => 'posts_per_page',
						'name'    => esc_html__( 'Articles per page', 'hpkb' ),
						'desc'    => esc_html__( '', 'hpkb' ),
						'default' => hpkb_get_option_default( 'posts_per_page' ),
						'min'     => 1,
						'max'     => 25,
					),
					'slugs' => array(
						'name' => esc_html__( 'Slugs', 'hpkb' ),
						'type' => 'heading',
					),
					'knowledge_base_slug' => array(
						'type'               => 'text',
						'id'                 => 'knowledge_base_slug',
						'name'               => esc_html__( 'Knowledge Base URL slug', 'hpkb' ),
						'desc'               => sprintf(
							__( 'The URL slug of the Knowledge Base page. <code>%s</code>', 'hpkb' ),
							home_url( '/' ) . '<ins>' . hpkb_get_option( 'knowledge_base_slug' ) . '</ins>/'
						),
						'default'            => hpkb_get_option_default( 'knowledge_base_slug' ),
						'sanitize_callbacks' => array( 'sanitize_title', 'hpkb_sanitize_slug' ),
					),
					'category_slug' => array(
						'type'               => 'text',
						'id'                 => 'category_slug',
						'name'               => esc_html__( 'Category URL slug', 'hpkb' ),
						'desc'               => sprintf(
							__( 'The URL slug for knowledge base categories. <code>%s</code>', 'hpkb' ),
							home_url( '/' ) . '<ins>' . hpkb_get_option( 'category_slug' ) . '</ins>/category-title/'
						),
						'default'            => hpkb_get_option_default( 'category_slug' ),
						'sanitize_callbacks' => array( 'sanitize_title', 'hpkb_sanitize_slug' ),
					),
					'tag_slug' => array(
						'type'               => 'text',
						'id'                 => 'tag_slug',
						'name'               => esc_html__( 'Tag URL slug', 'hpkb' ),
						'desc'               => sprintf(
							__( 'The URL slug for knowledge base tags. <code>%s</code>', 'hpkb' ),
							home_url( '/' ) . '<ins>' . hpkb_get_option( 'tag_slug' ) . '</ins>/tag-title/'
						),
						'default'            => hpkb_get_option_default( 'tag_slug' ),
						'sanitize_callbacks' => array( 'sanitize_title', 'hpkb_sanitize_slug' ),
					),
				),
			),
			'display' => array(
				'name'    => esc_html__( 'Display', 'hpkb' ),
				'options' => array(
					'layout' => array(
						'name' => esc_html__( 'Layout', 'hpkb' ),
						'type' => 'heading',
					),
					'columns' => array(
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
					),
					'css' => array(
						'name' => esc_html__( 'CSS', 'hpkb' ),
						'type' => 'heading',
					),
					'custom_css' => array(
						'type' => 'note',
						'name' => 'Custom CSS',
						'desc' => sprintf(
							__( 'We recommend adding custom CSS using the &ldquo;Additional CSS&rdquo; feature in the <a href="%s">WordPress Customizer</a>.', 'hpkb' ),
							esc_url( admin_url( 'customize.php' ) )
						),
					),
					'disable_css' => array(
						'type'    => 'checkbox',
						'id'      => 'disable_css',
						'name'    => esc_html__( 'Disable CSS', 'hpkb' ),
						'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'disable_css' ),
					),
				),
			),
		);

		$settings = apply_filters( 'hpkb_settings', $settings );

		$titan = TitanFramework::getInstance( 'hpkb' );

		$admin_panel = $titan->createAdminPanel( array(
			'id'     => 'hpkb',
			'name'   => esc_html__( 'Settings', 'hpkb' ),
			'parent' => 'edit.php?post_type=hpkb_article',
		) );

		$admin_panel->createOption( array(
			'type' => 'save',
		) );

		foreach ( $settings as $category ) {

			$tab = $admin_panel->createTab( array(
				'name' => $category['name'],
			) );

			foreach ( $category['options'] as $option ) {
				$tab->createOption( $option );
			}

		}

	}

	public function view_live_link() {

		global $submenu;

		$url   = hpkb_get_kb_url();
		$label = esc_html__( 'View KB &rarr;', 'hpkb' );

		$submenu['edit.php?post_type=hpkb_article'][] = array( $label, 'manage_options', $url );

	}

}

}

new HPKB_Settings();
