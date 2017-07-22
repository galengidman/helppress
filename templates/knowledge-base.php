<?php echo do_shortcode( '[helppress-search]' ); ?>

<div class="helppress__kb helppress__kb--<?php echo esc_attr( helppress_get_option( 'columns' ) ); ?>">
	<?php $categories = helppress_get_categories(); ?>
	<?php foreach ( $categories as $category ) : ?>
		<div class="helppress__cat">
			<h3 class="helppress__cat-title"><?php echo $category->name; ?></h3>

			<?php if ( $category->description ) : ?>
				<p class="helppress__cat-description"><?php echo $category->description; ?></p>
			<?php endif; ?>

			<ul class="helppress__articles">
				<?php $articles = helppress_get_articles( array( 'helppress_article_category' => $category->slug ) ); ?>
				<?php foreach ( $articles->posts as $article ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $article->ID ) ); ?>"><?php echo get_the_title( $article->ID ); ?></a></li>
				<?php endforeach; ?>
			</ul>

			<p class="helppress__more"><a href="<?php echo esc_url( get_term_link( $category ) ) ?>"><?php esc_html_e( 'View more', 'helppress' ); ?> &rarr;</a></p>
		</div>
	<?php endforeach; ?>
</div>
