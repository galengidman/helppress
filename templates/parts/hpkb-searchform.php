<?php

if ( ! hpkb_get_option( 'search' ) ) {
	return;
}

$input_classes = array( 'hpkb-search__input' );
if ( hpkb_get_option( 'search_suggestions' ) ) {
	$input_classes[] = 'hpkb-search__input--suggest';
}

?>

<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="hpkb-search" role="search">
	<label class="hpkb-search__label">
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'hpkb' ); ?></span>

		<input
			type="search"
			name="s"
			class="<?php echo esc_attr( join( ' ', $input_classes ) ); ?>"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php echo esc_attr( hpkb_get_option( 'search_placeholder' ) ); ?>"
			<?php if ( hpkb_get_option( 'search_autofocus' ) ) echo 'autofocus'; ?>>
	</label>

	<button type="submit" class="hpkb-search__submit hpkb-button button">
		<span><?php echo esc_html_e( 'Search', 'hpkb' ); ?></span>
	</button>

	<input type="hidden" name="hpkb-search" value="1">
</form>

<div class="hpkb-search__suggestions" style="position: relative;"></div>
