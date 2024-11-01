=== Cross Sell Products Slider For Woocommerce ===
Contributors:Logicfire
Donate link: 
Tags: woocommerce, wordpress, cross-sells products, woo commerce cross-sell products, carousel slider, upsell carousel, related product carousel, cross-sells products carousel
Requires at least: 5.0
Tested up to: 6.1
Requires at least: 5.2
Requires PHP: 7.2
Stable tag: 2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allow to display cross sell products on single product page or anywhere on website (using shortcode).
Also turn cross sell, woocommerce default upsells and related products sections on single product page into responsive sliders.

== Description ==

Allow to display cross sell products on single product page or or anywhere on website (using shortcode).
* Shortcode [wcsp_cross_sell orderby="rand" order="ASC" product_num="5" display_columns="3" title="Some title.." product_id="Product ID" class="class-1 class-2 class-3" hide_out_of_stock_products="no"]

Also turn cross sell, woocommerce default upsells and related products sections on single product page into responsive carousel sliders.
Go to plugin settings and enable the sliders.

== Installation ==

If you would prefer to do things manually then follow these instructions:

1. Upload the `woocommerce-cross-sell-products-display` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Settings -> Cross Sell Products Settings and configure according to your need.

== Changelog ==
2/11/2022
Plugin Rename from "Woocommerce Cross Sell Products Display" to "Cross Sell Products Slider For Woocommerce".
Added:
Shortcode attribute "hide_out_of_stock_products" to show/hide out of stock products.


15/12/2019
Fixed:
Minor Bugs

Added:
Option to turn the Cross sell section into a carousel slider.
Option to turn woocommerce default Upsells and Related products section into a carousel slider.

25/06/2019
Added:
Shortcode attribute 'class' to add classes to main wrapper of cross-sells.
[wcsp_cross_sell orderby="rand” order=“ASC” product_num=“5” display_columns=“3” title=“Some title..” category=“Category ID” product_id="Product ID" class="class-1 class-2 class-3"]


8/02/2019
Bug Fixes
Added shortcode attribute "product_id" to display crosssells anywhere on site.
[wcsp_cross_sell orderby="rand” order=“ASC” product_num=“5” display_columns=“3” title=“Some title..” category=“Category ID” product_id="Product ID"]

24/11/2015
Fixed:
Fixed php notice errors.
Added gettext() calls to labels for translations.


16/3/2015
Added:
Display cross sell products by category.
* Shortcode [wcsp_cross_sell orderby="rand” order=“ASC” product_num=“5” display_columns=“3” title=“Some title..” category=“Category ID”]
* Work with shortcode only.

29/12/2015
Fixed:
* Reported bugs.