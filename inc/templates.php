<?php

function wpkb_article_taxonomy_template( $template ) {

	if ( is_tax( array( 'wpkb_article_category', 'wpkb_article_tag' ) ) ) {
		$new_template = locate_template( array( 'single.php', 'page.php', 'index.php' ) );

		if ( $new_template !== '' ) {
			return $new_template;
		}
	}

	return $template;

}
add_filter( 'template_include', 'wpkb_article_taxonomy_template' );

function wpkb_get_template( $path = null ) {

	$theme_override = locate_template( 'wpkb/templates/' . $path );

	if ( $theme_override ) {
		include $theme_override;
	} else {
		include WPKB_PATH . 'templates/' . $path;
	}

}
