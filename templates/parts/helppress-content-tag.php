<div class="helppress-content helppress-content--taxonomy helppress-content--tag">
	<?php helppress_get_template_part( 'parts/helppress-breadcrumb', 'tag' ); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php helppress_get_template_part( 'parts/helppress-article-item', 'tag' ); ?>
	<?php endwhile; endif; ?>

	<?php helppress_get_template_part( 'parts/helppress-post-nav', 'tag' ); ?>
	<?php helppress_get_template_part( 'parts/helppress-searchform', 'tag' ); ?>
</div>
