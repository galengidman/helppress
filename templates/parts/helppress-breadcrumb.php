<?php

if (! helppress_get_option('breadcrumb')) {
	return;
}

?>

<?php do_action('helppress_before_breadcrumb'); ?>

<ol class="helppress-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">

	<?php do_action('helppress_before_breadcrumb_items'); ?>

	<?php $i = 1; foreach (helppress_get_breadcrumb() as $crumb) : ?>

		<?php do_action('helppress_before_breadcrumb_item'); ?>

		<li
			class="helppress-breadcrumb__crumb"
			itemprop="itemListElement"
			itemscope
			itemtype="http://schema.org/ListItem"
			data-sep="<?php echo esc_attr(helppress_get_option('breadcrumb_sep')); ?>">

			<?php do_action('helppress_before_breadcrumb_item_content'); ?>

			<a href="<?php echo esc_url($crumb['url']); ?>" itemprop="item">
				<span itemprop="name"><?php echo $crumb['label']; ?></span><?php
				?><meta itemprop="position" content="<?php echo esc_attr($i); ?>"><?php
			?></a>

			<?php do_action('helppress_after_breadcrumb_item_content'); ?>

		</li>

		<?php do_action('helppress_after_breadcrumb_item'); ?>

	<?php $i++; endforeach; ?>

	<?php do_action('helppress_after_breadcrumb_items'); ?>

</ol>

<?php do_action('helppress_after_breadcrumb');
