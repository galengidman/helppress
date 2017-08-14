<form action="<?php echo home_url( '/' ); ?>" method="get" class="hpkb__search-form" role="search">
	<label class="hpkb__search-label">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'hpkb' ); ?></span>

		<input
			type="search"
			name="s"
			class="hpkb__search-input"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php echo esc_attr__( 'Search the knowledge base …', 'hpkb' ); ?>">
	</label>

	<button type="submit" class="hpkb__search-button hpkb__button">
		<span><?php echo esc_html_e( 'Search', 'hpkb' ); ?></span>
	</button>

	<input type="hidden" name="post_type" value="hpkb_article">
</form>

<div class="hpkb__search-suggestions" style="position: relative;"></div>
