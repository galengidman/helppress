<div class="helppress__container">
	<?php helppress_get_template_part( 'breadcrumb' ); ?>

	<?php if ( have_posts() ) : ?>
		<ul class="helppress__articles">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php $article_id = get_the_id(); ?>
				<?php $icon       = helppress_article_format_icon( $article_id ); ?>
				<?php $title      = get_the_title( $article_id ); ?>
				<?php $permalink  = esc_url( get_permalink( $article_id ) ); ?>
				<li class="helppress__article"><a href="<?php echo $permalink; ?>"><?php echo $icon . $title ?></a></li>
			<?php endwhile; ?>
		</ul>
	<?php endif; ?>

	<?php helppress_get_template_part( 'search-form' ); ?>
</div>
