<?php
/**
 * Search
 *
 * @package HelpPress
 * @since 2.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('HelpPress_Search')) :

/**
 * Search class.
 *
 * @since 2.0.0
 */
class HelpPress_Search {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function __construct() {
		add_action('query_vars', [$this, 'add_query_var']);
		add_filter('pre_get_posts', [$this, 'search_query_mods']);

		add_action('wp_ajax_helppress_search_suggestions', [$this, 'get_suggestions']);
		add_action('wp_ajax_nopriv_helppress_search_suggestions', [$this, 'get_suggestions']);
	}

	/**
	 * Adds additional query vars to WP_Query.
	 *
	 * @since 2.0.0
	 *
	 * @param array $vars Default query vars.
	 * @return array Extended query vars.
	 */
	public function add_query_var($vars = []) {
		$vars[] = 'hps';
		return $vars;
	}

	/**
	 * Filters default search query as needed to make KB search work.
	 *
	 * Only applies if:
	 *
	 * - Is *not* admin.
	 * - Is main query
	 *
	 * Makes the following modifications:
	 *
	 * - Updates `posts_per_page` param as configured in admin Settings.
	 * - Limits search results on KB searches to `hp_article` post type.
	 *
	 * @since 2.0.0
	 *
	 * @param object $query Default WP_Query.
	 * @return object Potentially adjusted WP_Query.
	 */
	public function search_query_mods($query) {
		if (is_admin()) {
			return $query;
		}

		if (! $query->is_main_query()) {
			return $query;
		}

		if (! helppress_is_kb_search()) {
			return $query;
		}

		$query->set('post_type', 'hp_article');
		$query->set('posts_per_page', helppress_get_option('posts_per_page'));

		return $query;
	}

	/**
	 * Output search suggestions (results) as JSON for current search term.
	 *
	 * @access public
	 * @since 2.0.0
	 */
	public function get_suggestions() {
		$articles = new WP_Query([
			's' => $_REQUEST['query'],
			'post_type' => 'hp_article',
			'fields' => 'ids',
			'no_found_rows' => true,
			'posts_per_page' => helppress_get_option('search_suggestions_number'),
		]);

		$suggestions = ['suggestions' => []];

		foreach ($articles->posts as $article_id) {
			$suggestions['suggestions'][] = [
				'value' => get_the_title($article_id),
				'data' => esc_url(get_permalink($article_id)),
			];
		}

		echo html_entity_decode(json_encode($suggestions));

		exit;
	}

}

endif;

helppress_set('search', new HelpPress_Search());
