<?php

function helppress_search_autocomplete_suggestions() {

	$articles = new WP_Query( array(
		's'             => $_REQUEST['query'],
		'post_type'     => 'helppress_article',
		'fields'        => 'ids',
		'no_found_rows' => true,
	) );

	$suggestions = array('suggestions' => array());

	foreach ( $articles->posts as $article_id ) {
		$suggestions['suggestions'][] = array(
			'value' => get_the_title( $article_id ),
			'data'  => esc_url( get_permalink( $article_id ) ),
		);
	}

	echo json_encode( $suggestions );

	exit;

}
add_action( 'wp_ajax_helppress_autocomplete_suggestions', 'helppress_search_autocomplete_suggestions' );
add_action( 'wp_ajax_nopriv_helppress_autocomplete_suggestions', 'helppress_search_autocomplete_suggestions' );
