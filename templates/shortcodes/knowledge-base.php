<?php echo do_shortcode( '[wpkb-search]' ); ?>

<div class="wpkb__kb wpkb__kb--<?php echo wpkb_get_option( 'columns' ); ?>">
	<?php $categories = wpkb_get_categories(); ?>
	<?php foreach ( $categories as $category ) : ?>
		<div class="wpkb__cat">
			<h3 class="wpkb__cat-title"><?php echo $category->name; ?></h3>

			<?php if ( $category->description ) : ?>
				<p class="wpkb__cat-description"><?php echo $category->description; ?></p>
			<?php endif; ?>

			<ul class="wpkb__articles">
				<?php $articles = wpkb_get_articles( array( 'wpkb_article_category' => $category->slug ) ); ?>
				<?php foreach ( $articles->posts as $article ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $article->ID ) ); ?>"><?php echo get_the_title( $article->ID ); ?></a></li>
				<?php endforeach; ?>
			</ul>

			<p class="wpkb__more"><a href="<?php echo esc_url( get_term_link( $category ) ) ?>"><?php esc_html_e( 'View more', 'wpkb' ); ?> &rarr;</a></p>
		</div>
	<?php endforeach; ?>
</div>
