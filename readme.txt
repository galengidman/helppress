=== HelpPress Knowledge Base ===
Contributors:      galengidman
Tags:              knowledge base, knowledgebase, help desk, helpdesk, wiki
Requires at least: 4.4
Tested up to:      5.6
Stable tag:        trunk

A WordPress knowledge base plugin compatible with almost any theme.

== Description ==

HelpPress is a powerful and easy-to-use WordPress knowledge base plugin. No complicated configuration, templating, or code updates. Just install and you immediately have a fully-functional self-help system for your customers.

= Features =

- **Theme Compatible**: Compatible with almost any theme right out of the box. No templating required.
- **Responsive Design**: Works on almost any device or screen size your customers may be using.
- **Live Search Results**: Suggests relevant articles to your users live as they enter search terms.
- **Customizable URLs**: Customize the URL slugs for all the major sections of your knowledge base.
- **Easy Content Organization**: Organize knowledge base articles by category, tag, and post format.
- **Breadcrumb**: Includes a built-in breadcrumb to help your users keep track of where they are.
- **Custom Templates**: Override default templates with your own to better match your site.
- **Extendable**: Includes dozens of actions and filters to allow for ultimate customization.
- **Lightweight**: Coded with performance as a priority so it won't slow down your site.

== Installation ==

- **WordPress Plugins Directory**: Navigate to *Plugins* → *Add New* in the WordPress admin and search “HelpPress.” Click *Install* and then *Activate*.
- **Zip Upload**: Navigate to *Plugins* → *Add New* → *Upload Plugin* in the WordPress admin. Browse to the .zip file containing the plugin on your computer and upload, then activate.
- **Manual FTP Upload**: Upload the plugin folder to `/wp-content/plugins/`. Navigate to *Plugins* in the WordPress admin and activate.

== Frequently Asked Questions ==

= I'm getting a "Page Not Found" or 404 error. What do I do? =
Navigate to *Settings* → *Permalinks* in the WordPress admin and click *Save*.

= How do I add my knowledge base to a menu? =
Navigate to *Appearance* → *Menus* in the WordPress admin. Ensure "HelpPress" is checked in the *Screen Options* tab in the top-right corner of the screen. You will now see an expandable *HelpPress* box on the left side of the screen that contains a custom link that you can add to a menu.

= Does HelpPress work with Plain Permalinks? =
Yes, but the slug settings will have no effect.

== Screenshots ==

1. HelpPress on Twenty Seventeen using default, 2-column layout.
2. HelpPress on Twenty Fifteen using a 1-column layout.
3. General settings.
4. Display settings.
5. Breadcrumb settings.
6. Search settings.

== Changelog ==

= 3.1.4, November 24, 2020 =
* Tweak: Update compatible WP versions.

= 3.1.3, October 16, 2019 =
* Fix: Missing taxonomies on article edit screen by adding `show_in_rest`.

= 3.1.2, October 15, 2019 =
* Fix: Plugin settings action link.
* Fix: Orphaned column icon images.

= 3.1.1, October 15, 2019 =
* Fix: Ensure SVN repo has the correct files.

= 3.1.0, October 15, 2019 =
* Tweak: Update compatible WP versions.
* Tweak: Base asset minification on `SCRIPT_DEBUG` instead of `WP_DEBUG`.
* Tweak: Enable Block Editor on articles by adding `show_in_rest` to CPT registration.
* Tweak: Put PHP classes in global `helppress` container.
* Tweak: Don't run PHP includes through filter — could only lead to trouble.
* Fix: Double slash in asset URLs.
* Fix: Disable direct access to all PHP includes.
* Fix: Improper option default escaping.

= 3.0.0, October 6, 2019 =
* New: Rework Settings page to be powered by CMB2 instead of Titan Framework.
* New: Create `HelpPress_Plugin` class to manage plugin instantiation.
* Tweak: Minor updates to code styling.
* Fix: Ensure that rewrite rules are always regenerated after post types have been registered on plugin activation.

= 2.0.1, April 9, 2019 =
* Tweak: Updated contributors and bump up compatible WP versions.

= 2.0.0, February 11, 2018 =
* New: Add option to display the knowledge base on the front page.
* New: Allow for unlimitted articles/page setting (-1) and disable pagination if chosen.
* New: Add `helppress_disable_option_{option_id}` filter to disable UI of individual setting fields.
* New: Add `helppress_disable_css` filter to forcibly disable output of HelpPress CSS.
* New: Add `helppress_disable_page_template` filter to forcibly disable using the page template setting, even if option exists in DB.
* New: Add `helppress_is_paginated()` helper.
* New: Add `helppress-taxonomy.php` template file as default for `helppress-category.php` and `helppress-tag.php`.
* New: Add `helppress_disable_theme_compat_mode` filter to disable post resetting and content filtering — needed for custom theming.
* Tweak: Enqueue minified assets unless `WP_DEBUG` is `true`.
* Tweak: Various text capitalizations and strings.
* Tweak: Upgraded jQuery Autocomplete script.
* Tweak: Rename `helppress_is_kb_page()` to `helppress_is_kb()`. Kept old function as alias for backwards compatiblity.
* Tweak: Don't load plugin if WordPress or PHP is below required version.
* Tweak: Remove included POT file in liue of GlotPress.
* Tweak: Improved performance of demo content import.
* Fix: Only show permalinks notice to users that can manage options.
* Fix: Use knowledge base title for menu archive link.

= 1.4.2, November 13, 2017 =
* New: Add link Settings page to the plugin's action links.
* Fix: Fix user permissions for admin menu item and "View Live" link.

= 1.4.1, November 7, 2017 =
* Tweak: CSS enhancements for breadcrumb styling.
* Fix: Exclude admin area from context helper functions.

= 1.4.0, September 25, 2017 =
* New: Add option to use page template as knowledge base template.
* New: Added search form to the top of the article items and article templates.
* Tweak: Use dashicons for menu icon.

= 1.3.0, September 19, 2017 =
* New: Added dozens of action hooks to the front-end templates.
* Fix: i18n strings for the `helppress_category_article_count()`.

= 1.2.1, September 14, 2017 =
* New: `helppress_category_article_count()` template tag to output number of articles in a given category.
* Tweak: Updated styling for search field, button, and suggestions dropdown.
* Tweak: Yoda conditionals to conform to PHP coding standards.
* Fix: Decode HTML entities in search suggestions.

= 1.2.0, September 13, 2017 =
* New: `helppress_get_kb_context()` helper function.
* Tweak: Search results and category/tag archive content templates now pull from new `parts/helppress-content-article-items.php` template.
* Tweak: Wrap content templates in new `#helppress` div.
* Tweak: Generally more defensive CSS and consistent margins.
* Tweak: Update archive category title headings from `h2` → `h3`.
* Fix: Responsive archive columns CSS.

= 1.1.1, September 9, 2017 =
* Fix: Various bugs.

= 1.1.0, September 9, 2017 =
* New: Added built-in demo content installer. Will offer to install demo content if no published articles exist and demo content has not been previously installed.
* Tweak: Added `helppress_article_post_formats` filter for allows post formats for articles.
* Fix: Fixed missing search suggestions class file.

= 1.0.2, September 9, 2017 =
* New: Show category and tag columns in admin post table.
* New: Added inline DocBlock-style documentation to functions and classes.
* Fix: Pagination for the knowledge base archive when no categories are present.

= 1.0.1, September 7, 2017 =
* Fix: Various bugs.

= 1.0.0, September 6, 2017 =
* Initial release. So. Exciting.
