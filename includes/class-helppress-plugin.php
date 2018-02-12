<?php
/**
 * Plugin
 *
 * @package HelpPress
 * @since 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HelpPress_Plugin' ) ) :

/**
 * Main plugin class.
 */
class HelpPress_Plugin {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function __construct() {
		$this->include_files();

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );

		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'register_taxonomies' ] );

		add_action( 'load-post.php',     [ $this, 'add_article_post_formats_support' ] );
		add_action( 'load-post-new.php', [ $this, 'add_article_post_formats_support' ] );
	}

	/**
	 * Includes plugin files.
	 *
	 * @access protected
	 * @since 2.0.0
	 */
	protected function include_files() {
		$includes = [

			'includes/vendor/gamajo/template-loader/class-gamajo-template-loader.php',
			'includes/vendor/gambitph/titan-framework/titan-framework.php',
			'includes/vendor/yahnis-elsts/admin-notices/AdminNotice.php',

			'includes/class-helppress-breadcrumb.php',
			'includes/class-helppress-demo-content.php',
			'includes/class-helppress-menu-archive-link.php',
			'includes/class-helppress-search.php',
			'includes/class-helppress-settings.php',
			'includes/class-helppress-template-loader.php',
			'includes/class-helppress-theme-compat.php',

			'includes/formatting-functions.php',
			'includes/options-functions.php',
			'includes/template-functions.php',
		];

		$includes = apply_filters( 'helppress_includes', $includes );

		foreach ( $includes as $file ) {
			include HELPPRESS_PATH . $file;
		}
	}

	/**
	 * Enqueues assets.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function enqueue_assets() {
		$min = helppress_is_debug() ? ''  : '.min';

		wp_enqueue_script(
			'jquery-devbridge-autocomplete',
			esc_url( HELPPRESS_URL . "/assets/vendor/jquery.autocomplete{$min}.js" ),
			[ 'jquery' ],
			HELPPRESS_VERSION
		);

		wp_enqueue_script(
			'helppress',
			esc_url( HELPPRESS_URL . "/assets/dist/helppress{$min}.js" ),
			[ 'jquery', 'jquery-devbridge-autocomplete' ],
			HELPPRESS_VERSION
		);

		wp_localize_script( 'helppress', 'helppressL10n', [
			'adminAjax' => esc_url( admin_url( 'admin-ajax.php' ) ),
		] );

		$disable_css        = apply_filters( 'helppress_disable_css', false );
		$disable_css_option = helppress_get_option( 'disable_css' );

		if ( ! $disable_css && ! $disable_css_option ) {
			wp_enqueue_style(
				'helppress',
				esc_url( HELPPRESS_URL . "/assets/dist/helppress{$min}.css" ),
				[],
				HELPPRESS_VERSION
			);
		}
	}

	/**
	 * Registers `hp_article` post type.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function register_post_types() {
		$labels = [
			'name'                  => esc_html__( 'Articles',                   'helppress' ),
			'singular_name'         => esc_html__( 'Article',                    'helppress' ),
			'add_new'               => esc_html__( 'Add New',                    'helppress' ),
			'add_new_item'          => esc_html__( 'Add New Article',            'helppress' ),
			'edit_item'             => esc_html__( 'Edit Article',               'helppress' ),
			'new_item'              => esc_html__( 'New Article',                'helppress' ),
			'view_item'             => esc_html__( 'View Article',               'helppress' ),
			'view_items'            => esc_html__( 'View Articles',              'helppress' ),
			'search_items'          => esc_html__( 'Search Articles',            'helppress' ),
			'not_found'             => esc_html__( 'No articles found',          'helppress' ),
			'not_found_in_trash'    => esc_html__( 'No articles found in Trash', 'helppress' ),
			'parent_item_colon'     => esc_html__( 'Parent Article:',            'helppress' ),
			'all_items'             => esc_html__( 'All Articles',               'helppress' ),
			'insert_into_item'      => esc_html__( 'Insert into article',        'helppress' ),
			'uploaded_to_this_item' => esc_html__( 'Uploaded to this article',   'helppress' ),
			'menu_name'             => esc_html__( 'HelpPress',                  'helppress' ),
		];

		$args = [
			'labels'        => $labels,
			'public'        => true,
			'menu_position' => 25,
			'menu_icon'     => 'dashicons-sos',
			'supports'      => [
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'comments',
				'revisions',
				'post-formats',
			],
			'has_archive'   => true,
			'rewrite'       => [
				'slug'       => helppress_get_option( 'knowledge_base_slug' ),
				'with_front' => false,
			],
		];

		$args = apply_filters( 'helppress_register_articles_args', $args );

		register_post_type( 'hp_article', $args );
	}

	/**
	 * Registers `hp_category` and `hp_tag` taxonomies.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function register_taxonomies() {
		$labels = [
			'name'          => esc_html__( 'Article Categories', 'helppress' ),
			'singular_name' => esc_html__( 'Article Category',   'helppress' ),
		];

		$args = [
			'labels'            => $labels,
			'public'            => true,
			'show_in_menu'      => 'edit.php?post_type=hp_article',
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => [
				'slug'       => helppress_get_option( 'category_slug' ),
				'with_front' => false,
			],
		];

		$args = apply_filters( 'helppress_register_categories_args', $args );

		register_taxonomy( 'hp_category', 'hp_article', $args );

		$labels = [
			'name'          => esc_html__( 'Article Tags', 'helppress' ),
			'singular_name' => esc_html__( 'Article Tag',  'helppress' ),
		];

		$args = [
			'labels'            => $labels,
			'public'            => true,
			'show_in_menu'      => 'edit.php?post_type=hp_article',
			'show_admin_column' => true,
			'rewrite'           => [
				'slug'       => helppress_get_option( 'tag_slug' ),
				'with_front' => false,
			],
		];

		$args = apply_filters( 'helppress_register_tags_args', $args );

		register_taxonomy( 'hp_tag', 'hp_article', $args );
	}

	/**
	 * Returns allowed `hp_article` post types.
	 *
	 * @access public
	 * @since 2.0.0
	 *
	 * @return array Allowed post types.
	 */
	public static function get_article_post_formats() {
		$post_formats = [
			'gallery',
			'link',
			'image',
			'video',
			'audio',
		];

		return apply_filters( 'helppress_article_post_formats', $post_formats );
	}

	/**
	 * Adjusts the allowed post formats for articles.
	 *
	 * @since 2.0.0
	 */
	public function add_article_post_formats_support() {
		$screen = get_current_screen();

		if ( 'hp_article' === $screen->post_type ) {
			add_theme_support( 'post-formats', self::get_article_post_formats() );
		}
	}

}

endif;

new HelpPress_Plugin();
