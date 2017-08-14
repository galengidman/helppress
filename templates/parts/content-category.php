<div class="hpkb__container">
	<?php hpkb_get_template_part( 'parts/breadcrumb' ); ?>

	<?php if ( have_posts() ) : ?>
		<ul class="hpkb__article-list">
			<?php hpkb_get_template_part( 'parts/article-list' ); ?>
		</ul>
	<?php endif; ?>

	<?php hpkb_get_template_part( 'parts/search-form' ); ?>
</div>
