<?php

if ( ! helppress_get_option( 'search' ) ) {
	return;
}

$input_classes = array( 'helppress-search__input' );
if ( helppress_get_option( 'search_suggestions' ) ) {
	$input_classes[] = 'helppress-search__input--suggest';
}

?>

<div class="helppress-search">
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" class="helppress-search__form" role="search">
		<label class="helppress-search__label">
			<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'helppress' ); ?></span>

			<input
				type="search"
				name="s"
				class="<?php echo esc_attr( join( ' ', $input_classes ) ); ?>"
				value="<?php echo esc_attr( get_search_query() ); ?>"
				placeholder="<?php echo esc_attr( helppress_get_option( 'search_placeholder' ) ); ?>"
				<?php if ( helppress_get_option( 'search_autofocus' ) ) echo 'autofocus'; ?>>
		</label>

		<button type="submit" class="helppress-search__submit helppress-button button">
			<span><?php echo esc_html_e( 'Search', 'helppress' ); ?></span>
		</button>

		<input type="hidden" name="hps" value="1">
	</form>

	<div class="helppress-search__suggestions" style="position: relative;"></div>
</div>
