<div class="helppress__container">
	<?php helppress_get_template_part( 'parts/breadcrumb' ); ?>

	<?php if ( have_posts() ) : ?>
		<ul class="helppress__article-list">
			<?php helppress_get_template_part( 'parts/article-list' ); ?>
		</ul>
	<?php endif; ?>

	<?php helppress_get_template_part( 'parts/search-form' ); ?>
</div>
