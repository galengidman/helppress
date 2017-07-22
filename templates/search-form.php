<form action="<?php echo home_url( '/' ); ?>" method="get" class="helppress__search-form" role="search">
	<label class="helppress__search-label">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'helppress' ); ?></span>
		<input
			type="search"
			name="s"
			class="helppress__search-input"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php echo esc_attr__( 'Search the knowledge base …', 'helppress' ); ?>">
	</label>

	<button type="submit" class="helppress__search-button helppress__button">
		<span><?php echo esc_html_e( 'Search', 'helppress' ); ?></span>
	</button>

	<input type="hidden" name="post_type" value="helppress_article">
</form>
