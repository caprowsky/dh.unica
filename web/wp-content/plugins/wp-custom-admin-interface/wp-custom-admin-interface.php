<?php

/*
*		Plugin Name: WP Custom Admin Interface
*		Plugin URI: https://www.northernbeacheswebsites.com.au
*		Description: Customise the WordPress admin and login interfaces and customize the WordPress dashboard menu.  
*		Version: 7.12
*		Author: Martin Gibson
*		Developer: Northern Beaches Websites
*		Developer URI:  https://www.northernbeacheswebsites.com.au
*		Text Domain: wp-custom-admin-interface 
*       Copyright: ©2019 Northern Beaches Websites.
*		Support: https://www.northernbeacheswebsites.com.au/contact
*		Licence: GNU General Public License v3.0
*       License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/



/**
* 
*
*
* Create admin menu and add it to a global variable so that admin styles/scripts can hook into it
*/
add_action( 'admin_menu', 'wp_custom_admin_interface_add_admin_menu' );
add_action( 'admin_init', 'wp_custom_admin_interface_settings_init' );

function wp_custom_admin_interface_add_admin_menu(  ) { 
    $menu_icon_svg = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMjAgMjA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiNGRkZGRkY7fQ0KCS5zdDF7ZmlsbDojQTBBNUFBO30NCjwvc3R5bGU+DQo8cGF0aCBjbGFzcz0ic3QwIiBkPSJNLTM2OC4xLTE4LjljMC04MS43LDAtMTYzLjMsMC0yNDVjODcuNSwwLDE3NSwwLDI2Mi41LDBjMCw4MS43LDAsMTYzLjMsMCwyNDUNCglDLTE5My4xLTE4LjktMjgwLjYtMTguOS0zNjguMS0xOC45eiBNLTI5MC43LTE5MS45YzYuMiwwLDEyLjUsMCwxOC43LDBjNy4yLDAsMTEuMy00LjEsMTEuMy0xMS4yYzAtMTIuNSwwLTI1LDAtMzcuNQ0KCWMwLTcuMS00LjEtMTEuMi0xMS4xLTExLjJjLTEyLjYsMC0yNS4yLDAtMzcuNywwYy02LjksMC0xMS4xLDQuMS0xMS4xLDExYzAsMTIuNywwLDI1LjMsMCwzOGMwLDYuNyw0LjIsMTAuOSwxMC45LDExDQoJQy0zMDMuNC0xOTEuOS0yOTctMTkxLjktMjkwLjctMTkxLjl6IE0tMTkwLjYtMTcxLjljLTYuMywwLTEyLjcsMC0xOSwwYy02LjksMC0xMSw0LjItMTEsMTEuMWMwLDEyLjYsMCwyNS4yLDAsMzcuNw0KCWMwLDYuOSw0LjEsMTEuMSwxMSwxMS4xYzEyLjcsMCwyNS4zLDAsMzgsMGM2LjgsMCwxMS00LjIsMTEtMTEuMWMwLTEyLjYsMC0yNS4yLDAtMzcuN2MwLTctNC4xLTExLjEtMTEuMi0xMS4xDQoJQy0xNzguMS0xNzEuOS0xODQuMy0xNzEuOS0xOTAuNi0xNzEuOXogTS0yNzAuNi05MS44Yy02LjIsMC0xMi41LDAtMTguNywwYy03LjEsMC0xMS4yLDQuMS0xMS4yLDExLjFjMCwxMi42LDAsMjUuMiwwLDM3LjcNCgljMCw2LjksNC4xLDExLjEsMTEsMTEuMWMxMi43LDAsMjUuMywwLDM4LDBjNi44LDAsMTAuOS00LjIsMTEtMTAuOWMwLTEyLjcsMC0yNS41LDAtMzguMmMwLTYuNi00LjItMTAuOC0xMC44LTEwLjgNCglDLTI1Ny44LTkxLjktMjY0LjItOTEuOC0yNzAuNi05MS44eiBNLTI1NS41LTIxMi4xYzQ1LjEsMCw4OS45LDAsMTM0LjcsMGMwLTYuNiwwLTEzLjEsMC0xOS42Yy00NSwwLTg5LjgsMC0xMzQuNywwDQoJQy0yNTUuNS0yMjUuMS0yNTUuNS0yMTguNy0yNTUuNS0yMTIuMXogTS0zNjAuNC0xNTEuOGMwLDYuOCwwLDEzLjMsMCwxOS43YzQ1LDAsODkuOCwwLDEzNC42LDBjMC02LjcsMC0xMy4yLDAtMTkuNw0KCUMtMjcwLjctMTUxLjgtMzE1LjUtMTUxLjgtMzYwLjQtMTUxLjh6IE0tMjM1LjUtNTIuMWMzOC40LDAsNzYuNiwwLDExNC43LDBjMC02LjcsMC0xMy4xLDAtMTkuNmMtMzguMywwLTc2LjUsMC0xMTQuNywwDQoJQy0yMzUuNS02NS4xLTIzNS41LTU4LjctMjM1LjUtNTIuMXogTS0zMDUuNy03MS43Yy0xOC40LDAtMzYuNiwwLTU0LjcsMGMwLDYuNywwLDEzLjEsMCwxOS42YzE4LjMsMCwzNi41LDAsNTQuNywwDQoJQy0zMDUuNy01OC43LTMwNS43LTY1LjEtMzA1LjctNzEuN3ogTS0zMjUuOC0yMTJjMC02LjcsMC0xMy4zLDAtMTkuN2MtMTEuNywwLTIzLjEsMC0zNC42LDBjMCw2LjcsMCwxMy4yLDAsMTkuNw0KCUMtMzQ4LjgtMjEyLTMzNy40LTIxMi0zMjUuOC0yMTJ6IE0tMTU1LjQtMTUxLjdjMCw2LjcsMCwxMy4xLDAsMTkuN2MxMS42LDAsMjMuMiwwLDM0LjcsMGMwLTYuNiwwLTEzLjEsMC0xOS43DQoJQy0xMzIuMy0xNTEuNy0xNDMuOC0xNTEuNy0xNTUuNC0xNTEuN3oiLz4NCjxnPg0KCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik02LDYuMWMtMC41LDAtMSwwLTEuNSwwQzQsNi4xLDMuNiw1LjgsMy42LDUuMmMwLTEsMC0yLDAtM2MwLTAuNSwwLjMtMC45LDAuOS0wLjljMSwwLDIsMCwzLDANCgkJYzAuNiwwLDAuOSwwLjMsMC45LDAuOWMwLDEsMCwyLDAsM2MwLDAuNi0wLjMsMC45LTAuOSwwLjlDNyw2LjEsNi41LDYuMSw2LDYuMXoiLz4NCgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMTQsNy43YzAuNSwwLDEsMCwxLjUsMGMwLjYsMCwwLjksMC4zLDAuOSwwLjljMCwxLDAsMiwwLDNjMCwwLjYtMC4zLDAuOS0wLjksMC45Yy0xLDAtMiwwLTMsMA0KCQljLTAuNSwwLTAuOS0wLjMtMC45LTAuOWMwLTEsMC0yLDAtM2MwLTAuNiwwLjMtMC45LDAuOS0wLjlDMTMsNy43LDEzLjUsNy43LDE0LDcuN3oiLz4NCgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNNy42LDE0LjFjMC41LDAsMSwwLDEuNSwwYzAuNSwwLDAuOSwwLjMsMC45LDAuOWMwLDEsMCwyLDAsMy4xYzAsMC41LTAuMywwLjktMC45LDAuOWMtMSwwLTIsMC0zLDANCgkJYy0wLjUsMC0wLjktMC4zLTAuOS0wLjljMC0xLDAtMiwwLTNjMC0wLjYsMC4zLTAuOSwwLjktMC45QzYuNiwxNC4xLDcuMSwxNC4xLDcuNiwxNC4xeiIvPg0KCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik04LjgsNC41YzAtMC41LDAtMSwwLTEuNmMzLjYsMCw3LjIsMCwxMC44LDBjMCwwLjUsMCwxLDAsMS42QzE2LDQuNSwxMi40LDQuNSw4LjgsNC41eiIvPg0KCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik0wLjQsOS4zYzMuNiwwLDcuMiwwLDEwLjcsMGMwLDAuNSwwLDEsMCwxLjZjLTMuNiwwLTcuMSwwLTEwLjcsMEMwLjQsMTAuNCwwLjQsOS44LDAuNCw5LjN6Ii8+DQoJPHBhdGggY2xhc3M9InN0MSIgZD0iTTEwLjQsMTcuM2MwLTAuNSwwLTEsMC0xLjZjMy4xLDAsNi4xLDAsOS4yLDBjMCwwLjUsMCwxLDAsMS42QzE2LjUsMTcuMywxMy41LDE3LjMsMTAuNCwxNy4zeiIvPg0KCTxwYXRoIGNsYXNzPSJzdDEiIGQ9Ik00LjgsMTUuN2MwLDAuNSwwLDEsMCwxLjZjLTEuNSwwLTIuOSwwLTQuNCwwYzAtMC41LDAtMSwwLTEuNkMxLjksMTUuNywzLjMsMTUuNyw0LjgsMTUuN3oiLz4NCgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMy4yLDQuNWMtMC45LDAtMS44LDAtMi44LDBjMC0wLjUsMC0xLDAtMS42YzAuOSwwLDEuOCwwLDIuOCwwQzMuMiwzLjQsMy4yLDQsMy4yLDQuNXoiLz4NCgk8cGF0aCBjbGFzcz0ic3QxIiBkPSJNMTYuOCw5LjNjMC45LDAsMS44LDAsMi44LDBjMCwwLjUsMCwxLDAsMS42Yy0wLjksMC0xLjgsMC0yLjgsMEMxNi44LDEwLjQsMTYuOCw5LjgsMTYuOCw5LjN6Ii8+DQo8L2c+DQo8L3N2Zz4NCg==';

	$wp_custom_admin_interface_settings_page = add_menu_page( 'WP Custom Admin Interface', 'Custom Admin Interface', 'manage_options', 'wp_custom_admin_interface', 'wp_custom_admin_interface_options_page_welcome',$menu_icon_svg);
    
    
    //call a function which generates sub page settings
    wp_custom_admin_interface_subpage_menu_generator('General Settings');
    wp_custom_admin_interface_subpage_menu_generator('Custom Code');
    wp_custom_admin_interface_subpage_menu_generator('Custom Code Frontend');
    wp_custom_admin_interface_subpage_menu_generator('Maintenance Page');
    wp_custom_admin_interface_subpage_menu_generator('Custom Dashboard Widget');
    wp_custom_admin_interface_subpage_menu_generator('Admin Color Scheme');
    wp_custom_admin_interface_subpage_menu_generator('Admin Menu');
    wp_custom_admin_interface_subpage_menu_generator('Admin Toolbar');
    wp_custom_admin_interface_subpage_menu_generator('Admin Notice');
    wp_custom_admin_interface_subpage_menu_generator('Hide Plugins');
    wp_custom_admin_interface_subpage_menu_generator('Hide Users');
    wp_custom_admin_interface_subpage_menu_generator('Hide Sidebars');
    wp_custom_admin_interface_subpage_menu_generator('Hide Meta');
    wp_custom_admin_interface_subpage_menu_generator('Manage Settings');
    wp_custom_admin_interface_subpage_menu_generator('Help');
    //this removes the unnecessary submenu item output by WordPress
    remove_submenu_page('wp_custom_admin_interface','wp_custom_admin_interface');

}
/**
* 
*
*
* Helps generate submenus
*/
global $wp_custom_admin_interface_settings_pages;
$wp_custom_admin_interface_settings_pages = array();

global $wp_custom_admin_interface_settings_pages_names;
$wp_custom_admin_interface_settings_pages_names = array();

function wp_custom_admin_interface_subpage_menu_generator($menuName) {
    
    global $wp_custom_admin_interface_settings_pages;
    global $wp_custom_admin_interface_settings_pages_names;
    
    $lowercaseAndUnderScored = str_replace(' ','_',strtolower($menuName));

    $removeSpaces = str_replace(' ', '', $menuName);    
    
    $wp_custom_admin_interface_settings_page = add_submenu_page('wp_custom_admin_interface',$menuName,$menuName,'manage_options','wpcai_'.$lowercaseAndUnderScored,function() use ($removeSpaces) { 
        wp_custom_admin_interface_settings_page_content($removeSpaces);    
    });

    array_push($wp_custom_admin_interface_settings_pages,$wp_custom_admin_interface_settings_page);
    
    if($menuName !== 'Help' && $menuName !== 'Manage Settings'){
        array_push($wp_custom_admin_interface_settings_pages_names,$menuName);    
    }
    
    
}
/**
* 
*
*
* Function that displays settings tab content
*/
function wp_custom_admin_interface_settings_page_content ($submenu) {
    ?>
                
    <div class="wrap">
        <div id="poststuff">
            <!--main heading-->
            <h1 style="margin-bottom: 15px;">
                <i class="fa fa-sliders options-page-header-icon" aria-hidden="true"></i> WP Custom Admin Interface<a target="_blank" class="donate-button" href="https://northernbeacheswebsites.com.au/product/donate-to-northern-beaches-websites/">Donate now</a>
            </h1>
            
            <!--notice message-->
            <div style="border-radius: 4px;" data-dismissible="disable-done-notice-forever" class="notice is-dismissible please-hide-that-annoying-notice">
            <p><h3><?php _e( 'A Message from the Developer', 'wp-custom-admin-interface' ); ?></h3><p><?php _e('Hi there! Thanks for using my plugin. I wrote this plugin because at the moment I use a few different little plugins to customise the admin interface and I thought it would be great to put it all into one and make things easy to use. I appreciate that customising the WordPress admin is a bit of a pandora\'s box as everyone has their own way they like to do things! If you like the plugin please consider rating it', 'wp-custom-admin-interface' ); ?> <a href="https://wordpress.org/support/plugin/wp-custom-admin-interface/reviews/?rate=5#new-post" target="_blank"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></a>'s.</p>
            
            <p><?php _e('Sick of seeing this notice and my ugly face at the bottom of this settings page?', 'wp-custom-admin-interface' ); ?> <i style="color: #d14032; font-weight: 900;" class="fa fa-frown-o" aria-hidden="true"></i> <?php _e('Why not hide it using this plugin with the following', 'wp-custom-admin-interface' ); ?> <a href="admin.php?page=wpcai_custom_code#customCodePage"><?php _e('CSS code', 'wp-custom-admin-interface' ); ?></a>:</p>
            <code><strong>.please-hide-that-annoying-notice {display:none}</strong></code></p>
            </div>
            
            <!--start form-->
            <form id='custom_admin_interface_settings_form' action='options.php' method='post'>
                
            <div class="meta-box-sortables ui-sortable">
            <div class="postbox" style="border-radius: 4px;">
            <div class="inside">
                
            <h1 style="padding-left: 10px; font-weight: bold;"><?php echo substr(preg_replace('/(?<!\ )[A-Z]/', ' $0', $submenu),1); ?></h1>    
                
    <table class="form-table">       

        <!--fields-->
        <?php
        settings_fields($submenu);
        do_settings_sections($submenu);
            
        if($submenu !== 'ManageSettings' && $submenu !== 'Help') {
            echo '<button type="submit" name="submit" id="submit" class="button button-primary wp-custom-admin-interface-save-button"><i class="fa fa-check-square" aria-hidden="true"></i> ';
            echo _e('Save All Settings', 'wp-custom-admin-interface' );
            echo '</button>';   
        }
        
        ?>

    </table>
           
                
                
                
                
        </div></div></div>
    </form>     
            <!--ad-->
            <?php


                if ( ! function_exists( 'northernbeacheswebsites_information' ) ) {
                    require('inc/nbw.php');  
                }

                echo northernbeacheswebsites_information();

            ?>

        </div>
    </div>            
    <?php
}
/**
* 
*
*
* Gets version number of plugin
*/
function wp_custom_admin_interface_get_version() {
	if ( ! function_exists( 'get_plugins' ) )
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$plugin_file = basename( ( __FILE__ ) );
	return $plugin_folder[$plugin_file]['Version'];
}
/**
* 
*
*
* Gets, sets and renders options
*/
require('inc/options/options-output.php');
/**
* 
*
*
* Add custom links to plugin on plugins page
*/
function wp_custom_admin_interface_plugin_links( $links, $file ) {
   if ( strpos( $file, 'wp-custom-admin-interface.php' ) !== false ) {
      $new_links = array(
               '<a href="https://northernbeacheswebsites.com.au/product/donate-to-northern-beaches-websites/" target="_blank">' . __('Donate') . '</a>',
            //    '<a href="https://wordpress.org/support/plugin/wp-custom-admin-interface" target="_blank">' . __('Support Forum','wp-custom-admin-interface') . '</a>',
            );
      $links = array_merge( $links, $new_links );
   }
   return $links;
}
add_filter( 'plugin_row_meta', 'wp_custom_admin_interface_plugin_links', 10, 2 );
/**
* 
*
*
* Add settings link to plugin on plugins page
*/
function wp_custom_admin_interface_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=wpcai_general_settings">' . __( 'Settings','wp-custom-admin-interface' ) . '</a>';
    
    array_unshift( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'wp_custom_admin_interface_settings_link' );
/**
* 
*
*
* Function to check whether the current user should be subjected to the custom admin menu
*/
function wp_custom_admin_interface_admin_menu_exception_check($transientDefiner,$exceptionType,$exceptionCases)
{
    
    //current user
    $currentUser = wp_get_current_user();
    //current user ID
    $currentUserId = $currentUser->ID;   
    //create transient name    
    $transientName = 'wpcai_'.$transientDefiner.'_'.$currentUserId;
    //get transient
    $getTransient = get_transient($transientName);   

    //if transient exists return this value otherwise do the check and create the transient
    if($getTransient != false){

        return $getTransient;

    } else {

        //get current user role    
        $currentUserRole = strtoupper($currentUser->roles[0]); 
        
        $removeLastCharacterFromexceptionCases = substr($exceptionCases,0,-1);
        //create an array from exception cases
        $exceptionCasesArray = explode(",",$removeLastCharacterFromexceptionCases); 

        //start running through the exception rules    
        if($exceptionType == "Everyone"){
            //here we are taking them away
            $score = 1;  
            foreach($exceptionCasesArray as $value){

                //now we need to check whether the value is an integer
                if(is_numeric($value)) {
                    //so the value is an integer which means we need to check against the user id    
                    if($value == $currentUserId){
                        $score--;      
                    }
                } else {
                    //so the value isn't an integer which means we need to check against the user role
                    $valueUpper = strtoupper($value);

                    if($valueUpper == $currentUserRole){
                        $score--;      
                    } 
                }
            }  


        } else {
            //here we are adding values
            $score = 0;
            foreach($exceptionCasesArray as $value){

                //now we need to check whether the value is an integer
                if(is_numeric($value)) {
                    //so the value is an integer which means we need to check against the user id    
                    if($value == $currentUserId){
                        $score++;      
                    }
                } else {
                    //so the value isn't an integer which means we need to check against the user role
                    $valueUpper = strtoupper($value);

                    if($valueUpper == $currentUserRole){
                        $score++;      
                    } 
                }
            }

        } 

        if($score < 1){
            //the menu wouldn't show for you
            //set transient and return value
            set_transient($transientName,false,0);
            return false;    
        } else {
            //the menu would show for you
            //set transient and return value
            set_transient($transientName,true,0);
            return true;     
        }    
    }

              
}
/**
* 
*
*
* Load admin styles and scripts
*/
function wp_custom_admin_interface_register_admin($hook)
{
    //get our submenu array global variable
    global $wp_custom_admin_interface_settings_pages;
    //get the current page
    global $pagenow;
    
    //this applies to all admin pages as we want to make the admin notice dismissable
    wp_enqueue_script( 'dismissable-message-script', plugins_url( '/inc/dismissablemessage.min.js', __FILE__ ), array('jquery'));
    
    
    
    //apply style/script to all settings pages
    if(in_array($hook, $wp_custom_admin_interface_settings_pages)) {
        
        //this needs to be split up    
        wp_enqueue_script( 'custom-admin-script', plugins_url( '/inc/adminscript.min.js', __FILE__ ), array( 'jquery','wp-color-picker' ),wp_custom_admin_interface_get_version());

        //this needs to be on every page  
        wp_enqueue_style( 'wp-color-picker' );    
        wp_enqueue_script('jquery-form'); 
        wp_enqueue_script('clipboard', plugins_url('/inc/external/clipboard.min.js', __FILE__ ), array( 'jquery'),'2.0.4');   
        wp_enqueue_style( 'custom-admin-style', plugins_url( '/inc/adminstyle.min.css', __FILE__ ),array(),wp_custom_admin_interface_get_version());  
        wp_register_style( 'font-awesome-icons', plugins_url( '/inc/external/font-awesome.min.css', __FILE__ ));
        wp_enqueue_style(array('font-awesome-icons'));
        wp_enqueue_media();  

    }
    
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_custom_code'){
        //initialise codemirror on the page
        wp_enqueue_script( 'code-mirror-initialisation', plugins_url( '/inc/options/options-page-custom-code.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version());
        
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_custom_code_frontend'){
        //initialise codemirror on the page
        wp_enqueue_script( 'code-mirror-initialisation', plugins_url( '/inc/options/options-page-custom-code-frontend.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version());
                
    }
    
    
    if('admin.php' == $pagenow && isset($_GET['page']) && ($_GET['page'] == 'wpcai_custom_code'||$_GET['page'] == 'wpcai_custom_code_frontend')){
    
        //primary style of codemirror
        wp_register_style( 'code-mirror', plugins_url('/inc/external/codemirror.min.css', __FILE__ ));
        //custom black theme for editor
        wp_register_style( 'code-mirror-blackboard', plugins_url('/inc/external/blackboard.min.css', __FILE__ ));
        //primary codemirror script
        wp_enqueue_script( 'code-mirror-script', plugins_url('/inc/external/codemirror.min.js', __FILE__ ), array( 'jquery'));
        //language types
        wp_enqueue_script( 'code-mirror-php', plugins_url('/inc/external/php.min.js', __FILE__ ), array( 'jquery'));
        wp_enqueue_script( 'code-mirror-js', plugins_url('/inc/external/javascript.min.js', __FILE__ ), array( 'jquery'));
        wp_enqueue_script( 'code-mirror-css', plugins_url('/inc/external/css.min.js', __FILE__ ), array( 'jquery'));
        wp_enqueue_script( 'code-mirror-xml', plugins_url('/inc/external/xml.min.js', __FILE__ ), array( 'jquery')); 
        wp_enqueue_script( 'code-mirror-htmlmixed', plugins_url('/inc/external/htmlmixed.min.js', __FILE__ ), array( 'jquery')); 
        wp_enqueue_script( 'code-mirror-clike', plugins_url('/inc/external/clike.min.js', __FILE__ ), array( 'jquery')); 
        //addons
        wp_enqueue_script( 'code-mirror-close-tags', plugins_url('/inc/external/closetag.min.js', __FILE__ ), array( 'jquery'));
        wp_enqueue_script( 'code-mirror-close-brackets', plugins_url('/inc/external/closebrackets.min.js', __FILE__ ), array( 'jquery'));
        wp_enqueue_script( 'code-mirror-match-brackets', plugins_url('/inc/external/matchbrackets.min.js', __FILE__ ), array( 'jquery'));
        wp_enqueue_script( 'code-mirror-jump-to-line', plugins_url('/inc/external/jump-to-line.min.js', __FILE__ ), array( 'jquery'));
        wp_enqueue_script( 'code-mirror-search', plugins_url('/inc/external/search.min.js', __FILE__ ), array( 'jquery'));
        wp_enqueue_script( 'code-mirror-searchcursor', plugins_url('/inc/external/searchcursor.min.js', __FILE__ ), array( 'jquery'));
        //enqueue styles
        wp_enqueue_style(array('code-mirror','code-mirror-blackboard'));     
    }
    
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_manage_settings'){
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script( 'manage-settings', plugins_url( '/inc/options/options-page-manage-settings.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version());    
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_help'){
        wp_enqueue_script('jquery-ui-accordion');   
        wp_enqueue_script( 'help', plugins_url( '/inc/options/options-page-help.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version());   
    }

    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_admin_menu'){
        //this just needs to be on the menu page    
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('menu-page', plugins_url( '/inc/options/options-page-admin-menu.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version()); 
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && ($_GET['page'] == 'wpcai_maintenance_page'|| $_GET['page'] == 'wpcai_admin_notice') ){
        //this just needs to be on the maintenance and admin notice page    
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script( 'maintenance-page', plugins_url( '/inc/options/options-page-maintenance-page.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version());  
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && ($_GET['page'] == 'wpcai_admin_menu' || $_GET['page'] == 'wpcai_admin_toolbar')){
        //this just needs to be on the menu and toolbar page      
        wp_enqueue_script('nested-sortable', plugins_url('/inc/external/jquery.mjs.nestedSortable.min.js', __FILE__ ), array( 'jquery','jquery-ui-sortable'));
        wp_enqueue_script('jquery-ui-sortable');
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_hide_plugins'){
        wp_enqueue_script('hide-plugins', plugins_url( '/inc/options/options-page-hide-plugins.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version()); 
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_hide_sidebars'){
        wp_enqueue_script('hide-sidebars', plugins_url( '/inc/options/options-page-hide-sidebars.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version()); 
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_hide_users'){
        wp_enqueue_script('hide-users', plugins_url( '/inc/options/options-page-hide-users.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version()); 
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_admin_toolbar'){
        wp_enqueue_script('admin-toolbar', plugins_url( '/inc/options/options-page-admin-toolbar.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version()); 
    }
    
    if('admin.php' == $pagenow && isset($_GET['page']) && $_GET['page'] == 'wpcai_hide_meta'){
        wp_enqueue_script('hide-meta', plugins_url( '/inc/options/options-page-hide-meta.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version()); 
    }
    
    if(in_array($hook, $wp_custom_admin_interface_settings_pages) && ($_GET['page'] !== 'wpcai_admin_toolbar' || $_GET['page'] !== 'wpcai_admin_toolbar')) {
        wp_enqueue_script('generic-save-routine', plugins_url( '/inc/options/options-pre-save-routine-generic.min.js', __FILE__ ), array('jquery'),wp_custom_admin_interface_get_version());     
    }
    
    

    
}
add_action( 'admin_enqueue_scripts', 'wp_custom_admin_interface_register_admin' );
/**
* 
*
*
* Function to replace string with shortcodes to variables
*/
function wp_custom_admin_interface_shortcode_replacer ($originalText) {
    
    $current_user = wp_get_current_user();
    
    $outPut = $originalText;
    
    //create an associative array to be used for shortcode replacement    
    $variables = array(
                    "website_title"=>get_bloginfo('name'),
                    "website_tagline"=>get_bloginfo('description'),
                    "website_url"=>get_bloginfo('url'),
                    "admin_email_address"=>get_bloginfo('admin_email'),
                    "user_first_name"=>$current_user->user_firstname,
                    "user_last_name"=>$current_user->user_lastname,
                    "user_nickname"=>$current_user->nickname,
                    "user_email"=>$current_user->user_email,
                    "current_year"=>date("Y"),
                ); 
    

    foreach($variables as $key => $value) { 
        $outPut = str_replace('['.strtoupper($key).']', $value, $outPut);    
    }
    
    echo $outPut;
}
/**
* 
*
*
* Function to replace footer text
*/
function wp_custom_admin_interface_remove_footer_admin () {
    //get options
    $options = get_option('wp_custom_admin_interface_settings_GeneralSettings');
    
    if(isset($options['wp_custom_admin_interface_custom_footer']) && strlen($options['wp_custom_admin_interface_custom_footer'])>0){
        echo wp_custom_admin_interface_shortcode_replacer($options['wp_custom_admin_interface_custom_footer']); 
    }
}
add_filter('admin_footer_text', 'wp_custom_admin_interface_remove_footer_admin');
/**
* 
*
*
* Function to remove admin bar from front end
*/
function wp_custom_admin_interface_remove_admin_bar () {
$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
    
    if(isset($options['wp_custom_admin_interface_remove_toolbar_frontend'])) {
        add_filter('show_admin_bar', '__return_false');    
    }
    
}
wp_custom_admin_interface_remove_admin_bar();

/**
* 
*
*
* Function to remove gutenbery
*/
function wp_custom_admin_interface_remove_gutenberg() {

    $options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
        
    if(isset($options['wp_custom_admin_interface_disable_gutenberg'])) {
        // disable for posts
        add_filter('use_block_editor_for_post', '__return_false', 10);
        // disable for post types
        add_filter('use_block_editor_for_post_type', '__return_false', 10);      
    }
      
}
add_action( 'admin_init', 'wp_custom_admin_interface_remove_gutenberg' );


/**
* 
*
*
* Function to change login styling
*/
function wp_custom_admin_interface_login_background_color() {
    
    $options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
    
    wp_enqueue_style( 'custom-login', plugins_url( '/inc/adminstyle.min.css', __FILE__ ) ,array(),wp_custom_admin_interface_get_version());
    wp_enqueue_script( 'custom-login-script', plugins_url( '/inc/adminloginscript.min.js', __FILE__ ), array( 'jquery') ,wp_custom_admin_interface_get_version());
    
    
    if(isset($options['wp_custom_admin_interface_background_color']) ){
        
        $colour_options = "
    .login {
	background-color: {$options['wp_custom_admin_interface_background_color']};
    }";
    

    if(strlen($options['wp_custom_admin_interface_custom_logo']) > 0 && isset($options['wp_custom_admin_interface_custom_logo'])){
        $colour_options .= "#login h1 a, .login h1 a {
            background-image: url({$options['wp_custom_admin_interface_custom_logo']});
            width:320px !important;
            background-size: contain !important;
            background-repeat: no-repeat;

        }";
    }

    if(isset($options['wp_custom_admin_interface_text_color']) && strlen($options['wp_custom_admin_interface_text_color'])>0){
        $colour_options .= ".login #backtoblog a, .login #nav a {
            color: {$options['wp_custom_admin_interface_text_color']} !important;
        }";
    }

    
    wp_add_inline_style( 'custom-login', $colour_options );   
    }
      
}
add_action( 'login_enqueue_scripts', 'wp_custom_admin_interface_login_background_color' );
/**
* 
*
*
* Function to change login styling with custom CSS
*/
function wp_custom_admin_interface_custom_login_css() {

$options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );    
    
    // if(isset($options['wp_custom_admin_interface_deactivate_code'])){} else {

        if(isset($options['wp_custom_admin_interface_custom_login_css_code'])){ 
            
            //we are not going to run the exception check on this as technically the login page is for anyone not logged in so it doesn't make logical sense.
            // if(wp_custom_admin_interface_admin_menu_exception_check('code',$options['wp_custom_admin_interface_exception_type_code'],$options['wp_custom_admin_interface_exception_cases_code'])) {   

                ?>
                <style>
                <?php echo wp_strip_all_tags($options['wp_custom_admin_interface_custom_login_css_code']); ?>
                </style>    
                <?php  
            
            // }
        }
    // }      
}
add_filter( 'login_head', 'wp_custom_admin_interface_custom_login_css' );
/**
* 
*
*
* Function to add custom css to Wordpress admin
*/
function wp_custom_admin_interface_custom_admin_css() {
    
    $options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );
    $options2 = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
    
    // if(isset($options['wp_custom_admin_interface_deactivate_code'])){} else {
        
        if(isset($options['wp_custom_admin_interface_custom_css_code'])){
            
            //do check here if user is eligible to see changes
            if(wp_custom_admin_interface_admin_menu_exception_check('code',$options['wp_custom_admin_interface_exception_type_code'],$options['wp_custom_admin_interface_exception_cases_code'])) {

                ?>
                <style>
                <?php echo wp_strip_all_tags($options['wp_custom_admin_interface_custom_css_code']); ?>
                </style>    
                <?php    
            }   
        }
    // }
    
    
    if(isset($options2['wp_custom_admin_interface_button_link_color']) && $options2['wp_custom_admin_interface_button_link_color'] !== "#0085ba"){
        
        wp_enqueue_style( 'custom-admin-css', plugins_url( '/inc/adminstyle.min.css', __FILE__ ) ,array(),wp_custom_admin_interface_get_version());
        
        $buttonLinkColor = wp_strip_all_tags($options2['wp_custom_admin_interface_button_link_color']);
        
        $custom_code = "
        
        a {
        color: {$buttonLinkColor};
        }
        
        .wp-core-ui .button-primary {
            background: {$buttonLinkColor};
            background-image: -webkit-gradient(linear,left top,left bottom,from({$buttonLinkColor}),to({$buttonLinkColor}));
            background-image: -webkit-linear-gradient(top,{$buttonLinkColor},{$buttonLinkColor});
            background-image: -moz-linear-gradient(top,{$buttonLinkColor},{$buttonLinkColor});
            background-image: -ms-linear-gradient(top,{$buttonLinkColor},{$buttonLinkColor});
            background-image: -o-linear-gradient(top,{$buttonLinkColor},{$buttonLinkColor});
            background-image: linear-gradient(to bottom,{$buttonLinkColor},{$buttonLinkColor});
            border-color: {$buttonLinkColor};
            text-shadow: none !important;
            box-shadow: none !important;
        }
        ";
        wp_add_inline_style( 'custom-admin-css', $custom_code );
          
    }
    
    
    if(isset($options2['wp_custom_admin_interface_button_link_hover_color']) && $options2['wp_custom_admin_interface_button_link_hover_color'] !== "#008ec2"){
        
        wp_enqueue_style( 'custom-admin-css', plugins_url( '/inc/adminstyle.min.css', __FILE__ ) ,array(),wp_custom_admin_interface_get_version());
        
        $buttonLinkHoverColor = wp_strip_all_tags($options2['wp_custom_admin_interface_button_link_hover_color']);
        
        $custom_code = "
        a:hover, a:active {
        color: {$buttonLinkHoverColor};
        }
        
        .wp-core-ui .button-primary.active, .wp-core-ui .button-primary:hover, .wp-core-ui .button-primary:active {
            background: {$buttonLinkHoverColor};
            background-image: -webkit-gradient(linear,left top,left bottom,from({$buttonLinkHoverColor}),to({$buttonLinkHoverColor}));
            background-image: -webkit-linear-gradient(top,{$buttonLinkHoverColor},{$buttonLinkHoverColor});
            background-image: -moz-linear-gradient(top,{$buttonLinkHoverColor},{$buttonLinkHoverColor});
            background-image: -ms-linear-gradient(top,{$buttonLinkHoverColor},{$buttonLinkHoverColor});
            background-image: -o-linear-gradient(top,{$buttonLinkHoverColor},{$buttonLinkHoverColor});
            background-image: linear-gradient(to bottom,{$buttonLinkHoverColor},{$buttonLinkHoverColor});
            border-color: {$buttonLinkHoverColor};
            text-shadow: none !important;
            box-shadow: none !important;
        }
        ";
        wp_add_inline_style( 'custom-admin-css', $custom_code );
          
    }
    
}

add_action('admin_head', 'wp_custom_admin_interface_custom_admin_css');
/**
* 
*
*
* Function to add custom javascript to Wordpress admin
*/
function wp_custom_admin_interface_custom_admin_javascript() {
    
    $options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );
    
    
    // if(isset($options['wp_custom_admin_interface_deactivate_code'])){} else {
        
        if(isset($options['wp_custom_admin_interface_custom_javascript_code'])){    
            
            if(wp_custom_admin_interface_admin_menu_exception_check('code',$options['wp_custom_admin_interface_exception_type_code'],$options['wp_custom_admin_interface_exception_cases_code'])) {
            
                wp_enqueue_script( 'custom-admin-javascript', plugins_url( '/inc/customadminscript.min.js', __FILE__ ), array( 'jquery'),wp_custom_admin_interface_get_version() );

                
                $custom_code = "jQuery(document).ready(function ($) {
                {$options['wp_custom_admin_interface_custom_javascript_code']} 
                });";
                wp_add_inline_script( 'custom-admin-javascript', $custom_code );
        
            }
        }
    // }
}
add_action('admin_enqueue_scripts', 'wp_custom_admin_interface_custom_admin_javascript');
/**
* 
*
*
* This function removes the footer upgrade notice
*/
function wp_custom_admin_interface_remove_update_footer() {
    $options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
    if(isset($options['wp_custom_admin_interface_remove_footer'])) {
        remove_filter( 'update_footer', 'core_update_footer' );   
    } 
         
}
add_action( 'admin_menu', 'wp_custom_admin_interface_remove_update_footer' );
/**
* 
*
*
* Function to run upon ajax request to import settings
*/
function wp_custom_admin_interface_import_settings() {
    
    //check the nonce referrer exists
    check_ajax_referer( 'wp-custom-admin-interface-nonce', 'security' );

    // check if user can manage options    
    if ( ! current_user_can( 'manage_options') ){
        echo "You don't have permission to perform this action.";
        die(); 
    }
    
    //get user input
    $settings = stripslashes($_POST['settings']); 
    

    $extractedSettings = unserialize($settings);

    foreach ($extractedSettings as $key => $value) {

        if($value !==false && strpos($key,'wp_custom_admin_interface_settings_') !== false) {
                
            update_option($key,$value);     

        }

    }  

    echo "success";    
    die();    
}
add_action( 'wp_ajax_import_settings', 'wp_custom_admin_interface_import_settings' );
/**
* 
*
*
* Function to run upon ajax request to export settings
*/
function wp_custom_admin_interface_export_settings() {
    
    //check the nonce referrer exists
    check_ajax_referer( 'wp-custom-admin-interface-nonce', 'security' );

    // check if user can manage options    
    if ( ! current_user_can( 'manage_options') ){
        echo "You don't have permission to perform this action.";
        die(); 
    }
    
    //get user input
    $settings = $_POST['settings']; 
    
    $optionsOutput = array();
    
    foreach($settings as $option){
        
        $optionName = str_replace(' ', '', $option);
        $fullOptionName =  'wp_custom_admin_interface_settings_'.$optionName;
        
        $actualOption = get_option($fullOptionName);
        
        $optionsOutput[$fullOptionName] = $actualOption;
        
//        array_push($optionsOutput,$actualOption);
          
    }
    
    
    
    $selectedOptionsEncoded = serialize($optionsOutput);
    
    echo $selectedOptionsEncoded; 
    
    die();    
}
add_action( 'wp_ajax_export_settings', 'wp_custom_admin_interface_export_settings' );
/**
* 
*
*
* Function to enable maintenance mode
*/
function wp_custom_admin_interface_maintenance() {
    $options = get_option( 'wp_custom_admin_interface_settings_MaintenancePage' );
    $generalOptions = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
    global $pagenow;
    
    if(isset($options['wp_custom_admin_interface_maintenance_end'])) {
        if(strlen($options['wp_custom_admin_interface_maintenance_end'])>1){
        $maintenanceExpiryDate = $options['wp_custom_admin_interface_maintenance_end'];    
    } else {
        $maintenanceExpiryDate = "2050-01-01";    
    }} else {   
        $maintenanceExpiryDate = "2050-01-01";    
    }
    
    
    $todaysDate = date('Y-m-d');   
        
	if ($pagenow !== 'wp-login.php' && ! current_user_can( 'manage_options' ) && ! is_admin() && isset($options['wp_custom_admin_interface_enable_maintenance']) && $todaysDate < $maintenanceExpiryDate) {
        // header( $_SERVER['SERVER_PROTOCOL'] . '503 Service Temporarily Unavailable', true, 503 );
        header('HTTP/1.1 503 Service Temporarily Unavailable', true, 503 );
		header( 'Content-Type: text/html; charset=utf-8' );
        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="profile" href="http://gmpg.org/xfn/11">
            <style type="text/css">
            * {
              -webkit-box-sizing: border-box;
              -moz-box-sizing: border-box;
              box-sizing: border-box; }

            html, body {
              min-height: 100%; }

            body {
              background: <?php echo $generalOptions['wp_custom_admin_interface_background_color']; ?>;
              font-family: Helvetica, Arial, sans-serif;
              font-size: 18px;
              text-align: center; 
                
            }

            #container {
              margin: 40px auto;
              max-width: 600px;
              padding: 30px; 
              background: white;
              box-shadow: 0px 0px 5px 0px #e0dfdf;
              padding-bottom: 40px;
            }


            p {
              margin: 0 0 20px; }
                
            .logo {
             max-width:540px;             
            }
                
            @media screen and (max-width: 630px) {
            .logo {
             max-width:100%;             
            }   
            }
                
            </style>
            
            <title><?php echo esc_html( get_bloginfo( 'name' ) ); ?></title>
        </head>

        <body>
            <div id="container">
                <header>
                    <img class="logo" src="<?php echo $generalOptions['wp_custom_admin_interface_custom_logo']; ?>">
                </header>
                <main>
                    <?php echo $options['wp_custom_admin_interface_maintenance_text']; ?>
                </main>
            </div>
        </body>
        </html>

        <?php
		die();
	}
    
}
add_action( 'wp_loaded', 'wp_custom_admin_interface_maintenance' );
/**
* 
*
*
* Function output shortcodes
*/
function wp_custom_admin_interface_shortcode_output($class) {
    echo '</br>
    
    <a style="margin-bottom: 5px;" value="[CURRENT_YEAR]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[CURRENT_YEAR]</a>
    
    <a style="margin-bottom: 5px;" value="[WEBSITE_TITLE]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[WEBSITE_TITLE]</a>
    
    <a style="margin-bottom: 5px;" value="[WEBSITE_TAGLINE]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[WEBSITE_TAGLINE]</a>
    
    <a style="margin-bottom: 5px;" value="[WEBSITE_URL]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[WEBSITE_URL]</a>
    
    <a style="margin-bottom: 5px;" value="[ADMIN_EMAIL_ADDRESS]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[ADMIN_EMAIL_ADDRESS]</a>
    
    <a style="margin-bottom: 5px;" value="[USER_FIRST_NAME]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[USER_FIRST_NAME]</a>
    
    <a style="margin-bottom: 5px;" value="[USER_LAST_NAME]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[USER_LAST_NAME]</a>
    
    <a style="margin-bottom: 5px;" value="[USER_NICKNAME]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[USER_NICKNAME]</a>
    
    <a style="margin-bottom: 5px;" value="[USER_EMAIL]" class="quick-shortcode-button button-secondary wp_custom_admin_interface_append_buttons_'.$class.'">[USER_EMAIL]</a>
    
    ';
    
}
/**
* 
*
*
* Function to add new dashboard widget
*/
function wp_custom_admin_interface_dashboard_widget() {
    $options = get_option( 'wp_custom_admin_interface_settings_CustomDashboardWidget' );
    
    if(isset($options['wp_custom_admin_interface_enable_custom_widget'])) {
        
        if(strlen($options['wp_custom_admin_interface_custom_widget_title'])<1) {
            $widgetTitle = "Custom Widget";      
        } else {
            $widgetTitle = $options['wp_custom_admin_interface_custom_widget_title'];       
        }
        
        wp_add_dashboard_widget(
            'custom_widget',         // Widget slug.
            $widgetTitle,         // Title.
            'custom_widget_output' // Display function.
        );

        function custom_widget_output() {
            $options = get_option( 'wp_custom_admin_interface_settings_CustomDashboardWidget' );
            echo wp_custom_admin_interface_shortcode_replacer($options['wp_custom_admin_interface_custom_widget_content']); 
        }
    }
}
add_action( 'wp_dashboard_setup', 'wp_custom_admin_interface_dashboard_widget' );
/**
* 
*
*
* Function to run PHP code
*/
function wp_custom_admin_interface_run_php() {
$options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );

    // if(isset($options['wp_custom_admin_interface_deactivate_code'])){} else {
        if(isset($options['wp_custom_admin_interface_custom_php_code'])){


            if(wp_custom_admin_interface_admin_menu_exception_check('code',$options['wp_custom_admin_interface_exception_type_code'],$options['wp_custom_admin_interface_exception_cases_code'])) {

                $content = $options['wp_custom_admin_interface_custom_php_code']; 
                
                $stripPhpTags = preg_replace('/^<\?php(.*)(\?>)?$/s', '$1', $content);
                
                ob_start();
                @eval($stripPhpTags);   
                ob_end_clean();

            }
        }
    // }
}
add_action( 'admin_init', 'wp_custom_admin_interface_run_php' );
// wp_custom_admin_interface_run_php();
/**
* 
*
*
* Function to add new dashboard widget
*/
function wp_custom_admin_interface_custom_favicon() {
    
    $options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
    
    if(isset($options['wp_custom_admin_interface_custom_favicon']) && strlen($options['wp_custom_admin_interface_custom_favicon'])>0){
        echo '<link rel="shortcut icon" href="' . $options['wp_custom_admin_interface_custom_favicon'] . '" />';    
    } else {
        
        return;
    }  
    
}
add_action('login_head', 'wp_custom_admin_interface_custom_favicon');
add_action('admin_head', 'wp_custom_admin_interface_custom_favicon');

$faviconFrontEnd = get_option('wp_custom_admin_interface_settings_GeneralSettings');

if(isset($faviconFrontEnd['wp_custom_admin_interface_custom_favicon_frontend'])){
    add_action('wp_head','wp_custom_admin_interface_custom_favicon'); 
}
/**
* 
*
*
* Function to add custom colour scheme
*/
function wp_custom_admin_interface_custom_color_scheme() {

    $options = get_option('wp_custom_admin_interface_settings_AdminColorScheme');    

    if(isset($options['wp_custom_admin_interface_color_scheme_icon_color'])){
        $svgIconColor = $options['wp_custom_admin_interface_color_scheme_icon_color'];
    } else {
        $svgIconColor = "#f1f2f3"; 
    }    


    if(isset($options['wp_custom_admin_interface_color_scheme_color_one']) && isset($options['wp_custom_admin_interface_color_scheme_color_two']) && isset($options['wp_custom_admin_interface_color_scheme_color_three']) && isset($options['wp_custom_admin_interface_color_scheme_color_four'])){
        $colorScheme = array( $options['wp_custom_admin_interface_color_scheme_color_one'], $options['wp_custom_admin_interface_color_scheme_color_two'], $options['wp_custom_admin_interface_color_scheme_color_three'], $options['wp_custom_admin_interface_color_scheme_color_four'] );   
    } else {
        $colorScheme = array( '#222', '#333', '#0073aa', '#00a0d2' );
    }    
       
    wp_admin_css_color(
    'custom', 
    'Custom',
    plugins_url( '/inc/admintheme.css', __FILE__ ),
    $colorScheme,
    array( 'base' => $svgIconColor, 'focus' => $svgIconColor, 'current' => $svgIconColor )
    );
        
}
add_action('admin_init', 'wp_custom_admin_interface_custom_color_scheme');
/**
* 
*
*
* Function to implement custom color scheme to head
*/
function wp_custom_admin_interface_custom_color_scheme_implementation()
{
    
    wp_enqueue_style( 'custom-admin-theme', plugins_url( '/inc/admintheme.css', __FILE__ ) ,array(),wp_custom_admin_interface_get_version());
    
    $options = get_option('wp_custom_admin_interface_settings_AdminColorScheme');
    
    $currentColorScheme = get_user_option( 'admin_color' );
    
    if($currentColorScheme == "custom" && isset($options['wp_custom_admin_interface_color_scheme_color_one']) && isset($options['wp_custom_admin_interface_color_scheme_color_two']) && isset($options['wp_custom_admin_interface_color_scheme_color_three']) && isset($options['wp_custom_admin_interface_color_scheme_color_four']) && isset($options['wp_custom_admin_interface_color_scheme_icon_color'])){
    
    $customColorOne = $options['wp_custom_admin_interface_color_scheme_color_one']." !important"; 
    $customColorTwo = $options['wp_custom_admin_interface_color_scheme_color_two']." !important";   
    $customColorThree = $options['wp_custom_admin_interface_color_scheme_color_three']." !important";
    $customColorFour = $options['wp_custom_admin_interface_color_scheme_color_four']." !important";
    $customIconColor = $options['wp_custom_admin_interface_color_scheme_icon_color']." !important";   
    
            
        
    $cssWithVariables = "
    
    #adminmenu li a.wp-has-current-submenu .update-plugins,
    #adminmenu li.current a .awaiting-mod,
    #adminmenu li.menu-top:hover>a .update-plugins,
    #adminmenu li:hover a .awaiting-mod {
        background: {$customColorFour};
    }
    #adminmenu .wp-has-current-submenu .wp-submenu,
    #adminmenu .wp-has-current-submenu.opensub .wp-submenu,
    #adminmenu .wp-submenu,
    #adminmenu a.wp-has-current-submenu:focus+.wp-submenu,
    .folded #adminmenu .wp-has-current-submenu .wp-submenu {
        background: {$customColorOne};
    }

    #adminmenu li.wp-has-submenu.wp-not-current-submenu.opensub:hover:after {
        border-right-color: {$customColorOne};
    }

    #wpadminbar .ab-top-menu>li.menupop.hover>.ab-item,
    #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus,
    #wpadminbar.nojs .ab-top-menu>li.menupop:hover>.ab-item,
    #wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item,
    #wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus {
        background: {$customColorOne};
    }

    #wpadminbar .menupop .ab-sub-wrapper {
        background: {$customColorOne};
    }

    .wp-responsive-open #wpadminbar #wp-admin-bar-menu-toggle a {
        background: {$customColorOne};
    }

    .wp-core-ui .wp-ui-primary {
        background-color: {$customColorTwo};
    }

    .wp-core-ui .wp-ui-text-primary {
        color: {$customColorTwo};
    }

    .tablenav .tablenav-pages a:focus,
    .tablenav .tablenav-pages a:hover,
    .wrap .add-new-h2:hover,
    .wrap .page-title-action:hover {
        background-color: {$customColorTwo};
    }

    .view-switch a.current:before {
        color: {$customColorTwo};
    }

    #adminmenu,
    #adminmenuback,
    #adminmenuwrap {
        background: {$customColorTwo};
    }

    #wpadminbar {
        background: {$customColorTwo};
    }

    .theme-filter.current,
    .theme-section.current {
        border-bottom-color: {$customColorTwo};
    }

    body.more-filters-opened .more-filters {
        background-color: {$customColorTwo};
    }






    .wp-core-ui .wp-ui-highlight {
        background-color: {$customColorThree};
    }

    .wp-core-ui .wp-ui-text-highlight {
        color: {$customColorThree};
    }

    #adminmenu a:hover,
    #adminmenu li.menu-top:hover,
    #adminmenu li.opensub>a.menu-top,
    #adminmenu li>a.menu-top:focus {
        background-color: {$customColorThree};
    }

    #adminmenu .wp-has-current-submenu .wp-submenu a:focus,
    #adminmenu .wp-has-current-submenu .wp-submenu a:hover,
    #adminmenu .wp-has-current-submenu.opensub .wp-submenu a:focus,
    #adminmenu .wp-has-current-submenu.opensub .wp-submenu a:hover,
    #adminmenu .wp-submenu a:focus,
    #adminmenu .wp-submenu a:hover,
    #adminmenu a.wp-has-current-submenu:focus+.wp-submenu a:focus,
    #adminmenu a.wp-has-current-submenu:focus+.wp-submenu a:hover,
    .folded #adminmenu .wp-has-current-submenu .wp-submenu a:focus,
    .folded #adminmenu .wp-has-current-submenu .wp-submenu a:hover {
        color: white;
    }


    #adminmenu .wp-has-current-submenu.opensub .wp-submenu li.current a:focus,
    #adminmenu .wp-has-current-submenu.opensub .wp-submenu li.current a:hover,
    #adminmenu .wp-submenu li.current a:focus,
    #adminmenu .wp-submenu li.current a:hover,
    #adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a:focus,
    #adminmenu a.wp-has-current-submenu:focus+.wp-submenu li.current a:hover {
        color: white;
    }

    #adminmenu li.current a.menu-top,
    #adminmenu li.wp-has-current-submenu .wp-submenu .wp-submenu-head,
    #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,
    .folded #adminmenu li.current.menu-top {
        background: {$customColorThree};
    }

    #collapse-button:focus,
    #collapse-button:hover {
        color: {$customColorThree};
    }



    #wpadminbar .ab-top-menu>li.menupop.hover>.ab-item,
    #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus,
    #wpadminbar.nojs .ab-top-menu>li.menupop:hover>.ab-item,
    #wpadminbar:not(.mobile) .ab-top-menu>li:hover>.ab-item,
    #wpadminbar:not(.mobile) .ab-top-menu>li>.ab-item:focus {
        color: {$customColorThree};
    }

    #wpadminbar:not(.mobile)>#wp-toolbar a:focus span.ab-label,
    #wpadminbar:not(.mobile)>#wp-toolbar li.hover span.ab-label,
    #wpadminbar:not(.mobile)>#wp-toolbar li:hover span.ab-label {
        color: {$customColorThree};
    }

    #wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a,
    #wpadminbar .quicklinks .menupop ul li a:focus,
    #wpadminbar .quicklinks .menupop ul li a:focus strong,
    #wpadminbar .quicklinks .menupop ul li a:hover,
    #wpadminbar .quicklinks .menupop ul li a:hover strong,
    #wpadminbar .quicklinks .menupop.hover ul li a:focus,
    #wpadminbar .quicklinks .menupop.hover ul li a:hover,
    #wpadminbar li #adminbarsearch.adminbar-focused:before,
    #wpadminbar li .ab-item:focus .ab-icon:before,
    #wpadminbar li .ab-item:focus:before,
    #wpadminbar li a:focus .ab-icon:before,
    #wpadminbar li.hover .ab-icon:before,
    #wpadminbar li.hover .ab-item:before,
    #wpadminbar li:hover #adminbarsearch:before,
    #wpadminbar li:hover .ab-icon:before,
    #wpadminbar li:hover .ab-item:before,
    #wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus,
    #wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover {
        color: {$customColorThree};
    }

    #wpadminbar .menupop .menupop>.ab-item:hover:before,
    #wpadminbar .quicklinks .ab-sub-wrapper .menupop.hover>a .blavatar,
    #wpadminbar .quicklinks li a:focus .blavatar,
    #wpadminbar .quicklinks li a:hover .blavatar,
    #wpadminbar.mobile .quicklinks .ab-icon:before,
    #wpadminbar.mobile .quicklinks .ab-item:before {
        color: {$customColorThree};
    }    

    #wpadminbar #wp-admin-bar-user-info a:hover .display-name {
        color: {$customColorThree};
    }

    .wp-pointer .wp-pointer-content h3 {
        background-color: {$customColorThree};
    }

    .wp-pointer .wp-pointer-content h3:before {
        color: {$customColorThree};
    }



    .wp-pointer.wp-pointer-top .wp-pointer-arrow,
    .wp-pointer.wp-pointer-top .wp-pointer-arrow-inner,
    .wp-pointer.wp-pointer-undefined .wp-pointer-arrow,
    .wp-pointer.wp-pointer-undefined .wp-pointer-arrow-inner {
        border-bottom-color: {$customColorThree};
    }

    .media-item .bar,
    .media-progress-bar div {
        background-color: {$customColorThree};
    }

    .details.attachment {
        -webkit-box-shadow: inset 0 0 0 3px #fff, inset 0 0 0 7px {$customColorThree};
        box-shadow: inset 0 0 0 3px #fff, inset 0 0 0 7px {$customColorThree};
    }

    .attachment.details .check {
        background-color: {$customColorThree};
        -webkit-box-shadow: 0 0 0 1px #fff, 0 0 0 2px {$customColorThree};
        box-shadow: 0 0 0 1px #fff, 0 0 0 2px {$customColorThree};
    }

    .media-selection .attachment.selection.details .thumbnail {
        -webkit-box-shadow: 0 0 0 1px #fff, 0 0 0 3px {$customColorThree};
        box-shadow: 0 0 0 1px #fff, 0 0 0 3px {$customColorThree};
    }

    .theme-browser .theme.active .theme-name,
    .theme-browser .theme.add-new-theme a:focus:after,
    .theme-browser .theme.add-new-theme a:hover:after {
        background: {$customColorThree};
    }

    .theme-browser .theme.add-new-theme a:focus span:after,
    .theme-browser .theme.add-new-theme a:hover span:after {
        color: {$customColorThree};
    }

    body.more-filters-opened .more-filters:focus,
    body.more-filters-opened .more-filters:hover {
        background-color: {$customColorThree};
    }

    .widgets-chooser li.widgets-chooser-selected {
        background-color: {$customColorThree};
    }

    .wp-responsive-open div#wp-responsive-toggle a {
        background: {$customColorThree};
    }

    .mce-container.mce-menu .mce-menu-item-normal.mce-active,
    .mce-container.mce-menu .mce-menu-item-preview.mce-active,
    .mce-container.mce-menu .mce-menu-item.mce-selected,
    .mce-container.mce-menu .mce-menu-item:focus,
    .mce-container.mce-menu .mce-menu-item:hover {
        background: {$customColorThree};
    }

    .wp-core-ui .wp-ui-notification {
        background-color: {$customColorFour};
    }

    .wp-core-ui .wp-ui-text-notification {
        color: {$customColorFour};
    }    

    .view-switch a:hover:before {
        color: {$customColorFour};
    }

    #adminmenu .awaiting-mod,
    #adminmenu .update-plugins {
        background: {$customColorFour};
    }

    #adminmenu a:hover, #adminmenu li.menu-top:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus {
    color: #fff;
    }

    .wp-menu-image, .wp-menu-image:before {
        color: {$customIconColor};     
    }
    
    .wp-admin #wpadminbar #wp-admin-bar-site-name>.ab-item:before {
    color: {$customIconColor};
    }

    ";
    
    wp_add_inline_style( 'custom-admin-theme', $cssWithVariables );     
        
    }
    
    
}
add_action( 'admin_enqueue_scripts', 'wp_custom_admin_interface_custom_color_scheme_implementation' );
/**
* 
*
*
* Function to force color scheme if desired
*/
function wp_custom_admin_interface_force_color_scheme($color_scheme)
{
    $options = get_option('wp_custom_admin_interface_settings_AdminColorScheme');
    
    if(isset($options['wp_custom_admin_interface_force_color_scheme'])){
        $color_scheme = 'custom';    
        return $color_scheme;
    } else {
        return $color_scheme;      
    }
      
}
add_filter( 'get_user_option_admin_color', 'wp_custom_admin_interface_force_color_scheme', 5 );
/**
* 
*
*
* Function to disable automatic updates
*/
function wp_custom_admin_interface_disable_automatic_updates()
{
    $options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
    
    if(isset($options['wp_custom_admin_interface_disable_update'])){
        add_filter( 'automatic_updater_disabled', '__return_true' );      
    }
    
}
wp_custom_admin_interface_disable_automatic_updates();

/**
* 
*
*
* Function to make changes to the admin menu
*/
function wp_custom_admin_interface_implement_custom_admin_menu()
{
    $options = get_option( 'wp_custom_admin_interface_settings_AdminMenu' );
    
    
    global $submenu, $menu;
    global $wp_custom_admin_interface_original_top_level_menu, $wp_custom_admin_interface_original_sub_level_menu;

    $wp_custom_admin_interface_original_top_level_menu = $menu;
    $wp_custom_admin_interface_original_sub_level_menu = $submenu;

    //sort values and remove the links
    ksort($wp_custom_admin_interface_original_top_level_menu, SORT_NUMERIC);
    foreach ($wp_custom_admin_interface_original_top_level_menu as $key => $value){
        unset($wp_custom_admin_interface_original_top_level_menu[15]);

    }

    //rename all the keys because javascript doesn't like strings as key
    $wp_custom_admin_interface_original_top_level_menu = array_values($wp_custom_admin_interface_original_top_level_menu);

    
    if(isset($options['wp_custom_admin_interface_remove_menu_item'])) {

            
        //lets check if the changes are going to apply to this user
        
        if(wp_custom_admin_interface_admin_menu_exception_check('menu',$options['wp_custom_admin_interface_exception_type'],$options['wp_custom_admin_interface_exception_cases'])) {
            
            //lets replace the standard menu with our custom menu
            
            $topLevelMenu = $options['wp_custom_admin_interface_top_level_menu'];

            $subLevelMenu = $options['wp_custom_admin_interface_sub_level_menu'];

            // $topLevelMenuDecoded = json_decode($topLevelMenu,true);

            // $subLevelMenuDecoded = json_decode($subLevelMenu, true); 

            if(strpos($topLevelMenu, '[') !== false){
                $topLevelMenuDecoded = json_decode($topLevelMenu,true);  
            } else {
                $topLevelMenuDecoded = json_decode(base64_decode($topLevelMenu),true);
            }

            if(strpos($subLevelMenu, '[') !== false){
                $subLevelMenuDecoded = json_decode($subLevelMenu,true);  
            } else {
                $subLevelMenuDecoded = json_decode(base64_decode($subLevelMenu),true);
            }
            
            
            

            
            
            //check if notifications are necessary on the custom menu
            if(isset($options['wp_custom_admin_interface_show_notifications'])){
            
                //create an array which will store all our notifications
                $itemsWithNotifications = array();

                //cycle through the top level menu
                foreach($menu as $item => $value) {
                    //check if the label has a notification and if it does carry on
                    if(strpos($value[0], '<span') !== false) {
                        $positionOfSpan = strpos($value[0],'<span');
                        $lengthOfNotification = strlen($value[0])-$positionOfSpan;
                        $justTheNotification = substr($value[0],$positionOfSpan,$lengthOfNotification);
                        //add the position and notification to the array
                        $itemsWithNotifications += array($value[2] => $justTheNotification);     
                    }
                }

                //cycle through the sub level menu
                foreach($submenu as $item => $value){
                    //let's go a little deeper
                    foreach($value as $item => $value){
                        //check if the label has a notification and if it does carry on
                        if(strpos($value[0], '<span') !== false) {
                            $positionOfSpan = strpos($value[0],'<span');
                            $lengthOfNotification = strlen($value[0])-$positionOfSpan;
                            $justTheNotification = substr($value[0],$positionOfSpan,$lengthOfNotification);
                            //add the position and notification to the array
                            $itemsWithNotifications += array($value[2] => $justTheNotification);     
                        }
                    }
                }    
                
                
                
                //now lets loop through our new menu and add these notifications to it
                //let's start with the top level menu
                foreach($topLevelMenuDecoded as $item => $value) {
                    
                    $menuLink = $value[2];
                    
                    if(array_key_exists($menuLink,$itemsWithNotifications)){
                        
                        $notificationToUtilise = $itemsWithNotifications[$menuLink];
                        
                        $topLevelMenuDecoded[$item][0] = $value[0].' '.$notificationToUtilise;
                        
                    } 
                }
                

                //and now the sub menu
                foreach($subLevelMenuDecoded as $item => $value) {
                    //let's go a little deeper
                    foreach($value as $itemDeeper => $valueDeeper){   
                    
                        $menuLink = $valueDeeper[2];

                        if(array_key_exists($menuLink,$itemsWithNotifications)){

                            $notificationToUtilise = $itemsWithNotifications[$menuLink];

                            $subLevelMenuDecoded[$item][$itemDeeper][0] = $valueDeeper[0].' '.$notificationToUtilise;
                            
                        } 
                    }
                }
            }
 
            
            
            $menu = $topLevelMenuDecoded;
            $submenu = $subLevelMenuDecoded;    
            
            
            //now lets remove menu pages

            $removeLastCharacterFromString = substr($options['wp_custom_admin_interface_remove_menu_item'],0,-1);

            $turnCommaStringIntoArray = explode(",", $removeLastCharacterFromString);

            //cycle through each item in array
            foreach ($turnCommaStringIntoArray as $value) {

                //now we need to check whether the value has square brackets - this will determine whether the item is a top level or sub level item
                if(strpos($value, '[') !== false) {

                //lets get the top level component part    
                $positionOfFirstSquareBracket = strpos($value,'[');
                $topLevelMenuComponent = substr($value,0,$positionOfFirstSquareBracket);  

                //lets ge the sub level component part
                preg_match("/\[(.*)\]/", $value , $matches); 
                $subLevelMenuComponent = $matches[1];   

                remove_submenu_page($topLevelMenuComponent,$subLevelMenuComponent);    


                } else {
                    //its a top level menu item so lets remove it
                    remove_menu_page($value);   
                }  
            }
        }
    } 
}
//note this priority number needs to be set low otherwise custom plugins will run after so their menu items could render 2 times
add_action( 'admin_menu', 'wp_custom_admin_interface_implement_custom_admin_menu',999);
/**
* 
*
*
* Function to delete the menu upon request
*/
function wp_custom_admin_interface_delete_menu($wp) {
    // only process requests with "wp-custom-admin-interface=delete-menu"
    if (array_key_exists('wp-custom-admin-interface', $wp->query_vars) 
            && $wp->query_vars['wp-custom-admin-interface'] == 'delete-menu') {
        
        
        // check if user can manage options    
        if ( ! current_user_can( 'manage_options') ){
            echo "You don't have permission to perform this action.";
            die(); 
        } 
        
        delete_option('wp_custom_admin_interface_settings_AdminMenu');
        delete_option('wp_custom_admin_interface_settings_AdminToolbar');
        
        wp_die('The custom admin menu has now been deleted.');
    }
}
add_action('parse_request', 'wp_custom_admin_interface_delete_menu');
/**
* 
*
*
* Function to create the query for the above function
*/
function wp_custom_admin_interface_query_vars($vars) {
    $vars[] = 'wp-custom-admin-interface';
    return $vars;
}
add_filter('query_vars', 'wp_custom_admin_interface_query_vars');
/**
* 
*
*
* Function to clear transients, this is fired when someone saves the settings.
*/
function wp_custom_admin_interface_delete_transients() {
	global $wpdb; 
    $sql = "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_wpcai_%'";
    $wpdb->query($sql);
    echo "success";    
    die();    
}
add_action( 'wp_ajax_delete_transients', 'wp_custom_admin_interface_delete_transients');
/**
* 
*
*
* Add translation
*/
add_action('plugins_loaded', 'wp_custom_admin_interface_translations');
function wp_custom_admin_interface_translations() {
	load_plugin_textdomain( 'wp-custom-admin-interface', false, dirname( plugin_basename(__FILE__) ) . '/inc/lang/' );
}
/**
* 
*
*
* Remove plugins from plugin page
*/
function wp_custom_admin_hide_plugins() {
    global $wp_list_table;
    
    $options = get_option('wp_custom_admin_interface_settings_HidePlugins');    

    
    $removedPlugins = $options['wp_custom_admin_interface_hide_these_plugins'];
    
    //check if the setting is set
    if(isset($removedPlugins)){

        //lets check if the changes are going to apply to this user
        if(wp_custom_admin_interface_admin_menu_exception_check('plugin',$options['wp_custom_admin_interface_exception_type_plugin'],$options['wp_custom_admin_interface_exception_cases_plugin'])) {

            $removeFirstCharacterFromRemovedPlugins = substr($removedPlugins,1);
            //create an array from exception cases
            $removedPluginsArray = explode(",",$removeFirstCharacterFromRemovedPlugins); 

            $myplugins = $wp_list_table->items;

            foreach ($myplugins as $key => $val) {
                if (in_array($key,$removedPluginsArray)) {
                unset($wp_list_table->items[$key]);
                }
            }    
        }
    }
    

}
add_action('pre_current_active_plugins', 'wp_custom_admin_hide_plugins');
/**
* 
*
*
* Function to assist in the rendering of exception types
*/
function wp_custom_admin_interface_exception_type_render_assist($existingExceptionTypeOption,$optionName) { 
    
	$options = get_option($optionName);          
    
    $html = '<tr class="userAndRoleSelection" valign="top"><td scope="row" colspan="2"><h3 style="margin-top: -5px; margin-bottom:0px;">';
    $html .= __('Implement this for', 'wp-custom-admin-interface' );
    
    if(isset($options[$existingExceptionTypeOption])) {
        $wp_custom_admin_interface_exception_type = $options[$existingExceptionTypeOption];
    } else {
        $wp_custom_admin_interface_exception_type = "No-one";
    } 
    
    $html .= ' <select name="'.$optionName.'[';
    $html .= $existingExceptionTypeOption;
    $html .= ']" id="';
    $html .= $existingExceptionTypeOption;
    $html .= '">'; 
    $html .= '<option value="No-one" ';
    
 
    if( 'No-one'== $wp_custom_admin_interface_exception_type) {
    $html .= 'selected="selected"'; 
    }
    $html .= '>';
    $html .= __('No-one', 'wp-custom-admin-interface' ); 
    $html .= '</option>';
    $html .= '<option value="Everyone" ';

    if( 'Everyone'==$wp_custom_admin_interface_exception_type) {
        $html.= 'selected="selected"'; 
    }
    $html .= '>';
    $html .= __('Everyone', 'wp-custom-admin-interface' );
    $html .= '</option></select> ';
    $html .= __('except', 'wp-custom-admin-interface' );
    $html .= '</h3></td></tr>';
    

               
    return $html;
}
/**
* 
*
*
* Function to assist in the rendering of exception cases
*/
function wp_custom_admin_interface_exception_cases_render_assist($existingExceptionCases,$optionName) { 
    
    
    $options = get_option($optionName);
    
    $html = '<tr valign="top"><td scope="row" colspan="2">';
    
    
    $outputOfUsersAndRolesSelection = '';
    
    //lets get the users
    global $wpdb;

    $sql = "
    SELECT {$wpdb->users}.ID
    FROM {$wpdb->users} 
    ";

    $wp_custom_admin_interface_original_user_listing = $wpdb->get_results($sql);
    
    foreach($wp_custom_admin_interface_original_user_listing as $value){
                
        $userId = $value->ID;
        $userInfo = get_userdata($userId);

        $userFirstName = $userInfo->first_name;
        $userLastName = $userInfo->last_name;
        //we need to first unserialize the array, then get just the keys of the array and then implode it into a comma string
        $userRole = implode(', ',$userInfo->roles);

        if(strlen($userFirstName)<1 && strlen($userFirstName)<1) {
            $userDisplayName = $userInfo->user_login;
        } else {
            $userDisplayName = $userFirstName.' '.$userLastName;
        }


        $outputOfUsersAndRolesSelection .= 'User: '.$userDisplayName.'('.$userId.'),';
         
    }
    

    //lets get the roles
    global $wp_roles;
    foreach ( $wp_roles->roles as $key=>$value ){
        $outputOfUsersAndRolesSelection .= 'Role: '.$value['name'].',';    
    }
            
    $html .= '<div id="combinedListOfUsersAndRoles" data="';        
    $html .= $outputOfUsersAndRolesSelection;
    $html .= '"></div><div id="outputOfUsersAndRolesSelection" data=""></div><input style="display:none;" class="wp_custom_admin_interface_settings_input saved_exception_cases" type="text" name="'.$optionName.'[';

    $html .= $existingExceptionCases;        
    
    $html .= ']" id="';
    
    $html .= $existingExceptionCases; 

    $html .= '" class="regular-text" value="';

    if(isset($options[$existingExceptionCases])) { 
        
        $html .= esc_attr($options[$existingExceptionCases]); 
    
    } 
    
      
     $html .= '"></td></tr>';       

    return $html;

}
/**
* 
*
*
* Remove users from user page
*/
function wp_custom_admin_interface_hide_users($user_search) {
    
    $options = get_option('wp_custom_admin_interface_settings_HideUsers');    

    
    //check if the setting is set
    if(isset($options['wp_custom_admin_interface_hide_these_users'])){
        
        $removedUsers = $options['wp_custom_admin_interface_hide_these_users'];

        //lets check if the changes are going to apply to this user
        if(wp_custom_admin_interface_admin_menu_exception_check('user',$options['wp_custom_admin_interface_exception_type_user'],$options['wp_custom_admin_interface_exception_cases_user'])) {

            //gel global variable    
            global $current_user;
            //get current user login    
            $userID = $current_user->ID;



            $removeFirstCharacterFromRemovedUsers = substr($removedUsers,1);
            //create an array from exception cases
            $removedUsersArray = explode(",",$removeFirstCharacterFromRemovedUsers);     

            //get the database    
            global $wpdb;

            foreach ($removedUsersArray as &$removedUser) {

                //if the current user is the user lets not remove them, so this way they can still see themselves
                if ($userID == $removedUser) { 

                } else {
                    //do query
                    $user_search->query_where = str_replace('WHERE 1=1',"WHERE 1=1 AND {$wpdb->users}.ID != '$removedUser'",$user_search->query_where);    
                }       

            }  
 
        }
    }
    

}
add_action('pre_user_query', 'wp_custom_admin_interface_hide_users');
/**
* 
*
*
* Remove sidebars from widget page
*/
function wp_custom_admin_interface_hide_sidebars() {
    
    $options = get_option( 'wp_custom_admin_interface_settings_HideSidebars' );    
    
    global $wp_registered_sidebars;
    global $wp_custom_admin_interface_original_sidebar_listing; 
    
    $wp_custom_admin_interface_original_sidebar_listing = $wp_registered_sidebars;
    

    //check if the setting is set
    if(isset($options['wp_custom_admin_interface_hide_these_sidebars'])){
        
        $removedSidebars = $options['wp_custom_admin_interface_hide_these_sidebars'];

        //lets check if the changes are going to apply to this user
        if(wp_custom_admin_interface_admin_menu_exception_check('sidebar',$options['wp_custom_admin_interface_exception_type_sidebar'],$options['wp_custom_admin_interface_exception_cases_sidebar'])) {
            
            //remove first character from string
            $removeFirstCharacterFromRemovedSidebars = substr($removedSidebars,1);
            //create an array from exception cases
            $removedSidebarsArray = explode(",",$removeFirstCharacterFromRemovedSidebars);     

            foreach ($removedSidebarsArray as &$removedSidebar) {
            
                unregister_sidebar($removedSidebar);
            
            }
        }
    }

}
add_action('admin_init', 'wp_custom_admin_interface_hide_sidebars');
/**
* 
*
*
* Implement custom toolbar
*/
function wp_custom_admin_interface_all_toolbar_nodes( $wp_admin_bar ) {
    
    $options = get_option('wp_custom_admin_interface_settings_AdminToolbar');
    

    //only do on backend
    if( (is_admin() && isset($options['wp_custom_admin_interface_disable_custom_toolbar_frontend'])) || !isset($options['wp_custom_admin_interface_disable_custom_toolbar_frontend']) ){
        //get all nodes
        $originalWordPressNodes = $wp_admin_bar->get_nodes();
        
        //create a global variable
        global $wp_custom_admin_interface_all_toolbar_items;
        //set the variable to all nodes
        $wp_custom_admin_interface_all_toolbar_items = $originalWordPressNodes;
        
        
        
        if(isset($options['wp_custom_admin_interface_primary_toolbar_menu'])) {

            if(wp_custom_admin_interface_admin_menu_exception_check('toolbar',$options['wp_custom_admin_interface_exception_type_toolbar'],$options['wp_custom_admin_interface_exception_cases_toolbar'])) {
            
            

                // OPERATION 1 - we need to replace the standard toolbar with our new toolbar

                $toolbarMenu = $options['wp_custom_admin_interface_primary_toolbar_menu'];

                if(strpos($toolbarMenu, '{') !== false){
                    $toolbarMenuDecoded = json_decode($toolbarMenu);     
                } else {
                    $toolbarMenuDecoded = json_decode(base64_decode($toolbarMenu)); 
                }
                
                
                //create an array which will store all our notifications
                $itemsWithSpans = array();
                $itemsMeta = array();

                //cycle through each node in the toolbar
                foreach($originalWordPressNodes as $item) {
                    //item id
                    $itemId = $item->id;
                    //item meta
                    $itemMeta = $item->meta;
                    //lets add the id and meta to our array
                    $itemsMeta += array($itemId => $itemMeta);
                    //item title
                    $itemTitle = $item->title;
                    //if item title contains a span lets add it to the array
                    if(strpos($itemTitle,'<span') !== false) {
                        
                        $itemsWithSpans += array($itemId => $itemTitle);    
                    }
                }
                
                
                
                
                //now we need to add this information to our settings
                
                foreach($toolbarMenuDecoded as $item) {
                    //declare the id as a variable    
                    $itemId = $item->id;
                    //lets replace the meta
                    if(array_key_exists($itemId,$itemsMeta)){
                        $metaToUtilise = $itemsMeta[$itemId];
                        $item->meta = $metaToUtilise; 
                    } 
                    
                    //lets replace the titles
                    if(array_key_exists($itemId,$itemsWithSpans)){
                        $titleToUtilise = $itemsWithSpans[$itemId];
                        $item->title = $titleToUtilise;
                    }
                }
                
                
                // because wordpress wont just let us replace the global variable like it does on the main menu we need to remove all nodes from the original and then add our new nodes
                // so lets first remove all the nodes
                foreach($originalWordPressNodes as $key => $val) {
                    $current_node = $originalWordPressNodes[$key];
                    $wp_admin_bar->remove_node($key);
                }
                
                //now lets add our nodes...thanks wordpress!
                foreach($toolbarMenuDecoded as $item) {
                
                    $args = array(
                        'id'    => $item->id,
                        'title' => $item->title,
                        'parent' => $item->parent,
                        'href'  => $item->href,
                        'group' => $item->group,
                        'meta'  => $item->meta
                    );
                    $wp_admin_bar->add_node( $args );     
                }
                

                /*
                echo '<div style="float: right;">';  
                highlight_string("<?php\n\$data =\n" . var_export($wp_admin_bar, true) . ";\n?>");
                echo '</div><br></br><br></br><br></br><br></br>'; 
                
                echo '<div style="float: right;">';  
                highlight_string("<?php\n\$data =\n" . var_export($toolbarMenuDecoded, true) . ";\n?>");
                echo '</div><br></br><br></br><br></br><br></br>'; 

                echo '<div style="float: right;">';  
                highlight_string("<?php\n\$data =\n" . var_export($toolbarMenuDecoded, true) . ";\n?>");
                echo '</div><br></br><br></br><br></br><br></br>'; 

                echo '<div style="float: right;">';  
                highlight_string("<?php\n\$data =\n" . var_export($originalWordPressNodes, true) . ";\n?>");
                echo '</div>'; 
    
                echo '<div style="float: right;">';  
                highlight_string("<?php\n\$data =\n" . var_export($itemsMeta, true) . ";\n?>");
                echo '</div><br></br><br></br><br></br><br></br>'; 
                
                echo '<div style="float: right;">';  
                highlight_string("<?php\n\$data =\n" . var_export($itemsWithSpans, true) . ";\n?>");
                echo '</div>'; 
                
                */
                
        
                // OPERATION 2 - we need to remove menu items from the toolbar
                $removeLastCharacterFromString = substr($options['wp_custom_admin_interface_remove_toolbar_item'],0,-1);

                $turnCommaStringIntoArray = explode(",", $removeLastCharacterFromString);

                //cycle through each item in array
                foreach ($turnCommaStringIntoArray as $value) {
                    $wp_admin_bar->remove_node($value);  
                }

        
            }
        }

    }


    

}
add_action( 'admin_bar_menu', 'wp_custom_admin_interface_all_toolbar_nodes', 99999 );
/**
* 
*
*
* Implements update message on plugin page
*/
global $pagenow;
if ( 'plugins.php' === $pagenow )
{
    $file   = basename( __FILE__ );
    $folder = basename( dirname( __FILE__ ) );
    $hook = "in_plugin_update_message-{$folder}/{$file}";
    add_action( $hook, 'wp_custom_admin_interface_update_message', 20, 2 );
}

function wp_custom_admin_interface_update_message( $plugin_data, $r )
{
    
    $pluginInformation = get_plugin_data(__FILE__);
    $pluginTextDomain = $pluginInformation['TextDomain'];
    
    
    $data = file_get_contents( 'http://plugins.svn.wordpress.org/'.$pluginTextDomain.'/trunk/readme.txt' );

    $changelog = stristr( $data, '== Changelog ==' );

    $curr_ver = wp_custom_admin_interface_get_version();

    $changelogCurrentVersionAndAbove = stristr($changelog, "= {$curr_ver} =",true);
    
    $changelogCurrentVersionAndAbove = explode('= ', $changelogCurrentVersionAndAbove);
    
    $changelogCurrentVersionAndAboveRemoveFirstTwoItems = array_splice($changelogCurrentVersionAndAbove,2);
    

    $output = '<h3>' . __("What's new", 'wp-custom-admin-interface') . '</h3>';
    
    $output .= '<ul>';
    
    
    foreach ($changelogCurrentVersionAndAboveRemoveFirstTwoItems as $version) {
        
        $removeEquals = str_replace(' =', '', $version);
        
        $firstStar = strpos($removeEquals, '*');
        
        $justVersionNumber = substr($removeEquals,0,$firstStar);
        
        $lengthOfVersion = strlen($removeEquals);
        
        $justVersionInfo = substr($removeEquals,$firstStar,$lengthOfVersion);
        
        $exploreVersionInfo = explode('*',$justVersionInfo);
        $exploreVersionInfo = array_splice($exploreVersionInfo,1);
        
        $output .= '<li>'; 
        $output .= '<strong>'.$justVersionNumber.'</strong>';
        $output .= '<ul style="list-style-type: disc;">'; 
        
        foreach ($exploreVersionInfo as $change){
            $output .= '<li style="margin-left: 17px;">';
            $output .= $change; 
            $output .= '</li>';     
        }
        
        
        $output .= '</ul>'; 
        $output .= '</li>'; 
    }
        
    $output .= '</ul>';
    
    return print $output;
}
/**
* 
*
*
* Changes the login URL
*/
function wp_custom_admin_interface_login_url($url) {
    
    $options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
    
    if(isset($options['wp_custom_admin_interface_login_url'])){
        
        
        if(strlen($options['wp_custom_admin_interface_login_url'])<1){
            $loginUrl = '#';
        } else {
            $loginUrl = $options['wp_custom_admin_interface_login_url']; 
        }
        
        return $loginUrl;    
    }
    
}
add_filter( 'login_headerurl', 'wp_custom_admin_interface_login_url' );
/**
* 
*
*
* Function to run upon ajax request to delete settings
*/
function wp_custom_admin_interface_delete_settings() {
    
    //check the nonce referrer exists
    check_ajax_referer( 'wp-custom-admin-interface-nonce', 'security' );

    // check if user can manage options    
    if ( ! current_user_can( 'manage_options') ){
        echo "You don't have permission to perform this action.";
        die(); 
    }
    
    
    //get user input
    $settings = $_POST['settings']; 
    
    
    foreach($settings as $option){
        
        $optionName = str_replace(' ', '', $option);
        $fullOptionName =  'wp_custom_admin_interface_settings_'.$optionName;
        
        delete_option($fullOptionName);
        
    }
    

    echo "success";    
    die();    
}
add_action( 'wp_ajax_delete_settings', 'wp_custom_admin_interface_delete_settings' );
/**
* 
*
*
* Function to add custom css and javascript to frontend of Wordpress
*/
function wp_custom_admin_interface_custom_frontend_css() {
    
    $options = get_option( 'wp_custom_admin_interface_settings_CustomCodeFrontend' );
    
    if(isset($options['wp_custom_admin_interface_deactivate_frontend_code'])){} else {
        
        if(strlen($options['wp_custom_admin_interface_custom_frontend_css_code'])>0){  
            
            wp_enqueue_style( 'custom-frontend-style', plugins_url( '/inc/frontendstyle.css', __FILE__ ),array(),wp_custom_admin_interface_get_version() );    
            wp_add_inline_style( 'custom-frontend-style', $options['wp_custom_admin_interface_custom_frontend_css_code'] ); 
 
        }
        
        
        if(strlen($options['wp_custom_admin_interface_custom_frontend_javascript_code'])>0){
            wp_enqueue_script( 'custom-frontend-script', plugins_url( '/inc/frontendscript.js', __FILE__ ), array( 'jquery'),wp_custom_admin_interface_get_version());
            
            $custom_code = "jQuery(document).ready(function ($) {
            {$options['wp_custom_admin_interface_custom_frontend_javascript_code']} 
            });";
            wp_add_inline_script( 'custom-frontend-script', $custom_code );
            
            
        }
        
    }
}
add_action( 'wp_enqueue_scripts', 'wp_custom_admin_interface_custom_frontend_css', 999 );
/**
* 
*
*
* Function to remove meta boxes
*/
function wp_custom_admin_interface_remove_meta() {
    
    $options = get_option('wp_custom_admin_interface_settings_HideMeta');
    
    if(isset($options['wp_custom_admin_interface_hide_this_meta'])) {
       
        if(wp_custom_admin_interface_admin_menu_exception_check('meta',$options['wp_custom_admin_interface_exception_type_meta'],$options['wp_custom_admin_interface_exception_cases_meta'])) {
        
        
            $removeFirstComma = substr($options['wp_custom_admin_interface_hide_this_meta'], 1);

            $commasToArray = explode(',',$removeFirstComma);
                        
            foreach($commasToArray as $item) {

                $positionOfPipe = strpos($item,'|');

                $postType = substr($item,0,$positionOfPipe);
                
                $positionOfDoublePipe = strpos($item,'||');

                $metaId = substr($item,$positionOfPipe+1,$positionOfDoublePipe-$positionOfPipe-1);
            
                remove_meta_box($metaId,$postType,'normal');
                remove_meta_box($metaId,$postType,'advanced');
                remove_meta_box($metaId,$postType,'side');

            }
            
        }
    }
      
}
add_action('admin_head','wp_custom_admin_interface_remove_meta');
/**
* 
*
*
* Function to display admin notice
*/
function wp_custom_admin_interface_custom_admin_notice() {
    
    $options = get_option('wp_custom_admin_interface_settings_AdminNotice');
    
    //current user
    $currentUser = wp_get_current_user();
    //current user ID
    $currentUserId = $currentUser->ID;
    
    //check to make sure option is set
    if(isset($options['wp_custom_admin_interface_notice_message'])){
           
        //check if the user is exposed to the message
        if(wp_custom_admin_interface_admin_menu_exception_check('notice',$options['wp_custom_admin_interface_exception_type_notice'],$options['wp_custom_admin_interface_exception_cases_notice'])) {    
            
            //check if the date is within range
            if(isset($options['wp_custom_admin_interface_notice_expiry'])) {
                if(strlen($options['wp_custom_admin_interface_notice_expiry'])>1){
                $noticeExpiryDate = $options['wp_custom_admin_interface_notice_expiry'];    
            } else {
                $noticeExpiryDate = "2050-01-01";    
            }} else {   
                $noticeExpiryDate = "2050-01-01";    
            }


            $todaysDate = date('Y-m-d');   

            if ($todaysDate < $noticeExpiryDate) {
                
                //lets check if the user has dismissed the message
                //define transient name    
                $transientName = 'an_dismiss_'.$currentUserId;
                //get transient
                $getTransient = get_transient($transientName);   
                
                
                if($getTransient != true) {

                    if(isset($options['wp_custom_admin_interface_notice_dismissible'])){
                        $dismissableClass = 'is-dismissible'; 
                    } else {
                        $dismissableClass = '';     
                    }

                    echo '<div id="custom-admin-notice" data="'.$currentUserId.'" class="notice '.$options['wp_custom_admin_interface_notice_color'].' '.$dismissableClass.'">';
                    
                    echo wp_custom_admin_interface_shortcode_replacer($options['wp_custom_admin_interface_notice_message']);
                    
                    echo $getTransient;
                    
                    echo '</div>';
                
                }
            }
            
        }

    }

}
add_action( 'admin_notices', 'wp_custom_admin_interface_custom_admin_notice' );
/**
* 
*
*
* Function add transient when someone dismisses the notice message
*/
function wp_custom_admin_interface_dismiss_admin_notice() {
    
    //get user input
    $userId = $_POST['userId']; 
    
    //create transient name - an stands for admin notice    
    $transientName = 'an_dismiss_'.$userId;
    
    //create actual transient
    set_transient($transientName,true,0);
        
    die();    
}
add_action( 'wp_ajax_dismiss_message', 'wp_custom_admin_interface_dismiss_admin_notice' );
/**
* 
*
*
* Function to clear transients related to the admin notice
*/
function wp_custom_admin_interface_delete_dismiss_transients() {
	global $wpdb; 
    $sql = "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_an_dismiss_%'";
    $wpdb->query($sql);
    echo "success";    
    die();    
}
add_action( 'wp_ajax_delete_dismiss_transients', 'wp_custom_admin_interface_delete_dismiss_transients');





//function sccss_register_style() {
//	$url = home_url();
//
//	if ( is_ssl() ) {
//		$url = home_url( '/', 'https' );
//	}
//
//	wp_register_style( 'sccss_style', add_query_arg( array( 'sccss' => 1 ), $url ) );
//
//	wp_enqueue_style( 'sccss_style' );
//}
//add_action( 'wp_enqueue_scripts', 'sccss_register_style', 99 );
//
//
//
//
//function sccss_maybe_print_css() {
//
////	// Only print CSS if this is a stylesheet request
////	if( ! isset( $_GET['sccss'] ) || intval( $_GET['sccss'] ) !== 1 ) {
////		return;
////	}
//    
//    $options = get_option( 'wp_custom_admin_interface_settings_CustomCodeFrontend' );
//
//	ob_start();
//	header( 'Content-type: text/css' );
//	echo $options['wp_custom_admin_interface_custom_frontend_css_code']; //xss okay
//	die();
//}
//
//add_action( 'plugins_loaded', 'sccss_maybe_print_css' );


/**
* 
*
*
* Prevents Betheme from operating on custom code page
*/
global $pagenow;

if('admin.php' == $pagenow && isset($_GET['page']) && ($_GET['page'] == 'wpcai_custom_code' || $_GET['page'] == 'wpcai_custom_code_frontend')    ){
        //initialise codemirror on the page
       function mfn_builder_scripts() {
            wp_deregister_script( 'mfn-builder' );
        }
        add_action('admin_print_scripts', 'mfn_builder_scripts');
        
}



?>