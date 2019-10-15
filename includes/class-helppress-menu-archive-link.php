<?php
/**
 * Menu Archive Link
 *
 * @package HelpPress
 * @since 1.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

if (! class_exists('HelpPress_Menu_Archive_Link')) :

/**
 * Menu archive link class.
 *
 * @since 1.0.0
 */
class HelpPress_Menu_Archive_Link {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action('admin_init', [$this, 'add_meta_box']);
	}

	/**
	 * Adds the meta box to the nav menus screen.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function add_meta_box() {
		add_meta_box(
			'add-helppress-archive-link',
			esc_html__('HelpPress', 'helppress'),
			[$this, 'display_meta_box'],
			'nav-menus',
			'side',
			'low'
		);
	}

	/**
	 * Displays the meta box.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function display_meta_box() {
		?>

		<div id="helppress-archive-link" class="taxonomydiv">
			<div id="tabs-panel-helppress-archive-link" class="tabs-panel tabs-panel-active">
				<ul id="helppress-archive-link-checklist" class="categorychecklist form-no-clear">
					<li>
						<label class="menu-item-title">
							<input
								type="checkbox"
								class="menu-item-checkbox"
								name="menu-item[-1][menu-item-object-id]"
								value="-1"><?php

							echo esc_html(helppress_get_option('title')); ?>
						</label>

						<input
							type="hidden"
							class="menu-item-type"
							name="menu-item[-1][menu-item-type]"
							value="custom">

						<input
							type="hidden"
							class="menu-item-title"
							name="menu-item[-1][menu-item-title]"
							value="<?php echo esc_attr(helppress_get_option('title')); ?>">

						<input
							type="hidden"
							class="menu-item-url"
							name="menu-item[-1][menu-item-url]"
							value="<?php echo esc_url(helppress_get_kb_url()); ?>">

						<input
							type="hidden"
							class="menu-item-classes"
							name="menu-item[-1][menu-item-classes]">
					</li>
				</ul>
			</div>

			<p class="button-controls wp-clearfix">
				<span class="add-to-menu">
					<input
						type="submit"
						class="button-secondary submit-add-to-menu right"
						value="<?php esc_attr_e('Add to Menu', 'helppress'); ?>"
						name="add-taxonomy-menu-item"
						id="submit-helppress-archive-link">

					<span class="spinner"></span>
				</span>
			</p>
		</div>

		<?php
	}

}

endif;

helppress_set('menu_archive_link', new HelpPress_Menu_Archive_Link());
