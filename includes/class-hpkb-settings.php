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
			10 => array(
				'name'    => esc_html__( 'General', 'hpkb' ),
				'options' => array(
					array(
						'name' => esc_html__( 'Labels', 'hpkb' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'text',
						'id'      => 'title',
						'name'    => esc_html__( 'Knowledge Base title', 'hpkb' ),
						'desc'    => esc_html__( 'You could rename the knowledge base to something else, such as &ldquo;Documentation&rdquo; or &ldquo;Learning Center.&rdquo;', 'hpkb' ),
						'default' => hpkb_get_option_default( 'title' ),
					),
					array(
						'name' => esc_html__( 'Queries', 'hpkb' ),
						'type' => 'heading',
					),
					array(
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
					array(
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
					array(
						'type'    => 'number',
						'id'      => 'posts_per_page',
						'name'    => esc_html__( 'Articles per page', 'hpkb' ),
						'desc'    => esc_html__( '', 'hpkb' ),
						'default' => hpkb_get_option_default( 'posts_per_page' ),
						'min'     => 1,
						'max'     => 25,
					),
					array(
						'name' => esc_html__( 'Slugs', 'hpkb' ),
						'type' => 'heading',
					),
					array(
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
					array(
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
					array(
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
			20 => array(
				'name'    => esc_html__( 'Display', 'hpkb' ),
				'options' => array(
					array(
						'name' => esc_html__( 'Layout', 'hpkb' ),
						'type' => 'heading',
					),
					array(
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
					array(
						'name' => esc_html__( 'CSS', 'hpkb' ),
						'type' => 'heading',
					),
					array(
						'type' => 'note',
						'name' => 'Custom CSS',
						'desc' => sprintf(
							__( 'We recommend adding custom CSS using the &ldquo;Additional CSS&rdquo; feature in the <a href="%s">WordPress Customizer</a>.', 'hpkb' ),
							esc_url( admin_url( 'customize.php' ) )
						),
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'disable_css',
						'name'    => esc_html__( 'Disable CSS', 'hpkb' ),
						'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'disable_css' ),
					),
				),
			),
			30 => array(
				'name'    => esc_html__( 'Breadcrumb', 'hpkb' ),
				'options' => array(
					array(
						'name' => esc_html__( 'Settings', 'hpkb' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'enable',
						'id'      => 'breadcrumb',
						'name'    => esc_html__( 'Breadcrumb', 'hpkb' ),
						'desc'    => esc_html__( 'Turn the breadcrumb on or off globally.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'breadcrumb' ),
					),
					array(
						'type'    => 'enable',
						'id'      => 'breadcrumb_home',
						'name'    => esc_html__( 'Home link', 'hpkb' ),
						'desc'    => esc_html__( 'Start the breadcrumb with a link to the home page.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'breadcrumb_home' ),
					),
					array(
						'type'    => 'text',
						'id'      => 'breadcrumb_sep',
						'name'    => esc_html__( 'Separator', 'hpkb' ),
						'desc'    => esc_html__( 'Text to use to separate breadcrumb links.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'breadcrumb_sep' ),
					),
				),
			),
			40 => array(
				'name'    => esc_html__( 'Search', 'hpkb' ),
				'options' => array(
					array(
						'name' => esc_html__( 'Settings', 'hpkb' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'enable',
						'id'      => 'search',
						'name'    => esc_html__( 'Search', 'hpkb' ),
						'desc'    => esc_html__( 'Turn the search form on or off globally.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'search' ),
					),
					array(
						'type'    => 'text',
						'id'      => 'search_placeholder',
						'name'    => esc_html__( 'Placeholder text', 'hpkb' ),
						'desc'    => esc_html__( 'Help text to show in the search box.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'search_placeholder' ),
					),
					array(
						'type'    => 'enable',
						'id'      => 'search_autofocus',
						'name'    => esc_html__( 'Autofocus search', 'hpkb' ),
						'desc'    => esc_html__( 'Focus the cursor in the search box on page load.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'search_autofocus' ),
					),
					array(
						'name' => esc_html__( 'Suggestions', 'hpkb' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'enable',
						'id'      => 'search_suggestions',
						'name'    => esc_html__( 'Live suggestions', 'hpkb' ),
						'desc'    => esc_html__( 'Live suggest KB articles as users enter search terms.', 'hpkb' ),
						'default' => hpkb_get_option_default( 'search_suggestions' ),
					),
					array(
						'type'    => 'number',
						'id'      => 'search_suggestions_number',
						'name'    => esc_html__( 'Number of suggestions', 'hpkb' ),
						'desc'    => esc_html__( '', 'hpkb' ),
						'default' => hpkb_get_option_default( 'search_suggestions_number' ),
						'min'     => 1,
						'max'     => 10,
					),
				),
			),
		);

		$settings = apply_filters( 'hpkb_settings', $settings );

		ksort( $settings );

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
