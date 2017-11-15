<?php if ( helppress_get_option( 'posts_per_page' ) > -1 ) : ?>

	<?php do_action( 'helppress_before_post_nav' ); ?>

	<nav class="helppress-post-nav">

		<?php do_action( 'helppress_before_post_nav_content' ); ?>

		<?php posts_nav_link(); ?>

		<?php do_action( 'helppress_after_post_nav_content' ); ?>

	</nav>

	<?php do_action( 'helppress_after_post_nav' ); ?>

<?php endif;
