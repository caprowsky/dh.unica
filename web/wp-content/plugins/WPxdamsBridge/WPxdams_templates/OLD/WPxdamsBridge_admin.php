<?php
/*
 functions to manage admin panel
*/


function WPxdamsBridge_config_page(){
 
global $archivesConfig; 
//update_option('wpxdamsbridge_logA0', microtime());
  if (function_exists('add_options_page'))
	{
        add_menu_page		('WP to xDams Bridge Menu', 
						'WP to xDams Bridge',
						8,
						basename(__FILE__),
						'WPxdamsBridge_general_settings'
						);
	add_submenu_page	('WPxdamsBridge_admin.php', 
						'WP to xDams Bridge Settings', 
						'General Settings', 
						8,
						basename(__FILE__),
						'WPxdamsBridge_general_settings');	
						

	$archivesConfig 	= WPxdamsBridge_get_archives_config();
       
	$count 			= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];

	$parentPage		= 'WPxdamsBridge_admin.php';		
	$parentPage2		= 'WPxdamsBridge_admin.php';	
        $parentPage3		= 'WPxdamsBridge_admin.php';	

	for($i=0;$i<$count;$i++) 
		{	
		$archiveId 	= $archivesConfig ['father'][$i];
		$archLevelId	= $archivesConfig ['id'][$i];
		$archiveLabel	= $archivesConfig ['fatherDesc'][$i];
		$archLevelLabel	= $archivesConfig ['label'][$i];
		$archiveSlug	= 'WPxdamsBridge_configure_search_form_'.$archiveId;
		$archiveSlug2	= 'WPxdamsBridge_configure_output_fields_'.$archLevelId.'@'.$archiveId;
                $archiveSlug3	= 'WPxdamsBridge_languages_'.$archiveId;;
		
	
		add_submenu_page($parentPage, 
						'Configure your Archive Search Form', 
						'Search Form Fields', 
						8,
						$archiveSlug, 
						'WPxdamsBridge_configure_search_form');	
		add_submenu_page($parentPage2, 
						'Configure your Archive Output Fields', 
						'Output Fields', 
						8,
						$archiveSlug2, 
						'WPxdamsBridge_configure_output_fields');
                add_submenu_page($parentPage3, 
						'Translate your Terms', 
						'Languages', 
						8,
						$archiveSlug3, 
						'WPxdamsBridge_configure_languages');
   
	//  page more than the first are subpage
	
		 if ($i == 0) { 
						$parentPage = $archiveSlug;  
						$parentPage2 = $archiveSlug2;
                                                $parentPage3 = $archiveSlug3;
					}				
						
					
	}
        $archiveSlug3	= 'WPxdamsBridge_languages_general@';
        add_submenu_page($parentPage3, 
						'Translate your Terms', 
						'Languages', 
						8,
						$archiveSlug3, 
						'WPxdamsBridge_configure_languages');
	
	$parentPage			= 'WPxdamsBridge_admin.php';	  
        $countExhibits               	= get_option('WPxdamsBridge_exhibitions_number'); // number of archives;
        if (!$countExhibits) {   $countExhibits		= 3; };	
	
	for($i=1;$i<=$countExhibits;$i++)
        
		{	
                $archiveSlug 	= 'WPxdamsBridge_exhibitions_'. $i;	
		add_submenu_page($parentPage, 
						'Configure your Exhibitions', 
						'Exhibitions', 
						8,
						$archiveSlug, 
						'WPxdamsBridge_exhibitions');
		 if ($i == 1) { 
						$parentPage = $archiveSlug;  					
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
 
function WPxdamsBridge_exhibitions(){

	global $archivesConfig;

	include ('WPxdamsBridge_exhibitions.php'); ;
}



function WPxdamsBridge_configure_search_form(){

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

function update_WPxdamsBridge_settings(){
   global $archivesConfig;  
  // $archivesConfig 	= WPxdamsBridge_get_archives_config(); 

// actions after form submit of general settings page
  if($_POST['WPxdamsBridge_submit_button'] == 'Update Settings'){
    update_option('WPxdamsBridge_last_executed',11);
    
    $language       = $_POST['c_xdamsmainlanguage_WPxdamsBridge'];
    update_option('WPxdamsBridge_mainLanguage',$language);
	// da qui elimino?
    $newsetting =	'noFlag' . '%%%' . 
					$_POST['c_xdamsurl_WPxdamsBridge'].'%%%' .
					$_POST['c_xdamspsw_WPxdamsBridge'] .'%%%' . 
					'end';
    update_option('WPxdamsBridge_options',$newsetting);   //verificare di eliminare questa opzione
	//  fin qui?
   

	// save url and psw for each archive - this is the last procedure - ok
	$count2		= $_POST['c_xdamsnum_WPxdamsBridge'] ; // number of archives
	for($i=0;$i<$count2;$i++) {  //prepare link to configure search and to set url and password 
		$newsetting = $_POST['c_xdamsurl_WPxdamsBridge'.$i] ;
		$optionname = $_POST['c_xdamsid_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_url_'.$optionname,$newsetting);   //verificare di eliminare questa opzione
		$newsetting = $_POST['c_xdamspsw_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_psw_'.$optionname,$newsetting);   //verificare di eliminare questa opzione
		$newsetting = $_POST['c_xdamsxOut_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_xOut_'.$optionname,$newsetting);   //verificare di eliminare questa opzione
		$newsetting = $_POST['c_xdamsmedia_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_media_'.$optionname,$newsetting);   //verificare di eliminare questa opzione
                $newsetting = $_POST['c_xdamsattachments_WPxdamsBridge'.$i] ;
		update_option('WPxdamsBridge_attachments_'.$optionname,$newsetting);   //verificare di eliminare questa opzione
	}
	header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_admin.php&updated=true'); 


	
  }
  
// actions after form submit of search form page  
  if($_POST['WPxdamsBridge_submit_button2'] == 'Update Settings'){
    update_option('WPxdamsBridge_last_executed',2);
	  
        $archiveId		= $_POST['c_archiveId_WPxdamsBridge'];
	$count 			= $_POST['c_fieldsNumber_WPxdamsBridge'];
	$customForm		= $_POST['c_xdamsfrm_WPxdamsBridge'];
	$customPage		= $_POST['c_xdamspage_WPxdamsBridge'];
        $customImgListPage	= $_POST['c_xdamsimglistpage_WPxdamsBridge'];
	$activeFlag		= $_POST['c_active'];
        $previewFlag		= $_POST['c_preview'];


	update_option('WPxdamsBridge_fields_num_'.$archiveId,$count);
	update_option('WPxdamsBridge_form_'.$archiveId,$customForm);
	update_option('WPxdamsBridge_page_'.$archiveId,$customPage);
        update_option('WPxdamsBridge_imglistpage_'.$archiveId,$customImgListPage);
	update_option('WPxdamsBridge_active_'.$archiveId,$activeFlag);
        update_option('WPxdamsBridge_preview_'.$archiveId,$previewFlag);
	
	$test_check		= $_POST['c_field_check_WPxdamsBridge'];
	$field_name		= $_POST['c_fieldName_WPxdamsBridge'];
	$field_label            = $_POST['c_fieldDesc_WPxdamsBridge'];
	$field_custom           = $_POST['c_fieldCustom_WPxdamsBridge'];
	
	for($i=0;$i<$count;$i++) {
	    
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
	}
	update_option('WPxdamsBridge_search_fields_'.$archiveId,$field_options);
    header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_configure_search_form_'.$archiveId); 
  }
  
 // actions after form submit of output fields page   
 
   if($_POST['WPxdamsBridge_submit_button3'] == 'Update Settings'){
        update_option('WPxdamsBridge_last_executed',3);
 
        $archiveLevId       = $_POST['c_archiveLevId_WPxdamsBridge'];
	$archiveMedia       = $_POST['c_archiveMedia_WPxdamsBridge'];
	$archiveVideo       = $_POST['c_archiveVideo_WPxdamsBridge'];
	$count 			= $_POST['c_fieldsNumber_WPxdamsBridge'];

	update_option('WPxdamsBridge_out_fields_num_'.$archiveLevId,$count);
	if ($archiveMedia) { 
		update_option('WPxdamsBridge_media_fields_'.$archiveLevId,$archiveMedia);
	};
	if ($archiveVideo) { 
		update_option('WPxdamsBridge_video_fields_'.$archiveLevId,$archiveVideo);
	};	

	
	$test_check         = $_POST['c_field_check_WPxdamsBridge'];
	$field_name         = $_POST['c_fieldName_WPxdamsBridge'];
	$field_label        = $_POST['c_fieldDesc_WPxdamsBridge'];
	$field_custom       = $_POST['c_fieldCustom_WPxdamsBridge'];
        
        
        // to re-order config file
        $originalRow        = $_POST['c_fileRow_WPxdamsBridge'];
        $archiveLevel       = explode('@',$archiveLevId);
        $archiveConfFile    = WPxdamsBridge_get_archivesItem_file($archiveLevId);  
        
        $fs = fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_config/canc.xml', 'w');   // scrive in locale
         $fp = fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_config/temp.xml', 'w');  // scrive in locale
        fwrite($fp,'<c id="generic" level="'.$archiveLevel[0].'">');
        fwrite($fp,"\n");
       

	
	for($i=0;$i<$count;$i++) {
	    
            $field_options = $field_options. $field_label[$i].'%%%';
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
            
            // reverse string managing from the page
            $originalRow[$i] =   str_replace('£$%&', '<',  $originalRow[$i]);
            $originalRow[$i] =   str_replace('&%$£', '>',  $originalRow[$i]);
            $originalRow[$i] =   str_replace('-&-%-', '"', $originalRow[$i]);
            fwrite($fp,$originalRow[$i]);
            fwrite($fs,$field_options);
             fwrite($fs,"\n");
            
	}
        fwrite($fp,'</c>');
        fclose($fp);
        fclose($fs);
        
        rename ('../wp-content/plugins/WPxdamsBridge/WPxdams_config/temp.xml', '../wp-content/plugins/WPxdamsBridge/WPxdams_config/'.$archiveConfFile);
        
	update_option('WPxdamsBridge_output_fields_'.$archiveLevId,$field_options);
        
        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_configure_output_fields_'.$archiveLevId); 
  } 
  // actions after form submit of output fields page  
  
 
                
   if($_POST['WPxdamsBridge_submit_button4'] == 'Update Settings'){
        update_option('WPxdamsBridge_last_executed',4);
 
        $count          		= $_POST['c_fieldsNumber_WPxdamsBridge'];
	$exhibitionID  			= $_POST['c_exhibitionID_WPxdamsBridge'];
	$backgroundImgUrl               = $_POST['c_backgroundImgUrl_WPxdamsBridge'];
        $exhibitionTitle                = $_POST['c_exhibitionTitle_WPxdamsBridge'];
	$exibitionNumber   		= $_POST['c_exhibitNumber_WPxdamsBridge'];
	update_option('WPxdamsBridge_backgroundImgUrl_'.$exhibitionID,$backgroundImgUrl);
	update_option('WPxdamsBridge_exhibitions_number',$exibitionNumber);
        update_option('WPxdamsBridge_exhibitions_fieldsNumber_'.$exhibitionID ,$count);
        update_option('WPxdamsBridge_exhibitionTitle_'.$exhibitionID ,$exhibitionTitle);
        
   //     $fp = fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_config/temp.xml', 'w');

//	update_option('WPxdamsBridge_active_'.$archiveId,$activeFlag);
	$itemID           		= $_POST[ 'c_itemID_WPxdamsBridge'];
        $url           			= $_POST[ 'c_imgUrl_WPxdamsBridge'];
        $des           			= $_POST['c_fieldCustom_WPxdamsBridge'];
        $archId           		= $_POST['c_imgArchID_WPxdamsBridge'];
	
	for($i=1;$i<$count+1;$i++) {
     //       fwrite($fp,$itemID[$i].'%%%'.$des[$i].'%%%'.$archId[$i].'%%%'. $url[$i]);
       //      fwrite($fp,"\n");
             
            $field_options = $itemID[$i].'%%%'.$des[$i].'%%%'.$archId[$i].'%%%'. $url[$i]  ;
            update_option('WPxdamsBridge_exhibitions_'.$exhibitionID.'_'.$i,$field_options);
	}
//	 fclose($fp);
    header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_exhibitions_'.$exhibitionID); 
  }
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
            $fp = fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_config/languages/'.$archId.'_lang_'.$langId[$i].'.properties', 'w');
            
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
                  //  fwrite($fp,'-'.$i2.'...'.$i);
                   // fwrite($fp,"\n");
                } 
            }
            fclose($fp);
            if ( $EmptyFile    == 0 ){
               unlink('../wp-content/plugins/WPxdamsBridge/WPxdams_config/languages/'.$archId.'_lang_'.$langId[$i].'.properties') ;
            } else {
               $langOption     = $langOption.$langId[$i]. '%%%'; 
            }
	}
            
        // update general terms
        if ($archId   =='general@') {
            $fn = fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_config/languages/general@_lang_main.properties', 'w');
            for($i2=0;$i2<$fieldsNumber;$i2++) {
                $value                  = $inValues2[$i2];
                $field                  = $inFields [$i2];
                fwrite($fn,$field.'='.$value);
                fwrite($fn,"\n");
 
            }
            fclose($fn);
        }
        
        update_option('WPxdamsBridge_languages_'.$archId, $langOption  );
        
        header('Location: '.get_bloginfo('wpurl').'/wp-admin/admin.php?page=WPxdamsBridge_languages_'.$archId ); 
  }

 
}

add_action('init', 'update_WPxdamsBridge_settings', 9999);

// to retrieve data stored by general settings page  - obsoleta
/*
function WPxdamsBridge_option($opt, $archiveId=null){
  

  if ($opt == 'active') {
	$opt_WPxdamsBridge = get_option('WPxdamsBridge_active_'.$archiveId);
	return $opt_WPxdamsBridge;
  
  } else {
  
	$opt_WPxdamsBridge = get_option('WPxdamsBridge_options');
	$opt_WPxdamsBridge = explode('%%%', $opt_WPxdamsBridge);
  
	switch($opt){
//		case 'active':
//		return $opt_WPxdamsBridge[0];
//		break;
    
		case 'xdamsurl':
		return $opt_WPxdamsBridge[1];
		break;
	
		case 'xdamspsw':
		return $opt_WPxdamsBridge[2];
		break;
	
		case 'xdamsfrm':
		return $opt_WPxdamsBridge[3];
		break;
	}
  }
}
*/
function WPxdamsBridge_get_option($opt, $archiveId=null){

	switch($opt){
		case 'active':
		$out =  get_option('WPxdamsBridge_active_'.$archiveId);;
		break;
            
            	case 'preview':
		$out =  get_option('WPxdamsBridge_preview_'.$archiveId);
                if ($out=="") { $out =3 ;}
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

function WPxdamsBridge_loadLanguage ($language, $archiveId){
    
    
    if ($language=='general@' && $archiveId=='general@'){
         $fileLang = get_bloginfo('wpurl').'/wp-content/plugins/WPxdamsBridge/WPxdams_config/languages/general_lang.properties';
    } else {
        $fileLang = get_bloginfo('wpurl').'/wp-content/plugins/WPxdamsBridge/WPxdams_config/languages/'.$archiveId.'_lang_'.$language.'.properties';
    }
   

    
    if($handle=@fopen($fileLang,"r")){

        $contents = '';

        while (!feof($handle) && $i < 1000) {
            $i= $i+1;
            $contents   = fgets($handle, 1024);
        
            $term       = explode('=',$contents );
            if ($term[1]){
            
                $out[$term[0]]=$term[1];
           
            }
            
        }
        fclose($handle);
    } else {
       $out['%%%errore file']='file inesistente'.$fileLang;         
    }
        
  return $out;
}

function WPxdamsBridge_output_list_options($opt, $archiveId ,$fields_options_from_db, $count ){

  
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
  $out 	= substr($newpage,$first);
	;
	
	return $out;

  
}

function WPxdamsBridge_get_archive_id (){
	
  $newpage		= $_SERVER['QUERY_STRING'];
  $first 		= strrpos($newpage, '_')+1;
  $out 	= substr($newpage,$first);
	;
	
	return $out;

  
}
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
