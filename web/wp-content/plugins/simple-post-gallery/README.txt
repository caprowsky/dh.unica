=== Plugin Name ===
Post Gallery
Contributors: 10quality
Tags: gallery, post gallery, pictures, images, lightbox, customizable, customization, galleries, videos, video gallery, photo gallery, swipebox, youtube, vimeo
Requires at least: 3.2
Requires PHP: 5.4
Tested up to: 5.2
Stable tag: 2.3.6
License: MIT
License URI: http://www.linfo.org/mitlicense.html

Adds Gallery of pictures, photos and videos to any post type. Imports from YouTube and Vimeo.

== Description ==

https://www.youtube.com/watch?v=v96MRPZ9PCM

**Post Gallery** lets you add a gallery of pictures, photos and videos to any post type; each gallery can be created and updated from within the post form, making it easier and more flexible than many other gallery plugins out there.

Galleries created with **Post Gallery** can be displayed using a shortcode or templating functions. **Post Gallery** comes with a [light-box](https://github.com/brutaldesign/swipebox/) solution out-of-the-box; its superb design will let you customize it to function as you please.

**Post Gallery** comes built-in with a video importer that can be used across Wordpress and will let you import videos from YouTube and Vimeo to your media library.

This plugin is fully customizable; designed to let you modify it and stylize it the way you want to.

Features:

* Video support (YouTube, Vimeo and uploaded MP4).
* Custom post galleries.
* Easy to maintain.
* Editable from within post edit page.
* Turn on/off galleries per post type.
* Internal file cache for speed optimization.
* Fully customizable templates.
* Un-enqueuable styles.
* Light-box built-in.
* Use of the newest wordpress media editor to upload and select images.
* Adds video importer to wordpress media uploader, works all across wordpress.
* Supports multiple galleries in display.
* Supports guttenberg.

This plugin is very developer friendly, has many hooks that will let you extend and customize its functionality to meet your needs. Optionally we offer a pro extension with the following features:

* Additional video support (Dailymotion and Twitch).
* 7 professional and configurable slider layouts.
* Ability to set custom clickable url per image.
* Ability to add customizable text overlays per image.
* Responsive videos.

You can opt to obtain these features [here](https://www.10quality.com/product/post-gallery-pro/).

== Installation ==

1. Head to your Wordpress Admin Dashboard and click at the options **Plugins** then **Add new**.
2. Search for this plugin usign the search input or if have downloaded the zip file, upload it manually.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Configure the plugin at "Settings->Galleries".

== Changelog ==

= 2.3.6 =
*Release Date - 27 June 2019*

* Framework update.

= 2.3.5 =
*Release Date - 21 May 2019*

* Framework upgrade.
* Swipebox updated.

= 2.3.4 =
*Release Date - 16 March 2019*

* Framework upgrade.

= 2.3.2 =
*Release Date - 4 March 2019*

* Framework upgrade.

= 2.3.1 =
*Release Date - 16 January 2019*

* Small bug fixes.

= 2.3.0 =
*Release Date - 13 December 2018*

* Gutenberg support.
* Wordpress 5.0 tested.

= 2.2.9 =
*Release Date - 28 November 2018*

* WPMVC cache/log folders changed.
* File permissions issues fixed for various hosting servers.
* Framework update.

= 2.2.8 =
*Release Date - 2 October 2018*

* Fixes reported issue related to resource loading.

= 2.2.7 =
*Release Date - 12 June 2018*

* Framework updated.

= 2.2.6 =
*Release Date - 5 June 2018*

* Lightbox2 removed completely (after almost three months of compatibility support).
* Missing lightbox2 assets error gone.

= 2.2.5 =
*Release Date - 5 June 2018*

* Replaced mp4 image placeholder.

= 2.2.4 =
*Release Date - 5 June 2018*

* Bug fixes.
* Added more customizable hooks.
* Full MP4 support.

= 2.2.3 =
*Release Date - 29 May 2018*

* Fixes video bug generated on version 2.2.1.

= 2.2.2 =
*Release Date - 28 May 2018*

* Shortcode now supports post ID as attribute (Ability to display multiple galleries in a post).

= 2.2.1 =
*Release Date - 26 May 2018*

* Uploaded MP4 support added (without light-box).
* Loader displayed when media is being added to gallery.

= 2.2.0 =
*Release Date - 23 May 2018*

* Localization supported (via Wordpress.org).
* Deprecated Lightbox2 notice removed.

= 2.1.8 =
*Release Date - 6 April 2018*

* Shortcode button actions added (Ability to copy shortcode into clipboard and/or to insert shortcode into content).
* Tested with Wordpress 4.5.9

= 2.1.7 =
*Release Date - 31 March 2018*

* Framework updated.
* Hot fix for php 5.4 compatibility.

= 2.1.6 =
*Release Date - 30 March 2018*

* Hot fix for php 5.4 compatibility. Reported [2nd issue](https://wordpress.org/support/topic/parse-error-after-last-update-2/).

= 2.1.5 =
*Release Date - 29 March 2018*

* Hot fix for php 5.4 compatibility. Reported [issue](https://wordpress.org/support/topic/parse-error-after-last-update-2/).

= 2.1.4 =
*Release Date - 27 March 2018*

* More suttle (less intrusive) promotional pro formats.
* Updated Wordpress.org assets.

= 2.1.3 =
*Release Date - 27 March 2018*

* Fixes centered video icon position (multiple themes tested).

= 2.1.2 =
*Release Date - 23 March 2018*

* Switches from Lightbox2 to Swipebox as light-box solution, for more information [read this article](https://www.10quality.com/2018/03/23/switching-to-swipebox-in-post-gallery-plugin/).

= 2.1.1 =
*Release Date - 22 March 2018*

* Fixes bug when saving embed sizes.
* Updates Wordpress Media Uploader script to latest version.

= 2.1.0 =
*Release Date - 22 March 2018*

* Adds video support.
* Adds *Video Importer* to Wordpress Media Uploader.

= 2.0.0 =
*Release Date - 20 March 2018*

* Adds custom resolution method on attachments.
* Switched to [Wordpress MVC](https://www.wordpress-mvc.com/) framework.
* More customizable hooks.

= 1.0.5 =
*Release Date - 13 February 2018*

* Fixes CSS class on post gallery template.
* Fixes issue caused when handling images with the same name.
* Tests compatibility with Wordpress 4.9.4.

= 1.0.4 =
*Release Date - 15 June 2017*

* Refactored tag names.
* Added customization hooks.
* Javascript dependencies updated.
* JS window variable *postGallery* added during admin dashboard.

= 1.0.3 =
*Release Date - 8 June 2017*

* Fixes issue caused when handling images with the same name.
* Cache settings tab added.
* Framework updated.

= 1.0.2 =
*Release Date - 23 July 2016*

* Compatibility hotfix with [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/).
* Framework updated.

= 1.0.1 =
*Release Date - 6 June 2016*

* Attachment model casting (array|json) improvents.
* Documentation Github Gist examples fixed.

== Screenshots ==

1. Gallery displayed using shortcode. (Theme BlogRock Core)
2. Gallery Image at full resolution using Swipebox (built-in).
3. Gallery management within post edit form.
4. Gallery metabox.
5. Use of the newest wordpress media editor to upload and select images.
6. Video importer.
7. Selecting a video previously imported to media gallery.
8. Simple customizable template.
9. Gallery Video playing using Swipebox (built-in).
10. Gutenberg support.

== Frequently Asked Questions ==

= Setup? =

Once activated, **Simple Post Gallery** requires you to head to settings and select the post types that will support galleries.

The settings page is located at the **Settings** option in the admin dashboard.

= How to add a video? =

This plugin will add a "Video Importer" that will let you to import YouTube and Vimeo videos into your media gallery; the videos imported can be added to the gallery or to any wordpress editor.

To import a video, click the button "Add Media", after Wordpress Media Uploader shows up, click the option "Import Video" listed on the left sidebar and finally paste your video link in the input.

Look this plugin's screenshots for reference.

= Documentation? =

There is a tab called **Documentation** in the **Settings** option.

= How to modify the template? =

There is a tab called **Documentation** in the **Settings** option, here it is explained.

= Which WordPress versions are supported? =

At the time this document was created, we only tested on Wordpress 4.5, we believe, based on the software requirements, that any Wordpress version above 3.2 will work.

= Which PHP versions are supported? =

Any greater or equal to **5.4** is supported.

= Issues when migrating wordpress? =

Clear plugin's cache.

= How to display more than one gallery? =

Use shortcode's ID attribute/parameter to display multiple galleries. The ID refers to the post ID holding the gallery.

Example: [post_gallery id=99] [post_gallery id=399]

= How to use a different lightbox? =

This [tutorial](https://www.10quality.com/2018/05/29/how-to-change-the-default-lightbox-in-post-gallery/) explains how.

== Who do I thank for all of this? ==

* [10Quality](http://www.10quality.com)
* [Alejandro Mostajo](http://about.me/amostajo)
* [Wordpress MVC](https://www.wordpress-mvc.com/)