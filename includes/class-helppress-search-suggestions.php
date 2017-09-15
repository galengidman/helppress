<?php
/**
 * Search Suggestions
 *
 * @package HelpPress
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HelpPress_Search_Suggestions' ) ) :

/**
 * Search suggestions class.
 */
class HelpPress_Search_Suggestions {

	/**
	 * Admin AJAX action name.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @var string
	 */
	protected $action_name = 'helppress_search_suggestions';

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( "wp_ajax_{$this->action_name}",        array( $this, 'get_suggestions' ) );
		add_action( "wp_ajax_nopriv_{$this->action_name}", array( $this, 'get_suggestions' ) );

	}

	/**
	 * Output search suggestions (results) as JSON for current search term.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function get_suggestions() {

		$articles = new WP_Query( array(
			's'              => $_REQUEST['query'],
			'post_type'      => 'hp_article',
			'fields'         => 'ids',
			'no_found_rows'  => true,
			'posts_per_page' => helppress_get_option( 'search_suggestions_number' ),
		) );

		$suggestions = array( 'suggestions' => array() );

		foreach ( $articles->posts as $article_id ) {
			$suggestions['suggestions'][] = array(
				'value' => get_the_title( $article_id ),
				'data'  => esc_url( get_permalink( $article_id ) ),
			);
		}

		echo html_entity_decode( json_encode( $suggestions ) );

		exit;

	}

}

endif;

new HelpPress_Search_Suggestions();
