<?php helppress_get_template_part( 'parts/helppress-searchform', 'archive' ); ?>

<div class="helppress-archive helppress-archive--<?php echo esc_attr( helppress_get_option( 'columns' ) ); ?>">
	<?php foreach ( helppress_get_categories() as $category ) : ?>
		<div class="helppress-archive__cat">
			<h2 class="helppress-archive__cat-title">
				<span><?php echo $category->name; ?></span>
			</h2>

			<?php if ( $category->description ) : ?>
				<p class="helppress-archive__cat-description"><?php echo $category->description; ?></p>
			<?php endif; ?>

			<?php $articles = helppress_get_articles( array(
				'hp_category' => $category->slug,
				'fields'      => 'ids',
			) ); ?>

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
</div>
