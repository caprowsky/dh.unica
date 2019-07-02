<?php
/*
 functions to manage search form fields settings NEW THE PAGE NOW IS ARCHIVE SETTINGS
*/


    // set startoing message
        
    $json = '{
                            "live": false,
                            "info": "Wait....... procedure in progress...  "
                    }' ; 
    $fp =   fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json', 'w');     
                fwrite($fp,$json);
                fwrite($fp,"\n"); 
                fclose($fp); 


    $maxImportablenum       = 500;
    $archiveId              = WPxdamsBridge_get_archive_id();
    $queryParam             =  WPxdamsBridge_get_admin_param ();
  
    $archiveLabel           = WPxdamsBridge_get_archive_desc($archiveId);
    $xDamsFields            = WPxdamsBridge_get_fields_list($archiveId );
  
    $count                  = $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0]; //number of different items of all archives -non serve???
    $count2                 = $archivesConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives
    $archivesList           = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives
    $temp                   = get_option('WPxdamsBridge_tree_'.$archiveId);
    $splittedTemp           = explode('%%%', $temp);
    $storedCount            = count($splittedTemp);
    $queryNum               = 1;               
  
    for($i1=0;$i1<$storedCount;$i1+=2) {
     // echo( $i1.')'.$splittedTemp[$i1].' - '.$splittedTemp[$i1+1].'<br>');
        if ($splittedTemp[$i1+1]) {
            $storedPreferences[$splittedTemp[$i1]] = $splittedTemp[$i1+1];
                
        }
    }
  
    for($i=0;$i<$count;$i++) {
      	
	if ($i==0) { 
            $menuItems          = '<br>Please configure indexing fields for "'.$archiveLabel.'" :<br><br><table>';
        } 
       
        if ($archiveId == $archivesConfig ['father'][$i] ) { 
            $visualized         = $visualized +1;
            $archiveLevId       = $archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i];
            $archiveConfFile    = WPxdamsBridge_get_archivesItem_file($archiveLevId);  	
            $xDamsFields        = WPxdamsBridge_get_item_metadata($archiveLevId , $archiveConfFile);
            if ($storedPreferences[$archiveLevId]){
                $field          = $storedPreferences[$archiveLevId];
            } else{
                $field          = $xDamsFields ['name'][0];
            }
            $pos=strrpos($field, '/');
            if ($pos){
             //  $field=substr($field, 0, $pos);
            }
            $inputFields ['hierTitle'][$archiveLevId] =  $field  ;

            $menuItems          =  $menuItems. 
		'<tr>'.
                '   <td style="width:220px"><input type="text" readonly="readonly" name="c_labelIndex_WPxdamsBridge['.$visualized.']" value="'.stripslashes($archivesConfig ['label'][$i]).'" /> '.'
                   
                    </td>' .    
                    
                '   <td><input type="text" id="c_fieldIndex_WPxdamsBridge_'.$visualized.'" name="c_fieldIndex_WPxdamsBridge_'.$visualized.'" value="'.$field.'" /> '.'
                        <input type="hidden"  id="c_levelIndex_WPxdamsBridge_'.$visualized.'" name="c_levelIndex_WPxdamsBridge_'.$visualized.'" value="'.$archiveLevId  .'" />
                    </td></tr>'        
                        ;
              /*            $menuItems          =  $menuItems. 
		'<tr>'.
                '   <td style="width:220px"><input type="text" readonly="readonly" name="c_labelIndex_WPxdamsBridge['.$visualized.']" value="'.stripslashes($archivesConfig ['label'][$i]).'" /> '.'
                   
                    </td>' .    
                    
                '   <td><input type="text" id="c_fieldIndex_WPxdamsBridge['.$visualized.']" name="c_fieldIndex_WPxdamsBridge['.$visualized.']" value="'.$field.'" /> '.'
                        <input type="hidden"  id="c_levelIndex_WPxdamsBridge['.$visualized.']" name="c_levelIndex_WPxdamsBridge['.$visualized.']" value="'.$archiveLevId  .'" />
                    </td></tr>'        
                        ;
               */
        }	
  }      
  
    $menuItems  = $menuItems.' </table>'.
                    '<input type="hidden" id="c_fieldsNumber_WPxdamsBridge" name="c_fieldsNumber_WPxdamsBridge" value="'.$visualized  .'" />'.
                     '<input type="hidden" id="c_archiveId_WPxdamsBridge" name="c_archiveId_WPxdamsBridge" value="'.$archiveId  .'" />';
  
 

    for($i=0;$i<$count2;$i++) {
   
	$currentArchive	= 'archivio'; //?
	$separator		= '  -  ';
	if ($i==0) { $separator= 'You can also create tree index for: ';};
		$menuArchives=  $menuArchives. $separator .
		'<a href="admin.php?page=WPxdamsBridge_createtree_'.$archivesList ['id'][$i].'"> '.stripslashes($archivesList ['label'][$i]).'  </a>';
    }	
  
    $xdamsURL 			= WPxdamsBridge_get_option('url',$archiveId);
    $inputFields ['remotefile'] = $xdamsURL ; 
        
    $itemsNum                   = WPxdamsBridge_count_xdams_records ($inputFields, $archiveId);
    
    if ($itemsNum > 0) {
        
	
        $disabled               = '';
        $disabled2              = ''; 
        $itemNumInDB            = WPxdamsBridge_count_records_in_DB ($archiveId) ;
        sleep(1);
        $itemNumInDB2            = WPxdamsBridge_count_records_in_DB ($archiveId) ;
        
        

        
        $queryNum               = 1;
        if ($itemsNum > $maxImportablenum) {
            if ($queryParam['querynum']) {   //not active
                $queryNum           = $queryParam['querynum'];
            }
            
            $messageImport           = '<p><h3>WARNING</h3>
                                            <strong>your archive is very large we will proceed by importing groups of '.$maxImportablenum.' records<br>
                                                    click on the "Submit" button to start the import process<br>
                                                    ---- the process could take some minutes for any step ----
                                            </strong></p>'  ;         

        }
        

        
        if($itemNumInDB  > 0) {  
            $message            = 'There are '.$itemsNum .' records in this xDams archive and '.$itemNumInDB . ' in our DB<br>Have you changed or added new records in xDamsO.S. Platform? <br>';  
             if ($itemsNum > $itemNumInDB) {
                $a1                     = get_option('WPxdamsBridge_tree_lastimporting_page_'.$archiveId);
                $a2                     = get_option('WPxdamsBridge_tree_lastimported_page_'.$archiveId);
                if($a1>$a2) {
                    $resumeCheck        = '
                                            <strong>
                                                Your last import seems aborted on block n. '.$a1 .',
                                                resume from this last block? ( yes -> <input type="checkbox" id="c_resume_check_WPxdamsBridge" name="c_resume_check_WPxdamsBridge" checked=""  value="1" /> )  
                                            </strong>
                                            <input type="hidden" id="c_resumeQuery_WPxdamsBridge" name="c_resumeQuery_WPxdamsBridge" value="'.$a1 .'" />  
                                            ';
                } else {
                    $numPage            = ceil ($itemsNum  / $maxImportablenum) ;
                    if ($a2<$numPage) {
                        $resumeCheck        = '
                                            <strong>
                                                You have already imported  '.$a2 .' blocks,
                                                Restart from block '.($a2+1) .'? ( yes -> <input type="checkbox" id="c_resume_check_WPxdamsBridge" name="c_resume_check_WPxdamsBridge"   value="1" /> )  
                                            </strong>
                                            <input type="hidden" id="c_resumeQuery_WPxdamsBridge" name="c_resumeQuery_WPxdamsBridge" value="'.($a2+1) .'" />  
                                            ';  
                    } else {
                        $resumeCheck        = '<input type="hidden" id="c_noresume_WPxdamsBridge" name="c_resumeQuery_WPxdamsBridge" value="1" /> ';   
                    }
                }
            } else {
                        $resumeCheck        = '<input type="hidden" id="c_noresume_WPxdamsBridge" name="c_resumeQuery_WPxdamsBridge" value="1" /> ';   
            }
        } else {
             $resumeCheck        = '<input type="hidden" id="c_noresume_WPxdamsBridge" name="c_resumeQuery_WPxdamsBridge" value="1" /> ';    
            $message            = 'There are '.$itemsNum .' records in this xDams archive but you never imported anything before. <br>Please import data from xDams<br>';
            $disabled2          = 'disabled=”disabled”';  
        }
        
        if ( $itemNumInDB2 > $itemNumInDB) {  
            $messageImport          = '<p><h3>WARNING</h3>
                                            <strong>An importing procedure is already active!<br> Please wait before starting a new session...</strong></p>';
            $active                 = '<input type="hidden" id="c_status2_WPxdamsBridge" name="c_status2_WPxdamsBridge" value="Attendere" />
                                       <p>Messages: <span class="status2">Attendere....</span></p>';
            $status                 = 'on going...';
            
        } else {
            $printButton            = '
                                <p>
                                    '.$resumeCheck.' 
                                    <input	type="submit" class="pulsante" name="Submit"	value="Submit">
                                </p>';
            $importMessage          ='Import Them!!';
        }

  } else {
	$message                = 'Sorry!!!<br> Your archive is empty <br>';
        $disabled               = 'disabled=”disabled”';
    }
  
    
    $pageTitle		= 
	'<div class="wrap">		
	     
         <h2>Create tree indexing for	'. $archiveLabel . ' </h2> '.	'<p>By this page it\'s possible to create an index to navigate your archive in an hierarchical mode </p> ';

    $before		= '
                    <form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
             
			'.'
                            '. $menuItems.'<br>'
         ;

  
    $afterSubmit		=
          '
            <table>

                <tr><td>
                        
                        <p class="submit">
                            
                            <input type="submit" '.$disabled.'name="WPxdamsBridge_submit_tree_import" value="Save Tree Import Settings" />
                        </p> 
                    </td> <td> 
                      
                       
                    </td> <td>  
                </tr>
                 <tr>
                    <td style="width:220px">
                        <p> '.$message.'</p>
                    </td> <td>
                        <p> '.$message2.'</p>
                    </td>        
                </tr> 
            <table>    
	   </form> 
	 </div>
	<div>
        <input type="hidden" id="c_perPage_WPxdamsBridge" name="c_perPage_WPxdamsBridge" value="'. $maxImportablenum .'" />
        <input type="hidden" id="c_itemsNum_WPxdamsBridge" name="c_itemsNum_WPxdamsBridge" value="'.$itemsNum  .'" />
        <input type="hidden" id="c_itemsNumInDB_WPxdamsBridge" name="c_itemsNumInDB_WPxdamsBridge" value="'.$itemNumInDB  .'" />
        <input type="hidden" id="c_queryNum_WPxdamsBridge" name="c_queryNum_WPxdamsBridge" value="'.$queryNum  .'" />';
    
    
    $extra ='

	<h1>  </h1>

	<form id="modulosottotitolo" action="#" method="post">
            <p>
                <input	type="hidden" class="testo" placeholder="	testo sottotitolo">
            </p>
            <p>
           
                <input type="hidden" name="colore" id="colore" placeholder="colore in	(es. #ff0000)">
            </p>
            
            '.$printButton.' 
               
            
	</form>
        <div id="sottotitolo">
            <h4>'.$importMessage.'</h4>
	</div>
        ';
    $polling        = '<p>Status: <span class="status">'.$status  .'</span></p>'.$active;

    print ($pageTitle.$menuArchives.$before . $optionsTable . $after.   $afterSubmit.$messageImport.$extra .$polling  );
      
	// ((WPxdamsBridge_import_xdams_records ($inputFields, $archiveId);

   if ($queryParam['showrecords']=='yes')   { 
     //   WPxdamsBridge_find_my_father ($archiveId) ;
   }
 
 
/*  **************************************************
      this is the end....  
    **************************************************
*/

?>
