<?php hpkb_get_template_part( 'parts/hpkb-breadcrumb', 'search' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php hpkb_get_template_part( 'parts/hpkb-article-item', 'search' ); ?>
<?php endwhile; endif; ?>

<?php hpkb_get_template_part( 'parts/hpkb-post-nav', 'search' ); ?>
<?php hpkb_get_template_part( 'parts/hpkb-searchform', 'search' );
