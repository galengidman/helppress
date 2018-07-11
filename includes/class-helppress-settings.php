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
	 * Stores the configuration for the Settings page.
	 *
	 * @access protected
	 * @since 2.0.0
	 * @var array
	 */
	protected $settings = [];

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'plugin_action_links_' . HELPPRESS_BASENAME, [ $this, 'action_link' ] );

		add_action( 'tf_create_options', [ $this, 'register_settings' ] );
		add_action( 'tf_save_admin_helppress', 'flush_rewrite_rules' );

		add_action( 'admin_menu', [ $this, 'view_live_link' ] );

		add_action( 'admin_notices', [ $this, 'permalink_structure_notice' ] );
		add_action( 'admin_notices', [ $this, 'show_on_front_notice' ] );
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

		$settings_link = [ "<a href='{$url}'>{$label}</a>" ];

		return array_merge( $settings_link, $links );
	}

	/**
	 * Adds a tab to the Settings screen.
	 *
	 * @access protected
	 * @since 2.0.0
	 *
	 * @param integer $tab_index Array index of tab.
	 * @param string $name Tab label.
	 */
	protected function add_tab( $tab_index, $name ) {
		$this->settings[ $tab_index ] = [
			'name'    => $name,
			'options' => [],
		];
	}

	/**
	 * Adds an option to the Settings screen.
	 *
	 * Can later disable option by returning `true` to
	 * `helppress_disable_option_{id}` filter.
	 *
	 * @access protected
	 * @since 2.0.0
	 *
	 * @param integer $tab_index Array index of tab.
	 * @param array $option Option args.
	 */
	protected function add_option( $tab_index, $option ) {
		$disabled = apply_filters( "helppress_disable_option_{$option['id']}", false );

		if ( ! $disabled ) {
			$this->settings[ $tab_index ]['options'][] = $option;
		}
	}

	/**
	 * Registers settings via the Titan Framework.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function register_settings() {
		// General ---------------------------------------------------------------

		$this->add_tab( 10, esc_html__( 'General', 'helppress' ) );

		$this->add_option( 10, [
			'type'    => 'text',
			'id'      => 'title',
			'name'    => esc_html__( 'Knowledge Base Title', 'helppress' ),
			'desc'    => esc_html__( 'You could rename the knowledge base to something else, such as “Documentation” or “Help Center.”', 'helppress' ),
			'default' => helppress_get_option_default( 'title' ),
		] );

		$this->add_option( 10, [
			'type' => 'heading',
			'id'   => 'general_heading_queries',
			'name' => esc_html__( 'Queries', 'helppress' ),
		] );

		$this->add_option( 10, [
			'type'    => 'enable',
			'id'      => 'show_on_front',
			'name'    => esc_html__( 'Show on Homepage', 'helppress' ),
			'desc'    => esc_html__( 'Show the knowledge base on the homepage, replacing the current posts or static page.', 'helppress' ),
			'default' => helppress_get_option_default( 'home' ),
		] );

		$this->add_option( 10, [
			'type'    => 'select',
			'id'      => 'orderby',
			'name'    => esc_html__( 'Sort By', 'helppress' ),
			'desc'    => esc_html__( '', 'helppress' ),
			'options' => [
				'title'         => esc_html__( 'Title', 'helppress' ),
				'date'          => esc_html__( 'Date', 'helppress' ),
				'modified'      => esc_html__( 'Modified', 'helppress' ),
				'rand'          => esc_html__( 'Random', 'helppress' ),
				'comment_count' => esc_html__( 'Comment count', 'helppress' ),
			],
			'default' => helppress_get_option_default( 'orderby' ),
		] );

		$this->add_option( 10, [
			'type'    => 'select',
			'id'      => 'order',
			'name'    => esc_html__( 'Sort Order', 'helppress' ),
			'desc'    => esc_html__( '', 'helppress' ),
			'options' => [
				'ASC'  => esc_html__( 'Ascending', 'helppress' ),
				'DESC' => esc_html__( 'Decending', 'helppress' ),
			],
			'default' => helppress_get_option_default( 'order' ),
		] );

		$this->add_option( 10, [
			'type'    => 'number',
			'id'      => 'posts_per_page',
			'name'    => esc_html__( 'Articles per Page', 'helppress' ),
			'desc'    => sprintf(
				__( '<code>-1</code> = no pagination, <code>0</code> = site default from <a href="%s">Reading Settings</a>.', 'helppress' ),
				esc_url( admin_url( 'options-reading.php' ) )
			),
			'default' => helppress_get_option_default( 'posts_per_page' ),
			'min'     => -1,
			'max'     => 25,
		] );

		$this->add_option( 10, [
			'type' => 'heading',
			'id'   => 'general_heading_slugs',
			'name' => esc_html__( 'Slugs', 'helppress' ),
		] );

		$this->add_option( 10, [
			'type'               => 'text',
			'id'                 => 'knowledge_base_slug',
			'name'               => esc_html__( 'Knowledge Base URL Slug', 'helppress' ),
			'desc'               => sprintf(
				__( 'The URL slug of the knowledge base page. <code>%s</code>', 'helppress' ),
				home_url( '/' ) . '<ins>' . helppress_get_option( 'knowledge_base_slug' ) . '</ins>/'
			),
			'default'            => helppress_get_option_default( 'knowledge_base_slug' ),
			'sanitize_callbacks' => [ 'sanitize_title', 'helppress_sanitize_slug' ],
		] );

		$this->add_option( 10, [
			'type'               => 'text',
			'id'                 => 'category_slug',
			'name'               => esc_html__( 'Category URL Slug', 'helppress' ),
			'desc'               => sprintf(
				__( 'The URL slug for knowledge base categories. <code>%s</code>', 'helppress' ),
				home_url( '/' ) . '<ins>' . helppress_get_option( 'category_slug' ) . '</ins>/category-title/'
			),
			'default'            => helppress_get_option_default( 'category_slug' ),
			'sanitize_callbacks' => [ 'sanitize_title', 'helppress_sanitize_slug' ],
		] );

		$this->add_option( 10, [
			'type'               => 'text',
			'id'                 => 'tag_slug',
			'name'               => esc_html__( 'Tag URL Slug', 'helppress' ),
			'desc'               => sprintf(
				__( 'The URL slug for knowledge base tags. <code>%s</code>', 'helppress' ),
				home_url( '/' ) . '<ins>' . helppress_get_option( 'tag_slug' ) . '</ins>/tag-title/'
			),
			'default'            => helppress_get_option_default( 'tag_slug' ),
			'sanitize_callbacks' => [ 'sanitize_title', 'helppress_sanitize_slug' ],
		] );

		// Display ---------------------------------------------------------------

		$this->add_tab( 20, esc_html__( 'Display', 'helppress' ) );

		$this->add_option( 20, [
			'type'    => 'select',
			'id'      => 'page_template',
			'name'    => esc_html__( 'Page Template', 'helppress' ),
			'desc'    => esc_html__( 'The page template used to display the knowledge base. This may be overridden by a theme using custom HelpPress templates.', 'helppress' ),
			'options' => $this->get_page_templates(),
			'default' => helppress_get_option_default( 'page_template' ),
		] );

		$this->add_option( 20, [
			'type'    => 'radio-image',
			'id'      => 'columns',
			'name'    => esc_html__( 'Columns', 'helppress' ),
			'desc'    => esc_html__( 'The number of columns to display on the knowledge base.', 'helppress' ),
			'options' => [
				1 => esc_url( HELPPRESS_URL . '/assets/img/columns-1.svg' ),
				2 => esc_url( HELPPRESS_URL . '/assets/img/columns-2.svg' ),
				3 => esc_url( HELPPRESS_URL . '/assets/img/columns-3.svg' ),
			],
			'default' => helppress_get_option_default( 'columns' ),
		] );

		$this->add_option( 20, [
			'type' => 'heading',
			'id'   => 'display_heading_css',
			'name' => esc_html__( 'CSS', 'helppress' ),
		] );

		$this->add_option( 20, [
			'type' => 'note',
			'id'   => 'custom_css',
			'name' => 'Custom CSS',
			'desc' => sprintf(
				__( 'Add custom CSS using the “Additional CSS” feature in the <a href="%s">WordPress Customizer</a>.', 'helppress' ),
				esc_url( admin_url( 'customize.php' ) )
			),
		] );

		$this->add_option( 20, [
			'type'    => 'checkbox',
			'id'      => 'disable_css',
			'name'    => esc_html__( 'Disable CSS', 'helppress' ),
			'desc'    => esc_html__( 'You can disable the built-in CSS entirely if want to use your own.', 'helppress' ),
			'default' => helppress_get_option_default( 'disable_css' ),
		] );

		// Breadcrumb ------------------------------------------------------------

		$this->add_tab( 30, esc_html__( 'Breadcrumb', 'helppress' ) );

		$this->add_option( 30, [
			'type'    => 'enable',
			'id'      => 'breadcrumb',
			'name'    => esc_html__( 'Breadcrumb', 'helppress' ),
			'desc'    => esc_html__( 'Turn the breadcrumb on or off globally.', 'helppress' ),
			'default' => helppress_get_option_default( 'breadcrumb' ),
		] );

		$this->add_option( 30, [
			'type'    => 'enable',
			'id'      => 'breadcrumb_home',
			'name'    => esc_html__( 'Homepage Link', 'helppress' ),
			'desc'    => esc_html__( 'Start the breadcrumb with a link to the homepage.', 'helppress' ),
			'default' => helppress_get_option_default( 'breadcrumb_home' ),
		] );

		$this->add_option( 30, [
			'type'    => 'text',
			'id'      => 'breadcrumb_sep',
			'name'    => esc_html__( 'Separator', 'helppress' ),
			'desc'    => esc_html__( 'Text to use to separate breadcrumb links.', 'helppress' ),
			'default' => helppress_get_option_default( 'breadcrumb_sep' ),
		] );

		// Search ----------------------------------------------------------------

		$this->add_tab( 40, esc_html__( 'Search', 'helppress' ) );

		$this->add_option( 40, [
			'type'    => 'enable',
			'id'      => 'search',
			'name'    => esc_html__( 'Search', 'helppress' ),
			'desc'    => esc_html__( 'Turn search on or off globally.', 'helppress' ),
			'default' => helppress_get_option_default( 'search' ),
		] );

		$this->add_option( 40, [
			'type'    => 'text',
			'id'      => 'search_placeholder',
			'name'    => esc_html__( 'Placeholder Text', 'helppress' ),
			'desc'    => esc_html__( 'Help text to show in the search box.', 'helppress' ),
			'default' => helppress_get_option_default( 'search_placeholder' ),
		] );

		$this->add_option( 40, [
			'type'    => 'enable',
			'id'      => 'search_autofocus',
			'name'    => esc_html__( 'Autofocus Search', 'helppress' ),
			'desc'    => esc_html__( 'Focus the cursor in the search box when the page loads.', 'helppress' ),
			'default' => helppress_get_option_default( 'search_autofocus' ),
		] );

		$this->add_option( 40, [
			'type' => 'heading',
			'id'   => 'search_heading_suggestions',
			'name' => esc_html__( 'Suggestions', 'helppress' ),
		] );

		$this->add_option( 40, [
			'type'    => 'enable',
			'id'      => 'search_suggestions',
			'name'    => esc_html__( 'Live Suggestions', 'helppress' ),
			'desc'    => esc_html__( 'Suggest relevant articles to users as they enter search terms.', 'helppress' ),
			'default' => helppress_get_option_default( 'search_suggestions' ),
		] );

		$this->add_option( 40, [
			'type'    => 'number',
			'id'      => 'search_suggestions_number',
			'name'    => esc_html__( 'Number of Suggestions', 'helppress' ),
			'default' => helppress_get_option_default( 'search_suggestions_number' ),
			'min'     => 1,
			'max'     => 10,
		] );

		$settings = apply_filters( 'helppress_settings', $this->settings );

		ksort( $settings );

		$titan = TitanFramework::getInstance( 'helppress' );

		$admin_panel = $titan->createAdminPanel( [
			'id'     => 'helppress',
			'name'   => esc_html__( 'Settings', 'helppress' ),
			'parent' => 'edit.php?post_type=hp_article',
		] );

		$admin_panel->createOption( [ 'type' => 'save' ] );

		foreach ( $settings as $category ) {
			$tab = $admin_panel->createTab( [
				'name' => $category['name'],
			] );

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

		$submenu['edit.php?post_type=hp_article'][] = [ $label, 'edit_posts', $url ];
	}

	/**
	 * Displays a warning stating slug settings won't work if a user is using plain permalinks.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function permalink_structure_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

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
	 * Displays a warning on static front page when HelpPress is configured to show on front.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function show_on_front_notice() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! helppress_get_option( 'show_on_front' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( ! ( ( $screen->id === 'page' && get_the_ID() == get_option( 'page_on_front' ) ) || $screen->id === 'options-reading' ) ) {
			return;
		}

		AdminNotice::create()
			->warning()
			->html( sprintf(
				__( 'You have configured HelpPress to display on the homepage of your site, overriding this. This behavior can be disabled from <a href="%s">HelpPress Settings</a>.', 'helppress' ),
				esc_url( admin_url( 'edit.php?post_type=hp_article&page=helppress' ) )
			) )
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
		$page_templates = [ 'default' => esc_html__( 'Default Template', 'helppress' ) ];
		$page_templates = array_merge( $page_templates, wp_get_theme()->get_page_templates() );

		return $page_templates;
	}

}

endif;

new HelpPress_Settings();
