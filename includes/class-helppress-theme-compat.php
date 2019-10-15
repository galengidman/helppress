<?php
/**
 * Theme Compatibility
 *
 * @package HelpPress
 * @since 2.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('HelpPress_Theme_Compat')) :

/**
 * Theme compatibility class.
 *
 * @since 2.0.0
 */
class HelpPress_Theme_Compat {

	/**
	 * Stack of prioritized templates to use for theme compatibility.
	 *
	 * @access protected
	 * @since 2.0.0
	 * @var array
	 */
	protected $compat_templates = [
		'helppress.php',
		'page.php',
		'single.php',
		'index.php',
	];

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function __construct() {
		add_action('init', [$this, 'compat_page_template']);

		add_action('template_include', [$this, 'template_include']);

		add_filter('pre_get_posts', [$this, 'query_mods']);

		add_filter('the_content', [$this, 'custom_content']);
		add_filter('the_excerpt', [$this, 'custom_content']);

		add_action('body_class', [$this, 'body_classes']);

		add_filter('document_title_parts', [$this, 'document_title']);
	}

	/**
	 * Adds template file as highest-priority compatibility template.
	 *
	 * @access protected
	 * @since 2.0.0
	 *
	 * @param string $template Template file.
	 */
	protected function add_compat_template($template) {
		$this->compat_templates = array_merge([$template], $this->compat_templates);
	}

	/**
	 * Adds page template to compat templates if selected.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function compat_page_template() {
		$page_template = helppress_get_option('page_template');
		$disable_page_template = apply_filters('helppress_disable_page_template', false);

		if ($page_template !== 'default' && ! $disable_page_template) {
			$this->add_compat_template($page_template);
		}
	}

	/**
	 * Filters template_include to power built-in theme compatibility.
	 *
	 * For most themes, it works best to adjust the default template hierarchy for HelpPress. It will
	 * first attempt to find one of the following in the active theme (or child theme) folder.
	 *
	 * - `helppress/helppress-article.php`
	 * - `helppress/helppress-archive.php`
	 * - `helppress/helppress-category.php`
	 * - `helppress/helppress-tag.php`
	 * - `helppress/helppress-search.php`
	 *
	 * If none of the above are found, it defaults to the first found fallback template from
	 * `$this->get_compat_templates()`.
	 *
	 * @see $this->get_compat_templates()
	 * @since 2.0.0
	 *
	 * @param string $template Default template.
	 * @return string Potentially modified template
	 */
	public function template_include($template) {
		if (! helppress_is_kb()) {
			return $template;
		}

		if (helppress_is_kb_article()) {
			$this->add_compat_template('helppress/helppress-article.php');
		} else {
			if (! $this->is_theme_compat_disabled()) {
				remove_all_filters('the_content');

				if (helppress_is_kb_archive()) {
					$this->reset_post([
						'post_title' => helppress_get_option('title'),
						'post_content' => helppress_buffer_template_part('parts/helppress-content-archive'),
					]);
				}

				elseif (helppress_is_kb_category()) {
					$this->reset_post([
						'post_title' => single_term_title('', false),
						'post_content' => helppress_buffer_template_part('parts/helppress-content-category'),
						'is_archive' => true,
						'is_tax' => true,
					]);
				}

				elseif (helppress_is_kb_tag()) {
					$this->reset_post([
						'post_title' => single_term_title('', false),
						'post_content' => helppress_buffer_template_part('parts/helppress-content-tag'),
						'is_archive' => true,
						'is_tax' => true,
					]);
				}

				elseif (helppress_is_kb_search()) {
					$this->reset_post([
						'post_title' => sprintf(
							esc_html__('Search results: &ldquo;%s&rdquo;', 'helppress'),
							get_search_query()
						),
						'post_content' => helppress_buffer_template_part('parts/helppress-content-search'),
					]);
				}
			}

			$context = helppress_get_kb_context();

			if (in_array($context, ['category', 'tag'])) {
				$this->add_compat_template('helppress/helppress-taxonomy.php');
			}

			$this->add_compat_template("helppress/helppress-{$context}.php");
		}

		return locate_template($this->compat_templates);
	}

	/**
	 * Filters default post queries to apply custom sorting and other functionality needed for built-in
	 * theme compatibility.
	 *
	 * Only applies if:
	 *
	 * - Is *not* admin.
	 * - Is main query
	 *
	 * Makes the following modifications:
	 *
	 * - Updates `orderby`, `order`, and `posts_per_page` params as configured in admin Settings.
	 * - Limits search results on KB searches to `hp_article` post type.
	 *
	 * @since 2.0.0
	 *
	 * @param object $query Default WP_Query.
	 * @return object Potentially adjusted WP_Query.
	 */
	public function query_mods($query) {
		if (is_admin()) {
			return $query;
		}

		if (! $query->is_main_query()) {
			return $query;
		}

		/**
		 * Modifies query to show front page if enabled in settings.
		 *
		 * @since 2.0.0
		 */
		if (helppress_get_option('show_on_front')) {
			$front_page = get_option('page_on_front');

			if ($front_page && $front_page == $query->get('page_id') || is_front_page()) {
				$query->set('page_id', 0);
				$query->set('paged', helppress_page_num());
				$query->set('post_type', 'hp_article');

				$query->is_archive = true;
				$query->is_home = false;
				$query->is_page = false;
				$query->is_post_type_archive = true;
				$query->is_singular = false;
			}
		}

		/**
		 * Updates order and ppp params whatever is configured in settings on KB pages.
		 *
		 * @since 1.0.0
		 */
		if (is_archive() && helppress_is_kb()) {
			$query->set('orderby', helppress_get_option('orderby'));
			$query->set('order', helppress_get_option('order'));
			$query->set('posts_per_page', helppress_get_option('posts_per_page'));
		}

		return $query;
	}

	/**
	 * Filters `post_content()` and `post_excerpt()` to add HelpPress content template.
	 *
	 * Applies custom content template if:
	 *
	 * - Is *not* admin
	 * - Is *not* feed
	 * - Is *not* JSON API
	 * - Is singular `hp_article`
	 * - Content comes from `hp_article` post type
	 *
	 * @access public
	 * @since 2.0.0
	 *
	 * @param string $content Default post content.
	 * @return string Potentially modified post content.
	 */
	public function custom_content($content) {
		global $post;

		if ($this->is_theme_compat_disabled()) {
			return $content;
		}

		if (is_admin()) {
			return $content;
		}

		if (is_feed()) {
			return $content;
		}

		if (defined('JSON_REQUEST') && JSON_REQUEST) {
			return $content;
		}

		if (helppress_is_kb_article() && 'hp_article' === $post->post_type) {
			ob_start();
			remove_filter('the_content', [$this, 'custom_content']);
			remove_filter('the_excerpt', [$this, 'custom_content']);
			helppress_get_template_part('parts/helppress-content-article');
			add_filter('the_content', [$this, 'custom_content']);
			add_filter('the_excerpt', [$this, 'custom_content']);
			$content = ob_get_clean();
		}

		return $content;
	}

	/**
	 * Fills up some WordPress globals with dummy data to stop your average page template from
	 * complaining about it missing.
	 *
	 * Straight up ripped from bbPress. :)
	 *
	 * @since 2.0.0
	 *
	 * @param array $args WP_Query arguments to override default, dummy query with.
	 */
	public static function reset_post($args = []) {
		global $wp_query, $post;

		if (isset($wp_query->post)) {
			$dummy = wp_parse_args($args, [
				'ID' => $wp_query->post->ID,
				'post_status' => $wp_query->post->post_status,
				'post_author' => $wp_query->post->post_author,
				'post_parent' => $wp_query->post->post_parent,
				'post_type' => $wp_query->post->post_type,
				'post_date' => $wp_query->post->post_date,
				'post_date_gmt' => $wp_query->post->post_date_gmt,
				'post_modified' => $wp_query->post->post_modified,
				'post_modified_gmt' => $wp_query->post->post_modified_gmt,
				'post_content' => $wp_query->post->post_content,
				'post_title' => $wp_query->post->post_title,
				'post_excerpt' => $wp_query->post->post_excerpt,
				'post_content_filtered' => $wp_query->post->post_content_filtered,
				'post_mime_type' => $wp_query->post->post_mime_type,
				'post_password' => $wp_query->post->post_password,
				'post_name' => $wp_query->post->post_name,
				'guid' => $wp_query->post->guid,
				'menu_order' => $wp_query->post->menu_order,
				'pinged' => $wp_query->post->pinged,
				'to_ping' => $wp_query->post->to_ping,
				'ping_status' => $wp_query->post->ping_status,
				'comment_status' => $wp_query->post->comment_status,
				'comment_count' => $wp_query->post->comment_count,
				'filter' => $wp_query->post->filter,

				'is_404' => false,
				'is_page' => false,
				'is_single' => false,
				'is_archive' => false,
				'is_tax' => false,
			]);
		} else {
			$dummy = wp_parse_args($args, [
				'ID' => -9999,
				'post_status' => 'publish',
				'post_author' => 0,
				'post_parent' => 0,
				'post_type' => 'page',
				'post_date' => 0,
				'post_date_gmt' => 0,
				'post_modified' => 0,
				'post_modified_gmt' => 0,
				'post_content' => '',
				'post_title' => '',
				'post_excerpt' => '',
				'post_content_filtered' => '',
				'post_mime_type' => '',
				'post_password' => '',
				'post_name' => '',
				'guid' => '',
				'menu_order' => 0,
				'pinged' => '',
				'to_ping' => '',
				'ping_status' => '',
				'comment_status' => 'closed',
				'comment_count' => 0,
				'filter' => 'raw',

				'is_404' => false,
				'is_page' => false,
				'is_single' => false,
				'is_archive' => false,
				'is_tax' => false,
			]);
		}

		if (empty($dummy)) {
			return;
		}

		$post = new WP_Post((object) $dummy);

		$wp_query->post = $post;
		$wp_query->posts = [$post];

		$wp_query->post_count = 1;
		$wp_query->is_404 = $dummy['is_404'];
		$wp_query->is_page = $dummy['is_page'];
		$wp_query->is_single = $dummy['is_single'];
		$wp_query->is_archive = $dummy['is_archive'];
		$wp_query->is_tax = $dummy['is_tax'];

		unset($dummy);

		if (! $wp_query->is_404()) {
			status_header(200);
		}
	}

	/**
	 * Adds custom body classes.
	 *
	 * @see body_class()
	 * @since 2.0.0
	 *
	 * @param array $classes Default WP body classes.
	 * @return array Filtered body classes.
	 */
	public function body_classes($classes) {
		if (helppress_is_kb()) {
			$classes[] = 'helppress';
			$classes[] = sanitize_html_class('helppress-' . helppress_get_kb_context());
		}

		// Mimic the WordPress body classes for page templates to help with theme styling
		if (helppress_is_kb() && helppress_get_option('page_template') !== 'default') {

			$classes[] = 'page-template';

			$template_slug = helppress_get_option('page_template');
			$template_parts = explode('/', $template_slug);

			foreach ($template_parts as $part) {
				$classes[] = 'page-template-' . sanitize_html_class(str_replace(['.', '/'], '-', basename($part, '.php')));
			}

			$classes[] = 'page-template-' . sanitize_html_class(str_replace('.', '-', $template_slug));

		}

		return $classes;
	}

	/**
	 * Filters document title to make adjustments where needed.
	 *
	 * - Updates title on main KB archive to KB title as configured in admin Settings.
	 * - Updates title on KB taxonomy pages to single term title.
	 *
	 * @since 2.0.0
	 *
	 * @param array $title_parts Document title parts.
	 * @return array Potentially modified title parts.
	 */
	public function document_title($title_parts) {
		if (helppress_is_kb_archive()) {
			$title_parts['title'] = helppress_get_option('title');
		}

		elseif (helppress_is_kb_category() || helppress_is_kb_tag()) {
			$title_parts['title'] = single_term_title('', false);
		}

		return $title_parts;
	}

	/**
	 * Returns whether theme compatibilty has been disabled.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Theme compatiblity status.
	 */
	protected function is_theme_compat_disabled() {
		return apply_filters('helppress_disable_theme_compat_mode', false);
	}

}

endif;

helppress_set('theme_compat', new HelpPress_Theme_Compat());
