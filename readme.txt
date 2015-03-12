=== If Shortcode ===
Contributors: geomagas
Tags: if, shortcode, conditional, else, content, conditional tags
Requires at least: 3.0.1
Tested up to: 4.1.1
Stable tag: 0.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5SD6XG9JD5TS8

This plugin provides an "if" shortcode to conditionally render content.

== Description ==

This plugin provides an "if" shortcode to conditionally render content. The syntax is the following:

	[if condition1 condition2=false condition3]{content}[/if]

Conditions are passed as attribute names. Multiple conditions evaluate to the result of ORing all of them. In other words,
if at least one condition evaluates to the desired boolean result, {content} is rendered, otherwise it is discarded.
Attribute values determine if we want the condition to be true or false. A value of '0', 'false', '' (the empty string), 
'null' or 'no' means we expect the condition to be false. Anything else, including the absense of a value, is interpreted 
as true.

For example, suppose that we want to include a sentence in a post, but only for anonymous visitors:

	[if is_user_logged_in=no]The Sentence.[/if]
	
It also provides an [else] shortcode and an [eitherway] one for use inside [if] blocks. [else] will render its content if 
the condition evaluates to false, and [eitherway] will render its content regardless of the evaluation result. When used 
outside an [if] block, these shortcodes behave as if the whole content is surrounded by an [if] shortcode whose condition
evaluates to true. In other words, an [else] shortcode would not render any content, while a [eitherway] one would. You can 
use as many of these shortcodes as you like in a single [if] block, which gives you the ability to do things like:

		- Am I logged in?
		[if is_user_logged_in]- Yes you are.
		[else]- No you are not.
		[/else][eitherway]- I'm sorry, what?
		[/eitherway]- I said YOU A-R-E LOGGED IN!!!
		[else]- YOU ARE NOT LOGGED IN!!! What's the matter with you?[/else][/if]

A multitude of conditions are supported out-of-the-box. The following evaluate to the result of the corresponding 
WordPress Conditional Tag, using the no-parameter syntax:

		is_single
		is_singular
		is_page
		is_home
		is_front_page
		is_category
		is_tag
		is_tax
		is_sticky
		is_author
		is_archive
		is_year
		is_month
		is_day
		is_time
		is_feed
		is_search
		comments_open
		pings_open
		is_404
		is_user_logged_in
		is_super_admin
		
For example, the evaluation of the is_page condition is equivalent to calling is_page() with no parameter.

The functionality of the plugin can be extended by other plugins, by means of adding custom conditions through filters.
To add a custom condition, a filter hook must be defined in the following manner:

	add_filter($if_shortcode_filter_prefix.'my_condition','my_condition_evaluator');

	function my_condition_evaluator($value)
		{
		$evaluate=.... /* add your evaluation code here */
		return $evaluate;
		}
	
A big thanks to M Miller for the `normalize_empty_atts()` function found here: http://wordpress.stackexchange.com/a/123073/39275

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the `if-shortcode` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `[if condition]{content}[/if]` shortcodes in your content

== Changelog ==

= 0.2.0 =
* Addition: [else] shortcode
* Addition: [eitherway] shortcode

= 0.1.0 =
* First release.

