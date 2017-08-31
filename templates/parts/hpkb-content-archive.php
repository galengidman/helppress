<?php hpkb_get_template_part( 'parts/hpkb-searchform', 'archive' ); ?>

<div class="hpkb-archive hpkb-archive--<?php echo esc_attr( hpkb_get_option( 'columns' ) ); ?>">
	<?php foreach ( hpkb_get_categories() as $category ) : ?>
		<div class="hpkb-archive__cat">
			<h2 class="hpkb-archive__cat-title">
				<span><?php echo $category->name; ?></span>
			</h2>

			<?php if ( $category->description ) : ?>
				<p class="hpkb-archive__cat-description"><?php echo $category->description; ?></p>
			<?php endif; ?>

			<?php $articles = hpkb_get_articles( array(
				'hpkb_category' => $category->slug,
				'fields'        => 'ids',
			) ); ?>

			<?php if ( $articles->have_posts() ) : ?>
				<ul class="hpkb-article-list">
					<?php while ( $articles->have_posts() ) : $articles->the_post(); ?>
						<?php hpkb_get_template_part( 'parts/hpkb-article-list-item', 'archive' ); ?>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
			<?php endif; ?>

			<p class="hpkb-archive__more">
				<a href="<?php echo esc_url( get_term_link( $category ) ) ?>">
					<span><?php esc_html_e( 'View more', 'hpkb' ); ?></span>
					<?php echo hpkb_genericon( 'next' ); ?>
				</a>
			</p>
		</div>
	<?php endforeach; ?>
</div>
