<?php hpkb_get_template_part( 'parts/hpkb-breadcrumb', 'category' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php hpkb_get_template_part( 'parts/hpkb-article-item', 'category' ); ?>
<?php endwhile; endif; ?>

<?php hpkb_get_template_part( 'parts/hpkb-post-nav', 'category' ); ?>
<?php hpkb_get_template_part( 'parts/hpkb-searchform', 'category' );
