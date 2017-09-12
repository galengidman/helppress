<div class="helppress-article-items__item">
	<header class="helppress-article-items__item-header">
		<h4 class="helppress-article-items__item-title">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo helppress_genericon( helppress_get_post_format() ); ?>
				<span><?php the_title(); ?></span>
			</a>
		</h4>
	</header>

	<div class="helppress-article-items__item-excerpt">
		<?php the_excerpt(); ?>
	</div>
</div>
