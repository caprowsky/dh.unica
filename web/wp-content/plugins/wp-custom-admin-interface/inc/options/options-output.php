<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

//define all the settings in the plugin
function wp_custom_admin_interface_settings_init(  ) { 
    
    //start general
	register_setting( 'GeneralSettings', 'wp_custom_admin_interface_settings_GeneralSettings' );
    
    add_settings_section(
		'wp_custom_admin_interface_general','', 
		'wp_custom_admin_interface_settings_general_callback', 
		'GeneralSettings'
	);

	add_settings_field( 
		'wp_custom_admin_interface_background_color','', 
		'wp_custom_admin_interface_background_color_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
    );
    
    add_settings_field( 
		'wp_custom_admin_interface_text_color','', 
		'wp_custom_admin_interface_text_color_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_logo','', 
		'wp_custom_admin_interface_custom_logo_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_login_url','', 
		'wp_custom_admin_interface_login_url_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_favicon','', 
		'wp_custom_admin_interface_custom_favicon_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_favicon_frontend','', 
		'wp_custom_admin_interface_custom_favicon_frontend_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_footer','', 
		'wp_custom_admin_interface_custom_footer_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_remove_footer','', 
		'wp_custom_admin_interface_remove_footer_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_remove_toolbar_frontend','', 
		'wp_custom_admin_interface_remove_toolbar_frontend_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_disable_update','', 
		'wp_custom_admin_interface_disable_update_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
    );
    
    add_settings_field( 
		'wp_custom_admin_interface_disable_gutenberg','', 
		'wp_custom_admin_interface_disable_gutenberg_render', 
		'GeneralSettings', 
		'wp_custom_admin_interface_general' 
	);
    
    
    
    //start custom code
    register_setting( 'CustomCode', 'wp_custom_admin_interface_settings_CustomCode' );
    
    add_settings_section(
		'wp_custom_admin_interface_custom_code','', 
		'wp_custom_admin_interface_settings_custom_code_callback', 
		'CustomCode'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_css_code','', 
		'wp_custom_admin_interface_custom_css_code_render', 
		'CustomCode', 
		'wp_custom_admin_interface_custom_code' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_login_css_code','', 
		'wp_custom_admin_interface_custom_login_css_code_render', 
		'CustomCode', 
		'wp_custom_admin_interface_custom_code' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_javascript_code','', 
		'wp_custom_admin_interface_custom_javascript_code_render', 
		'CustomCode', 
		'wp_custom_admin_interface_custom_code' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_php_code','', 
		'wp_custom_admin_interface_custom_php_code_render', 
		'CustomCode', 
		'wp_custom_admin_interface_custom_code' 
	);
    
    // add_settings_field( 
	// 	'wp_custom_admin_interface_deactivate_code','', 
	// 	'wp_custom_admin_interface_deactivate_code_render', 
	// 	'CustomCode', 
	// 	'wp_custom_admin_interface_custom_code' 
    // );

    add_settings_field( 
		'wp_custom_admin_interface_exception_type_code','', 
		'wp_custom_admin_interface_exception_type_code_render', 
		'CustomCode', 
		'wp_custom_admin_interface_custom_code' 
    );

    add_settings_field( 
		'wp_custom_admin_interface_exception_cases_code','', 
		'wp_custom_admin_interface_exception_cases_code_render', 
		'CustomCode', 
		'wp_custom_admin_interface_custom_code' 
    );
    


    
    //start custom code frontend
    register_setting( 'CustomCodeFrontend', 'wp_custom_admin_interface_settings_CustomCodeFrontend' );
    
    add_settings_section(
		'wp_custom_admin_interface_custom_code_frontend','', 
		'wp_custom_admin_interface_custom_code_frontend_callback', 
		'CustomCodeFrontend'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_frontend_css_code','', 
		'wp_custom_admin_interface_custom_frontend_css_code_render', 
		'CustomCodeFrontend', 
		'wp_custom_admin_interface_custom_code_frontend' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_frontend_javascript_code','', 
		'wp_custom_admin_interface_custom_frontend_javascript_code_render', 
		'CustomCodeFrontend', 
		'wp_custom_admin_interface_custom_code_frontend' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_deactivate_frontend_code','', 
		'wp_custom_admin_interface_deactivate_frontend_code_render', 
		'CustomCodeFrontend', 
		'wp_custom_admin_interface_custom_code_frontend' 
	);
    
    
    
    //start maintenance
    
    register_setting( 'MaintenancePage', 'wp_custom_admin_interface_settings_MaintenancePage' );
    
    add_settings_section(
		'wp_custom_admin_interface_maintenance','', 
		'wp_custom_admin_interface_maintenance_callback', 
		'MaintenancePage'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_enable_maintenance','', 
		'wp_custom_admin_interface_enable_maintenance_render', 
		'MaintenancePage', 
		'wp_custom_admin_interface_maintenance' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_maintenance_text','', 
		'wp_custom_admin_interface_maintenance_text_render', 
		'MaintenancePage', 
		'wp_custom_admin_interface_maintenance' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_maintenance_end','', 
		'wp_custom_admin_interface_maintenance_end_render', 
		'MaintenancePage', 
		'wp_custom_admin_interface_maintenance' 
	);
    
    //start widget page
    
    register_setting( 'CustomDashboardWidget', 'wp_custom_admin_interface_settings_CustomDashboardWidget' );
    
    add_settings_section(
		'wp_custom_admin_interface_widget','', 
		'wp_custom_admin_interface_widget_callback', 
		'CustomDashboardWidget'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_enable_custom_widget','', 
		'wp_custom_admin_interface_enable_custom_widget_render', 
		'CustomDashboardWidget', 
		'wp_custom_admin_interface_widget' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_widget_title','', 
		'wp_custom_admin_interface_custom_widget_title_render', 
		'CustomDashboardWidget', 
		'wp_custom_admin_interface_widget' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_custom_widget_content','', 
		'wp_custom_admin_interface_custom_widget_content_render', 
		'CustomDashboardWidget', 
		'wp_custom_admin_interface_widget' 
	);
    
    
    
    //start custom color scheme
    
    register_setting( 'AdminColorScheme', 'wp_custom_admin_interface_settings_AdminColorScheme' );
    
    add_settings_section(
		'wp_custom_admin_interface_admin_color_scheme','', 
		'wp_custom_admin_interface_admin_color_scheme_callback', 
		'AdminColorScheme'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_color_scheme_color_one','', 
		'wp_custom_admin_interface_color_scheme_color_one_render', 
		'AdminColorScheme', 
		'wp_custom_admin_interface_admin_color_scheme' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_color_scheme_color_two','', 
		'wp_custom_admin_interface_color_scheme_color_two_render', 
		'AdminColorScheme', 
		'wp_custom_admin_interface_admin_color_scheme' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_color_scheme_color_three','', 
		'wp_custom_admin_interface_color_scheme_color_three_render', 
		'AdminColorScheme', 
		'wp_custom_admin_interface_admin_color_scheme' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_color_scheme_color_four','', 
		'wp_custom_admin_interface_color_scheme_color_four_render', 
		'AdminColorScheme', 
		'wp_custom_admin_interface_admin_color_scheme' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_color_scheme_icon_color','', 
		'wp_custom_admin_interface_color_scheme_icon_color_render', 
		'AdminColorScheme', 
		'wp_custom_admin_interface_admin_color_scheme' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_force_color_scheme','', 
		'wp_custom_admin_interface_force_color_scheme_render', 
		'AdminColorScheme', 
		'wp_custom_admin_interface_admin_color_scheme' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_button_link_color','', 
		'wp_custom_admin_interface_button_link_color_render', 
		'AdminColorScheme', 
		'wp_custom_admin_interface_admin_color_scheme' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_button_link_hover_color','', 
		'wp_custom_admin_interface_button_link_color_hover_render', 
		'AdminColorScheme', 
		'wp_custom_admin_interface_admin_color_scheme' 
	);
    
    
    //start menu options
    register_setting( 'AdminMenu', 'wp_custom_admin_interface_settings_AdminMenu' );
    
    add_settings_section(
		'wp_custom_admin_interface_admin_menu','', 
		'wp_custom_admin_interface_admin_menu_callback', 
		'AdminMenu'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_top_level_menu','', 
		'wp_custom_admin_interface_top_level_menu_render', 
		'AdminMenu', 
		'wp_custom_admin_interface_admin_menu' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_sub_level_menu','', 
		'wp_custom_admin_interface_sub_level_menu_render', 
		'AdminMenu', 
		'wp_custom_admin_interface_admin_menu' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_remove_menu_item','', 
		'wp_custom_admin_interface_remove_menu_item_render', 
		'AdminMenu', 
		'wp_custom_admin_interface_admin_menu' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_type','', 
		'wp_custom_admin_interface_exception_type_render', 
		'AdminMenu', 
		'wp_custom_admin_interface_admin_menu' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_cases','', 
		'wp_custom_admin_interface_exception_cases_render', 
		'AdminMenu', 
		'wp_custom_admin_interface_admin_menu' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_show_notifications','', 
		'wp_custom_admin_interface_show_notifications_render', 
		'AdminMenu', 
		'wp_custom_admin_interface_admin_menu' 
	);
    
    
    //start hide plugin options
    register_setting( 'HidePlugins', 'wp_custom_admin_interface_settings_HidePlugins' );
    
    add_settings_section(
		'wp_custom_admin_interface_hide_plugins','', 
		'wp_custom_admin_interface_hide_plugins_callback', 
		'HidePlugins'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_hide_these_plugins','', 
		'wp_custom_admin_interface_hide_these_plugins_render', 
		'HidePlugins', 
		'wp_custom_admin_interface_hide_plugins' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_type_plugin','', 
		'wp_custom_admin_interface_exception_type_plugin_render', 
		'HidePlugins', 
		'wp_custom_admin_interface_hide_plugins' 
	);

    
    add_settings_field( 
		'wp_custom_admin_interface_exception_cases_plugin','', 
		'wp_custom_admin_interface_exception_cases_plugin_render', 
		'HidePlugins', 
		'wp_custom_admin_interface_hide_plugins' 
	);
    
    
    //start hide users options
    register_setting( 'HideUsers', 'wp_custom_admin_interface_settings_HideUsers' );
    
    add_settings_section(
		'wp_custom_admin_interface_hide_users','', 
		'wp_custom_admin_interface_hide_users_callback', 
		'HideUsers'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_hide_these_users','', 
		'wp_custom_admin_interface_hide_these_users_render', 
		'HideUsers', 
		'wp_custom_admin_interface_hide_users' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_type_user','', 
		'wp_custom_admin_interface_exception_type_user_render', 
		'HideUsers', 
		'wp_custom_admin_interface_hide_users' 
	);

    
    add_settings_field( 
		'wp_custom_admin_interface_exception_cases_user','', 
		'wp_custom_admin_interface_exception_cases_user_render', 
		'HideUsers', 
		'wp_custom_admin_interface_hide_users' 
	);

    
    
    //start hide sidebars options
    register_setting( 'HideSidebars', 'wp_custom_admin_interface_settings_HideSidebars' );
    
    add_settings_section(
		'wp_custom_admin_interface_hide_sidebars','', 
		'wp_custom_admin_interface_hide_sidebars_callback', 
		'HideSidebars'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_hide_these_sidebars','', 
		'wp_custom_admin_interface_hide_these_sidebars_render', 
		'HideSidebars', 
		'wp_custom_admin_interface_hide_sidebars' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_type_sidebar','', 
		'wp_custom_admin_interface_exception_type_sidebar_render', 
		'HideSidebars', 
		'wp_custom_admin_interface_hide_sidebars' 
	);

    
    add_settings_field( 
		'wp_custom_admin_interface_exception_cases_sidebar','', 
		'wp_custom_admin_interface_exception_cases_sidebar_render', 
		'HideSidebars', 
		'wp_custom_admin_interface_hide_sidebars' 
	);    
    

    //start toolbar options
    register_setting( 'AdminToolbar', 'wp_custom_admin_interface_settings_AdminToolbar' );
    
    add_settings_section(
		'wp_custom_admin_interface_toolbar_menu','', 
		'wp_custom_admin_interface_toolbar_menu_callback', 
		'AdminToolbar'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_primary_toolbar_menu','', 
		'wp_custom_admin_interface_primary_toolbar_menu_render', 
		'AdminToolbar', 
		'wp_custom_admin_interface_toolbar_menu' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_disable_custom_toolbar_frontend','', 
		'wp_custom_admin_interface_disable_custom_toolbar_frontend_render', 
		'AdminToolbar', 
		'wp_custom_admin_interface_toolbar_menu' 
	);

    add_settings_field( 
		'wp_custom_admin_interface_remove_toolbar_item','', 
		'wp_custom_admin_interface_remove_toolbar_item_render', 
		'AdminToolbar', 
		'wp_custom_admin_interface_toolbar_menu' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_type_toolbar','', 
		'wp_custom_admin_interface_exception_type_toolbar_render', 
		'AdminToolbar', 
		'wp_custom_admin_interface_toolbar_menu' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_cases_toolbar','', 
		'wp_custom_admin_interface_exception_cases_toolbar_render', 
		'AdminToolbar', 
		'wp_custom_admin_interface_toolbar_menu' 
	);
    
    
    //start help
	register_setting( 'Help', 'wp_custom_admin_interface_settings' );
    
    add_settings_section(
		'wp_custom_admin_interface_help','', 
		'wp_custom_admin_interface_help_callback', 
		'Help'
	);
    
    //start help
	register_setting( 'ManageSettings', 'wp_custom_admin_interface_settings' );
    
    add_settings_section(
		'wp_custom_admin_interface_manage_settings','', 
		'wp_custom_admin_interface_manage_settings_callback', 
		'ManageSettings'
	);
    
    
    //start hide sidebars options
    register_setting( 'HideMeta', 'wp_custom_admin_interface_settings_HideMeta' );
    
    add_settings_section(
		'wp_custom_admin_interface_hide_meta','', 
		'wp_custom_admin_interface_hide_meta_callback', 
		'HideMeta'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_hide_this_meta','', 
		'wp_custom_admin_interface_hide_this_meta_render', 
		'HideMeta', 
		'wp_custom_admin_interface_hide_meta' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_type_meta','', 
		'wp_custom_admin_interface_exception_type_meta_render', 
		'HideMeta', 
		'wp_custom_admin_interface_hide_meta' 
	);

    
    add_settings_field( 
		'wp_custom_admin_interface_exception_cases_meta','', 
		'wp_custom_admin_interface_exception_cases_meta_render', 
		'HideMeta', 
		'wp_custom_admin_interface_hide_meta' 
	);
    
    
    //start custom code frontend
    register_setting( 'AdminNotice', 'wp_custom_admin_interface_settings_AdminNotice' );
    
    add_settings_section(
		'wp_custom_admin_interface_admin_notice','', 
		'wp_custom_admin_interface_admin_notice_callback', 
		'AdminNotice'
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_notice_message','', 
		'wp_custom_admin_interface_notice_message_render', 
		'AdminNotice', 
		'wp_custom_admin_interface_admin_notice' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_notice_color','', 
		'wp_custom_admin_interface_notice_color_render', 
		'AdminNotice', 
		'wp_custom_admin_interface_admin_notice' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_notice_expiry','', 
		'wp_custom_admin_interface_notice_expiry_render', 
		'AdminNotice', 
		'wp_custom_admin_interface_admin_notice' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_notice_dismissible','', 
		'wp_custom_admin_interface_notice_dismissible_render', 
		'AdminNotice', 
		'wp_custom_admin_interface_admin_notice' 
	);
    
    add_settings_field( 
		'wp_custom_admin_interface_exception_type_notice','', 
		'wp_custom_admin_interface_exception_type_notice_render', 
		'AdminNotice', 
		'wp_custom_admin_interface_admin_notice' 
	);

    add_settings_field( 
		'wp_custom_admin_interface_exception_cases_notice','', 
		'wp_custom_admin_interface_exception_cases_notice_render', 
		'AdminNotice', 
		'wp_custom_admin_interface_admin_notice' 
	);
    
    
    
     
}

/**
* 
*
*
* The following functions output the callback of the sections
*/
function wp_custom_admin_interface_settings_general_callback(){}
function wp_custom_admin_interface_settings_custom_code_callback(){}
function wp_custom_admin_interface_custom_code_frontend_callback(){}
function wp_custom_admin_interface_maintenance_callback(){}
function wp_custom_admin_interface_widget_callback(){}
function wp_custom_admin_interface_admin_color_scheme_callback(){}
function wp_custom_admin_interface_admin_menu_callback(){}
function wp_custom_admin_interface_toolbar_menu_callback(){}
function wp_custom_admin_interface_admin_notice_callback(){}
function wp_custom_admin_interface_hide_plugins_callback(){}
function wp_custom_admin_interface_hide_users_callback(){}
function wp_custom_admin_interface_hide_sidebars_callback(){}
function wp_custom_admin_interface_hide_meta_callback(){}
function wp_custom_admin_interface_manage_settings_callback(){
    
    ?>

    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'Please click on an option below to show further options for the export, import or delete procedure.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>
        
    <tr valign="top">
        <td scope="row" colspan="2">
            
            
            
            
            <div id="accordion" style="margin-top:-25px;">
        
                <h3><i class="fa fa-download" aria-hidden="true"></i> <?php _e('Export Settings', 'wp-custom-admin-interface' ); ?></h3>
                <div>
                    <?php  
            
                    global $wp_custom_admin_interface_settings_pages_names;

                    echo '<a id="export-options-select-all" class="options-select-all" href="#">Select all</a> / <a id="export-options-deselect-all" class="options-deselect-all" href="#">Deselect all</a>';

                    echo '<ul id="export-specific-options" class="checkbox-group">';

                    foreach($wp_custom_admin_interface_settings_pages_names as $optionName) {

                        echo '<li><input class="wp_custom_admin_interface_settings_checkbox export-options-checkbox" type="checkbox" value="'.$optionName.'" checked> '.$optionName.'</li>';

                    }

                    echo '</ul>';

                    ?>

                    <button class="clipboard button-secondary copy-settings-button" data="<?php echo wp_create_nonce('wp-custom-admin-interface-nonce'); ?>" style="cursor:pointer;" data-clipboard-text=""><?php _e('Generate Export', 'wp-custom-admin-interface' ); ?></button>
                    
                </div> 
                
                <h3><i class="fa fa-upload" aria-hidden="true"></i> <?php _e('Import Settings', 'wp-custom-admin-interface' ); ?></h3>
                <div>
                    <input class="wp_custom_admin_interface_settings_input" data="<?php echo wp_create_nonce('wp-custom-admin-interface-nonce'); ?>" name="wp_custom_admin_interface_settings[wp_custom_admin_interface_import_settings]" id="wp_custom_admin_interface_import_settings"> <button id="import-settings" class="button-secondary" style="cursor:pointer;"><?php _e('Import', 'wp-custom-admin-interface' ); ?></button>
                </div> 
                
                
                <h3><i class="fa fa-trash-o" aria-hidden="true"></i> <?php _e('Delete Plugin Settings', 'wp-custom-admin-interface' ); ?></h3>
                <div>
                    <?php
                        echo '<a id="delete-options-select-all" class="options-select-all" href="#">Select all</a> / <a id="delete-options-deselect-all" class="options-deselect-all" href="#">Deselect all</a>';

                        echo '<ul id="delete-specific-options" class="checkbox-group">';

                        foreach($wp_custom_admin_interface_settings_pages_names as $optionName) {

                            echo '<li><input class="wp_custom_admin_interface_settings_checkbox delete-options-checkbox" type="checkbox" value="'.$optionName.'"> '.$optionName.'</li>';

                        }

                        echo '</ul>';


                    ?>

                   <button id="delete-settings" class="button-secondary" data="<?php echo wp_create_nonce('wp-custom-admin-interface-nonce'); ?>" style="cursor:pointer;"><?php _e('Delete Settings', 'wp-custom-admin-interface' ); ?></button>
                    
                </div> 
                
                
            </div> 
            
            


        </td>
    </tr>


    
    <?php
    
    
}
function wp_custom_admin_interface_help_callback(){
    
    $date = new DateTime("now", new DateTimeZone('Australia/Sydney') );

    ?>

    <div id="accordion">
        
        <h3><i class="fa fa-info-circle" aria-hidden="true"></i> <?php _e('Support', 'wp-custom-admin-interface' ); ?></h3>
        <div>

            <p><?php _e('Before creating support requests, it is important you read the following rules: 
                
                <ol>
                    <li>The custom admin menu and custom toolbar are beta features, we <strong>DO NOT PROVIDE SUPPORT</strong> for this. We understand that there may be technical issues working with certain plugins or the frontend vs the backend of the toolbar. If you are experiencing issues, sorry, please either use your expertise and contribute code to the plugin or find another plugin which suits your needs. You did not pay any money for this plugin and I spent a good month working on this + months of solving issues, so you get what you pay for. I know life sucks.</li>
                    <li><strong>As part of support I do not provide customisation services or code samples.</strong> If you need help with the implementation of the plugin or need to achieve something specific please <a href="mailto:info@northernbeacheswebsites.com.au">email me</a> and I can provide an estimate for the work.</li> 
                    <li>Please include the diagnostic information mentioned below, otherwise I will not bother answering your request.</li>     
                    <li>Please ensure you are using the latest version of WordPress and the latest version of the plugin, and clear your browser cache.</li>                    
                </ol>

                Ok now that you have read ALL the rules you can create a support request <a target="_blank" href="https://wordpress.org/support/plugin/wp-custom-admin-interface">here</a>. You can also check out the below video which shows a general walkthrough of the plugin (although it is getting a little dated now).


                ', 'wp-custom-admin-interface' ); ?></p>

            <iframe width="560" height="315" src="https://www.youtube.com/embed/bIfPaWnSUvk?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>    

            <p>
            <?php _e('Your', 'wp-custom-admin-interface' ); ?> <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=R38R9NBWSPX28" target="_blank"><?php _e('donations', 'wp-custom-admin-interface' ); ?></a> <?php _e('keep me interested in this plugin and encourage me to provide ongoing support. Thank you!', 'wp-custom-admin-interface' ); ?>  
            </p>

        </div>
        
        
        <h3><i class="fa fa-info-circle" aria-hidden="true"></i> <?php _e('Diagnostic Information', 'wp-custom-admin-interface' ); ?></h3>
        <div>
            <p style="padding-top: 0px; padding-bottom: 0px;"><?php _e('To assist me with your support request I may ask you to provide the following information:', 'wp-custom-admin-interface' ); ?></p>
            <p><code><?php echo 'PHP Version: <strong>'.phpversion().'</strong>'; ?></br>
            <?php echo 'Wordpress Version: <strong>'.get_bloginfo('version').'</strong>'; ?></br>
            Plugin Version: <strong><?php echo wp_custom_admin_interface_get_version(); ?></strong></br>
            Current Theme: <strong><?php 
            $user_theme = wp_get_theme();    
            echo esc_html( $user_theme->get( 'Name' ) );
            ?></strong></br>

            Active Plugins:</br> 
            <?php 
            $active_plugins=get_option('active_plugins');
            $plugins=get_plugins();
            $activated_plugins=array();
            foreach ($active_plugins as $plugin){           
            array_push($activated_plugins, $plugins[$plugin]);     
            } 

            foreach ($activated_plugins as $key){  
            echo '<strong>'.$key['Name'].'</strong></br>';
            }

            ?></code></p>    
        </div>

        <!-- <h3><i class="fa fa-info-circle" aria-hidden="true"></i> <?php //_e('Feature Request', 'wp-custom-admin-interface' ); ?></h3>
        <div>
            <p><?php // _e('Please use this form to request a feature. I can\'t guarantee it will make its way into the production release but if it\'s decent enough I will try my best. Thanks for contributing and making the plugin even better! If you haven\'t already please consider rating the plugin', 'wp-custom-admin-interface' ); ?> <a href="https://wordpress.org/support/plugin/wp-custom-admin-interface/reviews/?rate=5#new-post" target="_blank"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></a>'s.</p>

            <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSf69lqYxf2AmiAH0owdj7lS5-pzypjyxhTbfbdxOn_QdhxV0g/viewform?embedded=true" width="760" height="1400" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>       
        </div> -->
        
    </div>    


    

    



    <?php
    
}



//the following functions output the option html
function wp_custom_admin_interface_background_color_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_background_color"><?php _e('Login Screen Background Color', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input name="wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_background_color]" id="wp_custom_admin_interface_background_color" type="text" value="<?php if(isset($options['wp_custom_admin_interface_background_color'])) { echo esc_attr($options['wp_custom_admin_interface_background_color']); } ?>" class="my-color-field" data-default-color="#f1f1f1" />

        </td>
    </tr>
	<?php
}

function wp_custom_admin_interface_text_color_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_text_color"><?php _e('Login Screen Text Color', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input name="wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_text_color]" id="wp_custom_admin_interface_text_color" type="text" value="<?php if(isset($options['wp_custom_admin_interface_text_color'])) { echo esc_attr($options['wp_custom_admin_interface_text_color']); } ?>" class="my-color-field" data-default-color="#555d66" />

        </td>
    </tr>
	<?php
}




function wp_custom_admin_interface_custom_logo_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_logo"><?php _e('Custom Login Logo', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
        <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_custom_logo]" id="wp_custom_admin_interface_custom_logo" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_custom_logo'])) { echo esc_attr($options['wp_custom_admin_interface_custom_logo']); } ?>">
            
            
        <input type="button" name="upload-btn" id="upload-btn" class="button-secondary wp_custom_admin_interface_media_upload_button" value="<?php _e('Upload Image', 'wp-custom-admin-interface' ); ?>">

        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_custom_favicon_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_favicon"><?php _e('Custom Favicon', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('For best results please upload an image with a square aspect ratio', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            
        <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_custom_favicon]" id="wp_custom_admin_interface_custom_favicon" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_custom_favicon'])) { echo esc_attr($options['wp_custom_admin_interface_custom_favicon']); } ?>">
            
            
        <input type="button" name="upload-btn" id="upload-btn" class="button-secondary wp_custom_admin_interface_media_upload_button" value="<?php _e('Upload Image', 'wp-custom-admin-interface' ); ?>">

        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_custom_favicon_frontend_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_favicon_frontend"><?php _e('Also add the above favicon to the frontend', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_custom_favicon_frontend" name='wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_custom_favicon_frontend]' <?php checked( isset($options['wp_custom_admin_interface_custom_favicon_frontend']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_button_link_color_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
	?>

    <tr valign="top" style="border-top: 2px dashed #d6d4d4;">
        <td scope="row">
        </td>
        <td>
        </td>
    </tr>

    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_button_link_color"><?php _e('Admin Link and Button Color', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('Please click the "Default" button when changing the colour to load the default WordPress styling', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            
            <input name="wp_custom_admin_interface_settings_AdminColorScheme[wp_custom_admin_interface_button_link_color]" id="wp_custom_admin_interface_button_link_color" type="text" value="<?php if(isset($options['wp_custom_admin_interface_button_link_color'])) { echo esc_attr($options['wp_custom_admin_interface_button_link_color']); } ?>" class="my-color-field" data-default-color="#0085ba" />

        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_button_link_color_hover_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_button_link_hover_color"><?php _e('Admin Link and Button Hover Color', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('Please click the "Default" button when changing the colour to load the default WordPress styling', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            
            <input name="wp_custom_admin_interface_settings_AdminColorScheme[wp_custom_admin_interface_button_link_hover_color]" id="wp_custom_admin_interface_button_link_hover_color" type="text" value="<?php if(isset($options['wp_custom_admin_interface_button_link_hover_color'])) { echo esc_attr($options['wp_custom_admin_interface_button_link_hover_color']); } ?>" class="my-color-field" data-default-color="#008ec2" />

        </td>
    </tr>
	<?php
}













function wp_custom_admin_interface_custom_footer_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_footer"><?php _e('Custom Footer Text', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('Please feel free to use shortcodes to add dynamic content.', 'wp-custom-admin-interface' ); ?></em></p>

            
        </td>
        <td>
            
            <?php 
            
            wp_custom_admin_interface_shortcode_output('footer_text');
    
            if(isset($options['wp_custom_admin_interface_custom_footer'])){    
                wp_editor(html_entity_decode(stripslashes($options['wp_custom_admin_interface_custom_footer'])), "wp_custom_admin_interface_custom_footer", $settings = array(
                'wpautop' => false,    
                'textarea_name' => "wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_custom_footer]",
                'drag_drop_upload' => true,
                'textarea_rows' => 30, 
                ));    
            } else {
                wp_editor("", "wp_custom_admin_interface_custom_footer", $settings = array(
                'wpautop' => false,    
                'textarea_name' => "wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_custom_footer]",
                'drag_drop_upload' => true,
                'textarea_rows' => 30,
                ));         
            }
        
            ?>

        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_remove_toolbar_frontend_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_remove_toolbar_frontend"><?php _e('Remove admin toolbar from the front end for all users', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_remove_toolbar_frontend" name='wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_remove_toolbar_frontend]' <?php checked( isset($options['wp_custom_admin_interface_remove_toolbar_frontend']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_custom_css_code_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );
	?>
    
    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'The custom code section enables you to implement custom code on the backend of Wordpress.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>

    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_css_code"><?php _e('Add custom CSS to the WordPress admin', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            
            <textarea style="display:none;" cols="70" rows="30" name="wp_custom_admin_interface_settings_CustomCode[wp_custom_admin_interface_custom_css_code]" id="wp_custom_admin_interface_custom_css_code"><?php if(isset($options['wp_custom_admin_interface_custom_css_code'])) { echo esc_attr($options['wp_custom_admin_interface_custom_css_code']); } ?></textarea>
            
            
        </td>
    </tr>
	<?php
}





function wp_custom_admin_interface_custom_login_css_code_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_login_css_code"><?php _e('Add custom CSS to the WordPress login area', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('This setting will apply to all users and the conditional logic at the bottom of this page will not affect the result because on the login page everyone is technically logged out.', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            
            
            <textarea style="display:none;" cols="70" rows="30" name="wp_custom_admin_interface_settings_CustomCode[wp_custom_admin_interface_custom_login_css_code]" id="wp_custom_admin_interface_custom_login_css_code"><?php if(isset($options['wp_custom_admin_interface_custom_login_css_code'])) { echo esc_attr($options['wp_custom_admin_interface_custom_login_css_code']); } ?></textarea>
            
            
        </td>
    </tr>
	<?php
}





function wp_custom_admin_interface_custom_javascript_code_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_javascript_code"><?php _e('Add custom Javascript/jQuery to the WordPress admin', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('There\'s no need to put in the script tags and jQuery can be used like: ', 'wp-custom-admin-interface' ); ?><code><strong>$('body').show();</strong></code> </em></p>
        </td>
        <td>
            
            
            <textarea style="display:none;" cols="70" rows="30" name="wp_custom_admin_interface_settings_CustomCode[wp_custom_admin_interface_custom_javascript_code]" id="wp_custom_admin_interface_custom_javascript_code"><?php if(isset($options['wp_custom_admin_interface_custom_javascript_code'])) { echo esc_attr($options['wp_custom_admin_interface_custom_javascript_code']); } ?></textarea>
            
            
        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_custom_php_code_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_php_code"><?php _e('Add custom PHP to WordPress', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('There\'s no need to put in the starting or closing PHP tags. Please be super careful before putting in code here. In fact I really recommend not using this setting and instead putting custom code into your themes functions.php file so you can easily revert any errors caused by the code.', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            <textarea style="display:none;" cols="70" rows="30" name="wp_custom_admin_interface_settings_CustomCode[wp_custom_admin_interface_custom_php_code]" id="wp_custom_admin_interface_custom_php_code"><?php if(isset($options['wp_custom_admin_interface_custom_php_code'])) { echo esc_attr($options['wp_custom_admin_interface_custom_php_code']); } ?></textarea>

            <br></br>
        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_exception_type_code_render() { 
    
    echo wp_custom_admin_interface_exception_type_render_assist('wp_custom_admin_interface_exception_type_code','wp_custom_admin_interface_settings_CustomCode');
     
}


function wp_custom_admin_interface_exception_cases_code_render() { 
    
    echo wp_custom_admin_interface_exception_cases_render_assist('wp_custom_admin_interface_exception_cases_code','wp_custom_admin_interface_settings_CustomCode');
    
}





function wp_custom_admin_interface_remove_footer_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_remove_footer"><?php _e('Remove WordPress Version Number from Footer', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_remove_footer" name='wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_remove_footer]' <?php checked( isset($options['wp_custom_admin_interface_remove_footer']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_deactivate_code_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomCode' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_deactivate_code"><?php _e('Deactivate Custom Code on this Settings Tab', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_deactivate_code" name='wp_custom_admin_interface_settings_CustomCode[wp_custom_admin_interface_deactivate_code]' <?php checked( isset($options['wp_custom_admin_interface_deactivate_code']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_enable_maintenance_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_MaintenancePage' );
	?>


    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'This section enables you to create a custom under construction/maintenance page which is shown to all non-logged in users. Please note the login logo image, login page background color and custom favicon (set in the <a target="_blank" href="admin.php?page=wpcai_general_settings">General Settings</a> menu page) will be used on the maintenance/coming soon page.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>




    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_enable_maintenance"><?php _e('Enable Maintenance Mode', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_enable_maintenance" name='wp_custom_admin_interface_settings_MaintenancePage[wp_custom_admin_interface_enable_maintenance]' <?php checked( isset($options['wp_custom_admin_interface_enable_maintenance']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}





function wp_custom_admin_interface_maintenance_text_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_MaintenancePage' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_maintenance_text"><?php _e('Custom Maintenance Page/Coming Soon Text', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <?php 
            
            if(isset($options['wp_custom_admin_interface_maintenance_text'])){    
                wp_editor(html_entity_decode(stripslashes($options['wp_custom_admin_interface_maintenance_text'])), "wp_custom_admin_interface_maintenance_text", $settings = array(
                'wpautop' => false,
                'textarea_name' => "wp_custom_admin_interface_settings_MaintenancePage[wp_custom_admin_interface_maintenance_text]",
                'drag_drop_upload' => true,
                'textarea_rows' => 15, 
                ));    
            } else {
                wp_editor("", "wp_custom_admin_interface_maintenance_text", $settings = array(
                'wpautop' => false,
                'textarea_name' => "wp_custom_admin_interface_settings_MaintenancePage[wp_custom_admin_interface_maintenance_text]",
                'drag_drop_upload' => true,
                'textarea_rows' => 15,
                ));         
            }
        
            ?>

        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_maintenance_end_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_MaintenancePage' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_maintenance_end"><?php _e('Maintenance Mode End Date', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('Please leave blank to have no expiry.', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            <input class="wp_custom_admin_interface_settings_input datepicker" type="text" placeholder="YYYY-MM-DD" name="wp_custom_admin_interface_settings_MaintenancePage[wp_custom_admin_interface_maintenance_end]" id="wp_custom_admin_interface_maintenance_end" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_maintenance_end'])) { echo esc_attr($options['wp_custom_admin_interface_maintenance_end']); } ?>">
        </td>
    </tr>
	<?php
}




function wp_custom_admin_interface_enable_custom_widget_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomDashboardWidget' );
	?>
    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'This section enables you to create a custom widget which will display on your dashboard.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>

    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_enable_custom_widget"><?php _e('Enable Custom Dashboard Widget', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_enable_custom_widget" name='wp_custom_admin_interface_settings_CustomDashboardWidget[wp_custom_admin_interface_enable_custom_widget]' <?php checked( isset($options['wp_custom_admin_interface_enable_custom_widget']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_custom_widget_title_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomDashboardWidget' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_widget_title"><?php _e('Widget Title', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
        <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_CustomDashboardWidget[wp_custom_admin_interface_custom_widget_title]" id="wp_custom_admin_interface_custom_widget_title" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_custom_widget_title'])) { echo esc_attr($options['wp_custom_admin_interface_custom_widget_title']); } ?>">
            
            
        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_custom_widget_content_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomDashboardWidget' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_widget_content"><?php _e('Widget Content', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('Please feel free to use shortcodes to add dynamic content.', 'wp-custom-admin-interface' ); ?></em></p>

        </td>
        <td>
            
            <?php 
            
            wp_custom_admin_interface_shortcode_output('widget_text');
    
            if(isset($options['wp_custom_admin_interface_custom_widget_content'])){    
                wp_editor(html_entity_decode(stripslashes($options['wp_custom_admin_interface_custom_widget_content'])), "wp_custom_admin_interface_custom_widget_content", $settings = array(
                'wpautop' => false,
                'textarea_name' => "wp_custom_admin_interface_settings_CustomDashboardWidget[wp_custom_admin_interface_custom_widget_content]",
                'drag_drop_upload' => true,
                'textarea_rows' => 30, 
                ));    
            } else {
                wp_editor("", "wp_custom_admin_interface_custom_widget_content", $settings = array(
                'wpautop' => false,
                'textarea_name' => "wp_custom_admin_interface_settings_CustomDashboardWidget[wp_custom_admin_interface_custom_widget_content]",
                'drag_drop_upload' => true,
                'textarea_rows' => 30,
                ));         
            }
        
            ?>

        </td>
    </tr>
	<?php
}




function wp_custom_admin_interface_color_scheme_color_one_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
	?>



    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'Create a custom color scheme for your admin area. These 5 below colors will make up a new color scheme called "Custom" that will be available to select on your <a target="_blank" href="profile.php">User Profile</a> page.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>


    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_color_scheme_color_one"><?php _e('Color Scheme Color 1', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
        <input name="wp_custom_admin_interface_settings_AdminColorScheme[wp_custom_admin_interface_color_scheme_color_one]" id="wp_custom_admin_interface_color_scheme_color_one" type="text" value="<?php if(isset($options['wp_custom_admin_interface_color_scheme_color_one'])) { echo esc_attr($options['wp_custom_admin_interface_color_scheme_color_one']); } ?>" class="my-color-field" data-default-color="#222" />    
      
        </td>
    </tr>
	<?php
}

function wp_custom_admin_interface_color_scheme_color_two_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_color_scheme_color_two"><?php _e('Color Scheme Color 2', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
        <input name="wp_custom_admin_interface_settings_AdminColorScheme[wp_custom_admin_interface_color_scheme_color_two]" id="wp_custom_admin_interface_color_scheme_color_two" type="text" value="<?php if(isset($options['wp_custom_admin_interface_color_scheme_color_two'])) { echo esc_attr($options['wp_custom_admin_interface_color_scheme_color_two']); } ?>" class="my-color-field" data-default-color="#333" />    
      
        </td>
    </tr>
	<?php
}

function wp_custom_admin_interface_color_scheme_color_three_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_color_scheme_color_three"><?php _e('Color Scheme Color 3', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
        <input name="wp_custom_admin_interface_settings_AdminColorScheme[wp_custom_admin_interface_color_scheme_color_three]" id="wp_custom_admin_interface_color_scheme_color_three" type="text" value="<?php if(isset($options['wp_custom_admin_interface_color_scheme_color_three'])) { echo esc_attr($options['wp_custom_admin_interface_color_scheme_color_three']); } ?>" class="my-color-field" data-default-color="#0073aa" />    
      
        </td>
    </tr>
	<?php
}

function wp_custom_admin_interface_color_scheme_color_four_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_color_scheme_color_four"><?php _e('Color Scheme Color 4', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
        <input name="wp_custom_admin_interface_settings_AdminColorScheme[wp_custom_admin_interface_color_scheme_color_four]" id="wp_custom_admin_interface_color_scheme_color_four" type="text" value="<?php if(isset($options['wp_custom_admin_interface_color_scheme_color_four'])) { echo esc_attr($options['wp_custom_admin_interface_color_scheme_color_four']); } ?>" class="my-color-field" data-default-color="#00a0d2" />    
      
        </td>
    </tr>
	<?php
}





function wp_custom_admin_interface_color_scheme_icon_color_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_color_scheme_icon_color"><?php _e('SVG Icon Color', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input name="wp_custom_admin_interface_settings_AdminColorScheme[wp_custom_admin_interface_color_scheme_icon_color]" id="wp_custom_admin_interface_color_scheme_icon_color" type="text" value="<?php if(isset($options['wp_custom_admin_interface_color_scheme_icon_color'])) { echo esc_attr($options['wp_custom_admin_interface_color_scheme_icon_color']); } ?>" class="my-color-field" data-default-color="#f1f2f3" />

        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_force_color_scheme_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminColorScheme' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_force_color_scheme"><?php _e('Force the custom color scheme on all users', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('This will force the "Custom" color scheme on all users regardless of what color scheme they have chosen in their user profile.', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_force_color_scheme" name='wp_custom_admin_interface_settings_AdminColorScheme[wp_custom_admin_interface_force_color_scheme]' <?php checked( isset($options['wp_custom_admin_interface_force_color_scheme']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_disable_update_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_disable_update"><?php _e('Disable Automatic WordPress Updates', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_disable_update" name='wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_disable_update]' <?php checked( isset($options['wp_custom_admin_interface_disable_update']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}

function wp_custom_admin_interface_disable_gutenberg_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_disable_gutenberg"><?php _e('Disable Gutenberg Editor', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_disable_gutenberg" name='wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_disable_gutenberg]' <?php checked( isset($options['wp_custom_admin_interface_disable_gutenberg']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}




function wp_custom_admin_interface_top_level_menu_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminMenu' );
    global $submenu, $menu;
    global $wp_custom_admin_interface_original_top_level_menu, $wp_custom_admin_interface_original_sub_level_menu; 
    
    
    

    
    /*
        highlight_string("<?php\n\$data =\n" . var_export($menu, true) . ";\n?>");
    
    echo '<br></br><br></br>';
    
    
    highlight_string("<?php\n\$data =\n" . var_export($wp_custom_admin_interface_original_top_level_menu, true) . ";\n?>");
    
    
    */
    
    

    
	?>
    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'Modify the main menu of WordPress. <em>Please note if you are moving a sub-level menu item to the top level menu you may get the following error message when trying to access the page: "Sorry, you are not allowed to access this page." To get around this for the moment I recommend firstly restoring your menu back to the WordPress default and instead of moving the menu item, keep it where it is and hide it, and then create a new menu item on the top level that goes to the same link as the hidden child menu item.</em>', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            <div class="notice notice-warning inline" >
                <p><i class="fa fa-exclamation-triangle information-icon" aria-hidden="true"></i> <?php _e( 'This feature is a BETA feature. We do not provide support for this feature. If it works great, if it does not work, sorry.', 'wp-custom-admin-interface' ); ?></p>
            </div>   
            
        </td>
    </tr>




    <tr valign="top">
        <td scope="row" colspan="2">
            
            <div id="admin-menu-manager-buttons" style="margin-bottom: 30px;">
                <button id="add-separator" class="button-secondary" style="cursor:pointer;"><i class="fa fa-plus" aria-hidden="true"></i> <?php _e('Add separator', 'wp-custom-admin-interface' ); ?></button>
                
                <button id="add-menu-item" class="button-secondary" style="cursor:pointer;"><i class="fa fa-plus" aria-hidden="true"></i> <?php _e('Add menu item', 'wp-custom-admin-interface' ); ?></button>
                
                <?php
                
                $currentDomain = substr(get_admin_url(),0,-9);    
                
                $deleteCustomAdminSettingsSuffix = 'index.php?wp-custom-admin-interface=delete-menu';
                
                $emergencyUrl = $currentDomain.$deleteCustomAdminSettingsSuffix;
    
                ?>
                
                <button id="advanced-menu-functionality" data-clipboard-text="<?php echo $emergencyUrl; ?>" class="button-secondary" style="cursor:pointer;"><i class="fa fa-superpowers" aria-hidden="true"></i> <?php _e('Advanced functionality', 'wp-custom-admin-interface' ); ?></button>


                <button id="restore-default-menu" class="button-secondary" style="cursor:pointer;" menudata="<?php echo htmlentities(json_encode($wp_custom_admin_interface_original_top_level_menu)); ?>" submenudata="<?php echo htmlentities(json_encode($wp_custom_admin_interface_original_sub_level_menu)); ?>"><i class="fa fa-window-restore" aria-hidden="true"></i> <?php _e('Restore to default WordPress menu', 'wp-custom-admin-interface' ); ?></button>
                
                <button id="restore-last-save" class="button-secondary" style="cursor:pointer;" menudata="<?php echo stripslashes(htmlentities(substr(json_encode($options['wp_custom_admin_interface_top_level_menu']),1,-1))); ?>" submenudata="<?php echo stripslashes(htmlentities(substr(json_encode($options['wp_custom_admin_interface_sub_level_menu']),1,-1))); ?>" removeditems="<?php echo $options['wp_custom_admin_interface_remove_menu_item']; ?>"><i class="fa fa-window-restore" aria-hidden="true"></i> <?php _e('Restore to last save', 'wp-custom-admin-interface' ); ?></button>


                <?php
                //var_dump($wp_custom_admin_interface_original_top_level_menu);
                
                $savedTopLevelMenu = json_decode($options['wp_custom_admin_interface_top_level_menu']);
                $tempTopLevelMenu = array();

                foreach($savedTopLevelMenu as $menuItem){
                    array_push($tempTopLevelMenu,$menuItem[2]);   
                }

                $originalTopLevelMenu = $wp_custom_admin_interface_original_top_level_menu;

                foreach( $wp_custom_admin_interface_original_top_level_menu as $key => $value ){

                    if( in_array($value[2],$tempTopLevelMenu) || $value[4] == 'wp-menu-separator'){
                        //the item is in the array so we want to remove the key from the array
                        unset($originalTopLevelMenu[$key]);

                    }

                }

                //now lets get just the index from the array
                $uniqueIndexes = array();

                foreach($originalTopLevelMenu as $menuItem){
                    array_push($uniqueIndexes,$menuItem[2]);
                }

                // var_dump($uniqueIndexes);


                // var_dump($originalTopLevelMenu);
                $originalSubLevelMenu = $wp_custom_admin_interface_original_sub_level_menu;

                // var_dump($wp_custom_admin_interface_original_sub_level_menu);

                foreach( $wp_custom_admin_interface_original_sub_level_menu as $key=>$value ){
                    if(!in_array($key,$uniqueIndexes)){
                        //if the item is not in the array remove it
                        unset($originalSubLevelMenu[$key]);

                    }

                }

                // var_dump($originalSubLevelMenu);



                ?>


                <button id="add-newly-added-menu-items" class="button-secondary" style="cursor:pointer;" menudata="<?php echo htmlentities(json_encode($originalTopLevelMenu)); ?>" submenudata="<?php echo htmlentities(json_encode($originalSubLevelMenu)); ?>"><i class="fa fa-plus" aria-hidden="true"></i> <?php _e('Add newly added menu items', 'wp-custom-admin-interface' ); ?></button>


                
                
                <!--This one below line of code is used to correctly set and maintain the advanced/simple view funcationlity so it doesn't get tricked from the creation of new menus-->
                <div class="restricted-advanced-functionality"></div>

                 <?php $admin_role_set = get_role( 'administrator' )->capabilities;  
                    echo '<span style="display:none;" id="admin-capabilities">';
                    foreach ($admin_role_set as $key => $value) {
                        
                        echo $key.',';
                    }    
                    echo '</span>';
                ?>
                
                
                
            </div>
                
                
                
            <div style="display:none;" id="custom-icon-dialog" title="Choose a custom icon">
                
                <?php
                    //declare an array that holds all dashicon classes
                    $allDashIcons = array('dashicons-menu', 'dashicons-admin-site', 'dashicons-dashboard', 'dashicons-admin-post', 'dashicons-admin-media', 'dashicons-admin-links', 'dashicons-admin-page', 'dashicons-admin-comments', 'dashicons-admin-appearance', 'dashicons-admin-plugins', 'dashicons-admin-users', 'dashicons-admin-tools', 'dashicons-admin-settings', 'dashicons-admin-network', 'dashicons-admin-home', 'dashicons-admin-generic', 'dashicons-admin-collapse', 'dashicons-filter', 'dashicons-admin-customizer', 'dashicons-admin-multisite', 'dashicons-welcome-write-blog', 'dashicons-welcome-add-page', 'dashicons-welcome-view-site', 'dashicons-welcome-widgets-menus', 'dashicons-welcome-comments', 'dashicons-welcome-learn-more', 'dashicons-format-aside', 'dashicons-format-image', 'dashicons-format-gallery', 'dashicons-format-video', 'dashicons-format-status', 'dashicons-format-quote', 'dashicons-format-chat', 'dashicons-format-audio', 'dashicons-camera', 'dashicons-images-alt', 'dashicons-images-alt2', 'dashicons-video-alt', 'dashicons-video-alt2', 'dashicons-video-alt3', 'dashicons-media-archive', 'dashicons-media-audio', 'dashicons-media-code', 'dashicons-media-default', 'dashicons-media-document', 'dashicons-media-interactive', 'dashicons-media-spreadsheet', 'dashicons-media-text', 'dashicons-media-video', 'dashicons-playlist-audio', 'dashicons-playlist-video', 'dashicons-controls-play', 'dashicons-controls-pause', 'dashicons-controls-forward', 'dashicons-controls-skipforward', 'dashicons-controls-back', 'dashicons-controls-skipback', 'dashicons-controls-repeat', 'dashicons-controls-volumeon', 'dashicons-controls-volumeoff', 'dashicons-image-crop', 'dashicons-image-rotate', 'dashicons-image-rotate-left', 'dashicons-image-rotate-right', 'dashicons-image-flip-vertical', 'dashicons-image-flip-horizontal', 'dashicons-image-filter', 'dashicons-undo', 'dashicons-redo', 'dashicons-editor-bold', 'dashicons-editor-italic', 'dashicons-editor-ul', 'dashicons-editor-ol', 'dashicons-editor-quote', 'dashicons-editor-alignleft', 'dashicons-editor-aligncenter', 'dashicons-editor-alignright', 'dashicons-editor-insertmore', 'dashicons-editor-spellcheck', 'dashicons-editor-expand', 'dashicons-editor-contract', 'dashicons-editor-kitchensink', 'dashicons-editor-underline', 'dashicons-editor-justify', 'dashicons-editor-textcolor', 'dashicons-editor-paste-word', 'dashicons-editor-paste-text', 'dashicons-editor-removeformatting', 'dashicons-editor-video', 'dashicons-editor-customchar', 'dashicons-editor-outdent', 'dashicons-editor-indent', 'dashicons-editor-help', 'dashicons-editor-strikethrough', 'dashicons-editor-unlink', 'dashicons-editor-rtl', 'dashicons-editor-break', 'dashicons-editor-code', 'dashicons-editor-paragraph', 'dashicons-editor-table', 'dashicons-align-left', 'dashicons-align-right', 'dashicons-align-center', 'dashicons-align-none', 'dashicons-lock', 'dashicons-unlock', 'dashicons-calendar', 'dashicons-calendar-alt', 'dashicons-visibility', 'dashicons-hidden', 'dashicons-post-status', 'dashicons-edit', 'dashicons-trash', 'dashicons-sticky', 'dashicons-external', 'dashicons-arrow-up', 'dashicons-arrow-down', 'dashicons-arrow-right', 'dashicons-arrow-left', 'dashicons-arrow-up-alt', 'dashicons-arrow-down-alt', 'dashicons-arrow-right-alt', 'dashicons-arrow-left-alt', 'dashicons-arrow-up-alt2', 'dashicons-arrow-down-alt2', 'dashicons-arrow-right-alt2', 'dashicons-arrow-left-alt2', 'dashicons-sort', 'dashicons-leftright', 'dashicons-randomize', 'dashicons-list-view', 'dashicons-exerpt-view', 'dashicons-grid-view', 'dashicons-move', 'dashicons-share', 'dashicons-share-alt', 'dashicons-share-alt2', 'dashicons-twitter', 'dashicons-rss', 'dashicons-email', 'dashicons-email-alt', 'dashicons-facebook', 'dashicons-facebook-alt', 'dashicons-googleplus', 'dashicons-networking', 'dashicons-hammer', 'dashicons-art', 'dashicons-migrate', 'dashicons-performance', 'dashicons-universal-access', 'dashicons-universal-access-alt', 'dashicons-tickets', 'dashicons-nametag', 'dashicons-clipboard', 'dashicons-heart', 'dashicons-megaphone', 'dashicons-schedule', 'dashicons-wordpress', 'dashicons-wordpress-alt', 'dashicons-pressthis', 'dashicons-update', 'dashicons-screenoptions', 'dashicons-info', 'dashicons-cart', 'dashicons-feedback', 'dashicons-cloud', 'dashicons-translation', 'dashicons-tag', 'dashicons-category', 'dashicons-archive', 'dashicons-tagcloud', 'dashicons-text', 'dashicons-yes', 'dashicons-no', 'dashicons-no-alt', 'dashicons-plus', 'dashicons-plus-alt', 'dashicons-minus', 'dashicons-dismiss', 'dashicons-marker', 'dashicons-star-filled', 'dashicons-star-half', 'dashicons-star-empty', 'dashicons-flag', 'dashicons-warning', 'dashicons-location', 'dashicons-location-alt', 'dashicons-vault', 'dashicons-shield', 'dashicons-shield-alt', 'dashicons-sos', 'dashicons-search', 'dashicons-slides', 'dashicons-analytics', 'dashicons-chart-pie', 'dashicons-chart-bar', 'dashicons-chart-line', 'dashicons-chart-area', 'dashicons-groups', 'dashicons-businessman', 'dashicons-id', 'dashicons-id-alt', 'dashicons-products', 'dashicons-awards', 'dashicons-forms', 'dashicons-testimonial', 'dashicons-portfolio', 'dashicons-book', 'dashicons-book-alt', 'dashicons-download', 'dashicons-upload', 'dashicons-backup', 'dashicons-clock', 'dashicons-lightbulb', 'dashicons-microphone', 'dashicons-desktop', 'dashicons-laptop', 'dashicons-tablet', 'dashicons-smartphone', 'dashicons-phone', 'dashicons-index-card', 'dashicons-carrot', 'dashicons-building', 'dashicons-store', 'dashicons-album', 'dashicons-palmtree', 'dashicons-tickets-alt', 'dashicons-money', 'dashicons-smiley', 'dashicons-thumbs-up', 'dashicons-thumbs-down', 'dashicons-layout', 'dashicons-paperclip');
                    
                    //for each dash icon print it out
                    foreach ($allDashIcons as $icons){
                        echo '<span data="'.$icons.'" class="dashicons icon-for-selection dash-icons-for-selection '.$icons.'"></span>';       
                    }
                    
                    echo '<hr style="border-top: 2px solid #ddd; margin-bottom: 15px;">';
                    echo '<p>Custom Icons</p>';

                    // print out all custom svg icons
                    foreach($wp_custom_admin_interface_original_top_level_menu as $item => $value) {
                        //check if item isn't a separator
                        $separatorClassCheck = $value[4];
                        
                        if(strpos($separatorClassCheck,'wp-menu-separator') !== false){} else {
                            
                            $iconTypeCheck = $value[6];
                            
                            if(strpos($iconTypeCheck,'data:image/svg+xml') !== false || strpos($iconTypeCheck,'http') !== false ){
                                
                                echo '<span class="svg svg-menu-icon icon-for-selection svg-icons-for-selection" data="'.$iconTypeCheck.'" style="background-image: url(&quot;'.$iconTypeCheck.'&quot;);"></span>';    
                                
                            }
                            

                        }

                    }
    
                    echo '<hr style="border-top: 2px solid #ddd; margin-bottom: 15px; margin-top: 15px;">';
                    echo '<input type="button" name="upload-icon-btn" id="upload-icon-btn" class="button-secondary wp_custom_admin_interface_media_upload_button" value="Upload an icon">';

    
                    
                ?>
                
                
                
            </div>
            
            <ul id="admin-menu-manager"></ul>
            
            

        
        </td>
        
    </tr>







    <tr valign="top" style="display:none;">
        <td scope="row">
            <label for="wp_custom_admin_interface_top_level_menu">Top Level Menu</label>
        </td>
        <td>
            
        <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_AdminMenu[wp_custom_admin_interface_top_level_menu]" id="wp_custom_admin_interface_top_level_menu" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_top_level_menu'])) { echo esc_attr($options['wp_custom_admin_interface_top_level_menu']); } else {echo htmlentities(json_encode($menu));} ?>">
            
        
        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_sub_level_menu_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminMenu' );
    global $submenu, $menu;
	?>
    <tr valign="top" style="display:none;">
        <td scope="row">
            <label for="wp_custom_admin_interface_sub_level_menu">Sub Level Menu</label>
        </td>
        <td>
            
        <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_AdminMenu[wp_custom_admin_interface_sub_level_menu]" id="wp_custom_admin_interface_sub_level_menu" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_sub_level_menu'])) { echo esc_attr($options['wp_custom_admin_interface_sub_level_menu']); } else {echo htmlentities(json_encode($submenu));} ?>">
        
            
        </td>
    </tr>




	<?php
}




function wp_custom_admin_interface_remove_menu_item_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminMenu' );
	?>
    <tr valign="top" style="display:none;">
        <td scope="row">
            <label for="wp_custom_admin_interface_remove_menu_item">Menu items to remove</label>
        </td>

        <td>
            <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_AdminMenu[wp_custom_admin_interface_remove_menu_item]" id="wp_custom_admin_interface_remove_menu_item" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_remove_menu_item'])) { echo esc_attr($options['wp_custom_admin_interface_remove_menu_item']); } ?>">
        </td>
    </tr>
	<?php
}





function wp_custom_admin_interface_exception_type_render() { 
    
    echo wp_custom_admin_interface_exception_type_render_assist('wp_custom_admin_interface_exception_type','wp_custom_admin_interface_settings_AdminMenu');
     
}


function wp_custom_admin_interface_exception_cases_render() { 
	
    echo wp_custom_admin_interface_exception_cases_render_assist('wp_custom_admin_interface_exception_cases','wp_custom_admin_interface_settings_AdminMenu');
   
}


function wp_custom_admin_interface_show_notifications_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminMenu' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_show_notifications"><?php _e('Show notification icons on custom menu', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_show_notifications" name='wp_custom_admin_interface_settings_AdminMenu[wp_custom_admin_interface_show_notifications]' <?php checked( isset($options['wp_custom_admin_interface_show_notifications']), 1 ); ?> value='1'>
            
        </td>
    </tr>

	<?php
}






function wp_custom_admin_interface_hide_these_plugins_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_HidePlugins' );
	?>

    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'Hide these plugins from showing on the <a target="_blank" href="plugins.php">plugins page</a>.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>

    <tr valign="top">
        <td scope="row" colspan="2">
            <?php
    
    
            $all_plugins = get_plugins();

    
    echo '<a id="select-all-items" class="select-all-items" href="#">Select all</a> / <a id="deselect-all-items" class="deselect-all-items" href="#">Deselect all</a><br></br>';
    
    
    echo '<div id="plugins-manager">';
    
    foreach($all_plugins as $key => $val){
        
        $pluginPath = $key;
        $pluginName = $val['Name'];
        $pluginDescription = $val['Description'];
            
        echo '<li class="plugin-item"><div><i class="fa fa-eye-slash remove-plugin-item" title="Hide plugin" aria-hidden="true"></i><span id="plugin-name" style="font-weight: bold;" data="'.$pluginPath.'">'.$pluginName.' <i class="fa fa-info-circle information-icon" aria-hidden="true"></i><p style="font-weight: normal; padding-left: 0px;" class="hidden">'.$pluginDescription.'</p></span></div></li>';  
        
        
        
    }
    
    echo '</div>';
    

    
    ?>
            
        </td>
        
    </tr>    

    <tr valign="top" style="display:none;">
        <td scope="row">
            <label for="wp_custom_admin_interface_hide_these_plugins">Hide plugins</label>
        </td>

        <td>
            <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_HidePlugins[wp_custom_admin_interface_hide_these_plugins]" id="wp_custom_admin_interface_hide_these_plugins" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_hide_these_plugins'])) { echo esc_attr($options['wp_custom_admin_interface_hide_these_plugins']); } ?>">
        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_exception_type_plugin_render() { 
    
    echo wp_custom_admin_interface_exception_type_render_assist('wp_custom_admin_interface_exception_type_plugin','wp_custom_admin_interface_settings_HidePlugins');
     
}


function wp_custom_admin_interface_exception_cases_plugin_render() { 
    
    echo wp_custom_admin_interface_exception_cases_render_assist('wp_custom_admin_interface_exception_cases_plugin','wp_custom_admin_interface_settings_HidePlugins');
    
}









function wp_custom_admin_interface_hide_these_users_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_HideUsers' );
	?>
    
    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'Hide these users from showing on the <a target="_blank" href="users.php">users page</a>. Please note if you hide yourself you will still see yourself in the user listing, however other people won\'t be able to see you.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>
    
    <tr valign="top">
        <td scope="row" colspan="2">
            <?php

            /*  
            highlight_string("<?php\n\$data =\n" . var_export($wp_custom_admin_interface_original_user_listing, true) . ";\n?>");
            */
            
            global $wpdb;

            $sql = "
            SELECT {$wpdb->users}.ID
            FROM {$wpdb->users} 
            ";

            $wp_custom_admin_interface_original_user_listing = $wpdb->get_results($sql);
            
            echo '<a id="select-all-items" class="select-all-items" href="#">Select all</a> / <a id="deselect-all-items" class="deselect-all-items" href="#">Deselect all</a><br></br>';
    
    
            //echo out the container
            echo '<div id="user-manager">';
    
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
                
                
                
                echo '<li class="user-item"><div><i class="fa fa-eye-slash remove-user-item" title="Hide user" aria-hidden="true"></i><span id="user-name" style="font-weight: bold;" data="'.$userId.'">'.$userDisplayName.' <em style="font-weight: normal;">('.$userRole.')</em></span></div></li>';  

            }
            //end container
            echo '</div>';
    
         

            ?>
            
        </td>
        
    </tr>    

    <tr valign="top" style="display:none;">
        <td scope="row">
            <label for="wp_custom_admin_interface_hide_these_users">Hide users</label>
        </td>

        <td>
            <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_HideUsers[wp_custom_admin_interface_hide_these_users]" id="wp_custom_admin_interface_hide_these_users" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_hide_these_users'])) { echo esc_attr($options['wp_custom_admin_interface_hide_these_users']); } ?>">
        </td>
    </tr>
	<?php
}










function wp_custom_admin_interface_exception_type_user_render() { 
    
    echo wp_custom_admin_interface_exception_type_render_assist('wp_custom_admin_interface_exception_type_user','wp_custom_admin_interface_settings_HideUsers');
     
}


function wp_custom_admin_interface_exception_cases_user_render() { 
    
    echo wp_custom_admin_interface_exception_cases_render_assist('wp_custom_admin_interface_exception_cases_user','wp_custom_admin_interface_settings_HideUsers');
    
}










function wp_custom_admin_interface_hide_these_sidebars_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_HideSidebars' );
	?>
    
    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'Hide these sidebars from showing on the <a target="_blank" href="widgets.php">widgets page</a>.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>
    
    <tr valign="top">
        <td scope="row" colspan="2">
            <?php
            
            /*
            highlight_string("<?php\n\$data =\n" . var_export($wp_custom_admin_interface_original_user_listing, true) . ";\n?>");
            */
            
            global $wp_custom_admin_interface_original_sidebar_listing;

            echo '<a id="select-all-items" class="select-all-items" href="#">Select all</a> / <a id="deselect-all-items" class="deselect-all-items" href="#">Deselect all</a><br></br>';        
    
            //echo out the container
            echo '<div id="sidebar-manager">';
    
            foreach($wp_custom_admin_interface_original_sidebar_listing as $sidebar) {
                
                $sidebarName = $sidebar['name'];
                $sidebarDescription = $sidebar['description'];
                $sidebarID = $sidebar['id'];
            
                
                echo '<li class="sidebar-item"><div><i class="fa fa-eye-slash remove-sidebar-item" title="Hide sidebar" aria-hidden="true"></i><span id="sidebar-name" style="font-weight: bold;" data="'.$sidebarID.'">'.$sidebarName.' <em style="font-weight: normal;">('.$sidebarDescription.')</em></span></div></li>';  

            }
            //end container
            echo '</div>';
    

            ?>
            
        </td>
        
    </tr>    

    <tr valign="top" style="display:none;">
        <td scope="row">
            <label for="wp_custom_admin_interface_hide_these_sidebars">Hide sidebars</label>
        </td>

        <td>
            <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_HideSidebars[wp_custom_admin_interface_hide_these_sidebars]" id="wp_custom_admin_interface_hide_these_sidebars" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_hide_these_sidebars'])) { echo esc_attr($options['wp_custom_admin_interface_hide_these_sidebars']); } ?>">
        </td>
    </tr>
	<?php
}




function wp_custom_admin_interface_exception_type_sidebar_render() { 
    
    echo wp_custom_admin_interface_exception_type_render_assist('wp_custom_admin_interface_exception_type_sidebar','wp_custom_admin_interface_settings_HideSidebars');
     
}


function wp_custom_admin_interface_exception_cases_sidebar_render() { 
    
    echo wp_custom_admin_interface_exception_cases_render_assist('wp_custom_admin_interface_exception_cases_sidebar','wp_custom_admin_interface_settings_HideSidebars');
    
}


function wp_custom_admin_interface_exception_type_toolbar_render() { 
    
    echo wp_custom_admin_interface_exception_type_render_assist('wp_custom_admin_interface_exception_type_toolbar','wp_custom_admin_interface_settings_AdminToolbar');
     
}


function wp_custom_admin_interface_exception_cases_toolbar_render() { 
    
    echo wp_custom_admin_interface_exception_cases_render_assist('wp_custom_admin_interface_exception_cases_toolbar','wp_custom_admin_interface_settings_AdminToolbar');
    
}


function wp_custom_admin_interface_primary_toolbar_menu_render() { 
    
    global $wp_custom_admin_interface_all_toolbar_items;
    $options = get_option( 'wp_custom_admin_interface_settings_AdminToolbar' );
    ?>

    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'Modify the main toolbar of WordPress. This is the bar that displays at the top of the admin screen.', 'wp-custom-admin-interface' ); ?></p>
            </div>  
            <div class="notice notice-warning inline" >
                <p><i class="fa fa-exclamation-triangle information-icon" aria-hidden="true"></i> <?php _e( 'This feature is a BETA feature. We do not provide support for this feature. If it works great, if it does not work, sorry.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>
    
    <tr valign="top">
        <td scope="row" colspan="2">
   
            
            <div id="admin-toolbar-manager-buttons" style="margin-bottom: 30px;">
                
                

                
                <button id="add-node-item" class="button-secondary" style="cursor:pointer;"><i class="fa fa-plus" aria-hidden="true"></i> <?php _e('Add menu item', 'wp-custom-admin-interface' ); ?></button>
                                
                <button id="restore-default-toolbar" class="button-secondary" style="cursor:pointer;" toolbardata="<?php echo htmlentities(json_encode($wp_custom_admin_interface_all_toolbar_items)); ?>"><i class="fa fa-window-restore" aria-hidden="true"></i> <?php _e('Restore to default WordPress Toolbar', 'wp-custom-admin-interface' ); ?></button>

                
                <button id="restore-last-save-toolbar" class="button-secondary" style="cursor:pointer;" toolbardata="<?php echo htmlentities(json_encode($options['wp_custom_admin_interface_primary_toolbar_menu'])); ?>" removeditems="<?php echo $options['wp_custom_admin_interface_remove_toolbar_item']; ?>"><i class="fa fa-window-restore" aria-hidden="true"></i> <?php _e('Restore to last save', 'wp-custom-admin-interface' ); ?></button>
                
                
            </div>
            
            
            
            
            <ul id="toolbar-menu-manager"></ul>
            
            <em style="margin-top:45px; margin-bottom:-20px; display: block;">Note: menu items which have html tags in the title are used by WordPress to display dynamic content like a users name or the amount of comments etc. Therefore these items aren't editable. Unlike the 'Customize Admin Menu' feature of this plugin this 'Customize Toolbar' feature is more rigid and a little more difficult to make sense of. I recommend keeping the existing menu structure intact as much as possible and rather just hide items or add new items in around the existing menu structure.</em><br></br>
    

        </td>
    </tr>
    

    
    
    

    
    <tr valign="top" style="display:none;">    
        <td scope="row">
            <label for="wp_custom_admin_interface_primary_toolbar_menu">Primary Toolbar Menu</label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_AdminToolbar[wp_custom_admin_interface_primary_toolbar_menu]" id="wp_custom_admin_interface_primary_toolbar_menu" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_primary_toolbar_menu'])) { echo esc_attr($options['wp_custom_admin_interface_primary_toolbar_menu']); } else {echo htmlentities(json_encode($wp_custom_admin_interface_all_toolbar_items));} ?>">

   
        </td>
    </tr>
    
    <?php  
}





function wp_custom_admin_interface_disable_custom_toolbar_frontend_render() { 
    
    $options = get_option( 'wp_custom_admin_interface_settings_AdminToolbar' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_disable_custom_toolbar_frontend"><?php _e('Disable the custom toolbar on the frontend', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_disable_custom_toolbar_frontend" type='checkbox' id="wp_custom_admin_interface_disable_custom_toolbar_frontend" name='wp_custom_admin_interface_settings_AdminToolbar[wp_custom_admin_interface_disable_custom_toolbar_frontend]' <?php checked( isset($options['wp_custom_admin_interface_disable_custom_toolbar_frontend']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
    
}






function wp_custom_admin_interface_remove_toolbar_item_render() { 
    
    $options = get_option( 'wp_custom_admin_interface_settings_AdminToolbar' );
	?>
    <tr valign="top" style="display:none;">
        <td scope="row">
            <label for="wp_custom_admin_interface_remove_toolbar_item">Toolbar items to remove</label>
        </td>

        <td>
            <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_AdminToolbar[wp_custom_admin_interface_remove_toolbar_item]" id="wp_custom_admin_interface_remove_toolbar_item" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_remove_toolbar_item'])) { echo esc_attr($options['wp_custom_admin_interface_remove_toolbar_item']); } ?>">
        </td>
    </tr>
	<?php
    
}


function wp_custom_admin_interface_login_url_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_GeneralSettings' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_login_url"><?php _e('Login Logo URL', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('This is the link of the login logo. Please input the full URL including <code>http://</code>. To have no link simply input <code>#</code>.', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            
        <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_GeneralSettings[wp_custom_admin_interface_login_url]" id="wp_custom_admin_interface_custom_widget_title" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_login_url'])) { echo esc_attr($options['wp_custom_admin_interface_login_url']); } ?>">
            
            
        </td>
    </tr>
	<?php
}







function wp_custom_admin_interface_custom_frontend_css_code_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomCodeFrontend' );
	?>
    
    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'The custom code section enables you to implement custom code on the frontend of Wordpress.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>
    
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_frontend_css_code"><?php _e('Add custom CSS to the frontend of WordPress', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <textarea style="display:none;" cols="70" rows="30" name="wp_custom_admin_interface_settings_CustomCodeFrontend[wp_custom_admin_interface_custom_frontend_css_code]" id="wp_custom_admin_interface_custom_frontend_css_code"><?php if(isset($options['wp_custom_admin_interface_custom_frontend_css_code'])) { echo esc_attr($options['wp_custom_admin_interface_custom_frontend_css_code']); } ?></textarea>

        </td>
    </tr>
	<?php
}




function wp_custom_admin_interface_custom_frontend_javascript_code_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomCodeFrontend' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_custom_frontend_javascript_code"><?php _e('Add custom Javascript/jQuery to the frontend of WordPress', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('There\'s no need to put in the script tags and jQuery can be used like: ', 'wp-custom-admin-interface' ); ?><code><strong>$('body').show();</strong></code> </em></p>
        </td>
        <td>

            <textarea style="display:none;" cols="70" rows="30" name="wp_custom_admin_interface_settings_CustomCodeFrontend[wp_custom_admin_interface_custom_frontend_javascript_code]" id="wp_custom_admin_interface_custom_javascript_code"><?php if(isset($options['wp_custom_admin_interface_custom_frontend_javascript_code'])) { echo esc_attr($options['wp_custom_admin_interface_custom_frontend_javascript_code']); } ?></textarea>

        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_deactivate_frontend_code_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_CustomCodeFrontend' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_deactivate_frontend_code"><?php _e('Deactivate Custom Code on this Settings Tab', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_deactivate_frontend_code" name='wp_custom_admin_interface_settings_CustomCodeFrontend[wp_custom_admin_interface_deactivate_frontend_code]' <?php checked( isset($options['wp_custom_admin_interface_deactivate_frontend_code']), 1 ); ?> value='1'>
            
        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_hide_this_meta_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_HideMeta' );
    
    global $wpdb;
	?>
    
    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'This will hide meta boxes which are shown on different parts of WordPress.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>
    
    <tr valign="top">
        <td scope="row" colspan="2">

            <?php
            $args = array(
//               'public'   => true,
            );

            $output = 'names'; 

            $postTypesAndIds = '';
            
            $getPostTypes = get_post_types($args, $output);       
            
            
            foreach ($getPostTypes as $post_type) {
                
                $customPostTypesToIgnore = array('attachment','nav_menu_item','revision','custom_css','customize_changeset','shop_order_refund','shop_webhook','product_variation');
                
                if(!in_array($post_type,$customPostTypesToIgnore)){
                    

                    $results = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type = %s LIMIT 1", $post_type ), ARRAY_A );

                    foreach($results as $index => $post) {
                        $recent_post = $post['ID'];
                    }
                    
                    
                    if(isset($recent_post)){
                        $postTypesAndIds .= $post_type.'|'.$recent_post.',';    
                    }

                }
  
            }
            
            $removeLastComma = rtrim($postTypesAndIds,", ");
            
    
            echo '<a id="select-all-items" class="select-all-items" href="#">Select all</a> / <a id="deselect-all-items" class="deselect-all-items" href="#">Deselect all</a><br></br>';
    
            echo '<div id="post-types-and-ids" data="'.$removeLastComma.'"></div>';
    
            ?>
            
            
            
        </td>
    </tr>
    <tr valign="top" style="display:none;">
        <td scope="row">
            <label for="wp_custom_admin_interface_hide_this_meta"><?php _e('Hide this meta', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>
           
            <input class="wp_custom_admin_interface_settings_input" type="text" name="wp_custom_admin_interface_settings_HideMeta[wp_custom_admin_interface_hide_this_meta]" id="wp_custom_admin_interface_hide_this_meta" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_hide_this_meta'])) { echo esc_attr($options['wp_custom_admin_interface_hide_this_meta']); } ?>">
            
        </td>
    </tr>
	<?php
}


function wp_custom_admin_interface_exception_type_meta_render() { 
    
    echo wp_custom_admin_interface_exception_type_render_assist('wp_custom_admin_interface_exception_type_meta','wp_custom_admin_interface_settings_HideMeta');
     
}


function wp_custom_admin_interface_exception_cases_meta_render() { 
    
    echo wp_custom_admin_interface_exception_cases_render_assist('wp_custom_admin_interface_exception_cases_meta','wp_custom_admin_interface_settings_HideMeta');
    
}

function wp_custom_admin_interface_exception_type_notice_render() { 
    
    echo wp_custom_admin_interface_exception_type_render_assist('wp_custom_admin_interface_exception_type_notice','wp_custom_admin_interface_settings_AdminNotice');
     
}


function wp_custom_admin_interface_exception_cases_notice_render() { 
    
    echo wp_custom_admin_interface_exception_cases_render_assist('wp_custom_admin_interface_exception_cases_notice','wp_custom_admin_interface_settings_AdminNotice');
    
}

function wp_custom_admin_interface_notice_expiry_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminNotice' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_notice_expiry"><?php _e('Admin Notice End Date', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('Please leave blank to have no expiry.', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            <input class="wp_custom_admin_interface_settings_input datepicker" type="text" placeholder="YYYY-MM-DD" name="wp_custom_admin_interface_settings_AdminNotice[wp_custom_admin_interface_notice_expiry]" id="wp_custom_admin_interface_notice_expiry" class="regular-text" value="<?php if(isset($options['wp_custom_admin_interface_notice_expiry'])) { echo esc_attr($options['wp_custom_admin_interface_notice_expiry']); } ?>">
            
        </td>
    </tr>


	<?php
}


function wp_custom_admin_interface_notice_color_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminNotice' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_notice_color"><?php _e('Admin Notice Color', 'wp-custom-admin-interface' ); ?></label>
        </td>
        <td>

            <select name="wp_custom_admin_interface_settings_AdminNotice[wp_custom_admin_interface_notice_color]" id="wp_custom_admin_interface_notice_color">
                <option value="notice-success" <?php if($options['wp_custom_admin_interface_notice_color'] == 'notice-success'){echo 'selected="selected"';} ?>><?php _e('Green', 'wp-custom-admin-interface' ) ?></option>
                <option value="notice-info" <?php if($options['wp_custom_admin_interface_notice_color'] == 'notice-info'){echo 'selected="selected"';} ?>><?php _e('Blue', 'wp-custom-admin-interface' ) ?></option>
                <option value="notice-warning" <?php if($options['wp_custom_admin_interface_notice_color'] == 'notice-warning'){echo 'selected="selected"';} ?>><?php _e('Yellow', 'wp-custom-admin-interface' ) ?></option>
                <option value="notice-error" <?php if($options['wp_custom_admin_interface_notice_color'] == 'notice-error'){echo 'selected="selected"';} ?>><?php _e('Red', 'wp-custom-admin-interface' ) ?></option>
            </select>

        </td>
    </tr>
	<?php
}



function wp_custom_admin_interface_notice_message_render() { 
	$options = get_option('wp_custom_admin_interface_settings_AdminNotice');
	?>

    <tr valign="top">
        <td scope="row" colspan="2">
            <div class="notice notice-info inline" >
                <p><i class="fa fa-info-circle information-icon" aria-hidden="true"></i> <?php _e( 'The admin notice creates a custom message that displays at the top of all admin pages.', 'wp-custom-admin-interface' ); ?></p>
            </div>    
            
        </td>
    </tr>

    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_notice_message"><?php _e('Notice Content', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('Please feel free to use shortcodes to add dynamic content.', 'wp-custom-admin-interface' ); ?></em></p>

        </td>
        <td>
            
            <?php 
            
            wp_custom_admin_interface_shortcode_output('notice_text');
    
            if(isset($options['wp_custom_admin_interface_notice_message'])){    
                wp_editor(html_entity_decode(stripslashes($options['wp_custom_admin_interface_notice_message'])), "wp_custom_admin_interface_notice_message", $settings = array(
                'wpautop' => false,
                'textarea_name' => "wp_custom_admin_interface_settings_AdminNotice[wp_custom_admin_interface_notice_message]",
                'drag_drop_upload' => true,
                'textarea_rows' => 30, 
                ));    
            } else {
                wp_editor("", "wp_custom_admin_interface_notice_message", $settings = array(
                'wpautop' => false,
                'textarea_name' => "wp_custom_admin_interface_settings_AdminNotice[wp_custom_admin_interface_notice_message]",
                'drag_drop_upload' => true,
                'textarea_rows' => 30,
                ));         
            }
        
            ?>

        </td>
    </tr>
	<?php
}

function wp_custom_admin_interface_notice_dismissible_render() { 
	$options = get_option( 'wp_custom_admin_interface_settings_AdminNotice' );
	?>
    <tr valign="top">
        <td scope="row">
            <label for="wp_custom_admin_interface_notice_dismissible"><?php _e('Make Notice Dismissable', 'wp-custom-admin-interface' ); ?></label> <i class="fa fa-info-circle information-icon" aria-hidden="true"></i>
            <p class="hidden"><em><?php _e('By checking this box a close icon will appear in the top right hand corner of the admin message. When a user clicks on this icon the message will no longer appear. Please note, whenever settings on this page are updated this dismiss history for each user will be erased and the message will reappear again for the user.', 'wp-custom-admin-interface' ); ?></em></p>
        </td>
        <td>
            
            <input class="wp_custom_admin_interface_settings_checkbox" type='checkbox' id="wp_custom_admin_interface_notice_dismissible" name='wp_custom_admin_interface_settings_AdminNotice[wp_custom_admin_interface_notice_dismissible]' <?php checked( isset($options['wp_custom_admin_interface_notice_dismissible']), 1 ); ?> value='1'>
            
        </td>
    </tr>

    <tr valign="top">
        <td scope="row" colspan="2">
            <br></br>
        </td>
    </tr>
	<?php
}






?>