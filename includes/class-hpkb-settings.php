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

		$settings = apply_filters( 'hpkb_settings', array(
			'general' => array(
				'name'    => esc_html__( 'General', 'hpkb' ),
				'options' => array(
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
					'disable_css' => array(
						'type'    => 'checkbox',
						'id'      => 'disable_css',
						'name'    => esc_html__( 'Disable CSS', 'hpkb' ),
						'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'disable_css' ),
					),
				),
			),
		) );

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

		$url   = hpkb_get_knowledge_base_url();
		$label = esc_html__( 'View KB &rarr;', 'hpkb' );

		$submenu['edit.php?post_type=hpkb_article'][] = array( $label, 'manage_options', $url );

	}

}

}

new HPKB_Settings();
