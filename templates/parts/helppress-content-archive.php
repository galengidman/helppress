<?php helppress_get_template_part( 'parts/helppress-open-content' ); ?>
	<?php helppress_get_template_part( 'parts/helppress-searchform', 'archive' ); ?>

	<?php

	$categories = helppress_get_categories();

	$archive_classes = array( 'helppress-archive' );
	if ( $categories ) {
		$archive_classes[] = 'helppress-archive--has-cats';
		$archive_classes[] = 'helppress-archive--' . helppress_get_option( 'columns' ) . '-col';
	} else {
		$archive_classes[] = 'helppress-archive--no-cats';
	}

	?>

	<div class="<?php echo join( ' ', array_map( 'esc_attr', $archive_classes ) ); ?>">
		<?php if ( $categories ) : ?>
			<?php foreach ( $categories as $category ) : ?>
				<div class="helppress-archive__cat">
					<?php $articles = helppress_get_articles( array(
						'hp_category' => $category->slug,
						'fields'      => 'ids',
					) ); ?>

					<h3 class="helppress-archive__cat-title">
						<span><?php echo $category->name; ?></span>
						<small class="helppress-archive__cat-count"><?php helppress_category_article_count( $category ); ?></small>
					</h3>

					<?php if ( $category->description ) : ?>
						<p class="helppress-archive__cat-description"><?php echo wptexturize( $category->description ); ?></p>
					<?php endif; ?>

					<?php if ( $articles->have_posts() ) : ?>
						<ul class="helppress-article-list">
							<?php while ( $articles->have_posts() ) : $articles->the_post(); ?>
								<?php helppress_get_template_part( 'parts/helppress-article-list-item', 'archive' ); ?>
							<?php endwhile; wp_reset_postdata(); ?>
						</ul>
					<?php endif; ?>

					<p class="helppress-archive__more">
						<a href="<?php echo esc_url( get_term_link( $category ) ) ?>">
							<span><?php esc_html_e( 'View more', 'helppress' ); ?></span>
							<?php echo helppress_genericon( 'next' ); ?>
						</a>
					</p>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
			<?php $articles = helppress_get_articles( array( 'fields' => 'ids' ) ); ?>

			<?php if ( $articles->have_posts() ) : ?>
				<ul class="helppress-article-list">
					<?php while ( $articles->have_posts() ) : $articles->the_post(); ?>
						<?php helppress_get_template_part( 'parts/helppress-article-list-item', 'archive' ); ?>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>

				<?php helppress_get_template_part( 'parts/helppress-post-nav', 'archive' ); ?>
			<?php else : ?>
				<p><?php esc_html_e( 'Nothing to see here… yet.', 'helppress' ); ?></p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php helppress_get_template_part( 'parts/helppress-close-content' );
