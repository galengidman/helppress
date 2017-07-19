<?php

$articles = wpkb_get_articles( array(
	'tax_query' => array(
		array(
			'taxonomy' => 'wpkb_article_category',
			'field' => 'slug',
			'terms' => get_queried_object()->slug,
		),
	),
) );

?>

<ul>
	<?php if ( $articles->have_posts() ) : while ( $articles->have_posts() ) : $articles->the_post(); ?>
		<li><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></li>
	<?php endwhile; wp_reset_postdata(); endif; ?>
</ul>
