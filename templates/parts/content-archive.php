<div class="hpkb__container">
	<?php hpkb_get_template_part( 'parts/search-form' ); ?>

	<div class="hpkb__archive hpkb__archive--<?php echo esc_attr( hpkb_get_option( 'columns' ) ); ?>">
		<?php foreach ( hpkb_get_categories() as $category ) : ?>
			<div class="hpkb__archive-cat">
				<h2 class="hpkb__archive-cat-title"><?php echo $category->name; ?></h2>

				<?php if ( $category->description ) : ?>
					<p class="hpkb__archive-cat-description"><?php echo $category->description; ?></p>
				<?php endif; ?>

				<ul class="hpkb__article-list">
					<?php $articles = hpkb_get_articles( array(
						'hpkb_article_category' => $category->slug,
						'fields'                     => 'ids',
						'posts_per_page'             => 5,
					) )->posts; ?>

					<?php foreach ( $articles as $article_id ) : ?>
						<?php $icon      = hpkb_article_format_icon( $article_id ); ?>
						<?php $title     = get_the_title( $article_id ); ?>
						<?php $permalink = esc_url( get_permalink( $article_id ) ); ?>
						<li class="hpkb__article-list-item"><a href="<?php echo $permalink; ?>"><?php echo $icon . $title ?></a></li>
					<?php endforeach; ?>
				</ul>

				<p class="hpkb__more"><a href="<?php echo esc_url( get_term_link( $category ) ) ?>"><?php esc_html_e( 'View more', 'hpkb' ); ?> <?php echo hpkb_genericon( 'next' ); ?></a></p>
			</div>
		<?php endforeach; ?>
	</div>
</div>
