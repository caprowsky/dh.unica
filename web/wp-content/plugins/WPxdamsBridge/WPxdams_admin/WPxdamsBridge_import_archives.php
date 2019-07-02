<?php
/*
 functions to manage admin panel
*/


{
 
    $count		= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];
    $count2		= $archivesConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives
  
 
    $archivesFileConfig = WPxdamsBridge_import_archives_config();
    $countB		= $archivesFileConfig ['WPxdamsBridge_archivesItemNumber'][0]; // number of archives  from file  
    $count2B		= $archivesFileConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives  from file    
    
  
    $archivesList         = $archivesFileConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives
    $archivesDBList       = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives
    $currLevelNum                   = 0;

    for($i=0;$i<$count2B;$i++) {  //prepare link to configure search and to set url and password 
   
	$alreadySaved           ='not saved';
        
        for($i2=0;$i2<$count2;$i2++) { 
            if ( $archivesList ['id'][$i]== $archivesDBList ['id'][$i2]) {
                $alreadySaved           ='already saved';
            }
        }
        
        $xdamsxOutOut= ' transformation:';
	$xdamsxOut [$i] = 'WPxdamsBridge_xOut_'.$archivesList ['id'][$i];  //????
		

	switch($archivesList ['xOut'][$i] ){
		case '0':
			$xdamsxOutOut   = 'none';
		break;
		case 'xslt':
			$xdamsxOutOut   = 'xslt';
		break;		
		case 'mods':
			$xdamsxOutOut   = 'MODS';
		break;	
		case 'lido':
			$xdamsxOutOut   = 'lido';
		break;		
		default:
			$xdamsxOutOut   = 'none';
		break;
	}

        $archivesItemFather             = '';
	$archivesItem                   = '';
	$archivesItemLabel              = '';
        $archivesItemConfigFile         = '';
        $archivesItemMediaFile          = '';
        $archivesItemVideoFile          = '';
        $archiveItemsRow                = '';
       
        
        for($i3=0;$i3<$countB;$i3++) {   // the order has determined by archives list and could be differente from order in levels list
            if($archivesFileConfig ['father'][$i3]== $archivesList ['id'][$i]) {
                $archivesItemFather     = $archivesItemFather.$archivesFileConfig ['father'][$i3].'%%%';
                $archivesItem           = $archivesItem.$archivesFileConfig ['id'][$i3].'%%%';
                $archivesItemLabel      = $archivesItemLabel.$archivesFileConfig['label'][$i3].'%%%';
                $archivesItemConfigFile = $archivesItemConfigFile.$archivesFileConfig ['configfile'][$i3].'%%%';
                
  //  echo ($i3.$archivesFileConfig ['father'][$i3].'<strong> ** id scheda ---- </strong>'.$archivesFileConfig ['id'][$i3].'<strong> label ---- </strong>'. $archivesFileConfig['label'][$i3].' <strong>file ---- </strong>'.$archivesFileConfig ['configfile'][$i3].'<br>');            
                
                $archiveItemsRow = $archiveItemsRow .'
                                            <tr><td></td>
                                                <td>    <input type="checkbox" name="c_check_level_WPxdamsBridge'.'['.$i3.']"'. '  value="1"/></td><td>'.'
                                                        <input type="text" readonly="readonly" name="'.$archivesFileConfig['label'][$i3].
                                                            '" value="'.$archivesFileConfig['label'][$i3].'" >'.'  </td><td> </td><td> </td>
                                            </tr>';
		$currLevelNum   =   $currLevelNum +1;	//unused?
                
                if ($archivesFileConfig ['mediafield'][$i3]){
                    $archivesItemMediaFile = $archivesItemMediaFile.$archivesFileConfig ['id'][$i3].'@'.$archivesFileConfig ['father'][$i3].'%%%'.
                                            $archivesFileConfig ['mediafield'][$i3].'%%%';
                }
                if ($archivesFileConfig ['videofield'][$i3]){
                    $archivesItemVideoFile = $archivesItemVideoFile.$archivesFileConfig ['id'][$i3].'@'.$archivesFileConfig ['father'][$i3].'%%%'.
                                            $archivesFileConfig ['videofield'][$i3].'%%%';
                }
             }
        }
        
	$exportLink			=  '<a href="admin.php?page=WPxdamsBridge_export_settings"> export saved settings </a>';  	
	$importLink			=  '<a href="admin.php?page=WPxdamsBridge_import_settings"> import saved settings </a>';  	
		
	$namefieldmedia                 = 'c_xdamsmedia_WPxdamsBridge'.$i;
	$namedesarchive                 = 'c_xdamsdes_WPxdamsBridge'.$i;
        $namestatusarchive              = 'c_xdamsstatus_WPxdamsBridge'.$i;
        $namefieldattachments           = 'c_xdamsattachments_WPxdamsBridge'.$i;
	$namefieldid                    = 'c_xdamsid_WPxdamsBridge'.$i;
	$namefieldxOut                  = 'c_xdamsxOut_WPxdamsBridge'.$i;
        
        // to verify - hidden field are not in use now see similar fields in the next loop - this part crete html to select the archive
	$ArchivesURLS                   = $ArchivesURLS.'
											<tr><td>	<input type="checkbox" name="c_field_import_WPxdamsBridge['.$i.']"'. '  value="1"/> </td>'.'
                                                <td>	<input type="text" readonly="readonly" name="'.$namefieldid .'" value="'.$archivesList ['id'][$i].'" /></td>'.'
                                                <td>	<input type="text" readonly="readonly" name="'.$namedesarchive .'" style="width: 300px;" value="'.$archivesList ['label'][$i].'" /> </td>'.'
						
                                                <td> 	<input type="text" readonly="readonly" name="'.  $namestatusarchive .'" style="width: 150px;" value="'.$alreadySaved .'" /></td> '.'
                                                <td> 	<input type="text" readonly="readonly"  name="noManaged'.$i .'" value="'.$xdamsxOutOut .'" /> ' . '
												<td> 	<input type="hidden"  name="'.$namefieldxOut .'" value="'.$archivesList ['xOut'][$i] .'" /> ' .' 	
														<input type="hidden" name="c_xdamsnum_WPxdamsBridge" value="'.$count2B.'" />'. ' 
                                                
														<input type="hidden" name="c_xdamsitems_WPxdamsBridge'.$i.'" value="'.$archivesItem	.'" />
														<input type="hidden" name="c_xdamsitemfather_WPxdamsBridge'.$i.'" value="'.$archivesItemFather	.'" />
														<input type="hidden" name="c_xdamsitemlabel_WPxdamsBridge'.$i.'" value="'.$archivesItemLabel	.'" />'.'
														<input type="hidden" name="c_xdamsitemfiles_WPxdamsBridge'.$i.'" value="'.$archivesItemConfigFile	.'" /> '.'
														<input type="hidden" name="c_xdamsmediafiles_WPxdamsBridge'.$i.'" value="'.$archivesItemMediaFile	.'" /> '.'
														<input type="hidden" name="c_xdamsvideofiles_WPxdamsBridge'.$i.'" value="'.$archivesItemVideoFile	.'" /> </td>
											</tr>'.
                                                 $archiveItemsRow;
                
        $ArchivesURLS                   = $ArchivesURLS.'
         <tr><td></td>
                                                <td>    <input type="checkbox" name="c_check_searchform_WPxdamsBridge'.'['.$i.']"'. '  value="1"/></td><td>'.'
                                                        <input type="text" readonly="readonly" name="searchformlabel'.$i3.
                                                            '" value="Search Fields" >'.'  </td><td> </td><td> </td>
                                            </tr>';
        
        
    }
   
    $ArchivesURLS                   = '
									<table> <tr>
											<td></td><td>ID</td><td>Description</td><td>Status in DB</td><td>Transformation</td></strong></tr>'.$ArchivesURLS.'
									</table>
								';
    
    $archivesItemFather                 = '';   // the following field are used to import
    $archivesItem                       = '';
    $archivesItemLabel                  = '';
    $archivesItemConfigFile             = '';
    
    for($i3=0;$i3<$countB;$i3++) {
      	
	$archivesItemFather             = $archivesItemFather.$archivesFileConfig ['father'][$i3].'%%%';
	$archivesItem			= $archivesItem.$archivesFileConfig ['id'][$i3].'%%%';
	$archivesItemLabel 		= $archivesItemLabel.$archivesFileConfig['label'][$i3].'%%%';
        $archivesItemConfigFile 	= $archivesItemConfigFile.$archivesFileConfig ['configfile'][$i3].'%%%';
        
      //  echo ('******'.$i3.$archivesFileConfig ['father'][$i3].'<strong> id scheda ---- </strong>'.$archivesFileConfig ['id'][$i3].'<strong> label ---- </strong>'. $archivesFileConfig['label'][$i3].' <strong>file ---- </strong>'.$archivesFileConfig ['configfile'][$i3].'<br>');
    }

    $stamp  = '<div class="wrap">
                <h2>Import Archives Configuration from Files</h2>
                <form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
                    <p>By this page it\'s possibile to import data from the configuration files stored in the "config" folder. You can also: '.$exportLink.' or '.$importLink	.'</p>
                    <fieldset class="options"><br>You have to check both the archive both all sub level you want to import <br>'.$ArchivesURLS.              					 
                                        '<input type="hidden" name="c_xdamsitems_WPxdamsBridge" value="'.$archivesItem	.'" />
					 <input type="hidden" name="c_xdamsitemfather_WPxdamsBridge" value="'.$archivesItemFather	.'" />
					 <input type="hidden" name="c_xdamsitemlabel_WPxdamsBridge" value="'.$archivesItemLabel	.'" />'.
                                    '     <input type="hidden" name="c_xdamsitemfiles_WPxdamsBridge" value="'.$archivesItemConfigFile	.'" /> '.
                                         ' <input type="hidden" name="c_xdamsupdateconfig_WPxdamsBridge" value="'.$archivesConfig['WPxdamsBridge_updateAllConfiguration'][0]	.'" />    
					</fieldset>';
            

    $stamp = $stamp. '
                     <p class="submit">
                        <input type="submit" name="WPxdamsBridge_submit_button_import" value="Import" />
                    </p> ';
               

    $stamp = $stamp. '
                 </form> '.
                $menuArchives.
            '</div>'
  ;
 	
    $stamp = $stamp. '<br>'.$archivesConfig['file_reading_msg'] ;
	  
    print($stamp);	
		
}


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>


