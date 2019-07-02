<?php
/*
 functions to manage admin panel
*/


{
 
    $count		= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];
    $count2		= $archivesConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives
    $archivesList       = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives
    
 
  
    $mainLanguage         = WPxdamsBridge_get_option('mlang');
    if(!$mainLanguage) {
      $mainLanguage='it_IT';
    }
  
    $ArchivesURLS           = $ArchivesURLS.'
                			<p><strong>MAIN LANGUAGE</strong></p>
                                        <input type="text" name="c_xdamsmainlanguage_WPxdamsBridge" value="'.$mainLanguage.'" /> ';

    for($i=0;$i<$count2;$i++) {  //prepare link to configure search and to set url and password 
   
	$currentArchive	= 'archivio'; //?
	$separator		= '  -  ';
	$xdamsxOutOut= ' transformation:';
	
	if ($i==0) { $separator= 'Please configure your archive search forms: <br> ';};     
		
        if (!$archivesConfig['WPxdamsBridge_updateAllConfiguration'][0]=='yes') {   // first installation case
            $menuArchives=  $menuArchives. $separator .
                '<a href="admin.php?page=WPxdamsBridge_configure_archive_settings_'.$archivesList ['id'][$i].'"> '.stripslashes($archivesList ['label'][$i]).'  </a>';  
        } else {
            $menuArchives=   "before continuining please save general settings";
        }
            
        $xdamsurls [$i] = 'WPxdamsBridge_url_'.$archivesList ['id'][$i];  // campo da ricercare nelle option
        $xdamspsws [$i] = 'WPxdamsBridge_psw_'.$archivesList ['id'][$i];
        $xdamsxOut [$i] = 'WPxdamsBridge_xOut_'.$archivesList ['id'][$i];  //????
		
        switch($archivesList ['xOut'][$i] ){
		case '0':
			$xdamsxOutOut= 'transformation: none';
		break;
		case 'xslt':
			$xdamsxOutOut= 'transformation: xslt';
		break;		
		case 'mods':
			$xdamsxOutOut= 'transformation: MODS';
		break;	
		case 'lido':
			$xdamsxOutOut= 'transformation: lido';
		break;		
		default:
			$xdamsxOutOut= 'transformation: none';
		break;
	}
		
	$storedURL		= WPxdamsBridge_get_option('url' ,$archivesList ['id'][$i]); 
	$storedPSW		= WPxdamsBridge_get_option('psw' ,$archivesList ['id'][$i]); 
	$storedMEDIA            = WPxdamsBridge_get_option('media' ,$archivesList ['id'][$i]); 
        $storedATTACHMENTS      = WPxdamsBridge_get_option('attachments' ,$archivesList ['id'][$i]); 
	$namefieldurl           = 'c_xdamsurl_WPxdamsBridge'.$i;
	$namefieldpsw           = 'c_xdamspsw_WPxdamsBridge'.$i;
	$namefieldmedia         = 'c_xdamsmedia_WPxdamsBridge'.$i;
	$namedesarchive		= 'c_xdamsdes_WPxdamsBridge'.$i;
        $namefieldattachments   = 'c_xdamsattachments_WPxdamsBridge'.$i;
	$namefieldid            = 'c_xdamsid_WPxdamsBridge'.$i;
	$namefieldxOut          = 'c_xdamsxOut_WPxdamsBridge'.$i;
	$ArchivesURLS           = $ArchivesURLS.
						'<br><br><br> <strong>Archive ->  ' .' <input type="text" name="'.$namedesarchive .'" style="width: 500px;" value="'.stripslashes($archivesList ['label'][$i]).'" /> '.
						'</strong>  -- > ID: '. $archivesList ['id'][$i].' - ('.$xdamsxOutOut.')<br>'.
						'<br>URL for request <br>' .
						' <input type="text" name="'.$namefieldurl .'" style="width: 800px;" value="'.$storedURL.'" />  
                        
                                                <br>URL for media<br>
                                                <input type="text" name="'.$namefieldmedia .'" style="width: 800px;" value="'.$storedMEDIA.'" /> 	
                                                <br>URL for attachments<br>
                                                <input type="text" name="'.$namefieldattachments .'" style="width: 800px;" value="'.$storedATTACHMENTS.'" /> 	 
                                                
                                                <input type="hidden" name="'.$namefieldpsw .'" value="'.$storedPSW.'" />                           

						<input type="hidden" name="'.$namefieldid .'" value="'.$archivesList ['id'][$i].'" /> 
						<input type="hidden" name="c_xdamsnum_WPxdamsBridge" value="'.$count2.'" />  
                                                <input type="hidden" name="'.$namefieldxOut .'" value="'.$archivesList ['xOut'][$i] .'" /> ' ;

  }	

  $iArchive=0;
  for($i=0;$i<$count;$i++) {
        $currentArchive	= 'archivio'; //?
	$separator		= '  -  ';
	if ($i==0) { 
            $separator= '<br><br>Please configure your archives items publishing forms:<br><strong>'.$archivesConfig ['fatherDesc'][$i].' : </strong>';
         //   $mediaManagementHidden=$archivesConfig ['fatherDesc'][$i];
         
        } else {
            if ($lastPublishedArchive == $archivesConfig ['father'][$i] ) { 
                $separator =  ' - ';
                
            } else { 
                
           		
                $separator 		= '<br><strong>'.stripslashes($archivesConfig ['fatherDesc'][$i]).' : </strong>';
                $mediaManagementHidden  = $mediaManagementHidden.       // to manmage media and vido field storing
                                        ' <input type="hidden" name="c_xdamsmediafiles_WPxdamsBridge'.$iArchive.'" value="'.$archivesItemMediaFile	.'" /> '.
                                        ' <input type="hidden" name="c_xdamsvideofiles_WPxdamsBridge'.$iArchive.'" value="'.$archivesItemVideoFile	.'" /> '  ;
                $archivesItemVideoFile  = '';
                $archivesItemMediaFile  = '';
                $iArchive=$iArchive+1;
            }
         }
       
        $lastPublishedArchive = $archivesConfig ['father'][$i];
        
        if (!$archivesConfig['WPxdamsBridge_updateAllConfiguration'][0]=='yes') {
            $menuArchives=  $menuArchives. $separator .
		'<a href="admin.php?page=WPxdamsBridge_configure_output_fields_'.$archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i].'"> '
		.' '.$archivesConfig ['label'][$i].'  </a>';
	}
	$archivesItemFather             = $archivesItemFather.$archivesConfig ['father'][$i].'%%%';
	$archivesItem			= $archivesItem.$archivesConfig ['id'][$i].'%%%';
	$archivesItemLabel 		= $archivesItemLabel.$archivesConfig ['label'][$i].'%%%';
        $archivesItemConfigFile 	= $archivesItemConfigFile.$archivesConfig ['configfile'][$i].'%%%';
        if ($archivesConfig ['mediafield'][$i]){
           $archivesItemMediaFile = $archivesItemMediaFile.$archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i].'%%%'.
                                            $archivesConfig ['mediafield'][$i].'%%%';
	 
        }
    
        if ($archivesConfig ['videofield'][$i]){
            $archivesItemVideoFile      = $archivesItemVideoFile.$archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i].'%%%'.
                                            $archivesConfig ['videofield'][$i].'%%%';
        }
        if ($i==$count-1){
            $mediaManagementHidden      = $mediaManagementHidden.
                                                ' <input type="hidden" name="c_xdamsmediafiles_WPxdamsBridge'.$iArchive.'" value="'.$archivesItemMediaFile	.'" /> '.
                                                ' <input type="hidden" name="c_xdamsvideofiles_WPxdamsBridge'.$iArchive.'" value="'.$archivesItemVideoFile	.'" /> ' ;}
  }	
 	
 
  $stamp = '<div class="wrap">'.
                '<h2>WP to xDams Bridge General Settings</h2>
                <form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
                    <p>By this page it\'s possibile configure the plugin. Setup the following options to start testing how the wordpress plugin works! <br>Save before the xDams URL and Password (not active now) and after continue with search forms and fields to be visualized (see "other options")</p> 
                    <fieldset class="options">'.
 
				'<h4>Other options: </h4>'.$mediaManagementHidden.$menuArchives.'<br>'. $ArchivesURLS .
              					 
                                        '<input type="hidden" name="c_xdamsitems_WPxdamsBridge" value="'.$archivesItem	.'" />
					 <input type="hidden" name="c_xdamsitemfather_WPxdamsBridge" value="'.$archivesItemFather	.'" />
					 <input type="hidden" name="c_xdamsitemlabel_WPxdamsBridge" value="'.$archivesItemLabel	.'" />'.
                                    '     <input type="hidden" name="c_xdamsitemfiles_WPxdamsBridge" value="'.$archivesItemConfigFile	.'" /> '.
                                         ' <input type="hidden" name="c_xdamsupdateconfig_WPxdamsBridge" value="'.$archivesConfig['WPxdamsBridge_updateAllConfiguration'][0]	.'" />    
					</fieldset>';
            
   if ($archivesConfig['WPxdamsBridge_updateAllConfiguration'][0]=='yes') {
                 $stamp = $stamp.'
                     <br><strong>WARNING</strong><br>
                     it seems that you have to import data, if this is your firt time in setting section please push  <strong>Import and Update</strong><br>
                     otherwise it could be depend from your version of plugin, we need to do some change. In this case, to save your previous settings, please push <br><strong>Only Update</strong><br>
                      
                    <table><tr><td>
                    <p class="submit">
                        <input type="submit" name="WPxdamsBridge_submit_button" value="Import and Update" />
                        
                    </p> 
                    </td><td>
                     <p class="submit">
                        
                        <input type="submit" name="WPxdamsBridge_submit_buttonB" value="Only Update" />
                    </p> 
                    </td></tr> <table>';
                
    } else  {
                 $stamp = $stamp. '
                     <p class="submit">
                        <input type="submit" name="WPxdamsBridge_submit_button" value="Update Settings" />
                    </p> ';
    }    

    $stamp = $stamp. '
                 </form> '.
                $menuArchives.
        '</div>
	 <div>'.
	  
		'<br><strong>use shortcode</strong> '.
		"<br>--> <strong>[xdamsItem type='archive ID' ]</strong> xdams item id<strong> [/xdamsItem]</strong> to request data of a specified item ".
		"<br>--> <strong>[xdamsImage type='archive ID' ]</strong> xdams item id<strong> [/xdamsImage]</strong> to request data of a specified item image".
		"<br>--> <strong>[xdamsSearch type='archive ID' ][/xdamsSearch]</strong> to activate search form - full text".
		"<br>--> <strong>[xdamsAdSearch type='archive ID' ]all or a specified field[/xdamsAdSearch]</strong> advanced search, at moment all run only on the first filled value ".
		"<br>--> <strong>[xdamsList type='archive ID' ]</strong> search criteria or nothing<strong> [/xdamsList]</strong> to request a list of item - without search criteria = entire archive".
		"<br>--> <strong>[xdamsListImg type='archive ID' ]</strong> search criteria or nothing<strong> [/xdamsListImg]</strong> to request a list of item with pics preview ".
		"<br>--> <strong>[xdamsPreview type='archive ID' ]</strong> search criteria or nothing<strong> [/xdamsPreview]</strong> to request a list of item with pics preview ".
		"<br>".
		"<br><strong>WPxdamsStories  shortcodes</strong> <br>(activable only using this second plugin)".
		"<br>--> <strong>[xdamsDynSlider type='archive ID' ]</strong> search criteria or nothing<strong> [/xdamsDynSlider]</strong> to request a list of item with pics preview ".
		"<br>--> <strong>[xdamsStory]</strong> id number of the story <strong>[/xdamsStory]</strong> to include a story in a page ".
		"<br>".
		"<br><strong>COMING SOON</strong> <strong>  ".     
		"<br>--> <strong>[xdamsTree type='archive ID' ]</strong> unused<strong> [/xdamsTree]</strong> for hierarchical navigation ".
		"<br>--> <strong>[xdamsTree]</strong> unused<strong> [/xdamsTree]</strong> for hierarchical navigation - all archives ".
	  
        "</div>"	  ;
 	
    $stamp = $stamp. '<br>'.$archivesConfig['file_reading_msg'] ;
	  
    print($stamp);	
		
}


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
