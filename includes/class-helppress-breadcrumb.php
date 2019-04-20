<?php
/**
 * Breadcrumb
 *
 * @package WordPress
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('HelpPress_Breadcrumb')) :

/**
 * HelpPress breadcrumb class.
 *
 * @since 1.0.0
 */
class HelpPress_Breadcrumb {

	/**
	 * Breadcrumb trail.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @var array
	 */
	protected $trail = [];

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->build_trail();
	}

	/**
	 * Builds the breadcrumb trail.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function build_trail() {
		if (helppress_get_option('breadcrumb_home')) {
			$this->add(
				esc_html__('Home', 'helppress'),
				home_url('/')
			);
		}

		$this->add(
			helppress_get_option('title'),
			helppress_get_kb_url()
		);

		if (is_singular('hp_article')) {
			$article_categories = wp_get_post_terms(
				get_the_id(),
				'hp_category',
				['fields' => 'ids']
			);

			if (isset($article_categories[0])) {
				$this->add_tax_tree($article_categories[0]);
			}

			$this->add(
				get_the_title(),
				get_permalink()
			);
		}

		if (is_tax(['hp_category', 'hp_tag'])) {
			$this->add_tax_tree(get_queried_object_id());
		}

		elseif (is_search()) {
			$this->add(
				get_search_query(),
				get_search_link()
			);
		}
	}

	/**
	 * Returns the breadcrumb trail.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @return array Breadcrumb trail.
	 */
	public function get_trail() {
		return $this->trail;
	}

	/**
	 * Adds crumb to the trail.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @param string $label Crumb label.
	 * @param string $url Crumb URL.
	 */
	protected function add($label, $url) {
		$this->trail[] = ['label' => $label, 'url' => $url];
	}

	/**
	 * Adds taxonomy and its acestors to the breadcrumb trail.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @param integer $term_id Term ID to add.
	 */
	protected function add_tax_tree($term_id) {
		if (term_exists($term_id)) {
			$term = get_term($term_id);
			$tree = [$term->term_id];
			$ancestors = get_ancestors($term->term_id, $term->term_slug, 'taxonomy');

			if ($ancestors) {
				$tree = array_merge($ancestors, $tree);
			}

			foreach ($tree as $term_id) {
				$term = get_term($term_id);

				$this->add(
					$term->name,
					get_term_link($term)
				);
			}
		}
	}

}

endif;
