<?php $context = helppress_get_kb_context(); ?>

<?php helppress_get_template_part( 'parts/helppress-open-content', $context ); ?>
	<?php helppress_get_template_part( 'parts/helppress-breadcrumb', $context ); ?>

	<div class="helppress-article-items">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php helppress_get_template_part( 'parts/helppress-article-item', $context ); ?>
		<?php endwhile; endif; ?>
	</div>

	<?php helppress_get_template_part( 'parts/helppress-post-nav', $context ); ?>
	<?php helppress_get_template_part( 'parts/helppress-searchform', $context ); ?>
<?php helppress_get_template_part( 'parts/helppress-close-content', $context );
