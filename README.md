=== eFront WordPress plugin ===
Contributors: V. 
Tags: eFront, elearning, lms, lcms, hcm, learning management system
Requires at least: 1.5
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin integrates eFront with Wordpress. Promote your eFront content through your WordPress site.

== Description ==

[eFront](http://www.efrontlearning.net/ "Enterprise Learning Management System Software") is a robust learning platform, bundled with key enterprise functionality ranging from branch management to tailor-made reports. We have worked with hundreds of organizations to shape a product that meet the training needs of modern enterprises.

Read more about TalentLMS in:

* [eFront – blog](http://blog.efrontlearning.net/ "eFront – blog")

## Plugin Features ##

1. List your eFront courses and lessons and their content in WordPress.


- Caching

	* Each time you retreive a eFront item (courses/lessons list, single course/lesson, categories list etc) this item is cached for performance reasons.
	  If you want to force cached items to be updated you should clear your cache. (_Administration Panel > eFront > Clear cache_)


== Installation ==

#To Install:#

1. Download eFront WordPress plugin
1. Unzip the file into a folder on your hard drive
1. Upload `/eFront/` folder to the `/wp-content/plugins/` folder on your site
1. Visit your WordPress _Administration -> Plugins_ and activate eFront WordPress plugin

Alternatively you can automatically install eFront WordPress plugin from the WordPress Plugin Directory. 

#Usage:#

* Once you have activated the plugin, provide your eFront Domain name and eFront admin username and password.
* You must update your permalinks to use "Custom Structure" or if your using WordPress 3.3 and above you can use the "Post name" option just as long as you have `/%postname%/` at the end of the url. 
* Login to eFront widget : Use this widget to login to your eFront domain
* Use the shortcodes:
	* `[eFront-catalog]` 	: to list your eFront courses

== Frequently Asked Questions ==

If you have a question or any feedback you want to share send us an email at [support@efrontlearning.net](mailto:support@efrontlearning.net 'support')

== Screenshots ==

Here are some screenshots of the eFront WordPress plugin.

##Administration panel##

1. Administration panel > eFront main options.
`assets/screenshot-1.png`

2. Administration panel > eFront > eFront Options.
`assets/screenshot-2.png`

3. Administration panel > eFront > Edit eFront CSS.
`assets/screenshot-3.png`

##Front End##

1. eFront courses list (pagination)
`assets/screenshot-4.png`

2. eFront courses list (tree)
`assets/screenshot-5.png`

3. eFront single lesson
`assets/screenshot-6.png`

4. eFront single course
`assets/screenshot-7.png`

5. eFront login widget
`assets/screenshot-8.png`

== Changelog ==

= 1.0 (Initial release) =

* Administration Panel for eFront management
* Login to eFront widget for Wordpress
* Shortcode for listing courses/lessons/categories from eFront
* Caching

== Upgrade Notice ==

