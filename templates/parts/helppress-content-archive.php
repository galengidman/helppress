<?php helppress_get_template_part('parts/helppress-open-content'); ?>

	<?php helppress_get_template_part('parts/helppress-searchform', 'archive'); ?>

	<?php

	$categories = helppress_get_categories();

	$archive_classes = ['helppress-archive'];
	if ($categories) {
		$archive_classes[] = 'helppress-archive--has-cats';
		$archive_classes[] = 'helppress-archive--' . helppress_get_option('columns') . '-col';
	} else {
		$archive_classes[] = 'helppress-archive--no-cats';
	}

	?>

	<?php do_action('helppress_before_archive'); ?>

	<div class="<?php echo join(' ', array_map('esc_attr', $archive_classes)); ?>">

		<?php do_action('helppress_before_archive_content'); ?>

		<?php if ($categories) : ?>

			<?php foreach ($categories as $category) : ?>

				<?php do_action('helppress_before_archive_cat'); ?>

				<div class="helppress-archive__cat">

					<?php do_action('helppress_before_archive_cat_content'); ?>

					<?php do_action('helppress_before_archive_cat_title'); ?>

					<h3 class="helppress-archive__cat-title">
						<span><?php echo $category->name; ?></span>
						<small class="helppress-archive__cat-count"><?php helppress_category_article_count($category); ?></small>
					</h3>

					<?php do_action('helppress_after_archive_cat_title'); ?>

					<?php if ($category->description) : ?>

						<?php do_action('helppress_before_archive_cat_description'); ?>

						<p class="helppress-archive__cat-description"><?php echo wptexturize($category->description); ?></p>

						<?php do_action('helppress_after_archive_cat_description'); ?>

					<?php endif; ?>

					<?php $articles = helppress_get_articles([
						'hp_category' => $category->slug,
						'fields' => 'ids',
					]); ?>

					<?php if ($articles->have_posts()) : ?>

						<?php do_action('helppress_before_article_list'); ?>

						<ul class="helppress-article-list">

							<?php do_action('helppress_before_article_list_items'); ?>

							<?php while ($articles->have_posts()) : $articles->the_post(); ?>
								<?php helppress_get_template_part('parts/helppress-article-list-item', 'archive'); ?>
							<?php endwhile; wp_reset_postdata(); ?>

							<?php do_action('helppress_after_article_list_items'); ?>

						</ul>

						<?php do_action('helppress_after_article_list'); ?>

					<?php endif; ?>

					<?php if (helppress_is_paginated()) : ?>

						<?php do_action('helppress_before_archive_more'); ?>

						<p class="helppress-archive__more">
							<a href="<?php echo esc_url(get_term_link($category)) ?>">
								<span><?php esc_html_e('View more', 'helppress'); ?></span>
								<?php echo helppress_genericon('next'); ?>
							</a>
						</p>

						<?php do_action('helppress_after_archive_more'); ?>

					<?php endif; ?>

					<?php do_action('helppress_after_archive_cat_content'); ?>

				</div>

				<?php do_action('helppress_after_archive_cat'); ?>

			<?php endforeach; ?>

		<?php else : ?>

			<?php $articles = helppress_get_articles(['fields' => 'ids']); ?>

			<?php if ($articles->have_posts()) : ?>

				<?php do_action('helppress_before_article_list'); ?>

				<ul class="helppress-article-list">

					<?php do_action('helppress_before_article_list_items'); ?>

					<?php while ($articles->have_posts()) : $articles->the_post(); ?>
						<?php helppress_get_template_part('parts/helppress-article-list-item', 'archive'); ?>
					<?php endwhile; wp_reset_postdata(); ?>

					<?php do_action('helppress_after_article_list_items'); ?>

				</ul>

				<?php do_action('helppress_after_article_list'); ?>

				<?php helppress_get_template_part('parts/helppress-post-nav', 'archive'); ?>

			<?php else : ?>

				<?php do_action('helppress_before_archive_nothing'); ?>

				<p><?php esc_html_e('Nothing to see here… yet.', 'helppress'); ?></p>

				<?php do_action('helppress_after_archive_nothing'); ?>

			<?php endif; ?>

		<?php endif; ?>

		<?php do_action('helppress_after_archive_content'); ?>

	</div>

	<?php do_action('helppress_after_archive'); ?>

<?php helppress_get_template_part('parts/helppress-close-content');
