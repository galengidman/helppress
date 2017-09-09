<?php
/**
 * Demo Content
 *
 * @package WordPress
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HelpPress_Demo_Content' ) ) :

/**
 * Demo content class.
 */
class HelpPress_Demo_Content {

	/**
	 * Path to demo content structure data.
	 *
	 * @access protected
	 * @since 1.1.0
	 * @var string
	 */
	protected $structure = HELPPRESS_PATH . '/demo-content/structure.json';

	/**
	 * Path to demo content tags data.
	 *
	 * @access protected
	 * @since 1.1.0
	 * @var string
	 */
	protected $tags = HELPPRESS_PATH . '/demo-content/tags.json';

	/**
	 * Path to demo content article markup.
	 *
	 * @access protected
	 * @since 1.1.0
	 * @var string
	 */
	protected $article_content = HELPPRESS_PATH . '/demo-content/article.html';

	/**
	 * Admin AJAX action name to trigger demo content install
	 *
	 * @access protected
	 * @since 1.1.0
	 * @var string
	 */
	protected $action_name = 'helppress_install_demo_content';

	/**
	 * Option name to indicate demo content has been installed.
	 *
	 * @access protected
	 * @since 1.1.0
	 * @var string
	 */
	protected $option_name = 'helppress_demo_content_installed';

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.1.0
	 */
	public function __construct() {

		add_action( "wp_ajax_{$this->action_name}", array( $this, 'install' ) );

	}

	/**
	 * Installs demo content.
	 *
	 * @access public
	 * @since 1.1.0
	 */
	public function install() {

		if ( $this->is_installed() ) {
			echo json_encode( array(
				'status'  => 'error',
				'message' => esc_html__( 'Demo content already installed.', 'helppress' ),
			) );

			exit;
		}

		$structure = json_decode( file_get_contents( $this->structure ) );

		$tags = json_decode( file_get_contents( $this->tags ) );

		$article_content = trim( file_get_contents( $this->article_content ) );

		$post_formats = helppress_get_article_post_formats();
		$post_formats = array_merge( $post_formats, array_fill( 0, 6, 'standard' ) );

		$i = 1;
		foreach ( $structure as $category ) {
			foreach ( $category->articles as $article_title ) {
				if ( term_exists( $category->name, 'hp_category' ) ) {
					$category_id = get_term_by( 'name', $category->name, 'hp_category' );
					$category_id = (int) $category_id->term_id;
				} else {
					$category_id = wp_insert_term( $category->name, 'hp_category' );
				}

				$post_id = wp_insert_post( array(
					'post_title'   => $article_title,
					'post_content' => $article_content,
					'post_type'    => 'hp_article',
					'post_status'  => 'publish',
					'post_date'    => date( 'Y-m-d H:i:s', time() - ($i * DAY_IN_SECONDS) ),
				) );

				set_post_format( $post_id, $post_formats[ array_rand( $post_formats) ] );

				wp_set_post_terms( $post_id, $category_id, 'hp_category' );

				for ( $i2 = 0; $i2 < 5; $i2++ ) {
					$tag = $tags[ array_rand( $tags ) ];
					wp_set_post_terms( $post_id, $tag, 'hp_tag', true );
					$i2++;
				}

				$i++;
			}
		}

		update_option( $this->option_name, true, false );

		echo json_encode( array(
			'status'  => 'success',
			'message' => esc_html__( 'Demo content successfully installed.', 'helppress' ),
		) );

		exit;

	}

	/**
	 * Returns whether demo content has been installed.
	 *
	 * @access public
	 * @since 1.1.0
	 *
	 * @return boolean Whether demo content has been installed.
	 */
	public function is_installed() {

		return (bool) get_option( $this->option_name );

	}

}

endif;

new HelpPress_Demo_Content();
