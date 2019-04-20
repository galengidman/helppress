<?php

if (! helppress_get_option('search')) {
	return;
}

$input_classes = ['helppress-search__input'];
if (helppress_get_option('search_suggestions')) {
	$input_classes[] = 'helppress-search__input--suggest';
}

?>

<?php do_action('helppress_before_search'); ?>

<div class="helppress-search">

	<?php do_action('helppress_before_search_form'); ?>

	<form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="helppress-search__form" role="search">

		<?php do_action('helppress_before_search_form_content'); ?>

		<?php do_action('helppress_before_search_label'); ?>

		<label class="helppress-search__label">

			<span class="screen-reader-text"><?php esc_html_e('Search for:', 'helppress'); ?></span>

			<?php do_action('helppress_before_search_input'); ?>

			<input
				type="search"
				name="s"
				class="<?php echo esc_attr(join(' ', $input_classes)); ?>"
				value="<?php echo esc_attr(get_search_query()); ?>"
				placeholder="<?php echo esc_attr(helppress_get_option('search_placeholder')); ?>"
				<?php if (helppress_get_option('search_autofocus')) echo 'autofocus'; ?>>

			<?php do_action('helppress_after_search_label'); ?>

		</label>

		<?php do_action('helppress_after_search_label'); ?>

		<?php do_action('helppress_before_search_submit'); ?>

		<button type="submit" class="helppress-search__submit helppress-button button">
			<span><?php echo esc_html_e('Search', 'helppress'); ?></span>
		</button>

		<?php do_action('helppress_after_search_submit'); ?>

		<input type="hidden" name="hps" value="1">

		<?php do_action('helppress_after_search_form_content'); ?>

	</form>

	<?php do_action('helppress_after_search_form'); ?>

	<div class="helppress-search__suggestions" style="position: relative;"></div>
</div>

<?php do_action('helppress_after_search');
