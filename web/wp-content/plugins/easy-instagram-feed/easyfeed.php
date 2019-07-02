<?php

/*
Plugin Name: Easy Instagram Feed
Description: This plugin allows to fetch the Instagram feeds in your wordpress site. Just add the shortcode [easyinstagramfeed] in the normal wordpress page inorder to get the feeds.
Version: 2.2.3
Author: priyanshu.mittal,a.ankit,spicethemes
Author URI: http://www.spicethemes.com
License: GPLv2 or later
Text Domain: easy-instagram-feed
Domain Path: /languages
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Make sure we don't expose any info if called directly




define( 'EIF__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'EIF__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define("eif", "easy-instagram-feed");

/*
* Loading a text domain code for plugin translation 
*/
add_action('plugins_loaded', 'eif_load_textdomain');
function eif_load_textdomain() {
	load_plugin_textdomain( 'eif', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

add_action('admin_menu', 'eif_menu_pages');
add_action('admin_enqueue_scripts','eif_plugin_scripts');


//call shortcode file
require_once(EIF__PLUGIN_DIR.'/easyfeed-shortcode.php');

function easy_instagram_feed_activate( ) {
	//call default data
require_once(EIF__PLUGIN_DIR.'/easyfeed-default-data.php');
	 
}

register_activation_hook(__FILE__, 'easy_instagram_feed_activate');

function eif_plugin_scripts($hook){ 
    if($hook!='toplevel_page_easy-instagram-feed'){return;}
    
    // otherwise enqueu all the scripts required
    wp_enqueue_script('eif_insta_admin',EIF__PLUGIN_URL.'lib/js/easy-feed-admin.js',array('jquery'));
	
	// jquery ui tab
	wp_enqueue_script('eif_custom_wp_admin_js',EIF__PLUGIN_URL.'lib/js/my-custom.js',array('jquery','jquery-ui-tabs'));
	wp_register_script( 'wff_custom_wp_admin_js', plugin_dir_url( __FILE__ ) . 'lib/js/my-custom.js',array('jquery','jquery-ui-core','jquery-ui-tabs','wp-color-picker'), false, '1.0.0' );
	wp_enqueue_script ('wff_custom_wp_admin_js');
    // color picker script
    wp_enqueue_script('eif_color_picker',EIF__PLUGIN_URL.'lib/js/easy-color-picker.js',array('jquery','wp-color-picker'));
    wp_enqueue_style('eif_style',EIF__PLUGIN_URL.'lib/eif_style.css');
    wp_enqueue_style( 'wp-color-picker' );
	// jquery ui css
	
	 wp_enqueue_style( 'bootstrap-style' , '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');  
		wp_register_style ('wff_custom_wp_admin_css', plugins_url('lib/wff-admin.css', __FILE__));
        wp_enqueue_style( 'wff_custom_wp_admin_css' );	
	 }
	 
	 
	 
	 


function eif_menu_pages(){
    
    
    add_menu_page(__('Easy Instagram Feed','eif'), __('Easy Instagram Feed','eif'), 'manage_options', 'easy-instagram-feed', 'eif_menu_output' );
    //add_submenu_page('my-menu', 'Settings', 'Whatever You Want', 'manage_options', 'my-menu' );
    //add_submenu_page('my-menu', 'Submenu Page Title2', 'Whatever You Want2', 'manage_options', 'my-menu2' );
}



function eif_menu_output () {
     $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
	
	 if($_POST)
	 {		
			//if (isset($_POST['eif_easy_instagram_media_security_check_custom_settings '])) {
				
				if(isset($_POST['eif_easy_instagram_media_security_check'])) {
				$nonce = wp_verify_nonce($_POST['eif_easy_instagram_media_security_check'], 'easy_instagram_media_security_check');
				}
				
				if(isset($_POST['eif_easy_instagram_media_security_check_custom_settings'])) {
				$nonce = wp_verify_nonce($_POST['eif_easy_instagram_media_security_check_custom_settings'], 'easy_instagram_media_security_check');
				}
				
				if(isset($_POST['eif_easy_instagram_media_security_check_custom_css'])) {
				$nonce  = wp_verify_nonce($_POST['eif_easy_instagram_media_security_check_custom_css&js'], 'easy_instagram_media_security_check');
				}
				
				switch ($nonce)
			{
			    
			    case 1:
                break;
                
                case 2:
                break;
                
                default:
                exit( 'Nonce is invalid' );
                
			    
			    
			}
	 }
	 
	 
?>

  <div class="wrap settings-wrap" id="page-settings">
    <h2><?php _e('Settings','eif');?></h2>
    <div id="option-tree-header-wrap">
        <ul id="option-tree-header">
            <li id=""><a href="" target="_blank"></a>
            </li>
            <li id="option-tree-version"><span> <?php _e('Instagram Feed Plugin','eif');?> </span>
            </li>
        </ul>
    </div>
    <div id="option-tree-settings-api">
        <div id="option-tree-sub-header"></div>
        <div class = "ui-tabs ui-widget ui-widget-content ui-corner-all">
            <ul >
                <li id="tab_create_setting"><a href="#section_general"> <?php _e('General Settings','eif');?></a>
                </li>
                <li id="tab_import"><a href="#section_design" ><?php _e('Design Customization','eif');?></a>
                </li>
				<li id="tab_custom_css_and_js"><a href="#section_custome_css_and_js"><?php _e('Custom CSS and JS','eif');?></a>
				</li>
				<li id="tab_feed_config"><a href="#display_your_feeds"><?php _e('Display Your Feeds','eif');?></a>
				</li>
				<li id="tab_get_beeta"><a href="#display_get_beeta"><?php _e('Get The advance Version','eif');?></a>
				</li>
				<li id="tab_show_love"><a href="#display_show_love"><?php _e('Show some love','eif');?></a>
				</li>
				<li id="tab_faq_doc"><a href="#display_FAQ_doc"><?php _e('FAQ','eif');?></a>
				</li>
				
            </ul>
            <div id="poststuff" class="metabox-holder">
                <div id="post-body">
                    <div id="post-body-content">
                        <div id="section_general" class = "postbox">
                            <div class="inside">
                                <div id="setting_theme_options_ui_text" class="format-settings">
                                    <div class="format-setting-wrap">
									<p><?php 
											{ 
												require_once(EIF__PLUGIN_DIR.'lib/optionpanel/general-settings.php');
												?><p><?php echo sprintf (__("Add the shortcode <strong>[easyinstagramfeed]</strong> to display instagram feeds.","eif"));?></p><?php
												
											}?><p>
	
									
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="section_design" class = "postbox">
                            <div class="inside">
                                <div id="design_customization_settings" class="format-settings">
                                   
                                    
                                    
                                    
                                        <div class="format-setting-wrap">
                                       
                                          <div class = "format-setting type-textarea has-desc">
                                          
                                          
                                          <div class = "format-setting-inner">
                                              
												</p><?php 
														{ 
														require_once(EIF__PLUGIN_DIR.'lib/optionpanel/customize.php');
														} 
													?><p>
                                              
                                              </div>
                                          
                                          
                                          
                                      </div>
                                        
                                             
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
						
						 <div id="section_custome_css_and_js" class = "postbox">
                            <div class="inside">
                                <div id="design_customization_settings" class="format-settings">
                                   
                                    
                                    
                                    
                                        <div class="format-setting-wrap">
                                       
                                          <div class = "format-setting type-textarea has-desc">
                                          
                                          
                                          <div class = "format-setting-inner">
                                              
												</p><?php 
														{ 
														require_once(EIF__PLUGIN_DIR.'lib/optionpanel/custome_css_and_js.php');
														} 
													?><p>
                                              
                                              </div>
                                          
                                          
                                          
                                      </div>
                                        
                                             
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
              
						 <div id="display_your_feeds" class = "postbox" >
                            <div class="inside">
                                <div id="setting_export_settings_file_text" class="format-settings">
                                    <div class="format-setting-wrap">
                                        
                                            <p><?php
											require_once(EIF__PLUGIN_DIR.'lib/optionpanel/display-feeds.php');
											?></p>
                                      

                                    </div>
                                </div>
                                
                                
                                
                            </div>
                        </div>
                   <div id="display_get_beeta" class = "postbox" >
                            <div class="inside">
                                <div id="setting_export_settings_file_text" class="format-settings">
                                    <div class="format-setting-wrap">
                                        <h1><?php _e('What you get in advance version','eif');?></h1><hr>
                                            <ol>
                                                <li>
                                                    <h3><?php _e('Video type media support','eif');?></h3>
                                                    <p><?php _e('In the advance verison you can show video type items in the instagram feed. LightBox pop up will play the video.','eif');?></p>
                                                </li>
                                                <li>
                                                    <h3><?php _e('Hashtags support','eif');?></h3>
                                                    <p><?php _e('Get feeds by the hashtags. Say if you set Adidas and sports as the tags than you will recieves those media items in feed which have atleast both the tags.','eif');?> </p>
                                                </li>
                                                <li>
                                                    <h3><?php _e('Common hashtags feed support','eif');?></h3>
                                                    <p><?php _e('By default Instagram shows all the feeds from the multiple hashtags. Right now instagram did not have a feature to show feeds common in the multiple hastags. The advance version does have a feature to display only those feeds common in the multiple hashtags.','eif');?></p>
                                                </li>
                                                <li>
                                                    <h3><?php _e('User feed filtering by hashtag','eif');?></h3>
                                                    <p><?php _e('As you know that instagram has no phenomena which allow you to display user feed tagged by specific hash tags, so , we have added a feature to do it.','eif');?></p>
                                                </li>
                                                <li>
                                                    <h3><?php _e('Lightbox support','eif');?></h3>
                                                    <p><?php _e('By default the lightbox is active that if you click on any of the image / video , than you get the nice piece of lightBox  overlay. In this overlay window you can watch video, navigate to other images, share the items on insatragam  etc etc. You can also disable it if you dint want to use lightbox.','eif');?>   </p>
                                                </li>
                                                <li>
                                                    <h3><?php _e('Socialise feeds','eif');?></h3>
                                                    <p><?php _e('Share the feed items on Instagram as well as other social services like Facebook, Twitter, Google Plus, LinkedIn, Pinterest, Reddit and Stumbleupon.','eif');?></p>
                                                </li>
                                                <li>
                                                    <h3><?php _e('Configure caption','eif');?></h3>
                                                    <p><?php _e('Easy control over the media caption. You can hide, style, specify the limit of text to show by default.','eif');?></p>
                                                </li>
                                                <li>
                                                    <h3><?php _e('Configure like and share icon','eif');?></h3>
                                                    <p><?php _e('You can add the like and share icons by selecting the checkbox. You can also change the icon colors.','eif');?></p>
                                                </li>
												<li>
                                                    <h3><?php _e('Header support','eif');?></h3>
                                                    <p><?php _e('Show you instagram profile picture along with the name. You can also change the text color in the header.','eif');?> </p>
                                                </li>
												
												</ol>
                                                <h3><?php _e('How to get advance version','eif');?></h3>
                                                <p><?php echo sprintf(__('If you are interested in advance version of this plugin then please drop us a mail. <a target ="_blank" href="https://spicethemes.com/contact/"> here</a>. I hope you will also enjoy working with us.','eif'));?>
                                                </p>
                                                
                                                <h3><?php _e('Cheers','eif');?></h3>
												<h3><?php echo 'Priyanshu';?></h3>
												<h3><?php _e('Co-Founder, Spicethemes','eif');?><p></p></h3>
                                    </div>
                                </div>
                                
                                
                                
                            </div>
                        </div>
						
						 <div id="display_show_love" class = "postbox" >
                            <div>
                                <div id="setting_export_settings_file_text" class="format-settings">
                                    <div class="format-setting-wrap">
                                        
                                            <p><div class="postbox like-postbox">
                                    <div class="handlediv" ><br></div>
                                    <h3 class="hndle"><span><?php _e('Show some love','eif');?></span></h3>
                                    <div >
                                        <div>
                                            <p><?php _e('Like this plugin? Support us by','eif');?></p>
                                            
                                                <a  class="buy-button gray-btn" target="_blank" href="https://wordpress.org/support/view/plugin-reviews/easy-instagram-feed"><i class="fa fa-star"></i><?php _e('Rate it','eif');?></a>
                                                <a class="buy-button blue-btn" target="_blank" href="http://twitter.com/share?url=https%3A%2F%2Fwordpress.org%2Fplugins%2Feasy-instagram-feed%2F&amp;text=Check out this awesome %23WordPress Plugin I'm using, Custom Instagram feed by @spicethemes"><i class="fa fa-twitter"></i><?php _e('Tweet it','eif');?></a>
                                            
                                        </div>
                                    </div>
                                </div></p>
                                      

                                    </div>
                                </div>
                                
                                
                                
                            </div>
                        </div>
						
						<div id="display_FAQ_doc" class = "postbox" >
                            <div class="inside">
                                <div id="setting_export_settings_file_text" class="format-settings">
                                    <div class="format-setting-wrap">
                                        <h1><?php _e('Common issues','eif');?></h1>
                                            <br>
                                            
                                           <ul style="padding-left:15px;"> 
                                           <li style="list-style:disc;">
                                                <h3 style="padding-left:0px;"><?php _e('Feeds not displaying','eif');?></h3>
                                                <p>
    											<?php _e('The heart of this plugin is javascript, so, its a very good chance that the plugin will face javascript conflicts with others themes and plugins. In this case, always check for the errors in the console, try to deactivate the plugin one by one and see whether you are still facing the same issue. Sometimes it has seen that the plugin did not work with the theme itself, again, the main issue is of javascript conflict, So, in this case, try with the others themes like twenty fourteen, twenty twelve etc. If nothing works then do let us know about the issue.','eif');?>
    											</p>
    											<p><?php echo sprintf(__('After taking all measures mentioned above, if you are still facing the issue, than check wither your access token is valid or not.','eif'));?>
    											</p>
											</li>
											
											<li style="list-style:disc;">
                                                <h3 style="padding-left:0px;"><?php _e('How to display Instagram feed on post/page?','eif');?></h3>
                                                <p>
    											<?php echo sprintf(__('After plugin activation Go to "Easy Instagram feed" option panel, configure it and add the shortcode <b>[easyinstagramfeed]</b> in the WordPress Post/Pages.','eif'));?>
    											</p>
											</li>
											
											
											
											<li style="list-style:disc;">
                                                <h3 style="padding-left:0px;"><?php _e('What is the minimum requirement to run the shortcode?','eif');?></h3>
                                                <p>
    											<?php _e('User access token are mandatory.','eif');?>
    											</p>
											</li>
											
											
											
											<li style="list-style:disc;">
                                                <h3 style="padding-left:0px;"><?php _e('How to display different feeds on different pages.','eif');?></h3>
                                                <p>
    											<?php echo sprintf(__('Add different shortcodes on different pages ie if you want to show 2 user feeds on different pages than add <b><i>[easyinstagramfeed accesstoken="Token1"]</i></b> to one page and add <b><i>[easyinstagramfeed accesstoken="Token2"]</i></b> to another page.','eif'));?>
    											</p>
											</li>
											
											
											<li style="list-style:disc;">
                                                <h3 style="padding-left:0px;"><?php _e('How to get user Access token?','eif');?></h3>
                                                <p>
    											<?php echo sprintf(__('Go to general settings and get the user from there or use the this third party <a target ="_blank" href="http://instagram.pixelunion.net/"> tool </a>','eif'));?></a></p>
											</li>
											
											
											
											
											<li style="list-style:disc;">
                                                <h3 style="padding-left:0px;"><?php _e('How to display multiple accounts feeds on pages?','eif');?></h3>
                                                <p>
    											<?php echo sprintf(__('I am assuming that you have authorized the app with your Instagram account ie you have the access token. Add the shortcode <b><i>[easyinstagramfeed accesstoken="Token1,Token2"]</i></b> to wordpress page.','eif'));?>
    											</p>
											</li>
											
											<li style="list-style:disc;">
                                                <h3 style="padding-left:0px;"><?php _e('Facing other issues.','eif');?></h3>
                                                <p>
    											<a target="_blank" href="https://wordpress.org/support/plugin/easy-instagram-feed"><?php _e('click here','eif');?></a></p>
											</li>
											
                                          </ul>

                                    </div>
                                </div>
                                
                                
                                
                            </div>
                        </div>
			  
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>

 

<?php 

}

wp_embed_register_handler( 'eif_instagram', '/https?\:\/\/instagram.com\/p\/(.+)/', 'eif_instagram_embed_function' );

function eif_instagram_embed_function( $matches, $attr, $url, $rawattr ) {
 wp_enqueue_script('eif_insta_responcive_iframe',EIF__PLUGIN_URL.'lib/js/res/jquery.responsiveinstagram.js');
    $image_id = str_replace('/','',$matches[1]);

    $embed = sprintf(
            '<iframe src="//instagram.com/p/%1$s/embed/" width="612" height="712" scrolling="no" allowtransparency="true" style="border-radius: 5px; border: 1px solid #d6d6d6;" ></iframe>',
            esc_attr($image_id)
            );
			?>
			<script type="text/javascript">
			jQuery(document).ready( function () {
 jQuery('iframe[src*="instagram.com"]').responsiveInstagram();
});
</script>
<?php

    return apply_filters( 'embed_eif_instagram', $embed, $matches, $attr, $url, $rawattr );
}


add_filter('widget_text', 'do_shortcode');
?>