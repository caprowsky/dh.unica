<?php
/*
 functions to manage admin panel
*/


function WPxdamsBridge_config_page(){
 
global $archivesConfig; 
$configurationAlreadySaved = get_option('WPxdamsBridge_setting_saved' );   /////xxxx
	
	

  if (function_exists('add_options_page'))
	{
        $main_menu_entry        = basename(__FILE__);                             
        $main_menu_entry        = 'WPxdamsBridge_main';    
        
        add_menu_page		('WP to xDams Bridge Menu', 
                                'WP to xDams Bridge',
                                'manage_options',
                                $main_menu_entry,
                                'WPxdamsBridge_general_settings',
                                '../wp-content/plugins/WPxdamsBridge/WPxdams_templates/img/iconXd.png');
						
	add_submenu_page	('WPxdamsBridge_admin.php', 
                                'WP to xDams Bridge Settings', 
				'General Settings', 
                                'manage_options',
                                $main_menu_entry,
                                'WPxdamsBridge_general_settings');	
						
	
	$archivesConfig 	= WPxdamsBridge_get_archives_config();
      
	$count 			= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];

        if ($configurationAlreadySaved=='yes') {
            $parentPage		= $main_menu_entry;		
            $parentPage2	= $main_menu_entry;	
            $parentPage3	= 'WPxdamsBridge_languages_general@';	
            $archiveSlug3       = 'WPxdamsBridge_languages_general@';
            
            
            add_submenu_page    ( $main_menu_entry, 
                                  'Translate your Terms', 
                                  'Languages', 
                                   'manage_options',
                                  'WPxdamsBridge_languages_general@', 
                                  'WPxdamsBridge_configure_languages');
            
            add_submenu_page	( $main_menu_entry, 
				 'WP to xDams Bridge Settings', 
				 'Create Tree', 
				 'manage_options',
				 'WPxdamsBridge_create_tree_list',
				 'WPxdamsBridge_create_tree_list');
        

            for($i=0;$i<$count;$i++) 
		{	
		$archiveId 	= $archivesConfig ['father'][$i];
		$archLevelId	= $archivesConfig ['id'][$i];
		$archiveLabel	= $archivesConfig ['fatherDesc'][$i];
		$archLevelLabel	= $archivesConfig ['label'][$i];
		$archiveSlug	= 'WPxdamsBridge_configure_archive_settings_'.$archiveId;
		$archiveSlug2	= 'WPxdamsBridge_configure_output_fields_'.$archLevelId.'@'.$archiveId;
                $archiveSlug3	= 'WPxdamsBridge_languages_'.$archiveId;;
		$archiveSlug4	= 'WPxdamsBridge_createtree_'.$archiveId;
	
		add_submenu_page($parentPage, 
						'Configure your Archives Settins', 
						'Archives Settings', 
						'manage_options',
						$archiveSlug, 
						'WPxdamsBridge_configure_archive_settings');	
		add_submenu_page($parentPage2, 
						'Configure your Archive Output Fields', 
						'Output Fields', 
						'manage_options',
						$archiveSlug2, 
						'WPxdamsBridge_configure_output_fields');
                add_submenu_page($parentPage3, 
						'Translate your Terms', 
						'Languages', 
						'manage_options',
						$archiveSlug3, 
						'WPxdamsBridge_configure_languages');
                add_submenu_page('WPxdamsBridge_create_tree_list', 
						'Create Tree Index', 
						'Tree', 
						'manage_options',
						$archiveSlug4, 
						'WPxdamsBridge_create_tree');	
   
	//  page more than the first are subpage
	
                if ($i == 0) { 
                    $parentPage     = $archiveSlug;  
                    $parentPage2    = $archiveSlug2;
                                          
		}				
					
            }
   
        $parentPage             = $main_menu_entry;
        for($i=1;$i<=3;$i++)       
		{	
		        switch($i){
					case 3:
						$suffisso= 'import_settings';
						$functionTocall = 'WPxdamsBridge_import_settings';
						$functionTitle = 'Import Saved Settings';
					break;					
					case 2:
						$suffisso= 'export_settings';
						$functionTocall = 'WPxdamsBridge_export_settings';
						$functionTitle = 'Export Saved Settings';
					break;
					default:
						$suffisso= 'import_from_config';
						$functionTocall = 'WPxdamsBridge_import_archives';
						$functionTitle = 'Import Config File';
					break;
				}
                $archiveSlug 	= 'WPxdamsBridge_'.$suffisso;	
				add_submenu_page($parentPage, 
						$functionTitle , 
						'Import / Export', 
						'manage_options',
						$archiveSlug, 
						$functionTocall);
		if ($i == 1) { 
                    $parentPage = $archiveSlug;  					
		}				
            }
        }       
    }
    
}

/*This function show the general settings config page in WP control panel*/

function WPxdamsBridge_general_settings(){

	global $archivesConfig;
	include ('WPxdamsBridge_general_settings.php'); ;
}

add_action('admin_menu', 'WPxdamsBridge_config_page');

function WPxdamsBridge_create_tree_list(){

	global $archivesConfig;
	include ('WPxdamsBridge_create_tree_list.php'); ;
}

function WPxdamsBridge_create_tree(){

	global $archivesConfig;
	include ('WPxdamsBridge_create_tree.php'); ;
}
 
function WPxdamsBridge_stories(){

	global $archivesConfig;

	include ('WPxdamsBridge_stories.php'); ;
}

function WPxdamsBridge_import_archives(){

	global $archivesConfig;

	include ('WPxdamsBridge_import_archives.php'); ;
}

function WPxdamsBridge_import_settings(){

	global $archivesConfig;

	include ('WPxdamsBridge_import_settings.php'); ;
}

function WPxdamsBridge_export_settings(){

	global $archivesConfig;

	include ('WPxdamsBridge_export_settings.php'); ;
}

function WPxdamsBridge_configure_archive_settings(){

	global $archivesConfig; 
	include ('WPxdamsBridge_search_form_fields.php'); 
	
}
function WPxdamsBridge_configure_languages(){

	global $archivesConfig; 
	include ('WPxdamsBridge_languages.php'); 
	
}

function WPxdamsBridge_configure_output_fields(){

	global $archivesConfig; 
        
	include ('WPxdamsBridge_output_fields_config.php'); 
	
}
// to record new settings (general settings and fields form

function update_WPxdamsBridge_settings(){  // nooo???'
   global $archivesConfig;
   
   if (!$archivesConfig){
      $archivesConfig 	= WPxdamsBridge_get_archives_config();    
   }
      
    $main_menu_entry        = 'WPxdamsBridge_main';  

 
// actions after form submit of general settings page
    if( ($_POST['WPxdamsBridge_submit_button'] == 'Update Settings') or
        ($_POST['WPxdamsBridge_submit_buttonB'] == 'Only Update') or     
        ($_POST['WPxdamsBridge_submit_button'] == 'Import and Update')){
   
    
        $language       = $_POST['c_xdamsmainlanguage_WPxdamsBridge'];
        update_option('WPxdamsBridge_mainLanguage',$language);
  
        if($_POST['WPxdamsBridge_submit_buttonB'] == 'Only Update') {
        update_option('WPxdamsBridge_setting_saved'             ,'yes');   // if this a change from an older version of plugin
        }

	// da qui elimino?
        $newsetting =	'noFlag' . '%%%' . 
					$_POST['c_xdamsurl_WPxdamsBridge'].'%%%' .
					$_POST['c_xdamspsw_WPxdamsBridge'] .'%%%' . 
					'end';
	//  fin qui?

        $count2		= $_POST['c_xdamsnum_WPxdamsBridge'] ; // number of archives
	
        for($i=0;$i<$count2;$i++) {  //prepare link to configure search and to set url and password 
              
                $optionname         = $_POST['c_xdamsid_WPxdamsBridge'.$i] ;
                $newsetting         = $_POST['c_xdamsurl_WPxdamsBridge'.$i] ;
		$archiveId          = $_POST['c_xdamsid_WPxdamsBridge'.$i] ;
                $optiondes          = $_POST['c_xdamsdes_WPxdamsBridge'.$i] ;
                $archiveIdList      = $archiveIdList.$archiveId.'%%%';
                
                $archiveDesList     = $archiveDesList.$optiondes.'%%%' ;
		update_option('WPxdamsBridge_url_'.$optionname,$newsetting);   
		$newsetting         = $_POST['c_xdamspsw_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_psw_'.$optionname,$newsetting);   //verificare di eliminare questa opzione
		$newsetting         = $_POST['c_xdamsxOut_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_xOut_'.$optionname,$newsetting);   
		$archivexOutList    = $archivexOutList.$newsetting  .'%%%' ;
		$newsetting         = $_POST['c_xdamsmedia_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_media_'.$optionname,$newsetting);   
                $newsetting         = $_POST['c_xdamsattachments_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_attachments_'.$optionname,$newsetting); 
                
                if ($_POST['c_xdamsupdateconfig_WPxdamsBridge']=='yes' && ($_POST['WPxdamsBridge_submit_button'] == 'Import and Update')){
                    if ($_POST['c_xdamsmediafiles_WPxdamsBridge'.$i]) {
                        $temp       = explode('%%%', $_POST['c_xdamsmediafiles_WPxdamsBridge'.$i]);
                        $countB     = count($temp)/2;
                        for($i4=0;$i4<$countB-1;$i4++) { 
                            update_option('WPxdamsBridge_media_fields_'.$temp[$i4*2],$temp[($i4*2)+1] );
                        }
                    }
                    if ($_POST['c_xdamsvideofiles_WPxdamsBridge'.$i]) {
                        $temp       = explode('%%%', $_POST['c_xdamsvideofiles_WPxdamsBridge'.$i]);
                        $countB     = count($temp)/2;
                        for($i4=0;$i4<$countB-1;$i4++) { 
                            update_option('WPxdamsBridge_video_fields_'.$temp[$i4*2],$temp[($i4*2)+1] );
                        }
                    }                    
                      update_option('WPxdamsBridge_active_'.$archiveId,1);
                    WPxdamsBridge_importSearchFieldInDB ($archiveId);  // the first time it pre-save the configuration                  
                }
        }
        
        update_option('WPxdamsBridge_archives_id',$archiveIdList); 
        update_option('WPxdamsBridge_archives_des',$archiveDesList); 
        update_option('WPxdamsBridge_archives_xOut',$archivexOutList);      
        
        
        if ($_POST['c_xdamsupdateconfig_WPxdamsBridge']=='yes' && ($_POST['WPxdamsBridge_submit_button'] == 'Import and Update')){
            
            WPxdamsBridge_importOutpuFieldsInDB ($_POST['c_xdamsitemfather_WPxdamsBridge'], $_POST['c_xdamsitems_WPxdamsBridge'], $_POST['c_xdamsitemfiles_WPxdamsBridge']);
            update_option('WPxdamsBridge_setting_saved'             ,$_POST['c_xdamsupdateconfig_WPxdamsBridge']);   
            update_option('WPxdamsBridge_archives_items'            ,$_POST['c_xdamsitems_WPxdamsBridge']); 
            update_option('WPxdamsBridge_archives_itemFather'       ,$_POST['c_xdamsitemfather_WPxdamsBridge']); 
            update_option('WPxdamsBridge_archives_itemLabel'        ,$_POST['c_xdamsitemlabel_WPxdamsBridge']); 
            update_option('WPxdamsBridge_archives_itemFiles'        ,$_POST['c_xdamsitemfiles_WPxdamsBridge']); 
        }
        
        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page='. $main_menu_entry .'&updated=true'); 	
    }
  
//***************************************************************************   
// actions after form submit of SEARCH FORM PAGE NOW ARCHIVE SETTINGs    ****
//***************************************************************************  
    
    if( ($_POST['WPxdamsBridge_submit_button2'] == 'Update Settings') or
        ($_POST['WPxdamsBridge_submit_button2b'] == 'Update and Add')   ){
      
        $archiveId = WPxdamsBridge_execute_searchOptionUpdate();
        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_configure_archive_settings_'.$archiveId); 
    }
 
 //************************************************************************ 
 // actions after form submit of OUTPUT FIELD PAGE  ***********************
 // ***********************************************************************   
 
   if ( ($_POST['WPxdamsBridge_submit_button3'] == 'Update Settings') or
        ($_POST['WPxdamsBridge_submit_button3B'] == 'Update and Add') ) {
       
        $archiveLevId=WPxdamsBridge_execute_outputFieldUpdate();

        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_configure_output_fields_'.$archiveLevId); 
  } 

 //************************************************************************ 
 // actions after form submit of a story (obsolte)  ***********************
 // ***********************************************************************  
        
   if($_POST['WPxdamsBridge_submit_button4'] == 'Update Settings'){
        $count          		= $_POST['c_fieldsNumber_WPxdamsBridge'];
	$storyID  			= $_POST['c_storyID_WPxdamsBridge'];
	$backgroundImgUrl               = $_POST['c_backgroundImgUrl_WPxdamsBridge'];
        $storyTitle                     = $_POST['c_storyTitle_WPxdamsBridge'];
	$storiesNumber   		= $_POST['c_storyNumber_WPxdamsBridge'];
	update_option('WPxdamsBridge_backgroundImgUrl_'.$storyID,$backgroundImgUrl);
	update_option('WPxdamsBridge_stories_number',$storiesNumber);
        update_option('WPxdamsBridge_story_fieldsNumber_'.$storyID ,$count);
        update_option('WPxdamsBridge_storyTitle_'.$storyID ,$storyTitle);   
	$itemID           		= $_POST[ 'c_itemID_WPxdamsBridge'];
        $url           			= $_POST[ 'c_imgUrl_WPxdamsBridge'];
        $des           			= $_POST['c_fieldCustom_WPxdamsBridge'];
        $archId           		= $_POST['c_imgArchID_WPxdamsBridge'];	
	for($i=1;$i<$count+1;$i++) {
            $field_options = $itemID[$i].'%%%'.$des[$i].'%%%'.$archId[$i].'%%%'. $url[$i]  ;
            update_option('WPxdamsBridge_story_'.$storyID.'_'.$i,$field_options);
	}

    header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_stories_'.$storyID); 
  }
  
 //************************************************************************ 
 // actions after form submit of EXPORT  **********************************
 // ***********************************************************************  
  
if($_POST['WPxdamsBridge_submit_button_export'] == 'Export'){

    $nomefile = '../wp-content/plugins/'. $_POST['c_xdams_exportFileName'];
    WPxdamsBridge_exportDBsettings($nomefile);
    header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_import_from_config');  
}

 //************************************************************************ 
 // actions after form submit of IMPORT  **********************************
 // ***********************************************************************  
   
if($_POST['WPxdamsBridge_submit_button_import2'] == 'Import'){
               
	$fileName       =  $_POST['c_xdams_importFileName'];
        $result         = WPxdamsBridge_loadSettings ($fileName);
        $count          =  $result['results_number'][0];
        for($i2=0;$i2<$count;$i2++) {        
              update_option( $result['option_name'][$i2], $result['option_value'][$i2]);
        }
    header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_import_from_config'); 
}  

 //************************************************************************ 
 // actions after form submit ADD LANGUAGE ********************************
 // ***********************************************************************  

if($_POST['WPxdamsBridge_submit_buttonADDLANG'] == 'ADD A NEW LANGUAGE'){
        update_option('WPxdamsBridge_last_executed',5);
        $count          		= $_POST['c_languagesNumber_WPxdamsBridge'];
        $archId           		= $_POST['c_archiveId_WPxdamsBridge'];
        $count          		= $count + 1;
        $colsNumberOption               = WPxdamsBridge_get_option('langs', $archId);
        $colsNumberOption               = $colsNumberOption."lang_".$count.'%%%';
	update_option('WPxdamsBridge_languages_'.$archId, $colsNumberOption );
        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_languages_'.$archId ); 
}
  
if($_POST['WPxdamsBridge_submit_buttonSAVELANG'] == 'Update Settings'){
        update_option('WPxdamsBridge_last_executed',6);
 
        $langsNumber          		= $_POST['c_languagesNumber_WPxdamsBridge'];
        $archId           		= $_POST['c_archiveId_WPxdamsBridge'];
        $fieldsNumber          		= $_POST['c_fieldsNumber_WPxdamsBridge'];
        $langId          		= $_POST['c_language_WPxdamsBridge'];
        $inFields                       = $_POST['c_langfield_WPxdamsBridge'];
        $inValues2                      = $_POST['c_mainvalue_WPxdamsBridge'];
        $inValues                       = $_POST['c_langvalue_WPxdamsBridge'];

        for($i=0;$i<$langsNumber;$i++) {
            
            if (!$langId[$i]){
                $langId[$i]             = $i;
            }
            $fp = fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_custom/languages/'.$archId.'_lang_'.$langId[$i].'.properties', 'w');
            
            fwrite($fp,'# lang_'.$langId[$i]);
            fwrite($fp,"\n"); 
            $EmptyFile    = 0;
            
            for($i2=0;$i2<$fieldsNumber;$i2++) { 
                $value                  = $inValues[$i2][$i];
                $field                  = $inFields [$i2];
                if ($value ) {
                    $EmptyFile          = 1;
                    fwrite($fp,$field.'='.$value);
                    fwrite($fp,"\n");
                } else{
                    continue;
                } 
            }
            fclose($fp);
            if ( $EmptyFile    == 0 ){
               unlink('../wp-content/plugins/WPxdamsBridge/WPxdams_custom/languages/'.$archId.'_lang_'.$langId[$i].'.properties') ;
            } else {
               $langOption     = $langOption.$langId[$i]. '%%%'; // unsed?
            }
	}
            
        // update general terms

        
        update_option('WPxdamsBridge_languages_'.$archId, $langOption  );
        
        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_languages_'.$archId ); 
  }
 // ********************************************************************************************************** 
 // actions after form submit of import page *****************************************************************
 // ********************************************************************************************************** 
    if(($_POST['WPxdamsBridge_submit_button_import'] == 'Import') ){
 
        $ok=WPxdamsBridge_execute_archivesImport();    
        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page='. $main_menu_entry .'&updated=true'); 
    }
    

 // ***********************************************************************
 // actions after form submit create tree  (*************)import option) **
 // ***********************************************************************  
   
if($_POST['WPxdamsBridge_submit_tree_import'] == 'Save Tree Import Settings'){
               
        $count          		= $_POST['c_fieldsNumber_WPxdamsBridge'];	
	//$itemID           		= $_POST['c_fieldIndex_WPxdamsBridge'];
    //    $level                          = $_POST['c_levelIndex_WPxdamsBridge'];    
        $archId           		= $_POST['c_archiveId_WPxdamsBridge'];	
        $itemsNum           		= $_POST['c_itemsNum_WPxdamsBridge'];	
        $queryNum           		= $_POST['c_queryNum_WPxdamsBridge'];
        $perPage           		= $_POST['c_perPage_WPxdamsBridge'];
        
        if ( ($queryNum) && ( $itemsNum>($queryNum*$perPage) ) ) {
            $addtorequest               = '&querynum='.($queryNum +1)  ;
        }
        
        for($i=1;$i<=$count;$i++) {
            $itemID           		= $_POST['c_fieldIndex_WPxdamsBridge_'.$i];
            $level                      = $_POST['c_levelIndex_WPxdamsBridge_'.$i]; 
            $field_options              =  $field_options. $level.'%%%'.$itemID .'%%%' ; 
            $inputFields ['hierTitle'][$level]= $itemID ;
	}
        update_option('WPxdamsBridge_tree_'.$archId,$field_options);
        $xdamsURL 			= WPxdamsBridge_get_option('url',$archId);
        $inputFields ['remotefile']     = $xdamsURL ; 
        $inputFields ['itemsNum']       = $itemsNum ; 
        $inputFields ['queryNum']       = $queryNum ; 
        $inputFields ['perPage']        = $perPage ; 
       // WPxdamsBridge_import_xdams_records($inputFields, $archId);
        
    header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_createtree_'. $archId.'&showrecords=yes'.$addtorequest); 
}

 // ***********************************************************************
 // actions after form submit create tree  (*************)import option) **
 // ***********************************************************************  
   
if($_POST['WPxdamsBridge_submit_tree_show'] == 'show already imported records'){
                   
        $archId           		= $_POST['c_archiveId_WPxdamsBridge'];	       
        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_create_tree_'. $archId.'&showrecords=yes'); 
}

  
}

add_action('init', 'update_WPxdamsBridge_settings', 9999);

function WPxdamsBridge_execute_outputFieldUpdate(){
  
        $archiveLevId       = $_POST['c_archiveLevId_WPxdamsBridge'];
	$archiveMedia       = $_POST['c_archiveMedia_WPxdamsBridge'];
	$archiveVideo       = $_POST['c_archiveVideo_WPxdamsBridge'];
	$count              = $_POST['c_fieldsNumber_WPxdamsBridge'];
        $titlePre           = $_POST['c_titlePre_WPxdamsBridge'];
        $titlePost          = $_POST['c_titlePost_WPxdamsBridge'];
        $descPre            = $_POST['c_descPre_WPxdamsBridge'];
        $descPost           = $_POST['c_descPost_WPxdamsBridge']; 
        $descSeparator      = $_POST['c_descSeparator_WPxdamsBridge']; 
        $groupEnd           = $_POST['c_groupEnd_WPxdamsBridge']; 
        
        if ($_POST['WPxdamsBridge_submit_button3B'] == 'Update and Add'){
            $count          = $count + 1;
        } 
	
	if ($archiveMedia) { 
		update_option('WPxdamsBridge_media_fields_'.$archiveLevId,$archiveMedia);
	};
	if ($archiveVideo) { 
		update_option('WPxdamsBridge_video_fields_'.$archiveLevId,$archiveVideo);
	};	
        
	$test_check         = $_POST['c_field_check_WPxdamsBridge'];
        $test_clean         = $_POST['c_field_clean_WPxdamsBridge'];
        $test_delete        = $_POST['c_field_delete_WPxdamsBridge'];
	$field_name         = $_POST['c_fieldName_WPxdamsBridge'];
	$field_label        = $_POST['c_fieldDesc_WPxdamsBridge'];
	$field_custom       = $_POST['c_fieldCustom_WPxdamsBridge'];
        $originalRow        = $_POST['c_fileRow_WPxdamsBridge'];
        $archiveLevel       = explode('@',$archiveLevId);
        $archiveConfFile    = WPxdamsBridge_get_archivesItem_file($archiveLevId);  
	
	for($i=0;$i<$count;$i++) {	    
            
            if ($field_custom[$i]){ 
		$custom_field_label = $field_custom[$i];             
            } else {
		$custom_field_label = $field_label[$i];
            }
            if (!$field_label[$i]){     //  row added by backoffice
		$field_label[$i] = $field_custom[$i];             
            } 
	    if ($test_check[$i]){ 
		$active_yes_no= 1;             
            } else {
		$active_yes_no= 0;
            }
            if ($test_clean[$i]){ 
		$clean_yes_no= 1;             
            } else {
		$clean_yes_no= 0;
            }
            if ($test_delete[$i]){ 
		$deletedFields = $deletedFields + 1 ;             
            } else {
                $label_options          = $label_options    . $field_label[$i].'%%%';  // new i ntroduced options
                $titlePre_options       = $titlePre_options . str_replace('"', ".@@.", $titlePre[$i]).'%%%'  ;       
                $titlePost_options      = $titlePost_options. str_replace('"', ".@@.",$titlePost[$i]).'%%%'   ;  
                $descPre_options        = $descPre_options  .str_replace('"', ".@@.", $descPre[$i]).'%%%'  ;       
                $descPost_options       = $descPost_options . str_replace('"', ".@@.",$descPost[$i]).'%%%'   ; 
                $descSeparator_options  = $descSeparator_options . $descSeparator[$i].'%%%'   ;
                $groupEnd_options       = $groupEnd_options . $groupEnd[$i].'%%%'   ;
                $clean_options          = $clean_options . $clean_yes_no.'%%%'   ; 
                
                $field_options          = $field_options. $field_name[$i].'%%%';   //first set of options
		$field_options          = $field_options. $field_custom [$i].'%%%' .$active_yes_no  .'%%%';

            }
                        // reverse string managing from the page - eliminated
            $originalRow[$i]            = str_replace('£$%&', '<',  $originalRow[$i]);
            $originalRow[$i]            = str_replace('&%$£', '>',  $originalRow[$i]);
            $originalRow[$i]            = str_replace('-&-%-', '"', $originalRow[$i]);   
	}

	update_option('WPxdamsBridge_out_fields_num_'.$archiveLevId,$count - $deletedFields);
        update_option('WPxdamsBridge_output_fields_'.$archiveLevId,$field_options);
        update_option('WPxdamsBridge_output_labels_'.$archiveLevId,$label_options);
        update_option('WPxdamsBridge_output_titlePre_'.$archiveLevId,$titlePre_options);
        update_option('WPxdamsBridge_output_titlePost_'.$archiveLevId,$titlePost_options);
        update_option('WPxdamsBridge_output_descPre_'.$archiveLevId,$descPre_options);
        update_option('WPxdamsBridge_output_descPost_'.$archiveLevId,$descPost_options);
        update_option('WPxdamsBridge_output_descSeparator_'.$archiveLevId,$descSeparator_options);
        update_option('WPxdamsBridge_output_groupEnd_'.$archiveLevId,$groupEnd_options);
        update_option('WPxdamsBridge_output_clean_'.$archiveLevId,$clean_options );
        
        
        return $archiveLevId;
}

function WPxdamsBridge_execute_searchOptionUpdate(){  
	  
        $archiveId		= $_POST['c_archiveId_WPxdamsBridge'];
	$count 			= $_POST['c_fieldsNumber_WPxdamsBridge'];
	$customForm		= $_POST['c_xdamsfrm_WPxdamsBridge'];
	$customPage		= $_POST['c_xdamspage_WPxdamsBridge'];
        $customListPage         = $_POST['c_xdamslistpage_WPxdamsBridge'];
        $customImgListPage	= $_POST['c_xdamsimglistpage_WPxdamsBridge'];
        $customAllListPage	= $_POST['c_xdamsalllistpage_WPxdamsBridge'];
	$activeFlag		= $_POST['c_active'];
        $allRecordsFlag		= $_POST['c_allRecords'];
        $previewFlag		= $_POST['c_preview'];
        $preview2Flag		= $_POST['c_preview2'];
        $preview3Flag		= $_POST['c_preview3'];
        $HierDesc		= $_POST['c_xdams_hier_desc'];
        $HierDescPre		= $_POST['c_xdams_hier_desc_pre'];
        $HierDescPost		= $_POST['c_xdams_hier_desc_post'];
        $HierDescPrefix		= $_POST['c_xdams_hier_prefix'];
        $HierDelimiter1		= $_POST['c_xdams_hier_delimiter1'];
        $HierDelimiter2		= $_POST['c_xdams_hier_delimiter2'];       
        if ($preview3Flag==0){
            $HierField1pre	= $_POST['c_xdams_hier_field1_pre'];
            $HierField1post	= $_POST['c_xdams_hier_field1_post'];        
            $HierField2pre      = $_POST['c_xdams_hier_field2_pre'];
            $HierField2post	= $_POST['c_xdams_hier_field2_post'];
        } else {  
            $hierConfig         = WPxdamsBridge_getHierStandardConfig(); 
            $HierField1pre	= $hierConfig [$preview3Flag]['pre1'];
            $HierField1post	= $hierConfig [$preview3Flag]['post1'] ;        
            $HierField2pre      = $hierConfig [$preview3Flag]['pre2'] ;
            $HierField2post	= $hierConfig [$preview3Flag]['post2'];            
        }

	
        $HierField              = $HierField1pre. '%%%' .$HierField1post.'%%%' .$HierField2pre.'%%%' .$HierField2post.'%%%' .$HierDelimiter1.'%%%' .$HierDelimiter2.'%%%'.$preview3Flag;
        
        if( $_POST['WPxdamsBridge_submit_button2b'] == 'Update and Add') {
            $count              = $count + 1;
        }
        
	update_option('WPxdamsBridge_form_'.$archiveId,$customForm);
	update_option('WPxdamsBridge_page_'.$archiveId,$customPage);
        update_option('WPxdamsBridge_imglistpage_'.$archiveId,$customImgListPage);
        update_option('WPxdamsBridge_listpage_'.$archiveId,$customListPage); 
        update_option('WPxdamsBridge_alllistpage_'.$archiveId,$customAllListPage);
	update_option('WPxdamsBridge_active_'.$archiveId,$activeFlag);
        update_option('WPxdamsBridge_allRecords_'.$archiveId,$allRecordsFlag);
        update_option('WPxdamsBridge_preview_'.$archiveId,$previewFlag);
        update_option('WPxdamsBridge_preview2_'.$archiveId,$preview2Flag);
        update_option('WPxdamsBridge_hier_desc_'.$archiveId, $HierDesc);
        update_option('WPxdamsBridge_hier_desc_pre_'.$archiveId, $HierDescPre);
        update_option('WPxdamsBridge_hier_desc_post_'.$archiveId, $HierDescPost);
	update_option('WPxdamsBridge_hier_prefix_'.$archiveId, $HierDescPrefix);
        update_option('WPxdamsBridge_hier_field_'.$archiveId, $HierField);
        
        
	$test_check		= $_POST['c_field_check_WPxdamsBridge'];
        $delete_check		= $_POST['c_delete_check_WPxdamsBridge'];
	$field_name		= $_POST['c_fieldName_WPxdamsBridge'];
	$field_label            = $_POST['c_fieldDesc_WPxdamsBridge'];
	$field_custom           = $_POST['c_fieldCustom_WPxdamsBridge'];
	
	for($i=0;$i<$count;$i++) {
	     
            if (!$delete_check[$i]){ 
		$field_options  = $field_options. $field_name[$i].'%%%';
                
		if ($field_custom[$i]){ 
                    $custom_field_label = $field_custom[$i];             
		} else {
                    $custom_field_label = $field_label[$i];
		}
                
                if ($test_check[$i]){ 
                    $active_yes_no= 1;             
		} else {
                    $active_yes_no= 0;
		}
		$field_options = $field_options. $custom_field_label.'%%%' .$active_yes_no  .'%%%';
                
            } else {
                 $deletedItems = $deletedItems + 1;
            }
        }
        
        $count = $count - $deletedItems;
        
        update_option('WPxdamsBridge_fields_num_'.$archiveId,$count);
	update_option('WPxdamsBridge_search_fields_'.$archiveId,$field_options);
        return  $archiveId;                                
}

function WPxdamsBridge_execute_archivesImport(){
	
	global $archivesConfig ;
	
	$out= true;
	    $addedArchives                      = 0;
    $countA                             = $_POST['c_xdamsnum_WPxdamsBridge'] ; // number of archives
    $test_import                        = $_POST['c_field_import_WPxdamsBridge'];
    $test_import_search                 = $_POST['c_check_searchform_WPxdamsBridge'];
    
    $count                              = $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];
    $count2                             = $archivesConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives
 
    
    for($i=0;$i<$count;$i++) {   // refatoring lists of archive items - first step queueing not modified archives taking their data from DB
        $yes_append                     = true;
        for($i2=0;$i2<$countA;$i2++) {
            if ($archivesConfig ['father'][$i] == $_POST['c_xdamsid_WPxdamsBridge'.$i2] && $test_import[$i2]) {
                $yes_append             = false; // don't append!! we have to take data from file
            }
        }
        if ( $yes_append) {
            $archivesItemFather         = $archivesItemFather.$archivesConfig ['father'][$i].'%%%';
            $archivesItem               = $archivesItem.$archivesConfig ['id'][$i].'%%%';
            $archivesItemLabel 		= $archivesItemLabel.$archivesConfig['label'][$i].'%%%';
            $archivesItemConfigFile 	= $archivesItemConfigFile.$archivesConfig ['configfile'][$i].'%%%';
        }
        
    }
	
    for($i=0;$i<$countA;$i++) {  
              
        if ($test_import[$i]){ 

            $test_level_import          = $_POST['c_check_level_WPxdamsBridge'] ;        
            $optionname                 = $_POST['c_xdamsid_WPxdamsBridge'.$i] ;             
            $archiveId                  = $_POST['c_xdamsid_WPxdamsBridge'.$i] ;
                
            if ($_POST['c_xdamsstatus_WPxdamsBridge'.$i] =='not saved'){   // update archive specific information and append data to update archibes general lists
               
                $optiondes              = $_POST['c_xdamsdes_WPxdamsBridge'.$i] ;
                $archiveIdList          = $archiveIdList.$archiveId.'%%%';
                $archiveDesList         = $archiveDesList.$optiondes.'%%%' ;
		   
                $newsetting             = $_POST['c_xdamsxOut_WPxdamsBridge'.$i] ;
                update_option('WPxdamsBridge_xOut_'.$optionname,$newsetting); 
                
                $archivexOutList        = $archivexOutList.$newsetting  .'%%%' ;
                    
                $addedArchives          = $addedArchives + 1;
            }
                                        
            $archivesItemFather         = $archivesItemFather.$_POST['c_xdamsitemfather_WPxdamsBridge'.$i];
            $archivesItem               = $archivesItem.$_POST['c_xdamsitems_WPxdamsBridge'.$i];
            $archivesItemLabel          = $archivesItemLabel.$_POST['c_xdamsitemlabel_WPxdamsBridge'.$i];
            $archivesItemConfigFile     = $archivesItemConfigFile.$_POST['c_xdamsitemfiles_WPxdamsBridge'.$i]; 
			update_option('___1', $test_import_search[$i] .'-');
            if ($test_import_search[$i]){ 
			update_option('___2', $test_import_search[$i] .'-');
                WPxdamsBridge_importSearchFieldInDB ($archiveId);  // the first time it pre-save the configuration   
            }
            WPxdamsBridge_importOutpuFieldsInDB ($_POST['c_xdamsitemfather_WPxdamsBridge'], $_POST['c_xdamsitems_WPxdamsBridge'], $_POST['c_xdamsitemfiles_WPxdamsBridge'],  $archiveId , $test_level_import );
            update_option('WPxdamsBridge_active_'.$archiveId,1);
            
            if ($_POST['c_xdamsmediafiles_WPxdamsBridge'.$i]) {
                $temp                       = explode('%%%', $_POST['c_xdamsmediafiles_WPxdamsBridge'.$i]);
                $countB                     = count($temp)/2;
                for($i4=0;$i4<$countB-1;$i4++) { 
                    update_option('WPxdamsBridge_media_fields_'.$temp[$i4*2],$temp[($i4*2)+1] );
                }
            }
            if ($_POST['c_xdamsvideofiles_WPxdamsBridge'.$i]) {
                $temp                       = explode('%%%', $_POST['c_xdamsvideofiles_WPxdamsBridge'.$i]);
                $countB                     = count($temp)/2;
                for($i4=0;$i4<$countB-1;$i4++) { 
                    update_option('WPxdamsBridge_video_fields_'.$temp[$i4*2],$temp[($i4*2)+1] );
                }
            }           
        }        
    }
        
    if($addedArchives  > 0) {   // append data to general list - this is only in the case of a new archive to import to add archive id and des
        $archiveIdList                  =  get_option('WPxdamsBridge_archives_id').$archiveIdList;   
        update_option('WPxdamsBridge_archives_id',$archiveIdList); 
      
        $archiveDesList                 =  get_option('WPxdamsBridge_archives_des').$archiveDesList;
        update_option('WPxdamsBridge_archives_des',$archiveDesList);
      
        $archivexOutList                =  get_option('WPxdamsBridge_archives_xOut').$archivexOutList;
        update_option('WPxdamsBridge_archives_xOut',$archivexOutList);      
      
    }
        
   // to refator archives items list with modified elements
    
        update_option('WPxdamsBridge_archives_items'            , $archivesItem  ); 
        update_option('WPxdamsBridge_archives_itemFather'       , $archivesItemFather); 
        update_option('WPxdamsBridge_archives_itemLabel'        , $archivesItemLabel ); 
        update_option('WPxdamsBridge_archives_itemFiles'        , $archivesItemConfigFile ); 
    
   return $out;
}
function WPxdamsBridge_get_option($opt, $archiveId=null){
    
        global $currentInfo;

	switch($opt){
		case 'active':
		$out =  get_option('WPxdamsBridge_active_'.$archiveId);;
		break;            
            
		case 'allRecords':
		$out =  get_option('WPxdamsBridge_allRecords_'.$archiveId);;
		break;
            
            	case 'preview':
		$out =  get_option('WPxdamsBridge_preview_'.$archiveId);
                if ($out=="") { $out =3 ;}
		break;
                
                case 'preview2':
		$out =  get_option('WPxdamsBridge_preview2_'.$archiveId);
                if ($out=="") { $out =1 ;}
		break;
		
                case 'preview3':
                    
                if (!$currentTnfo['Hfield'])   { 
                    $currentTnfo['Hfield'] =  get_option('WPxdamsBridge_hier_field_'.$archiveId);
                }
                $HierValues = explode(  '%%%', $currentTnfo['Hfield']);
                $out        =  $HierValues[6]  ;  
                if ($out=="") { $out =1 ;}
		break;
                
                case 'Hfld1Pr':
                if (!$currentTnfo['Hfield'])   { 
                    $currentTnfo['Hfield'] =  get_option('WPxdamsBridge_hier_field_'.$archiveId);
                }
                $HierValues = explode(  '%%%', $currentTnfo['Hfield']);
                $out        =  $HierValues[0]  ;  
		break; 	

                case 'Hfld1Po':
                if (!$currentTnfo['Hfield'])   { 
                    $currentTnfo['Hfield'] =  get_option('WPxdamsBridge_hier_field_'.$archiveId);
                }
                $HierValues = explode(  '%%%', $currentTnfo['Hfield']);
                $out        =  $HierValues[1]  ;  
		break; 
		
                case 'Hfld2Pr':
                if (!$currentTnfo['Hfield'])   { 
                    $currentTnfo['Hfield'] =  get_option('WPxdamsBridge_hier_field_'.$archiveId);
                }
                $HierValues = explode(  '%%%', $currentTnfo['Hfield']);
                $out        =  $HierValues[2]  ;  
		break; 	

                case 'Hfld2Po':
                if (!$currentTnfo['Hfield'])   { 
                    $currentTnfo['Hfield'] =  get_option('WPxdamsBridge_hier_field_'.$archiveId);
                }
                $HierValues = explode(  '%%%', $currentTnfo['Hfield']);
                $out        =  $HierValues[3]  ;  
		break;
                
                		
                case 'Hdel1':
                if (!$currentTnfo['Hfield'])   { 
                    $currentTnfo['Hfield'] =  get_option('WPxdamsBridge_hier_field_'.$archiveId);
                }
                $HierValues = explode(  '%%%', $currentTnfo['Hfield']);
                $out        =  $HierValues[4]  ; 
                if ($out=="") { $out =' (' ;}
		break; 	

                case 'Hdel2':
                if (!$currentTnfo['Hfield'])   { 
                    $currentTnfo['Hfield'] =  get_option('WPxdamsBridge_hier_field_'.$archiveId);
                }
                $HierValues = explode(  '%%%', $currentTnfo['Hfield']);
                $out        =  $HierValues[5]  ;  
                if ($out=="") { $out =') ' ;}
		break;
                
                case 'Hprefix':
		$out =  get_option('WPxdamsBridge_hier_prefix_'.$archiveId);
                if ($out=="") { $out =' |_ ' ;}
		break;                
                
                case 'Hpre':
		$out =  get_option('WPxdamsBridge_hier_desc_pre_'.$archiveId);
                if ($out=="") { $out =' <strong> ' ;}
		break;  
                
                case 'Hpost':
		$out =  get_option('WPxdamsBridge_hier_desc_post_'.$archiveId);
                if ($out=="") { $out =' </strong> ' ;}
		break;  
                
                case 'Hdesc':
		$out =  get_option('WPxdamsBridge_hier_desc_'.$archiveId);
                if ($out=="") { $out =' gerarchia ' ;}
		break;  
                
                case 'url':
		$out = get_option('WPxdamsBridge_url_'.$archiveId);;
		break;
	
		case 'psw':
		$out = get_option('WPxdamsBridge_psw_'.$archiveId);;
		break;
	
		case 'frm':
		$out = get_option('WPxdamsBridge_form_'.$archiveId);;
		break;
		
		case 'pag':
		$out = get_option('WPxdamsBridge_page_'.$archiveId);;
		break;	
		
		case 'media':
		$out = get_option('WPxdamsBridge_media_'.$archiveId);;
		break;
		
		case 'list':
		$out = get_option('WPxdamsBridge_imglistpage_'.$archiveId);;
		break;
		
		case 'listC':
		$out = get_option('WPxdamsBridge_listpage_'.$archiveId);;
		break;
            
		case 'alllist':
		$out = get_option('WPxdamsBridge_alllistpage_'.$archiveId);
		break;
       	
		case 'xOut':
		$out = get_option('WPxdamsBridge_xOut_'.$archiveId);;
		break;
            
            	case 'attachments':
		$out = get_option('WPxdamsBridge_attachments_'.$archiveId);;
		break;
            
                case 'langs':
		$out = get_option('WPxdamsBridge_languages_'.$archiveId);;
		break;
            
                case 'mlang':
		$out = get_option('WPxdamsBridge_mainLanguage');;
		break;
            
	}
	return $out;
  
}

// search fields configuration

function WPxdamsBridge_search_form_options($opt, $archiveId){
  $fields_options_from_db 	= get_option('WPxdamsBridge_search_fields_'.$archiveId);
  $count 					= get_option('WPxdamsBridge_fields_num_'.$archiveId);
  
  $fields_options_from_db 	= explode('%%%', $fields_options_from_db);
  
  for($i=1;$i<=$count;$i++) {
     $i1 = ($i - 1) * 3;
	;
	 if ($opt== $fields_options_from_db[$i1]) {
		$Out['desc'] 		= $fields_options_from_db[$i1+1];
		$Out['visibility'] 	= $fields_options_from_db[$i1+2];
	 }
  }
  return $Out;
}
// search fields configuration


function WPxdamsBridge_url_exist($url){
	update_option ($url,$url);
	$ch = curl_init($url);    
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // don't output the response
	curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if($code == 200){
		$status = true;
	}else{
		$status = false;
	}
	curl_close($ch);
	return $status;
}



function WPxdamsBridge_output_list_options($opt, $archiveId ,$fields_options_from_db, $count ){

  $a=$fields_options_from_db;
  $fields_options_from_db 	= explode('%%%', $fields_options_from_db);
  
  for($i=1;$i<=$count;$i++) {
     $i1 = (($i - 1) * 3) ;
	 $stored = $fields_options_from_db[$i1];
	
	 if ($opt== $stored) {
		$Out['desc'] 		= $fields_options_from_db[$i1+1];
		$Out['visibility'] 	= $fields_options_from_db[$i1+2];
	 }
  }
  
  
  return $Out;
}

function WPxdamsBridge_getFieldCustomDesc($fields_options_from_db, $index ){
  
  $fields_options_from_db 	= explode('%%%', $fields_options_from_db);
  $index 					= $index * 3;
  $Out				 		= $fields_options_from_db[$index+1];

  return $Out;
}
function WPxdamsBridge_getFieldName($fields_options_from_db, $index ){
  
  $fields_options_from_db 	= explode('%%%', $fields_options_from_db);
  $index 					= $index * 3;
  $Out				 		= $fields_options_from_db[$index];

  return $Out;
}

function WPxdamsBridge_fieldIsVisible($fields_options_from_db, $index ){
  
  $fields_options_from_db 	= explode('%%%', $fields_options_from_db);
  $Out 						= false;
  $index 					= $index * 3;
  if ($fields_options_from_db[$index+2] !='0') {
		$Out = true;
	 }
  return $Out;
}

function WPxdamsBridge_install(){
  if(get_option('WPxdamsBridge_options' == '') || !get_option('WPxdamsBridge_options')){
    add_option('WPxdamsBridge_options', '0%%%Write given xdamsurl%%%Write given xdamspsw%%%');

  }
}

if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
	WPxdamsBridge_install();
}



//  get information about archives available

function WPxdamsBridge_get_archive_desc($inId){
	
	global $archivesConfig; 
	$count = $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];	
	
	for($i=0;$i<=$count;$i++) {
		if($inId == $archivesConfig ['father'][$i] ){ $out=$archivesConfig ['fatherDesc'][$i];};
	}
	
	
	return $out;

  
}
function WPxdamsBridge_get_archivesItem_file($inId){
	
	global $archivesConfig; 
	$count 	= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];	
	$out	= 'non trovata descrizione archivio - verifica file configurazione';
	for($i=0;$i<=$count;$i++) {
	    $currId  =  $archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i];
		if($inId == $currId  ){ $out=$archivesConfig ['configfile'][$i];};
		
	}
	
	
	return $out;

  
}
function WPxdamsBridge_get_archivesItem_desc($inId){
	
	global $archivesConfig; 
	$count 	= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];	
	$out	= 'non trovata descrizione archivio - verifica file configurazione';
	for($i=0;$i<=$count;$i++) {
	    $currId  =  $archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i];
		if($inId == $currId  ){ $out=$archivesConfig ['fatherDesc'][$i].' -> '.$archivesConfig ['label'][$i];};
		
	}
	
	
	return $out;

  
}
function WPxdamsBridge_get_archivesMediaFiles($inId){
	
	global $archivesConfig; 
	$count 	= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];	
	$out	= 'non trovata descrizione archivio - verifica file configurazione';
	for($i=0;$i<=$count;$i++) {
	    $currId  =  $archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i];
		if($inId == $currId  ){ $out=$archivesConfig ['mediafield'][$i];};
		
	}
	
	
	return $out;

  
}
function WPxdamsBridge_get_archivesVideoFiles($inId){
	
	global $archivesConfig; 
	$count 	= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];	
	$out	= 'non trovata descrizione archivio - verifica file configurazione';
	for($i=0;$i<=$count;$i++) {
	    $currId  =  $archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i];
		if($inId == $currId  ){ $out=$archivesConfig ['videofield'][$i];};
		
	}
	
	
	return $out;

  
}
function WPxdamsBridge_get_archivesItem_id (){
	
  $newpage		= $_SERVER['QUERY_STRING'];
  $first 		= strrpos($newpage, '_')+1;
  $out                  = substr($newpage,$first);
	;
	
	return $out;
}

function WPxdamsBridge_get_admin_param (){
	
  $inquery              = $_SERVER['QUERY_STRING'];
  $param                = explode('&', $inquery);
  if ($param[1]) {
    $temp               = explode('=', $param[1]);
    $out [$temp[0]]     = $temp[1];
  }
  if ($param[2]) {
    $temp               = explode('=', $param[2]);
    $out [$temp[0]]     = $temp[1];
  }
  if ($param[3]) {
    $temp               = explode('=', $param[3]);
    $out [$temp[0]]     = $temp[1];
  }  
  
  return $out;
}

function WPxdamsBridge_get_archive_id (){
	
  $inquery		= $_SERVER['QUERY_STRING'];
  $newpage              = explode('&', $inquery);
  
  
  $first 		= strrpos($newpage [0], '_')+1;
  $out                  = substr($newpage [0],$first);

  return $out;
}

/*  **************************************************
      this is the end....
    **************************************************
*/

?>
