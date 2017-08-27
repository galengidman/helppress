<?php

function hpkb_query_settings( $query ) {

	if ( is_admin() ) {
		return $query;
	}

	if (
		$query->is_main_query()
		&& (
			hpkb_is_kb_archive()
			|| hpkb_is_kb_category()
			|| hpkb_is_kb_tag()
			|| hpkb_is_kb_search()
		) ) {
		$query->set( 'orderby',        hpkb_get_option( 'orderby' ) );
		$query->set( 'order',          hpkb_get_option( 'order' ) );
		$query->set( 'posts_per_page', hpkb_get_option( 'posts_per_page' ) );
	}

	return $query;

}
add_filter( 'pre_get_posts', 'hpkb_query_settings' );
