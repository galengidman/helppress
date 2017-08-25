<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'HPKB_Menu_Archive_Link' ) ) {

	class HPKB_Menu_Archive_Link {

		public function __construct() {

			add_action( 'admin_init', array( $this, 'add_meta_box' ) );

		}

		public function add_meta_box() {

			add_meta_box(
				'add-hpkb-archive-link',
				esc_html__( 'HelpPress', 'hpkb' ),
				array( $this, 'display_meta_box' ),
				'nav-menus',
				'side',
				'low'
			);

		}

		public function display_meta_box() {

			?>

			<div id="hpkb-archive-link" class="taxonomydiv">
				<div id="tabs-panel-hpkb-archive-link" class="tabs-panel tabs-panel-active">
					<ul id="hpkb-archive-link-checklist" class="categorychecklist form-no-clear">
						<li>
							<label class="menu-item-title">
								<input
									type="checkbox"
									class="menu-item-checkbox"
									name="menu-item[-1][menu-item-object-id]"
									value="-1"><?php

								esc_html_e( 'Knowledge Base', 'hpkb' ); ?>
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
								value="<?php esc_attr_e( 'Knowledge Base', 'hpkb' ); ?>">

							<input
								type="hidden"
								class="menu-item-url"
								name="menu-item[-1][menu-item-url]"
								value="<?php echo esc_url( hpkb_get_knowledge_base_url() ); ?>">

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
							value="<?php esc_attr_e( 'Add to Menu', 'hpkb' ); ?>"
							name="add-taxonomy-menu-item"
							id="submit-hpkb-archive-link">

						<span class="spinner"></span>
					</span>
				</p>
			</div>

			<?php

		}

	}

}

new HPKB_Menu_Archive_Link();
