<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="hpkb-search" role="search">
	<label class="hpkb-search__label">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'hpkb' ); ?></span>

		<input
			type="search"
			name="s"
			class="hpkb-search__input"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php echo esc_attr__( 'Search the knowledge base …', 'hpkb' ); ?>">
	</label>

	<button type="submit" class="hpkb-search__submit hpkb-button button">
		<span><?php echo esc_html_e( 'Search', 'hpkb' ); ?></span>
	</button>

	<input type="hidden" name="hpkb-search" value="1">
</form>

<div class="hpkb-search__suggestions" style="position: relative;"></div>
