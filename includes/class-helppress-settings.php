<?php
/**
 * Settings
 *
 * @package HelpPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use \YeEasyAdminNotices\V1\AdminNotice;

if ( ! class_exists( 'HelpPress_Settings' ) ) :

/**
 * Admin settings class.
 */
class HelpPress_Settings {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function __construct() {

		add_filter( 'plugin_action_links_' . HELPPRESS_BASENAME, array( $this, 'action_link' ) );

		add_action( 'tf_create_options', array( $this, 'register_settings' ) );
		add_action( 'tf_save_admin_helppress', 'flush_rewrite_rules' );

		add_action( 'admin_menu', array( $this, 'view_live_link' ) );

		add_action( 'admin_notices', array( $this, 'permalink_structure_notice' ) );

	}

	/**
	 * Adds "Settings" link to plugin action links.
	 *
	 * @access public
	 * @since 1.4.2
	 *
	 * @param array $links Default action links.
	 * @return array Action links.
	 */
	public function action_link( $links ) {

		$url   = esc_url( admin_url( 'edit.php?post_type=hp_article&page=helppress' ) );
		$label = esc_html__( 'Settings', 'helppress' );

		$settings_link = array( "<a href='{$url}'>{$label}</a>" );

		return array_merge( $settings_link, $links );

	}

	/**
	 * Registers settings via the Titan Framework.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function register_settings() {

		$settings = array();

		// General -------------------------------------------------------------

		$settings[10] = array(
			'name'    => esc_html__( 'General', 'helppress' ),
			'options' => array(),
		);

		$settings[10]['options'][] = array(
			'name' => esc_html__( 'Labels', 'helppress' ),
			'type' => 'heading',
		);

		$settings[10]['options'][] = array(
			'type'    => 'text',
			'id'      => 'title',
			'name'    => esc_html__( 'Knowledge Base Title', 'helppress' ),
			'desc'    => esc_html__( 'You could rename the knowledge base to something else, such as “Documentation” or “Help Center.”', 'helppress' ),
			'default' => helppress_get_option_default( 'title' ),
		);

		$settings[10]['options'][] = array(
			'name' => esc_html__( 'Queries', 'helppress' ),
			'type' => 'heading',
		);

		$settings[10]['options'][] = array(
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
		);

		$settings[10]['options'][] = array(
			'type'    => 'select',
			'id'      => 'order',
			'name'    => esc_html__( 'Sort Order', 'helppress' ),
			'desc'    => esc_html__( '', 'helppress' ),
			'options' => array(
				'ASC'  => esc_html__( 'Ascending', 'helppress' ),
				'DESC' => esc_html__( 'Decending', 'helppress' ),
			),
			'default' => helppress_get_option_default( 'order' ),
		);

		$settings[10]['options'][] = array(
			'type'    => 'number',
			'id'      => 'posts_per_page',
			'name'    => esc_html__( 'Articles Per Page', 'helppress' ),
			'desc'    => esc_html__( '', 'helppress' ),
			'default' => helppress_get_option_default( 'posts_per_page' ),
			'min'     => 1,
			'max'     => 25,
		);

		$settings[10]['options'][] = array(
			'name' => esc_html__( 'Slugs', 'helppress' ),
			'type' => 'heading',
		);

		$settings[10]['options'][] = array(
			'type'               => 'text',
			'id'                 => 'knowledge_base_slug',
			'name'               => esc_html__( 'Knowledge Base URL Slug', 'helppress' ),
			'desc'               => sprintf(
				__( 'The URL slug of the knowledge base page. <code>%s</code>', 'helppress' ),
				home_url( '/' ) . '<ins>' . helppress_get_option( 'knowledge_base_slug' ) . '</ins>/'
			),
			'default'            => helppress_get_option_default( 'knowledge_base_slug' ),
			'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
		);

		$settings[10]['options'][] = array(
			'type'               => 'text',
			'id'                 => 'category_slug',
			'name'               => esc_html__( 'Category URL Slug', 'helppress' ),
			'desc'               => sprintf(
				__( 'The URL slug for knowledge base categories. <code>%s</code>', 'helppress' ),
				home_url( '/' ) . '<ins>' . helppress_get_option( 'category_slug' ) . '</ins>/category-title/'
			),
			'default'            => helppress_get_option_default( 'category_slug' ),
			'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
		);

		$settings[10]['options'][] = array(
			'type'               => 'text',
			'id'                 => 'tag_slug',
			'name'               => esc_html__( 'Tag URL Slug', 'helppress' ),
			'desc'               => sprintf(
				__( 'The URL slug for knowledge base tags. <code>%s</code>', 'helppress' ),
				home_url( '/' ) . '<ins>' . helppress_get_option( 'tag_slug' ) . '</ins>/tag-title/'
			),
			'default'            => helppress_get_option_default( 'tag_slug' ),
			'sanitize_callbacks' => array( 'sanitize_title', 'helppress_sanitize_slug' ),
		);

		// Display -------------------------------------------------------------

		$settings[20] = array(
			'name'    => esc_html__( 'Display', 'helppress' ),
			'options' => array(),
		);

		$settings[20]['options'][] = array(
			'name' => esc_html__( 'Layout', 'helppress' ),
			'type' => 'heading',
		);

		$settings[20]['options'][] = array(
			'type'    => 'select',
			'id'      => 'page_template',
			'name'    => esc_html__( 'Page Template', 'helppress' ),
			'desc'    => esc_html__( 'The page template used to display the knowledge base. This may be overridden by a theme using custom HelpPress templates.', 'helppress' ),
			'options' => $this->get_page_templates(),
			'default' => helppress_get_option_default( 'page_template' ),
		);

		$settings[20]['options'][] = array(
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
		);

		$settings[20]['options'][] = array(
			'name' => esc_html__( 'CSS', 'helppress' ),
			'type' => 'heading',
		);

		$settings[20]['options'][] = array(
			'type' => 'note',
			'name' => 'Custom CSS',
			'desc' => sprintf(
				__( 'Add custom CSS using the “Additional CSS” feature in the <a href="%s">WordPress Customizer</a>.', 'helppress' ),
				esc_url( admin_url( 'customize.php' ) )
			),
		);

		$settings[20]['options'][] = array(
			'type'    => 'checkbox',
			'id'      => 'disable_css',
			'name'    => esc_html__( 'Disable CSS', 'helppress' ),
			'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'helppress' ),
			'default' => helppress_get_option_default( 'disable_css' ),
		);

		// Breadcrumb ----------------------------------------------------------

		$settings[30] = array(
			'name'    => esc_html__( 'Breadcrumb', 'helppress' ),
			'options' => array(),
		);

		$settings[30]['options'][] = array(
			'name' => esc_html__( 'Settings', 'helppress' ),
			'type' => 'heading',
		);

		$settings[30]['options'][] = array(
			'type'    => 'enable',
			'id'      => 'breadcrumb',
			'name'    => esc_html__( 'Breadcrumb', 'helppress' ),
			'desc'    => esc_html__( 'Turn the breadcrumb on or off globally.', 'helppress' ),
			'default' => helppress_get_option_default( 'breadcrumb' ),
		);

		$settings[30]['options'][] = array(
			'type'    => 'enable',
			'id'      => 'breadcrumb_home',
			'name'    => esc_html__( 'Home Link', 'helppress' ),
			'desc'    => esc_html__( 'Start the breadcrumb with a link to the home page.', 'helppress' ),
			'default' => helppress_get_option_default( 'breadcrumb_home' ),
		);

		$settings[30]['options'][] = array(
			'type'    => 'text',
			'id'      => 'breadcrumb_sep',
			'name'    => esc_html__( 'Separator', 'helppress' ),
			'desc'    => esc_html__( 'Text to use to separate breadcrumb links.', 'helppress' ),
			'default' => helppress_get_option_default( 'breadcrumb_sep' ),
		);

		// Search --------------------------------------------------------------

		$settings[40] = array(
			'name'    => esc_html__( 'Search', 'helppress' ),
			'options' => array(),
		);

		$settings[40]['options'][] = array(
			'name' => esc_html__( 'Settings', 'helppress' ),
			'type' => 'heading',
		);

		$settings[40]['options'][] = array(
			'type'    => 'enable',
			'id'      => 'search',
			'name'    => esc_html__( 'Search', 'helppress' ),
			'desc'    => esc_html__( 'Turn search on or off globally.', 'helppress' ),
			'default' => helppress_get_option_default( 'search' ),
		);

		$settings[40]['options'][] = array(
			'type'    => 'text',
			'id'      => 'search_placeholder',
			'name'    => esc_html__( 'Placeholder Text', 'helppress' ),
			'desc'    => esc_html__( 'Help text to show in the search box.', 'helppress' ),
			'default' => helppress_get_option_default( 'search_placeholder' ),
		);

		$settings[40]['options'][] = array(
			'type'    => 'enable',
			'id'      => 'search_autofocus',
			'name'    => esc_html__( 'Autofocus Search', 'helppress' ),
			'desc'    => esc_html__( 'Focus the cursor in the search box when the page loads.', 'helppress' ),
			'default' => helppress_get_option_default( 'search_autofocus' ),
		);

		$settings[40]['options'][] = array(
			'name' => esc_html__( 'Suggestions', 'helppress' ),
			'type' => 'heading',
		);

		$settings[40]['options'][] = array(
			'type'    => 'enable',
			'id'      => 'search_suggestions',
			'name'    => esc_html__( 'Live Suggestions', 'helppress' ),
			'desc'    => esc_html__( 'Suggest relevant articles to users as they enter search terms.', 'helppress' ),
			'default' => helppress_get_option_default( 'search_suggestions' ),
		);

		$settings[40]['options'][] = array(
			'type'    => 'number',
			'id'      => 'search_suggestions_number',
			'name'    => esc_html__( 'Number of Suggestions', 'helppress' ),
			'desc'    => esc_html__( '', 'helppress' ),
			'default' => helppress_get_option_default( 'search_suggestions_number' ),
			'min'     => 1,
			'max'     => 10,
		);

		$settings = apply_filters( 'helppress_settings', $settings );

		ksort( $settings );

		$titan = TitanFramework::getInstance( 'helppress' );

		$admin_panel = $titan->createAdminPanel( array(
			'id'     => 'helppress',
			'name'   => esc_html__( 'Settings', 'helppress' ),
			'parent' => 'edit.php?post_type=hp_article',
		) );

		$admin_panel->createOption( array( 'type' => 'save' ) );

		foreach ( $settings as $category ) {
			$tab = $admin_panel->createTab( array(
				'name' => $category['name'],
			) );

			foreach ( $category['options'] as $option ) {
				$tab->createOption( $option );
			}
		}

	}

	/**
	 * Adds "View KB →" link to the HelpPress admin menu ite.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function view_live_link() {

		global $submenu;

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		$url   = helppress_get_kb_url();
		$label = esc_html__( 'View KB', 'helppress' ) . ' &rarr;';

		$submenu['edit.php?post_type=hp_article'][] = array( $label, 'edit_posts', $url );

	}

	/**
	 * Displays a warning stating slug settings won't work if a user is using plain permalinks.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function permalink_structure_notice() {

		if ( get_option( 'permalink_structure' ) !== '' ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->base !== 'hp_article_page_helppress' ) {
			return;
		}

		AdminNotice::create( 'helppress_install_demo_content' )
			->warning()
			->html( sprintf(
				__( 'HelpPress slugs are not compatible with Plain permalinks. You can fix this from the <a href="%s">Permalinks Settings</a> page.', 'helppress' ),
				esc_url( admin_url( 'options-permalink.php' ) )
			) )
			->persistentlyDismissible()
			->show();

	}

	/**
	 * Gets page templates from active theme.
	 *
	 * @access public
	 * @since 1.4.0
	 *
	 * @return array Page templates.
	 */
	public function get_page_templates() {

		$page_templates = array( 'default' => esc_html__( 'Default Template', 'helppress' ) );
		$page_templates = array_merge( $page_templates, wp_get_theme()->get_page_templates() );

		return $page_templates;

	}

}

endif;

new HelpPress_Settings();
