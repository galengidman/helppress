<?php helppress_get_template_part('parts/helppress-open-content'); ?>

	<?php helppress_get_template_part('parts/helppress-searchform', 'article'); ?>

	<?php helppress_get_template_part('parts/helppress-breadcrumb', 'article'); ?>

	<?php do_action('helppress_before_article_content'); ?>

	<div class="helppress-article__content">

		<?php do_action('helppress_before_article_content_content'); ?>

		<?php the_content(); ?>

		<?php helppress_get_template_part('parts/helppress-page-links', 'article'); ?>

		<?php do_action('helppress_after_article_content_content'); ?>

	</div>

	<?php do_action('helppress_after_article_content'); ?>

<?php helppress_get_template_part('parts/helppress-close-content');
