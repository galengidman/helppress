<div class="hpkb-article-item">
	<header class="hpkb-article-item__header">
		<h4 class="hpkb-article-item__title">
			<a href="<?php esc_url( get_permalink() ); ?>">
				<?php echo hpkb_article_format_genericon(); ?>
				<span><?php the_title(); ?></span>
			</a>
		</h4>
	</header>

	<div class="hpkb-article-item__excerpt">
		<?php the_excerpt(); ?>
	</div>
</div>
