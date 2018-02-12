<?php
/**
 * Deprecated Functions
 *
 * @package HelpPress
 * @since 2.0.0
 */

/**
 * Aliase of `helppress_is_kb()` for backwards compatibility.
 *
 * @deprecated 2.0.0 Use `helppress_is_kb()`
 * @since 1.0.0
 *
 * @return boolean HelpPress page or not.
 */
function helppress_is_kb_page() {
	return helppress_is_kb();
}

/**
 * Aliase of HelpPress_Plugin::get_article_post_formats() for backwards compatiblity.
 *
 * @deprecated 2.0.0 Use `HelpPress_Plugin::get_article_post_formats()`
 * @since 1.1.0
 *
 * @return array Allowed post formats.
 */
function helppress_get_article_post_formats() {
	return HelpPress_Plugin::get_article_post_formats();
}
