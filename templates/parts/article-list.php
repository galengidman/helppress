<ul class="hpkb__article-list">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php $article_id = get_the_id(); ?>
		<?php $icon       = hpkb_article_format_icon( $article_id ); ?>
		<?php $title      = get_the_title( $article_id ); ?>
		<?php $permalink  = esc_url( get_permalink( $article_id ) ); ?>
		<li class="hpkb__article-list-item"><a href="<?php echo $permalink; ?>"><?php echo $icon . $title ?></a></li>
	<?php endwhile; ?>
</ul>
