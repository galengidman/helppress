<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HelpPress_Settings' ) ) :

class HelpPress_Settings {

	public function __construct() {

		add_action( 'tf_create_options', array( $this, 'register_settings' ) );
		add_action( 'tf_save_admin_helppress', 'flush_rewrite_rules' );

		add_action( 'admin_menu', array( $this, 'view_live_link' ) );

		add_action( 'admin_notices', array( $this, 'permalink_structure_notice' ) );

	}

	public function register_settings() {

		$settings = array(
			10 => array(
				'name'    => esc_html__( 'General', 'helppress' ),
				'options' => array(
					array(
						'name' => esc_html__( 'Labels', 'helppress' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'text',
						'id'      => 'title',
						'name'    => esc_html__( 'Knowledge Base Title', 'helppress' ),
						'desc'    => esc_html__( 'You could rename the knowledge base to something else, such as &ldquo;Documentation&rdquo; or &ldquo;Learning Center.&rdquo;', 'helppress' ),
						'default' => helppress_get_option_default( 'title' ),
					),
					array(
						'name' => esc_html__( 'Queries', 'helppress' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'select',
						'id'      => 'orderby',
						'name'    => esc_html__( 'Sort By', 'helppress' ),
						'desc'    => esc_html__( '', 'helppress' ),
						'options' => array(
							'title'         => esc_html__( 'Title', 'helppress' ),
							'date'          => esc_html__( 'Date', 'helppress' ),
							'modified'      => esc_html__( 'Modified', 'helppress' ),
							'rand'          => esc_html__( 'Random', 'helppress' ),
							'comment_count' => esc_html__( 'Comment count', 'helppress' ),
						),
						'default' => helppress_get_option_default( 'orderby' ),
					),
					array(
						'type'    => 'select',
						'id'      => 'order',
						'name'    => esc_html__( 'Sort Order', 'helppress' ),
						'desc'    => esc_html__( '', 'helppress' ),
						'options' => array(
							'ASC'  => esc_html__( 'Ascending', 'helppress' ),
							'DESC' => esc_html__( 'Decending', 'helppress' ),
						),
						'default' => helppress_get_option_default( 'order' ),
					),
					array(
						'type'    => 'number',
						'id'      => 'posts_per_page',
						'name'    => esc_html__( 'Articles Per Page', 'helppress' ),
						'desc'    => esc_html__( '', 'helppress' ),
						'default' => helppress_get_option_default( 'posts_per_page' ),
						'min'     => 1,
						'max'     => 25,
					),
					array(
						'name' => esc_html__( 'Slugs', 'helppress' ),
						'type' => 'heading',
					),
					array(
						'type'               => 'text',
						'id'                 => 'knowledge_base_slug',
						'name'               => esc_html__( 'Knowledge Base URL Slug', 'helppress' ),
						'desc'               => sprintf(
							__( 'The URL slug of the knowledge base page. <code>%s</code>', 'helppress' ),
							home_url( '/' ) . '<ins>' . helppress_get_option( 'knowledge_base_slug' ) . '</ins>/'
						),
						'default'            => helppress_get_option_default( 'knowledge_base_slug' ),
						'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
					),
					array(
						'type'               => 'text',
						'id'                 => 'category_slug',
						'name'               => esc_html__( 'Category URL Slug', 'helppress' ),
						'desc'               => sprintf(
							__( 'The URL slug for knowledge base categories. <code>%s</code>', 'helppress' ),
							home_url( '/' ) . '<ins>' . helppress_get_option( 'category_slug' ) . '</ins>/category-title/'
						),
						'default'            => helppress_get_option_default( 'category_slug' ),
						'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
					),
					array(
						'type'               => 'text',
						'id'                 => 'tag_slug',
						'name'               => esc_html__( 'Tag URL Slug', 'helppress' ),
						'desc'               => sprintf(
							__( 'The URL slug for knowledge base tags. <code>%s</code>', 'helppress' ),
							home_url( '/' ) . '<ins>' . helppress_get_option( 'tag_slug' ) . '</ins>/tag-title/'
						),
						'default'            => helppress_get_option_default( 'tag_slug' ),
						'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
					),
				),
			),
			20 => array(
				'name'    => esc_html__( 'Display', 'helppress' ),
				'options' => array(
					array(
						'name' => esc_html__( 'Layout', 'helppress' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'radio-image',
						'id'      => 'columns',
						'name'    => esc_html__( 'Columns', 'helppress' ),
						'desc'    => esc_html__( 'The number of columns to display on the knowledge base.', 'helppress' ),
						'options' => array(
							1 => esc_url( HELPPRESS_URL . '/assets/img/columns-1.svg' ),
							2 => esc_url( HELPPRESS_URL . '/assets/img/columns-2.svg' ),
							3 => esc_url( HELPPRESS_URL . '/assets/img/columns-3.svg' ),
						),
						'default' => helppress_get_option_default( 'columns' ),
					),
					array(
						'name' => esc_html__( 'CSS', 'helppress' ),
						'type' => 'heading',
					),
					array(
						'type' => 'note',
						'name' => 'Custom CSS',
						'desc' => sprintf(
							__( 'Add custom CSS using the &ldquo;Additional CSS&rdquo; feature in the <a href="%s">WordPress Customizer</a>.', 'helppress' ),
							esc_url( admin_url( 'customize.php' ) )
						),
					),
					array(
						'type'    => 'checkbox',
						'id'      => 'disable_css',
						'name'    => esc_html__( 'Disable CSS', 'helppress' ),
						'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'helppress' ),
						'default' => helppress_get_option_default( 'disable_css' ),
					),
				),
			),
			30 => array(
				'name'    => esc_html__( 'Breadcrumb', 'helppress' ),
				'options' => array(
					array(
						'name' => esc_html__( 'Settings', 'helppress' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'enable',
						'id'      => 'breadcrumb',
						'name'    => esc_html__( 'Breadcrumb', 'helppress' ),
						'desc'    => esc_html__( 'Turn the breadcrumb on or off globally.', 'helppress' ),
						'default' => helppress_get_option_default( 'breadcrumb' ),
					),
					array(
						'type'    => 'enable',
						'id'      => 'breadcrumb_home',
						'name'    => esc_html__( 'Home Link', 'helppress' ),
						'desc'    => esc_html__( 'Start the breadcrumb with a link to the home page.', 'helppress' ),
						'default' => helppress_get_option_default( 'breadcrumb_home' ),
					),
					array(
						'type'    => 'text',
						'id'      => 'breadcrumb_sep',
						'name'    => esc_html__( 'Separator', 'helppress' ),
						'desc'    => esc_html__( 'Text to use to separate breadcrumb links.', 'helppress' ),
						'default' => helppress_get_option_default( 'breadcrumb_sep' ),
					),
				),
			),
			40 => array(
				'name'    => esc_html__( 'Search', 'helppress' ),
				'options' => array(
					array(
						'name' => esc_html__( 'Settings', 'helppress' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'enable',
						'id'      => 'search',
						'name'    => esc_html__( 'Search', 'helppress' ),
						'desc'    => esc_html__( 'Turn search on or off globally.', 'helppress' ),
						'default' => helppress_get_option_default( 'search' ),
					),
					array(
						'type'    => 'text',
						'id'      => 'search_placeholder',
						'name'    => esc_html__( 'Placeholder Text', 'helppress' ),
						'desc'    => esc_html__( 'Help text to show in the search box.', 'helppress' ),
						'default' => helppress_get_option_default( 'search_placeholder' ),
					),
					array(
						'type'    => 'enable',
						'id'      => 'search_autofocus',
						'name'    => esc_html__( 'Autofocus Search', 'helppress' ),
						'desc'    => esc_html__( 'Focus the cursor in the search box when the page loads.', 'helppress' ),
						'default' => helppress_get_option_default( 'search_autofocus' ),
					),
					array(
						'name' => esc_html__( 'Suggestions', 'helppress' ),
						'type' => 'heading',
					),
					array(
						'type'    => 'enable',
						'id'      => 'search_suggestions',
						'name'    => esc_html__( 'Live Suggestions', 'helppress' ),
						'desc'    => esc_html__( 'Suggest relevant articles to users as they enter search terms.', 'helppress' ),
						'default' => helppress_get_option_default( 'search_suggestions' ),
					),
					array(
						'type'    => 'number',
						'id'      => 'search_suggestions_number',
						'name'    => esc_html__( 'Number of Suggestions', 'helppress' ),
						'desc'    => esc_html__( '', 'helppress' ),
						'default' => helppress_get_option_default( 'search_suggestions_number' ),
						'min'     => 1,
						'max'     => 10,
					),
				),
			),
		);

		$settings = apply_filters( 'helppress_settings', $settings );

		ksort( $settings );

		$titan = TitanFramework::getInstance( 'helppress' );

		$admin_panel = $titan->createAdminPanel( array(
			'id'     => 'helppress',
			'name'   => esc_html__( 'Settings', 'helppress' ),
			'parent' => 'edit.php?post_type=hp_article',
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

		$url   = helppress_get_kb_url();
		$label = esc_html__( 'View KB &rarr;', 'helppress' );

		$submenu['edit.php?post_type=hp_article'][] = array( $label, 'manage_options', $url );

	}

	public function permalink_structure_notice() {

		if ( get_option( 'permalink_structure' ) !== '' ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->base !== 'hp_article_page_helppress' ) {
			return;
		}

		?>

		<div class="notice notice-warning">
			<p><?php printf(
				__( 'HelpPress slugs are not compatible with Plain permalinks. You can fix this on the <a href="%s">Permalinks Settings</a> page.', 'helppress' ),
				esc_url( admin_url( 'options-permalink.php' ) )
			); ?></p>
		</div>

		<?php

	}

}

endif;

new HelpPress_Settings();
