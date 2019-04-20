<?php do_action('helppress_before_article_list_item'); ?>

<li class="helppress-article-list__item">

	<?php do_action('helppress_before_article_list_item_content'); ?>

	<a href="<?php echo esc_url(get_permalink()); ?>">
		<?php echo helppress_genericon(helppress_get_post_format()); ?>
		<span><?php the_title(); ?></span>
	</a>

	<?php do_action('helppress_after_article_list_item_content'); ?>

</li>

<?php do_action('helppress_after_article_list_item');
