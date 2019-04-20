<?php do_action('helppress_before_article_item'); ?>

<div class="helppress-article-items__item">

	<?php do_action('helppress_before_article_item_header'); ?>

	<header class="helppress-article-items__item-header">

		<?php do_action('helppress_before_article_item_header_content'); ?>

		<h4 class="helppress-article-items__item-title">

			<a href="<?php echo esc_url(get_permalink()); ?>">
				<?php echo helppress_genericon(helppress_get_post_format()); ?>
				<span><?php the_title(); ?></span>
			</a>

		</h4>

		<?php do_action('helppress_after_article_item_header_content'); ?>

	</header>

	<?php do_action('helppress_after_article_item_header'); ?>

	<?php do_action('helppress_before_article_item_excerpt'); ?>

	<div class="helppress-article-items__item-excerpt">

		<?php do_action('helppress_before_article_item_excerpt_content'); ?>

		<?php the_excerpt(); ?>

		<?php do_action('helppress_after_article_item_excerpt_content'); ?>

	</div>

	<?php do_action('helppress_after_article_item_excerpt'); ?>

</div>

<?php do_action('helppress_after_article_item');
