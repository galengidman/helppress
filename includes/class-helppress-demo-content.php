<?php
/**
 * Demo Content
 *
 * @package WordPress
 * @since 1.1.0
 */

if (! defined('ABSPATH')) {
	exit;
}

use \YeEasyAdminNotices\V1\AdminNotice;

if (! class_exists('HelpPress_Demo_Content')) :

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
	 * Admin AJAX action name to trigger demo content install.
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
		add_action('admin_init', [$this, 'install']);
		add_action('admin_notices', [$this, 'prompt_admin_notice']);
	}

	/**
	 * Installs demo content.
	 *
	 * Runs on admin_init if the following conditions are met:
	 *
	 * - Is in WordPress admin
	 * - `helppress_action` URL parameter is set and equals `install_demo_content`
	 * - `helppress_install_demo_content` nonce verifies
	 * - Demo content has *not* already been installed
	 *
	 * @access public
	 * @since 1.1.0
	 */
	public function install() {
		if (! is_admin()) {
			return;
		}

		if (! isset($_GET['helppress_action']) || $_GET['helppress_action'] !== 'install_demo_content') {
			return;
		}

		if (! wp_verify_nonce($_REQUEST['_wpnonce'], 'helppress_install_demo_content')) {
			return;
		}

		if ($this->is_installed()) {
			return;
		}

		$structure = json_decode(file_get_contents($this->structure));

		$tags = json_decode(file_get_contents($this->tags));

		$article_content = trim(file_get_contents($this->article_content));

		$post_formats = helppress_get_article_post_formats();
		// Adding 6 `standard` format posts vs 1 of alternate formats
		$post_formats = array_merge($post_formats, array_fill(0, 6, 'standard'));

		$existing_terms = [];

		$i = 1;
		foreach ($structure as $category) {
			foreach ($category->articles as $article_title) {
				$post_id = wp_insert_post([
					'post_title' => $article_title,
					'post_content' => $article_content,
					'post_type' => 'hp_article',
					'post_status' => 'publish',
					'post_date' => date('Y-m-d H:i:s', time() - ($i * DAY_IN_SECONDS)),
				]);

				set_post_format($post_id, $post_formats[array_rand($post_formats)]);

				if (array_key_exists($category->name, $existing_terms)) {
					$category_object = $existing_terms[$category->name];
				} else {
					$category_object = wp_insert_term($category->name, 'hp_category');
					$existing_terms[$category->name] = $category_object;
				}

				$category_id = (int) $category_object['term_id'];

				wp_set_post_terms($post_id, [$category_id], 'hp_category');

				$tag_indexes = array_rand($tags, 4);
				foreach ($tag_indexes as $index) {
					$tag_name = $tags[$index];

					if (term_exists($tag_name, 'hp_tag')) {
						$tag_object = get_term_by('name', $tag_name, 'hp_tag', ARRAY_A);
					} else {
						$tag_object = wp_insert_term($tag_name, 'hp_tag');
					}

					$tag_id = (int) $tag_object['term_id'];

					wp_set_post_terms($post_id, [$tag_id], 'hp_tag', true);
				}

				$i++;
			}
		}

		update_option($this->option_name, true, false);

		AdminNotice::create()
			->success()
			->text(esc_html__('Demo content installed!', 'helppress'))
			->dismissible()
			->show();
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
		return (bool) get_option($this->option_name);
	}

	/**
	 * Conditionally prompts admin notice to install demo content.
	 *
	 * Displays if the following conditions are met:
	 *
	 * - Demo content is *not* already installed
	 * - Admin screen is post_type `hp_article`
	 * - No existing, published `hp_article` post types exist
	 * - Notice has not been previously dismissed
	 *
	 * @access public
	 * @since 1.1.0
	 */
	public function prompt_admin_notice() {
		if ($this->is_installed()) {
			return;
		}

		$screen = get_current_screen();
		if ($screen->post_type !== 'hp_article') {
			return;
		}

		$existing_articles = get_posts([
			'posts_per_page' => 1,
			'post_type' => 'hp_article',
			'fields' => 'ids',
		]);

		if ($existing_articles) {
			return;
		}

		// Must replace &amp; → & to get persistent dismissal to work.
		// That only took *forever* to figure out. :|
		$install_url = str_replace('&amp;', '&', esc_url_raw(
			wp_nonce_url(
				add_query_arg([
					'post_type' => 'hp_article',
					'helppress_action' => 'install_demo_content',
				], admin_url('edit.php')),
				'helppress_install_demo_content'
			)
		));

		ob_start();

		?>

		<p><?php esc_html_e('HelpPress includes build-in demo content to give you a head start. Would you like to install it now?', 'helppress'); ?></p>
		<p><a href="<?php echo $install_url; ?>" class="button button-primary"><?php esc_html_e('Install Demo Content', 'helppress'); ?></a></p>

		<?php

		$notice_markup = ob_get_clean();

		AdminNotice::create('helppress_install_demo_content')
			->info()
			->rawHtml($notice_markup)
			->persistentlyDismissible()
			->show();
	}

}

endif;

helppress_set('demo_content', new HelpPress_Demo_Content());
