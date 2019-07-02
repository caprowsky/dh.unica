<div id="shortcode_atts" class = "postbox">
        <div class="inside">
            <div class="format-settings">
                <div class="format-setting-wrap">
    <h3><?php _e('Display your Feed','eif') ?></h3>
	<p>
<?php _e("To show Instagram feeds on the pages or posts add the shortcode highlighted below in the editor. But for this configure the details in the option panel.","eif");?>
</p>
	 <input type="text" value="[easyinstagramfeed]" size="17" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select()">
 <p><?php _e("The plugin comes with the number of attributes so that you can configure your feeds by just assigning the appropriate value to it. For example, if you'd like to display Instagram feed in the fashion of 4 columns than all you need to do is just assign the value 4 to the cols attribute as shown below.","eif"); ?><code>[easyinstagramfeed cols=4]</code></p>
 <p><?php _e("You can display as many different feeds as you like, on either the same page or on different pages, by just using the shortcode attributes below. For example:","eif");?><br />
        <code>[easyinstagramfeed]</code><br />
        <code>[easyinstagramfeed accesstoken="1591885187.44a5744.385971946cc341fa9f84967c9ba1b9db"]</code><br />
        <code>[easyinstagramfeed accesstoken="1591885187.44a5744.385971946cc341fa9f84967c9ba1b9db,1631861081.3a81a9f.e8ce23b5d41640cfbc39a320d5fdf6eb"]</code>
        </p>
<p><?php _e("See the table below for a full list of available shortcode attributes:","eif"); ?></p>
	<table id="menu-locations-table" class="widefat fixed">
		<thead>
		<tr>
		<th class="wff-att-name" scope="col"><?php _e('Shortcode option','eif');?></th>
		<th class="wff-att-name" scope="col"><?php _e('Example','eif');?></th>
		<th class="wff-att-uses" scope="col"><?php _e('Description','eif');?></th>
		</tr>
		</thead>
		<tbody>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('accesstoken');?></td>
			<td class="wff-att-name"><?php echo('1591885187.44a5744.385971946cc341fa9f84967c9ba1b9db');?></td>
			<td class="wff-att-uses"><?php _e('An Instagram User Token. Want to fetch feeds from multiple user accounts than specify their Tokens and separate them by commas. Use this tool to know your <a href="http://instagram.pixelunion.net/" target="_blank">Token</a> . You can also get your token by authorizing this app in the General Settings of the Option Panel.','eif'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('width');?></td>
			<td class="wff-att-name"><?php echo('100');?></td>
			<td class="wff-att-uses"><?php _e('The width of your feed in number. No need to add px or %. Default value is 100.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('widthunit');?></td>
			<td class="wff-att-name"><?php echo('% or px');?></td>
			<td class="wff-att-uses"><?php _e('The width unit of the feed. Allowed units are px or %. Default value if not specified is %.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('height');?></td>
			<td class="wff-att-name"><?php echo('100');?></td>
			<td class="wff-att-uses"><?php _e('The height of the feed. Just specify a number. The Default value is 100.','eif') ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('heightunit');?></td>
			<td class="wff-att-name"><?php echo('% or px');?></td>
			<td class="wff-att-uses"><?php _e('The height unit of feed. Use px or %.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('backgroundcolor');?></td>
			<td class="wff-att-name"><?php echo('#595e4d');?></td>
			<td class="wff-att-uses"><?php _e('The background color color of your feed area. Default value #fff.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('orderby');?></td>
			<td class="wff-att-name"><?php echo('Random');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__('Sort photos by order. It has two values <b>"Newest to Oldest"</b> and <b>"Random"</b>. Default order is <strong>Newest to Oldest</strong> if not specified.','eif'));?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('num');?></td>
			<td class="wff-att-name"><?php echo('5');?></td>
			<td class="wff-att-uses"><?php _e('Limit number of images to show.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('cols');?></td>
			<td class="wff-att-name"><?php echo('4');?></td>
			<td class="wff-att-uses"><?php _e('Number of column of feed. The default value is 4.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('resolution');?></td>
			<td class="wff-att-name"><?php echo('low_resolution');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__('Resolution of images, has three values <b>thumbnail</b> , <b>low_resolution</b> and <b>standard_resolution</b>. Default resolution is low_resolution if not specified. Thumbnail will render image of size 150 * 150, low resolution 306 * 306 and standard 640px * 640px ','eif'));?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('imagepadding');?></td>
			<td class="wff-att-name"><?php echo('5');?></td>
			<td class="wff-att-uses"><?php _e('The image padding size in number. The default is 5.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('imagepaddingunit');?></td>
			<td class="wff-att-name"><?php echo('px');?></td>
			<td class="wff-att-uses"><?php _e('The image padding unit in % or px. The default is px.','eif');?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('imageoverlay');?></td>
			<td class="wff-att-name"><?php echo('yes');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__('Whether to show the "overlay" on feed. <b>yes</b> or <b>no</b>. The default value is <b>Yes</b>.','eif'));?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('imageborder');?></td>
			<td class="wff-att-name"><?php echo('yes');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__('Whether to show the "Border" on feed. <b>yes</b> or <b>no</b>. The default value is <b>Yes</b>.','eif'));?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('imageshadow');?></td>
			<td class="wff-att-name"><?php echo('yes');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__('Whether to show the "image shadow" on feed. <b>yes</b> or <b>no</b>. The default value is <b>no</b>.','eif'));?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('loadmorebuttondisplay');?></td>
			<td class="wff-att-name"><?php echo('yes');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__("Whether to show the 'Load More' button. <b>yes</b> or <b>no</b>. The default is <b>no</b>.","eif"));?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('loadmorebuttoncolor');?></td>
			<td class="wff-att-name"><?php echo('#000000');?></td>
			<td class="wff-att-uses"><?php _e('The Load More button color. The default is #000.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('loadmorebuttontextcolor');?></td>
			<td class="wff-att-name"><?php echo('#fff');?></td>
			<td class="wff-att-uses"><?php _e('The Load More button text color. The default is #fff.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('loadmorebuttontext');?></td>
			<td class="wff-att-name"><?php echo('Load More');?></td>
			<td class="wff-att-uses"><?php _e('The Load More button display text.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('followbuttondisplay');?></td>
			<td class="wff-att-name"><?php echo('yes');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__("Whether to show the <b>Follow on Instagram</b> button. <b>yes</b> or <b>no</b>. The default value is no.","eif"));?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('followbuttoncolor');?></td>
			<td class="wff-att-name"><?php echo('#000000');?></td>
			<td class="wff-att-uses"><?php _e('The follow on Instagram button color. The default color is #000.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('followbuttontextcolor');?></td>
			<td class="wff-att-name"><?php echo('#fff');?></td>
			<td class="wff-att-uses"><?php _e('The follow on Instagram button text color. The default is #fff.','eif');?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('followbuttontext');?></td>
			<td class="wff-att-name"><?php echo('Follow on Instagram..');?></td>
			<td class="wff-att-uses"><?php _e('The follow on Instagram button display text.','eif');?></td>
		</tr>
		<tr>
		<th class="wff-att-name" style="  background: darkgray;" colspan="3" scope="col"><?php _e('Available Attributes in advance version','eif');?></th>
		<th class="wff-att-name" scope="col"></th>
		<th class="wff-att-name" scope="col"></th>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('searchtype');?></td>
			<td class="wff-att-name"><?php echo('Hashtag');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__("This is to specify which type of feed you want to display. If you want to show feed with hashtag then specify <b>hashtag</b> as a value of shortcode attribute <i>searchtype</i>. If you want feeds from specific user account than specify <b>user</b> as a value of shortcode attribute <i>searchtype</i>. <br> Note: In case of user feed  it is not mandatory to use specify searchtype value as user, it is the defautl value ie [easyinstagramfeed userid='your-user-id' searchtype='user'] is equivalent to [easyinstagramfeed userid='your-user-id']","eif")); ?><br>
		</strong></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('Hashtag');?></td>
			<td class="wff-att-name"><?php echo('Hashtag');?></td>
			<td class="wff-att-uses"><?php _e('An Instagram Hashtag. Want to fetch feeds from multiple Hashtag than specify their Name and for multiple hashtag separate them by commas. Also no need to put # symbol before the hashtag name.','eif'); ?></td>
		</tr>
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('showlightbox');?></td>
			<td class="wff-att-name"><?php echo('yes or no');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__("To disable popup set <strong>no</strong>. The default value is <b>yes</b>.","eif"));?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('captiondisplay');?></td>
			<td class="wff-att-name"><?php echo('yes or no');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__("Whether to show the caption on feed. <b> yes</b> or <b>no</b>. The default value is no.","eif"));?></td>
		</tr>
		
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('captiontextlength');?></td>
			<td class="wff-att-name"><?php echo('10');?></td>
			<td class="wff-att-uses"><?php _e('The caption text length. The default is 10.','eif');?></strong></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('captiontextcolor');?></td>
			<td class="wff-att-name"><?php echo('#666');?></td>
			<td class="wff-att-uses"><?php _e('The caption text color. The default is #666.','eif');?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('captiontextsize');?></td>
			<td class="wff-att-name"><?php echo('14');?></td>
			<td class="wff-att-uses"><?php _e('The caption text size does not need to mention px it is by default include in. The default is 14.','eif');?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('headerdisplay');?></td>
			<td class="wff-att-name"><?php echo('yes or no');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__("Whether to show the header on feed. <b>yes</b> or <b>no</b>. The default value is yes.","eif"));?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('headertextcolor');?></td>
			<td class="wff-att-name"><?php echo('#e34f0e');?></td>
			<td class="wff-att-uses"><?php _e('The color of header text. The default is #e34f0e.','eif');?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('likesdisplay');?></td>
			<td class="wff-att-name"><?php echo('yes or no');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__("Whether to show the likes on feed. <b>yes</b> or <b>no</b>.  The default value is yes.","eif"));?></td>
		</tr>
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('commentsdisplay');?></td>
			<td class="wff-att-name"><?php echo('yes or no');?></td>
			<td class="wff-att-uses"><?php echo sprintf(__("Whether to show the comments on feed. <b>yes</b> or <b>no</b>.  The default value is yes.","eif"));?></td>
		</tr>
		
		
		<tr id="menu-locations-row">
			<td class="wff-att-name"><?php echo('likescommentscolor');?></td>
			<td class="wff-att-name"><?php echo('#dd9494');?></td>
			<td class="wff-att-uses"><?php _e('The likes and comments color. The default is #dd9494.','eif');?></strong></td>
		</tr>
		
		
		
		</tbody>
	</table>	
			   </div>
            </div>
        </div>
	</div>
	