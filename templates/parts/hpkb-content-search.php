<?php hpkb_get_template_part( 'parts/hpkb-breadcrumb', 'search' ); ?>

<?php if ( have_posts() ) : ?>
	<ul class="hpkb-article-list">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php hpkb_get_template_part( 'parts/hpkb-article-item', 'search' ); ?>
		<?php endwhile; ?>
	</ul>
<?php endif; ?>

<?php hpkb_get_template_part( 'parts/hpkb-post-navigation', 'search' ); ?>
<?php hpkb_get_template_part( 'parts/hpkb-searchform', 'search' );
