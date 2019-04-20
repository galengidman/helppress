<?php

wp_link_pages([
	'before' => '<nav class="helppress-article__page-links">' . esc_html__('Pages:', 'helppress'),
	'after' => '</nav>'
]);
