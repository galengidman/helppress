<?php helppress_get_template_part( 'parts/helppress-breadcrumb', 'search' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php helppress_get_template_part( 'parts/helppress-article-item', 'search' ); ?>
<?php endwhile; endif; ?>

<?php helppress_get_template_part( 'parts/helppress-post-nav', 'search' ); ?>
<?php helppress_get_template_part( 'parts/helppress-searchform', 'search' );
