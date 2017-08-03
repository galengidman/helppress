<div class="helppress__container">
	<?php helppress_get_template_part( 'partials/helppress-search-form' ); ?>

	<div class="helppress__kb helppress__kb--<?php echo esc_attr( helppress_get_option( 'columns' ) ); ?>">
		<?php foreach ( helppress_get_categories() as $category ) : ?>
			<div class="helppress__cat">
				<h2 class="helppress__cat-title"><?php echo $category->name; ?></h2>

				<?php if ( $category->description ) : ?>
					<p class="helppress__cat-description"><?php echo $category->description; ?></p>
				<?php endif; ?>

				<ul class="helppress__articles">
					<?php $articles = helppress_get_articles( array(
						'helppress_article_category' => $category->slug,
						'fields'                     => 'ids',
						'posts_per_page'             => 5,
					) )->posts; ?>

					<?php foreach ( $articles as $article_id ) : ?>
						<?php $icon      = helppress_article_format_icon( $article_id ); ?>
						<?php $title     = get_the_title( $article_id ); ?>
						<?php $permalink = esc_url( get_permalink( $article_id ) ); ?>
						<li class="helppress__article"><a href="<?php echo $permalink; ?>"><?php echo $icon . $title ?></a></li>
					<?php endforeach; ?>
				</ul>

				<p class="helppress__more"><a href="<?php echo esc_url( get_term_link( $category ) ) ?>"><?php esc_html_e( 'View more', 'helppress' ); ?> <?php echo helppress_genericon( 'next' ); ?></a></p>
			</div>
		<?php endforeach; ?>
	</div>
</div>
