<?php helppress_get_template_part( 'parts/helppress-open-content' ); ?>
	<?php helppress_get_template_part( 'parts/helppress-breadcrumb', 'article' ); ?>

	<div class="helppress-article__content">
		<?php the_content(); ?>
		<?php helppress_get_template_part( 'parts/helppress-page-links', 'article' ); ?>
	</div>
<?php helppress_get_template_part( 'parts/helppress-close-content' );
