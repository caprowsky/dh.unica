<?php
/*
Plugin Name: WP to xDams Bridge
Plugin URI: http://www.xdams.org/
Description: Plugin to connect wordpress to xDams Opens Source Platform. <br />Use the <a href="options-general.php?page=WPxdamsBridge.php">configuration page</a> to active / deactive and configure this plugin.
Author: regesta.exe for xDams O.S.
Version: 2.1.4 delta
Date: 14/05/2018
Author URI: http://www.regesta.com/
*/
include ('WPxdamsBridge_functions.php');                // general functions
include ('WPxdamsBridge_publicAPI.php');                // API to publish on the website
include ('WPxdamsBridge_external_calls.php');           // access to remote data
include ('WPxdams_admin/WPxdamsBridge_admin.php');      // bachk end pages

add_shortcode("xdamsItem", "WPxdamsBridge_page_publishing_process"); 
add_shortcode("xdamsImage", "WPxdamsBridge_image_publishing_process");   
add_shortcode("xdamsSearch", "WPxdamsBridge_search_publishing_process"); 
add_shortcode("xdamsAdSearch", "WPxdamsBridge_ad_search_publishing_process"); 
add_shortcode("xdamsTree", "WPxdamsBridge_tree_publishing_process");  
add_shortcode("xdamsList", "WPxdamsBridge_listing_publishing_process"); 
add_shortcode("xdamsListImg", "WPxdamsBridge_listing_publishing_process"); 
add_shortcode("xdamsPreview", "WPxdamsBridge_listing_publishing_process"); 

add_shortcode("xdamsStory", "WPxdamsBridge_story_publishing_process");


//  management of the short code for publishing a specific item of an archive 

// Register style sheet and scripts for admin
// .
add_action( 'wp_enqueue_scripts', 'WPxdamsBridge_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'WPxdamsBridge_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'WPxdamsBridge_enqueue_admin_styles_and_scripts' );
    
function WPxdamsBridge_enqueue_admin_styles_and_scripts() {
        WPxdamsBridge_start_process();
    
        if (WPxdamsBridge_loadJSforAdminPage()){
            wp_register_style( 'WPxdamsbridgeAdminStyles', plugins_url( 'WPxdamsBridge/WPxdams_templates/css/bootstrap/bootstrap.min.css' ) );
            wp_enqueue_style( 'WPxdamsbridgeAdminStyles' );
            wp_register_script( 'WPxdamsbridgeAdminjquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
            wp_enqueue_script( 'WPxdamsbridgeAdminjquery' );
        
            wp_register_style( 'WPxdamsbridgeStyles3', plugins_url( 'WPxdamsBridge/WPxdams_templates/css/bootstrap/bootstrap.min.css' ) );
            wp_enqueue_style( 'WPxdamsbridgeStyles3' );
            wp_register_script( 'WPxdamsbridgeAdminjs', plugins_url( 'WPxdamsBridge/WPxdams_templates/js/xdamsAdminStory.js' ));
            wp_enqueue_script( 'WPxdamsbridgeAdminjs' );  
        }
        
        wp_register_script( 'WPxdamsbridgeMain', plugins_url( 'WPxdamsBridge/WPxdams_templates/js/xdamsMain.js' , false, false, true));
        wp_enqueue_script(  'WPxdamsbridgeMain' );
        
        wp_register_script( 'WPxdamsbridgePolling', plugins_url( 'WPxdamsBridge/WPxdams_templates/js/xdamsPolling.js' , false, false, true));
        wp_enqueue_script(  'WPxdamsbridgePolling' );        
        
        wp_register_script( 'WPxdamsbridgePollingonload', plugins_url( 'WPxdamsBridge/WPxdams_templates/js/xdamsPolling_onload.js' , false, false, true));
        wp_enqueue_script(  'WPxdamsbridgePollingonload' );
        
        wp_localize_script('WPxdamsbridgeMain','my_vars', array(
                'ajaxurl'   => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('import-tree-nonce)')
                ));
 
         wp_localize_script('WPxdamsbridgePolling','my_vars', array(
                'ajaxurl'   => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('polling-nonce)')
                ));
         
        wp_localize_script('WPxdamsbridgePollingonload','my_vars', array(
                'ajaxurl'   => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('pollingonload-nonce)')
                ));
        
        wp_register_style( 'WPxdamsbridgeAdminStyles2', plugins_url( 'WPxdamsBridge/WPxdams_templates/css/WPxdamsBridge_adminStyle.css' ) );
	wp_enqueue_style( 'WPxdamsbridgeAdminStyles2' );
	wp_register_script( 'WPxdamsbridgeAdminjquery2', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js');
	wp_enqueue_script( 'WPxdamsbridgeAdminjquery2' );    

}

/**
 * Register style sheet.
 */ 
function WPxdamsBridge_enqueue_styles() {  

	
	WPxdamsBridge_start_process();
	wp_register_style( 'WPxdamsbridgeAwesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'WPxdamsbridgeAwesome' );
	wp_register_style( 'WPxdamsbridgeStyles', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700' );
	wp_enqueue_style( 'WPxdamsbridgeStyles' );
	wp_register_style( 'WPxdamsbridgeStyles1', 'https://fonts.googleapis.com/css?family=Oxygen:400,300,200');
	wp_enqueue_style( 'WPxdamsbridgeStyles1' );
	wp_register_style( 'WPxdamsbridgeStyles2', plugins_url( 'WPxdamsBridge/WPxdams_templates/css/WPxdamsBridge_style.css' ) );
	wp_enqueue_style( 'WPxdamsbridgeStyles2' );
//	wp_register_style( 'WPxdamsbridgeStyles3', plugins_url( 'WPxdamsBridge/WPxdams_templates/css/bootstrap/bootstrap.min.css' ) );
//	wp_enqueue_style( 'WPxdamsbridgeStyles3' );
        wp_register_style( 'WPxdamsbridgeStylesCustom', plugins_url( 'WPxdamsBridge/WPxdams_custom/css/custom_style.css' ) );
	wp_enqueue_style( 'WPxdamsbridgeStylesCustom' );
}


function WPxdamsBridge_enqueue_scripts() {  

	wp_register_script( 'WPxdamsbridgejquery', 'http://code.jquery.com/jquery-latest.min.js');
	wp_enqueue_script( 'WPxdamsbridgejquery' );
	wp_register_script( 'WPxdamsbridgeStory',plugins_url( 'WPxdamsBridge/WPxdams_templates/js/xdamsStory.js' ));
	wp_enqueue_script( 'WPxdamsbridgeStory' );
        wp_register_script( 'WPxdamsbridgejquerybootstrap','https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js' );
	wp_enqueue_script( 'WPxdamsbridgejquerybootstrap' );
        wp_register_script( 'WPxdamsbridgeBootstrap',plugins_url( 'WPxdamsBridge/WPxdams_templates/js/bootstrap/bootstrap.min.js' ));
	wp_enqueue_script( 'WPxdamsbridgeBootstrap' );
}



 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
