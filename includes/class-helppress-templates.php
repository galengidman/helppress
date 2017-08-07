<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HelpPress_Templates' ) ) {

	class HelpPress_Templates {

		protected $compat_templates = array(
			'helppress.php',
			'page.php',
			'single.php',
			'index.php',
		);

		public function __construct() {

			add_filter( 'template_include', array( $this, 'template_include' ) );

		}

		public function template_include( $template ) {

			if ( is_singular( 'helppress_article' ) ) {
				$custom_template = $this->get_template( 'helppress-article.php' );
			}

			elseif ( helppress_is_knowledge_base_archive() ) {
				remove_all_filters( 'the_content' );

				$this->reset_post( array(
					'post_content' => helppress_buffer_template_part( 'parts/content-archive' ),
					'post_title'   => esc_html__( 'Knowledge Base', 'helppress' ),
				) );

				$custom_template = $this->get_template( 'helppress-archive.php' );
			}

			elseif ( is_tax( 'helppress_article_category' ) ) {
				remove_all_filters( 'the_content' );

				$this->reset_post( array(
					'post_content' => helppress_buffer_template_part( 'parts/content-category' ),
					'post_title'   => single_term_title( '', false ),
				) );

				$custom_template = $this->get_template( 'helppress-category.php' );
			}

			elseif ( is_tax( 'helppress_article_tag' ) ) {
				remove_all_filters( 'the_content' );

				$this->reset_post( array(
					'post_content' => helppress_buffer_template_part( 'parts/content-tag' ),
					'post_title'   => single_term_title( '', false ),
				) );

				$custom_template = $this->get_template( 'helppress-tag.php' );
			}

			elseif ( helppress_is_knowledge_base_search() ) {
				remove_all_filters( 'the_content' );

				$this->reset_post( array(
					'post_content' => helppress_buffer_template_part( 'parts/content-search' ),
					'post_title'   => get_search_query(),
				) );

				$custom_template = $this->get_template( 'helppress-search.php' );
			}

			if ( isset( $custom_template ) ) {
				$template = locate_template( $custom_template );
			}

			return $template;

		}

		public function reset_post( $args = array() ) {

			global $wp_query, $post;

			if ( isset( $wp_query->post ) ) {
				$dummy = wp_parse_args( $args, array(
					'ID'                    => $wp_query->post->ID,
					'post_status'           => $wp_query->post->post_status,
					'post_author'           => $wp_query->post->post_author,
					'post_parent'           => $wp_query->post->post_parent,
					'post_type'             => $wp_query->post->post_type,
					'post_date'             => $wp_query->post->post_date,
					'post_date_gmt'         => $wp_query->post->post_date_gmt,
					'post_modified'         => $wp_query->post->post_modified,
					'post_modified_gmt'     => $wp_query->post->post_modified_gmt,
					'post_content'          => $wp_query->post->post_content,
					'post_title'            => $wp_query->post->post_title,
					'post_excerpt'          => $wp_query->post->post_excerpt,
					'post_content_filtered' => $wp_query->post->post_content_filtered,
					'post_mime_type'        => $wp_query->post->post_mime_type,
					'post_password'         => $wp_query->post->post_password,
					'post_name'             => $wp_query->post->post_name,
					'guid'                  => $wp_query->post->guid,
					'menu_order'            => $wp_query->post->menu_order,
					'pinged'                => $wp_query->post->pinged,
					'to_ping'               => $wp_query->post->to_ping,
					'ping_status'           => $wp_query->post->ping_status,
					'comment_status'        => $wp_query->post->comment_status,
					'comment_count'         => $wp_query->post->comment_count,
					'filter'                => $wp_query->post->filter,

					'is_404'                => false,
					'is_page'               => false,
					'is_single'             => false,
					'is_archive'            => false,
					'is_tax'                => false,
				) );
			} else {
				$dummy = wp_parse_args( $args, array(
					'ID'                    => -9999,
					'post_status'           => 'publish',
					'post_author'           => 0,
					'post_parent'           => 0,
					'post_type'             => 'page',
					'post_date'             => 0,
					'post_date_gmt'         => 0,
					'post_modified'         => 0,
					'post_modified_gmt'     => 0,
					'post_content'          => '',
					'post_title'            => '',
					'post_excerpt'          => '',
					'post_content_filtered' => '',
					'post_mime_type'        => '',
					'post_password'         => '',
					'post_name'             => '',
					'guid'                  => '',
					'menu_order'            => 0,
					'pinged'                => '',
					'to_ping'               => '',
					'ping_status'           => '',
					'comment_status'        => 'closed',
					'comment_count'         => 0,
					'filter'                => 'raw',

					'is_404'                => false,
					'is_page'               => false,
					'is_single'             => false,
					'is_archive'            => false,
					'is_tax'                => false,
				) );
			}

			if ( empty( $dummy ) ) {
				return;
			}

			$post = new WP_Post( (object) $dummy );

			$wp_query->post       = $post;
			$wp_query->posts      = array( $post );

			$wp_query->post_count = 1;
			$wp_query->is_404     = $dummy['is_404'];
			$wp_query->is_page    = $dummy['is_page'];
			$wp_query->is_single  = $dummy['is_single'];
			$wp_query->is_archive = $dummy['is_archive'];
			$wp_query->is_tax     = $dummy['is_tax'];

			unset( $dummy );

			if ( ! $wp_query->is_404() ) {
				status_header( 200 );
			}

		}

		public function get_compat_templates() {

			return apply_filters( 'helppress_get_compat_templates', $this->compat_templates );

		}

		public function get_template( $preferred = null ) {

			$preferred = 'helppress/' . $preferred;
			$compat_templates = $this->get_compat_templates();

			$templates = $compat_templates;
			array_unshift( $templates, $preferred );

			return $templates;

		}

	}

}

new HelpPress_Templates();
