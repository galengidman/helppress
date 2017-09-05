<div class="helppress-content helppress-content--taxonomy helppress-content--category">
	<?php helppress_get_template_part( 'parts/helppress-breadcrumb', 'category' ); ?>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php helppress_get_template_part( 'parts/helppress-article-item', 'category' ); ?>
	<?php endwhile; endif; ?>

	<?php helppress_get_template_part( 'parts/helppress-post-nav', 'category' ); ?>
	<?php helppress_get_template_part( 'parts/helppress-searchform', 'category' ); ?>
</div>
