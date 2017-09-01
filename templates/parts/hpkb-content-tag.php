<?php hpkb_get_template_part( 'parts/hpkb-breadcrumb', 'tag' ); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php hpkb_get_template_part( 'parts/hpkb-article-item', 'tag' ); ?>
<?php endwhile; endif; ?>

<?php hpkb_get_template_part( 'parts/hpkb-post-nav', 'tag' ); ?>
<?php hpkb_get_template_part( 'parts/hpkb-searchform', 'tag' );
