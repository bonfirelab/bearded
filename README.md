Bearded
=======

Bearded WordPress Theme

A responsive CSS3 and HTML5 blogging, ecommerce and portfolio theme.  It supports all post formats and has layout, and color options built into the theme customizer. The theme also supports the <a href="http://wordpress.org/extend/plugins/custom-content-portfolio">Custom Content Portfolio</a> and <a href="http://wordpress.org/extend/plugins/woocommerce">Woocommerce</a> plugin, giving artists and other creative people the ability to share their work.

Documentation
=============

##### Table of Contents

1. [Plugin Used in Demo](#plugin)
2. [Home Page Setup](#setup-home)
3. [Portfolio Page Setup](#setup-portfolio)
4. [Credits](#credits)


<a name="plugin"/>
## Plugin Used in Demo
1. [Custom Content Portfolio](http://wordpress.org/plugins/custom-content-portfolio/). A simple and amazing plugin created by Justin Tadlock. This plugin used to control the Portfolio post type.
2. [WooCommerce - excelling eCommerce](http://wordpress.org/plugins/woocommerce/)
3. [YITH WooCommerce Wishlist](http://wordpress.org/plugins/yith-woocommerce-wishlist/). This plugin used to show add to wishlist feature.
4. [Animate Slider](http://wordpress.org/plugins/animate-slider/) (*Recommended*). This plugin used to show slideshow in the homepage

<a name="setup-home"/>
## Set Up the Home Page
1. Create a blank new page, name it whatever you want and set the page template to **HOME**
2. Set this page as static front page in Settings > Reading > Static Front Page
3. To setup the slider in home page make sure you install the [Animate Slider](http://wordpress.org/plugins/animate-slider/), The **Home Page Template** will automatically call any latest post in Slider.
4. To setup the content for Home Page, Go to Appearance > Widget. Drag an Drop any Bearded Widget there, the Bearded widget is built for home content so you can easily rearrange the content.

<a name="setup-portfolio"/>
## Portfolio Page Setup

The Portfolio Page Template is powered by [Shuffle jQuery](http://vestride.github.io/Shuffle/) plugin. 

To create portfolio page with filter, go to Page > Add New. Create a new blank page and set the page template to "Portfolio X Columns".

In order for the filter to work is that you have assigned each **Portfolio Items** with **Portfolios** ( The Taxonomy name in Custom Content Portfolio plugin )

<a name="credits"/>
## Credits
1. [Justin Tadlock](http://justintadlock.com) for awesome Hybrid Framework and Custom Content Portfolio plugin
2. Glen Cheney [@Vestride](https://twitter.com/Vestride) for wonderful [Shuffle jQuery](http://vestride.github.io/Shuffle/) plugin
3. [Krzysztof Nowak](http://www.behance.net/Chkn) for providing Extraordinary artwork used in theme demo.
4. [designmodo](http://designmodo.com/flat-free/) for Flat UI Icon


Changelog
=========
= 0.1.0 =
* Initial Release

= 0.1.2 =
* Fixed the Theme description in style.css file
* Remove Included Custom Post Type

= 0.1.3 =
* Added License for included resources
* Fix Unprefixed Issue

= 1.0.0 =
* Major Update in theme function
* Fixed Strict error issue
* Added Woocommerce
* Fixed Footer Issue
* Fixed Social Google Plus Issue

= 1.0.1 =
* Fixed Translation function call in footer

= 1.0.2 =
* Woocommerce Compatibility Update

= 1.0.3 =
* Added Menu Fallback

= 1.0.4 =
* Fixed Sidebar Issue when Woocommerce not installed

= 1.0.5 =
* Replaced Isotope with Shuffle.js
* Allow Footer textbox to use HTML allowed tags.
* Fixed Woocommerce 2.1 product list class

= 1.0.6 =
* Added TGM Plugin Activation Library



Theme Demo
==========
[Visit this link for theme demo](http://themes.bonfirelab.com/bearded)