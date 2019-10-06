<?php
/**
 * Deprecated Functions
 *
 * @package HelpPress
 * @since 2.0.0
 */

if (! defined('ABSPATH')) {
	exit;
}

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
