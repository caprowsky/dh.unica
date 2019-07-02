=== Custom Instagram Feed ===
Contributors: priyanshu.mittal,a.ankit,spicethemes
Donate link: http://www.spicethemes.com/
Tags: instagram, instagram page, instagram feed, instagram photos,custom instagram feed,mobile instagram,wordpress instagram
Requires at least: 3.3+
Tested up to: 5.0.3
Stable tag: 2.2.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Plugin allows you to display customizable and responsive Instagram photos. 

== Description ==

Custom Instagram Feed plugin allows to display Instagram photos on your WordPress site. Just add the shortcode *[easyinstagramfeed]* in the normal WordPress page/post inorder to get the feeds.


= Features =
* Completely *Responsive* on any device like ipads, mobiles etc etc. Looks good in all devices.
* Very *easy set up* process.
* Display photos from *multiple Instagram accounts* in a single feed.
* Options for configuring width, height and background color of the section where you will get the Instagram photos.
* *Layout Options* - You can configure the gallery/feed layout ie 2 column, 3 column and so on.
* Photo Count - Option for *selecting the number of photos* to display ie if you select 20 photos to display first time, than, after 20 th one, you will be get a nice piece of load more button and when you click this button you will get the next set of photos.
* Easily select the *order of photos* ie you can randomize the order of photos as well as set the order from new to old.
* Easily *add padding* around each photo. 
* Feature for *configuring load more button* as per the theme's color schemes so that the button looks more like the theme button itself.
* *Follow us* on Instagram button.
* Most Important adding *shortcode attributes* so that you can *display multiple feeds* on the same page as well as on different pages by just adding [easyinstagramfeed accesstoken="xyz"]
* Support for *Instagram Embed*


Here is the link to [Documentation](https://spicethemes.com/documentation-for-easy-instagram-feed-plugin/)

[youtube https://www.youtube.com/watch?v=BBbg3etugX8]

In case you face any problem, contact us via the [Forums](http://wordpress.org/support/plugin/easy-instagram-feed). 

= What you get in advance version? =
* *Video Media Support:* In the advance version you can show video type items in the instagram feed. You can also watch the video directly on your website in the form of Lightbox pop up.
* *Hashtag Support:* Filter your feeds with the help of hashtags. You can also add multiple hashtags. Say if you set Adidas and sports as the tags than you will receives those media items in feed which have these two tags only.
* *Common Hashtags Feed Support:* By default Instagram shows all the feeds from the multiple hashtags. Right now Instagram did not have a feature to show feeds common in the multiple hastags. The advance version does have a feature to display only those feeds common in the multiple hashtags. 
* *User Feed filtering by hashtag:* As you know that Instagram has no phenomena which allow you to display user feed tagged by specific hash tags, so , we have added a feature to do it.
* *Lightbox Support:* By default the Lightbox is active that if you click on any of the image / video , than you get the nice piece of LightBox Overlay. In this overlay window you can watch video, navigate to other images, share the items on Instagram etc etc. You can also disable it if you dint want to use Lightbox.
* *Socialise Feeds:* Share the feed items on instagram as well as other social services like Facebook, twitter, google plus, linkedin, pinterest, Reddit and StumbleUpon.
* *Configure Caption:* Easy control over the media caption. You can hide, style, specify the limit of text to show by default.
* *Configure Like and Comment icon:* You can hide the like and comment icons by selecting the checkbox. You can also change the icon colors.
* *Header Support:* Show you Instagram profile picture along with the name. You can also change the text color in the header.
* [View Custom Instagram Feed advance Live Demo &raquo;](http://webriti.com/easy-instagram-feed-demo/)

== Installation ==

1. Download Easy Instagram Feed plugin.
2. Upload the easy-instagram-feed folder to the /wp-content/plugins/ directory.
3. Activate the plugin through the 'Plugins' menu in WordPress and Enjoy.

Lots more to come, will update the change log accordingly.
Give **Custom Instagram Feed** a try. We are sure you will like it. 


== FAQ ==

= 1. How to get user Access token? =

Go to general settings and click the big blue button or use the this third party <a href="http://instagram.pixelunion.net/" target="_blank">tool</a> 


= 2. How to display Instagram feed on post / page? =

After plugin activation  Go to "Easy Instagram feed" option panel, configure it and add the shortcode **[easyinstagramfeed]** in the WordPress Post / Pages.


= 3. How to display multiple feeds on pages? =

I am assuming that you have authorize the app with your Instagram account ie you have the access token. Add the shortcode **[easyinstagramfeed accesstoken="Token1,Token2"]** to WordPress page.

= 4. What is the minimum requirement to run the shortcode?. =

User access token are mandatory.

= 5. How to display different feeds on different pages. =

Add different shortcodes on different pages ie if you want to show 2 user feeds on different pages than add **[easyinstagramfeed accesstoken="Token1"]** to one page and add **[easyinstagramfeed accesstoken="Token2"]** to another page.

= 6. How to get 4 column layout of feed? =

For this use the attribute *cols* . Add this shortcode **[easyinstagramfeed accesstoken="Token1" cols=4]**. Similarly you can play around with the other attributes.

= 7. What type of configuration is possible?. =

Feed width, height, background color, image resolution, padding , load moer button configurations etc etc.

= 8. What do you mean by image resolution. =

Instagram has three type resolutions thumbnail, low_resolution and standard_resolution.If you set the thumbnail size than instagram will return you the image of size 15
px by 150px. Simialry for low_resolution size is 306 by 306 and for standard_resolution image of size 640 * 640 is returned.

= 8. Getting Blank Screen or feed not working =

Always check for *javascript issue* in the console. Plugin heart is javascript so if you have any js conflict prior to the instagram plugin activation irrespective of any theme and plugin than it will not work. If no js issue is found than always check the *access token* validity or not. 


== Screenshots ==

1. Create Instagram feed page like this
2. Instagram Image Embed page. Just add the image url in the WordPress Page and will get the similar layout as shown in the snapshot below.
3. Instagram Video Embed page. Just add the video url and you will the video iframe automatically gets created on the WordPress page.

== Changelog ==

= 2.2.3 =
1. Test WordPress version 5.0.3 compatibility.

= 2.2.2 =
1. Test WordPress version 5.0 compatibility.

= 2.2.1 =
1. Change screen shot.
2. Remove default access token and user id.
3. Remove user id field.
4. Always replace user token with new token. 
5. Fixed nonce undefined error.
6. Fixed Instagram authentication issue.

= 2.2 =
1. Make advance version.

= 2.1.6 =
1. Update code

= 2.1.5 =
1. Added code according to new Instagram API.

= 2.1.4 =
1. Test WordPress version 4.9.4 compatibility.

= 2.1.3 =
1. Show video thumbnail in square.

= 2.1.2 =
1. Change strings.
2. Commit from new office.

= 2.1.1 =
1. Change strings.

= 2.1 =
1. Updated Strings.

= 2.0 =
1. Added support for localization..

= 1.9 =
1. Test WordPress version 4.6 compatibility.

= 1.8 =
1. show note for use default access token due to instagram API changes in 01 june 2016.
= 1.7 =
1. show note for use default access token due to instagram API changes in 01 june 2016.

= 1.5.5 =
1. Added corrected security issue.
= 1.5.4 =
1. Add Youtube link in the description
= 1.5.3 =
1. mention FAQ tab
= 1.5.2 =
1. resolve issue plugin style scope.
2. resolve issue feed responsive.
= 1.5.1 =
1. Added extra tab in the option panel.
= 1.5 =
1. Added image border setting.
2. Added image shadow setting.
3. Added image overlay setting.
4. resolve  instagram Embed image size issue

= 1.4 =
1. Added support for instagram Embed.
2. Update read me file.
= 1.3 =
Updated Readme file
Small bug fixes.
= 1.2 =
Added feature to add custom css and js that apply only in instagram feed shortcode page .
= 1.1 =
Remove load more bug on some specific number of objects.
= 1.0 =
Added beta version link.
= 0.7 =
1. Added subscription form for beta testers.
2. Improoved some styling issues.
= 0.6 =
1.Improove Load More button logic. Now after each button click the ajax request will be send to fetch the next set of media items.
 
= 0.5 =
1. Image padding.
2. Locad more button configurations.
3. Follow Us Instagram button configurations.

= 0.4 =
1. Added feature to select order of the photos ie from new to old or random.
2. You can select photo count.
3. Feature for adding padding.
4. Select number of columns.

= 0.3 =
1. Feature to configure feed section ie width , height and background color.

= 0.2 =
1. Added support for adding multiple user id's.

= 0.1 =
This version provides basic functionality to authorize an app with the instagram and fetch instagram feeds with the help of shortcode [easyinstagramfeed] on pages.