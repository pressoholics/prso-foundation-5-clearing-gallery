=== Zurb Foundation 5 Clearing Gallery ===
Contributors: ben.moody
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: zurb foundation,zurb foundation 5, zurb, foundation, foundation 5, foundation gallery, foundation clearing, zurb foundation gallery, zurb foundation clearing
Requires at least: 3.0
Tested up to: 3.8
Stable tag: 1.0

Enhance Wordpress gallery shortcode content with the Zurb Foundation Clearing lightbox. Just enable and all gallery shortcodes will use Clearing.

== Description ==

Enhance Wordpress gallery shortcode content with the Zurb Foundation Clearing lightbox. Just enable and all gallery shortcodes will use Clearing.

[youtube http://www.youtube.com/watch?v=IsqmG00pNYM]

You can add a gallery just as you normally would including setting up the number of columns.

The plugin supports up to 6 columns for any gallery, it will fall back to 4 column grid for invalid values.

MOBILE: Note that the foundation mobile classes have already been added for each gallery size.
That said you can use the filters below to alter any foundation classes applied to the
block grid.

There are also a number of filters devs can use to alter output.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload plugin folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Start adding galleries to posts/pages via wordpress add media interface

== Frequently Asked Questions ==

= Will this work without Zurb Foundation =

No. This plugin will only work with a theme using the Zurb Foundation framework, version 4 and 5.

== Screenshots ==

1. Default Wordpress gallery in Foundation 5.
2. Wordpress gallery using plugin, nice block grid there!
3. Example of Clearing lightbox at work.

== Changelog ==

= 1.0 =
* Added some filters for devs to use

== Upgrade Notice ==

= 1.0 =
This is the inital version of the plugin

== Filters ==

prso_found_gallery_large_class 		->	Foundation large class for grid block
prso_found_gallery_small_class 		->	Foundation small class for grid block
prso_found_gallery_image_caption 	->	Filter caption for each image in gallery
prso_found_gallery_li_class 		->	Filter class applied to each <li> item in block grid
prso_found_gallery_output 			->	Filter overall html output for gallery
