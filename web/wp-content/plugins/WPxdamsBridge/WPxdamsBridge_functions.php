<?php
/*
general functions of the plugin   vedi 786 e 755
*/




/**
 * starting operation.
 */
 
function WPxdamsBridge_start_process() {   
    
	global $currentInfo  ;
	

	$splittedrequest 				= explode("?", $_SERVER['REQUEST_URI']);
	$currentInfo ['newRequestURL']  		= $splittedrequest [0];
	$currentInfo ['originalRequestParam']  		= $splittedrequest [1];
	$splittedparam					= explode("&",  $splittedrequest [1]);
	$count						= count($splittedparam);
	update_option('WPxdamsBridge_active_@all', 1);
        

  
	$currentInfo['No PermalinkPageID']              = $splittedparam  [0];   // usable if user sets permalinks off 
        
        if ($_POST['WPxdamsBridge_text_search_button']=='search') {
            $currentInfo ['newSearchStart']  		= true;
        }
    
        
	for($i1=0;$i1<$count;$i1++)  {
            $splittedfield				=  explode("=",  $splittedrequest [$i1]); //funziona ma probabile errore verificare deve usare $splittedparam? cedi sotto
	
            switch($splittedfield [0]){
            	case 'searchfield':
                    $currentInfo ['searchfield'] 	= $splittedrequest [1];
		break;
            }
        }    
        for($i1=0;$i1<=$count;$i1++)  {
            
       
            $splittedfield2				=  explode("=",  $splittedparam [$i1]); //	?
            switch($splittedfield2 [0]){

                case 'slideIDToEdit':
                    $currentInfo ['slideIDToEdit'] 	= $splittedfield2[1];
		break;
            
            }
		
	}
        $logVisibility = get_option('WPxdamsBridge_test_instance');
        if ($logVisibility== 1 ){
            $currentInfo ['stampa']  		=$logVisibility;
            
           
        }
        $currentInfo ['stampa']  		=0;
        WPxdamsBridge_loadGeneralTerms();
	WPxdamsBridge_start_log() ;  
}



// test if is the admin page for "Stories"

function WPxdamsBridge_loadJSforAdminPage() {
    
    global $currentInfo  ;
            // discover id is the admin story page
    $splittedrequest 			= explode("?", $_SERVER['REQUEST_URI']);
    $pageTest				= explode("_",  $splittedrequest [1]);
    $currentInfo ['storyTest']          =  $pageTest[1];
    $out                                = false;

    if ($pageTest[1] =='stories'){
        $out                            = true;  
    }
    if ($pageTest[1] =='createtree'){
        $out                            = true;  
    }
    if ($pageTest[1] =='story'){
        $out                            = true;  
    }	
     if ($pageTest[1] =='configure' && $pageTest[2] =='output'){
        $out                            = true;  
    }  
    if ($splittedrequest [1] =='WPxdamsStories_stories_list'){
        $out                            = false;  
    }

    $currentInfo ['storyTest']= $currentInfo ['storyTest'].$out;
  return $out;
}

function WPxdamsBridge_start_log() {   
    
	global $WPxdamsBridge_log_active;
	global $wpdb;
	
	$WPxdamsBridge_log_active= 1;

}



function WPxdamsBridge_import_tree_ajax()
	{
	// verifico codice casuale
          
	if ( !wp_verify_nonce( $_REQUEST[ '_nonce' ], 'import-tree-nonce' ) )
	{
	  // die( 'Non	autorizzato');
	}
        
        $json = '{
                            "live": false,
                            "info": "Wait....... procedure in progress...  "
                    }' ; 
        
  
        $fp =   fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json', 'w');     
                fwrite($fp,$json);
                fwrite($fp,"\n"); 
                fclose($fp); 
       
        $itemID                         =  $_REQUEST[ 'itemID' ] ;
        $fieldsNumber                   = strval( $_REQUEST[ 'fieldsNumber' ] );
        $level                          =  $_REQUEST[ 'level' ] ; 
       //  echo('<br>.... inizio elabrazione - campi da verificare '.$fieldsNumber. ' - '. $itemID[1]);
        
        
        
        for($i=1;$i<=$fieldsNumber ;$i++) {
     //        echo('<br>.... carico input field - livello '.$level[$i]. ' valore: '.$itemID[$i]. ' . ');
            $inputFields ['hierTitle'][$level[$i]]= $itemID[$i] ;
	}
        
        $archId                             = strval( $_REQUEST[ 'archId' ] );  ;
        $inputFields ['remotefile']         = WPxdamsBridge_get_option('url',$archId); 
        $inputFields ['itemsNum']           = ( $_REQUEST[ 'itemsNum' ] ); 
        $inputFields ['queryNum']           = strval( $_REQUEST[ 'queryNum' ] ); 
        $inputFields ['perPage']            = strval( $_REQUEST[ 'perPage' ] ); 
    //    update_option('www_import_step0',$inputFields ['queryNum'] );  
        
        
        if ( $inputFields ['itemsNum'] < $inputFields ['perPage'] ) {
            $res = WPxdamsBridge_import_xdams_records($inputFields, $archId);
        } else {
            $numPage                        = ceil ($inputFields ['itemsNum'] / $inputFields ['perPage']) ;
            for($currPage=$inputFields ['queryNum'] ;$currPage<=$numPage   ;$currPage++) {
                
                $inputFields ['queryNum']   = $currPage ;
                $res = WPxdamsBridge_import_xdams_records($inputFields, $archId);
            }
        }
        
        $message = ' numero di pagine '. $numPage .'/'.($currPage-1).$a . ' numero item ' .$inputFields ['itemsNum'] . ' massimo numero ' . $inputFields ['perPage'];
        $message = $res ['msg']  ;
        $json = '{
                            "live": true,
                            "info": "'.$message.'"
                    }' ; 
  
        $fp =   fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json', 'w');     
                fwrite($fp,$json);
                fwrite($fp,"\n"); 
                fclose($fp); 
            
	/* PrgBgrg le variabili
	$output = '';
	$colore = strval( $_REQUEST[ 'colore' ] );
	$testo  = strval( $_REQUEST['testo'] );
	// concateno il testo in variabile output */
                
        sleep(3)  ;      
                
        $json = '{
                            "live": false,
                            "info": "GO....."
                    }' ; 
  
        $fp =   fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json', 'w');     
                fwrite($fp,$json);
                fwrite($fp,"\n"); 
                fclose($fp);                 
                

	$output .= '<h4 style-"color:' . $colore .';">' .$testo.' per archivio: '. $archId .'</h4> ';

	// risultato
	echo $output;
        
        
        
        
        
        
        
        

        // se non impostato torna 0
	die();
	}
        
        function WPxdamsBridge_startPolling_ajax () {
            
            $archId                         = strval( $_REQUEST[ 'archId' ] );    
            $json = '{
                            "live": false,
                            "info": "Starting process for archive '.$archId .'  "
                    }' ; 

            $fp =   fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json', 'w');     
            
            fwrite($fp,$json);
            fwrite($fp,"\n"); 
            fclose($fp); 
            
        // risultato
	echo $output;

        // se non impostato torna 0
	die();
	}
        
        
	add_action( 'wp_ajax_import_tree'   , 'WPxdamsBridge_import_tree_ajax' );
	add_action( 'wp_ajax_polling'       , 'WPxdamsBridge_startPolling_ajax' );
        add_action( 'wp_ajax_pollingonload', 'WPxdamsBridge_startPolling_ajax' );

function WPxdamsBridge_get_xml_field ($row , $fieldName, $startPos=0) {

        $row="$$$ ".$row;  // to manage position = 0

	$first 			= strpos($row, $fieldName, $startPos);
	
	if($first) {
		$first 		= strpos($row, '"', $first);
		$last 		= strpos($row, '"', $first+1);
		$out 	 	= substr($row, $first + 1, $last - $first -1) ; 
	}
	return $out;
} 

// ricerca l'elenco dei campi 
function WPxdamsBridge_get_item_metadata($archiveLevelId) { 

    // $requestedId = item to search in xml result file - leave it null for generic - obsolete for config
	$temp = get_option('WPxdamsBridge_output_fields_'.$archiveLevelId);
	
        $fields_options_from_db 	= explode('%%%', $temp);
        $countField                     = (count($fields_options_from_db) -1 )/ 3 ;  
        
        $temp2 = get_option('WPxdamsBridge_output_labels_'.$archiveLevelId);
        $fields_options_from_db_2 	= explode('%%%', $temp2);
       
        $temp3 = get_option('WPxdamsBridge_output_titlePre_'.$archiveLevelId);
        $fields_options_from_db_3 	= explode('%%%', $temp3);
       
        $temp4 = get_option('WPxdamsBridge_output_titlePost_'.$archiveLevelId);
        $fields_options_from_db_4 	= explode('%%%', $temp4);
       
        $temp5 = get_option('WPxdamsBridge_output_descPre_'.$archiveLevelId);
        $fields_options_from_db_5 	= explode('%%%', $temp5);
       
        $temp6 = get_option('WPxdamsBridge_output_descPost_'.$archiveLevelId);
        $fields_options_from_db_6 	= explode('%%%', $temp6);
       
        $temp7 = get_option('WPxdamsBridge_output_clean_'.$archiveLevelId);
        $fields_options_from_db_7 	= explode('%%%', $temp7);
        
        $temp8 = get_option('WPxdamsBridge_output_descSeparator_'.$archiveLevelId);
        $fields_options_from_db_8 	= explode('%%%', $temp8);
        
        $temp9 = get_option('WPxdamsBridge_output_groupEnd_'.$archiveLevelId);
        $fields_options_from_db_9 	= explode('%%%', $temp9);       
		
	for($i1=0;$i1<$countField;$i1++) 
		{
         
                $i= $i1 * 3;

		$outarray ['label'][$i1]            = $fields_options_from_db[$i+1];  			// labels of fields  
		$outarray ['name' ][$i1]            = $fields_options_from_db[$i];                           // labels of fields
                if($fields_options_from_db_2[$i1]) {
                    $outarray ['olabel'][$i1]       = $fields_options_from_db_2[$i1];
                } else {
                    $outarray ['olabel'][$i1]       = $fields_options_from_db[$i];
                }

                $pos                                = strpos($outarray ['name' ][$i1], '/1');
                
                $outarray['visibility'] [$i1]       = $fields_options_from_db[$i+2];
                
                if($temp3) {
                    $outarray ['titlePre'][$i1]     = $fields_options_from_db_3[$i1];
                } else {
                    if ($pos) {
                        $outarray ['titlePre'][$i1]     = "<em>";
                    } else {
                        $outarray ['titlePre'][$i1]     = "<strong>";
                    }    
                }
                if($temp4) {
                    $outarray ['titlePost'][$i1]    = $fields_options_from_db_4[$i1];
                } else {
                    if ($pos) {
                        $outarray ['titlePost'][$i1]     = ":</em><br>";
                    } else {
                        $outarray ['titlePost'][$i1]     = ":</strong><br>";
                    } 
                }
                if($temp5) {
                    $outarray ['descPre'][$i1]      = $fields_options_from_db_5[$i1];
                } else {
                    $outarray ['descPre'][$i1]      = "";
                }
                if($temp6) {
                    $outarray ['descPost'][$i1]     = $fields_options_from_db_6[$i1];
                } else {
                    $outarray ['descPost'][$i1]     = ";<br><br>";
                }
                 
                if($temp7) {
                    $outarray ['tagClean'][$i1]     = $fields_options_from_db_7[$i1];
                    
                } else {
                    $outarray ['tagClean'][$i1]     = "0";
                }
                if($temp8) {
                    $outarray ['descSeparator'][$i1]= $fields_options_from_db_8[$i1];
                } else {
                    $outarray ['descSeparator'][$i1]= "; ";
                }
                if($temp9) {
                    $outarray ['groupEnd'][$i1]= $fields_options_from_db_9[$i1];
                } else {
                    $outarray ['groupEnd'][$i1]= " ";
                }               
                
	}

	$outarray ['metadata'][1]=$countField ;
				
	return $outarray;
} 
function WPxdamsBridge_get_item_metadataOLD($archiveId, $archiveIdConfFile) { 

    // $requestedId = item to search in xml result file - leave it null for generic - obsolete for config
	$element	= WPxdamsBridge_parse_xml_for_config ($requestedId, $archiveIdConfFile);
	
	$keys 		= array_keys($element); 
	$count 		= count($keys);

			
	for($i1=0;$i1<$count;$i1++) 
		{	
		$outarray ['label'][$i1]        = $keys[$i1];    			// labels of fields
		$outarray ['name' ][$i1]        = $keys[$i1];                           // labels of fields
		$outarray ['multiple' ][$i1] 	= $element[$keys[$i1]]['multiple'];    	// is the field multiple? yes or not
                $outarray ['row' ][$i1] 	= $element[$keys[$i1]]['row'];    	// is the field multiple? yes or not
		
	}

	$outarray ['metadata'][1]=$count;
				
	return $outarray;
} 

// ricerca l'elenco dei campi 
function WPxdamsBridge_importOutpuFieldsInDB($archiveItemFather, $archiveItems, $archiveItemFiles, $requestedArchive=null, $requestedItems=null) {
    
    // $archiveItems contains different levels pf archives
    
    global $archivesConfig;

    $items                          = explode('%%%', $archiveItems);
    $itemsNumber                    = count( $items)-1;
    
    $itemFiles                      = explode('%%%', $archiveItemFiles);
    $itemArchive                    = explode('%%%', $archiveItemFather);
    
    for($i=0;$i<$itemsNumber;$i++) {
	//  update_option ('__ww'.$i , 'ask '.$requestedArchive. ' curr ' . $itemArchive[$i] . ' flag '.$requestedItems[$i] .' - '. $items [$i]);
       
        if ( (!$requestedArchive) || ( ($requestedArchive== $itemArchive[$i]) && $requestedItems [$i] ) ) { // two cases - all items if $requestedArchive=null - a specified archive otherwise
            //update_option ('__ww2'.$i , 'ask '.$requestedArchive. ' curr ' . $itemArchive[$i] . ' flag '.$requestedItems[$i] .' - '. $items [$i]);
            $element                = WPxdamsBridge_parse_xml_for_config ('',  $itemFiles  [$i]);	
            $keys                   = array_keys($element); 
            $count                  = count($keys);
            $out                    = '';
             $out2                    = '';
			
            for($i1=0;$i1<$count;$i1++) 
		{	
		$out                = $out. $keys[$i1].'%%%'.$element[$keys[$i1]]['label'].'%%%1%%%'; 
                $out2               = $out2.$element[$keys[$i1]]['label'].'%%%';
		
            }

            update_option('WPxdamsBridge_out_fields_num_'.$items[$i].'@'.$itemArchive [$i],$count);
            update_option('WPxdamsBridge_output_fields_'.$items[$i].'@'.$itemArchive [$i],$out);
            update_option('WPxdamsBridge_output_labels_'.$items[$i].'@'.$itemArchive [$i],$out2);
        }
    }
				
    return ;
}

function WPxdamsBridge_isAField($inputParam) {	
    
    $out         = true;

    if($inputParam == 'pageToShow' || $inputParam == 'picToShow' ||$inputParam == 'viewType') {    // manage page navigation
       $out         = false;
    }

			
    return $out ;		
}

function WPxdamsBridge_story_publishing_process($atts, $content = null) {
    
    		extract(shortcode_atts(array(				
                                'type' => '1'     ,
                                'height' => '500'    ,
                                'ratio' => ''    ,
                                'interval' => '4000'
				), $atts));
		
		// $type contains parameters e. [xdamsItem type="audiovisivo"]  		
		// $content contains data between shortcode /shortcode	
		global $currentInfo;

                
                $currentInfo['sliderHeight'] = $height ;
                $currentInfo['sliderInterval'] = $interval ;
	
	
                if ($type=='1'){
                    include ('WPxdams_templates/WPxdamsBridge_storyRender1.php');
                } else {
                    include ('WPxdams_templates/WPxdamsBridge_storyRender2.php');
                }
    return $out;     
}
function WPxdamsBridge_tree_publishing_process($atts, $content = null) {
   
		extract(shortcode_atts(array(
				'type'                  => ''     ,
				'redirect'              => '' ,                           // only authority
                                'treetemplate'          => '', 
                                'treestartlevel'                 => '',
                                'listtemplate'          => '',                  
                                'formtemplate'          => '',          // to publish or not the menu with the list          
                                'formdescpost'          => '',
                                'treestartlevel'        => '' ,
                                'showarchives'          => 'yes',
                                'showlist'              => 'no' ,
                
                                
				), $atts));
		
		// $type contains parameters e. [xdamsItem type="audiovisivo"]  		
		// $content contains data between shortcode /shortcode	
		global $currentInfo;
		$content                                    = trim($content);
               
                $currentInfo['searchBoxWidth']  = $boxdim;
		$currentInfo['showarchives']                = $showarchives;
		$currentInfo['showlist']                    = $showlist;
		$currentInfo['formtemplate']                = $formtemplate;  
                $currentInfo['formDescPost']                = $formdescpost ;
                $currentInfo['treetemplate']                = $treetemplate; 
                $currentInfo['listtemplate']                = $listtemplate;
                $currentInfo['treestartlevel']              = $treestartlevel;
		$currentInfo['redirect']                    = $redirect;
		// $type contains parameters e. [xdamsItem type="warning"]  		
		// $type contains data between shortcode /shortcode	
		global $archivesConfig;	
		
		if (!$type) {
			$currLevel			= WPxdamsBridge_get_request_parameter();
			$type				= $currLevel['archID']	;
                       
			$root			 	= 1 	;  // indica che primo livello ï¿½ "tutti gli archivi"
		}
		
		if ($type) {
		    
			if(WPxdamsBridge_get_option('active',$type) == 1){
                           
				$currLevel		= WPxdamsBridge_get_request_parameter();					 
				$archivesConfig 	= WPxdamsBridge_get_archives_config();  //  load archives search configuration 
				$currLevel['root'] 	= $root;
                                
                                
				$outItem 		= WPxdamsBridge_get_childs ($content, $type, $currLevel);
				//$outItem 		= '<div class="alert"> ' .$outItem.'</div>'.' richiesta a URL '. $xdamsURL .' con password '. $xdamsPSW ;
			}
		} else {
                    
			$archivesConfig                 = WPxdamsBridge_get_archives_config();  //  load archives search configuration 
			$currPage		 	= $_SERVER['REQUEST_URI'];
			$count				= $archivesConfig ['WPxdamsBridge_archivesNumber'][0];
			$archivesList                   = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives
			
			for($i=0;$i<$count;$i++) {
				$separator		= ' <br>';
				if(WPxdamsBridge_get_option('active',$archivesList ['id'][$i]) == 1){
				$outItem 		=  $outItem . $separator .
				'<a href="'.$currPage.'&archID='.$archivesList ['id'][$i].'"> '.$archivesList ['label'][$i].'  </a>';
				}
			}
		}
		
		
		return $outItem.'<br><br>';
}

//  test what kind of xml I will receive. with or without xOut transformation

function WPxdamsBridge_getTransformation($archiveId) {   //20160301
   
        global $currentInfo;
        
		$xOutYes = WPxdamsBridge_get_option('xOut' ,$archiveId);
		
		$currentInfo['xmlOutType'] = $xOutYes;
		
        return $currentInfo['xmlOutType'] ;
} 
function WPxdamsBridge_getCurrTransformation() {   //20160301
   
        global $currentInfo;

        return $currentInfo['xmlOutType'] ;
        
}

//  test what kind of xml I will receive. with or without xOut transformation

function WPxdamsBridge_isActiveXslt($archiveId) {   //20160301
   
        global $currentInfo;
        
		$xOutYes = WPxdamsBridge_get_option('xOut' ,$archiveId);
		
		$currentInfo['xmlOutType'] = $xOutYes;
		
		if ($xOutYes=='xslt') {
			return true;
		} else {		
			return false;
		}	
} 

//  test what kind of xml I will receive. is mods or not


function WPxdamsBridge_isMods($archiveId) {  //20160301
   
		global $currentInfo;
     
		$xOutYes = WPxdamsBridge_get_option('xOut' ,$archiveId);
		
		$currentInfo['xmlOutType'] = $xOutYes;
                
              
                 
		
		if ($xOutYes=='mods') {
			return true;
		} else {		
			return false;
		}	
}

//  to delete <tag> from xml


function WPxdamsBridge_cleanXmlTag ($xml) {                 // delete{
   
            $endpos = strpos ($xml , '>' );

	return $xml;
        
}
function WPxdamsBridge_cleanAndReordXmlTagOLD ($xml, $onlyMainValue=false) {                 
   
            $endpos = strpos ($xml , '>' );
		
	    while ($endpos) {
			if ($endpos) {
				$startpos =  strpos($xml , '<' );
				if ($startpos != 0) {
					$xml1 	= substr($xml , 0 , $startpos); 
				}
				$endpos2	= strpos ($xml , '>' , $endpos + 1 );
				$xml2           = substr($xml , $endpos + 1 );
                                $existNewTag    = strpos ($xml2 , '>' );  // to test if it's the last occurrence 
				$sep            ='';
				if ($xml1) {$sep='  ';  }
                                if ($existNewTag !=0){
                                    $xml	=  $xml2;
                           //         if ($xml1) {
                             //           $xml	=  $xml1.$sep.$xml2;
                               //     }
                                    $xml	=  $xml1.$sep.$xml2;
                                    
                                    if ($onlyMainValue ==1) {  // in case of nested tags here show only the main value
                                       $xml	=  $xml1;
                                    }
                                } else {  
                                    $xml	=  $xml1;
                                    if ($xml2) {
                                        $xml	=  $xml2.$sep.$xml1;
                                    }    
                                }
                                
			}
			$endpos = strpos ($xml , '>' );
		}
	return $xml;
        
}

function WPxdamsBridge_disableHtmlChar ($xmlIn) {   // uncorrect html tag can produce error in search              
   
        $out = str_replace('<p>','1Â£$%&=p2Â£$%&=',$xmlIn);
	$out = str_replace('</p>','1Â£$%&=/p2Â£$%&=',$out);	
        $out = str_replace('<span>','1Â£$%&=span2Â£$%&=',$out);
	$out = str_replace('</span>','1Â£$%&=/span2Â£$%&=',$out);	
        $out = str_replace('<strong>','1Â£$%&=strong2Â£$%&=',$out);
	$out = str_replace('</strong>','1Â£$%&=/strong2Â£$%&=',$out);
        $out = str_replace('<h1>','1Â£$%&=h12Â£$%&=',$out);
	$out = str_replace('</h1>','1Â£$%&=/h12Â£$%&=',$out);
        
	return $out;     
}
function WPxdamsBridge_enableHtmlChar ($xmlIn) {   // uncorrect html tag can produce error in search              
   
        $out = str_replace('1Â£$%&=','<',$xmlIn);
	$out = str_replace('2Â£$%&=','>',$out);	
        
	return $out;     
}
function WPxdamsBridge_cleanAndReordXmlTag ($xmlIn, $onlyMainValue=false) {                 
   
   
        $xmlIn = WPxdamsBridge_eliminateCdata ($xmlIn);
        
        $stop  = true;
        $xmlIn = str_replace('<p>', '', $xmlIn);
        $xmlIn = str_replace('</p>', '', $xmlIn);
        
        $xmlIn = WPxdamsBridge_disableHtmlChar ($xmlIn);
		
        while ($stop) {    // recursuve process that eliminates sub tags included in a main tag
           
                $xmlOut  = WPxdamsBridge_eliminateTag ($xmlIn, $onlyMainValue);
                if($xmlIn == $xmlOut) {
                   $stop = false;
                }  
                $xmlIn = $xmlOut;
        }
        $xmlOut = WPxdamsBridge_enableHtmlChar ($xmlIn);
            
	return $xmlOut;     
}
function WPxdamsBridge_eliminateCdata ($xmlIn) {
        
        $newStart               = 0;
        
	$newStart               = strpos($xmlIn, '<![CDATA[' );
          
        while ($newStart )
            {
            $newStart           = $newStart + 9;
            $length             = strpos($xmlIn , ']]>') - $newStart ;
            $xmlIn                = substr ($xmlIn, $newStart, $length).substr ($xmlIn, $newStart + $length + 3);
            $newStart           = strpos ($xmlIn, '<![CDATA[' );
            }   
        
            
	$newStart               = strpos($xmlIn, 'CDATA[' );
        
        while ($newStart )
            {
            $newStart           = $newStart + 6;
            $length             = strpos($xmlIn , ']') - $newStart ;
            $out                = substr ($xmlIn, $newStart, $length).substr ($xmlIn, $newStart + $length + 1);
            $newStart           = strpos ($xmlIn, 'CDATA[' );
            }
            
            
    return $xmlIn;        
}

function WPxdamsBridge_eliminateTag ($xmlIn, $onlyMainValue=false) {                 
   
        $startpos                   =  strpos ($xmlIn , '<' );    // find id there is a tag inside
            
        if ($startpos || ( substr($xmlIn, 0, 1) == '<')) {      // if eliminates
            $extractedTag           =  WPxdamsBridge_getTagName ($xmlIn);
            
            $tagEnd                 =  '</'.$extractedTag.'>';
            $tagStart               =  '<'.$extractedTag;
            $xml1                   =  WPxdamsBridge_GetElementByTagOnShoot ($xmlIn, $tagStart, $tagEnd);
            
            /*
            echo ('<br>input -- '.str_replace('<', '%', $xmlIn).' cerca - '.$extractedTag.' <br>pre - '.$xml1['pre'].
               '<br> valore --'.str_replace('<', '%', $xml1['requestedValue']).
                '<br> post --'.str_replace('<', '%', $xml1['post']).    
                    ' - cbr1 --<br>');
            */
            $xmlOut                 =  $xmlIn;
            if ($xml1['ok']) {
                $xmlOut             = $xml1['pre'];
                if(!$onlyMainValue){
                    $xmlOut         = $xmlOut .' '.$xml1['requestedValue'] ;
                }
                $xmlOut             = $xmlOut .' '.$xml1['post'];
            }
        } else {
             $xmlOut=$xmlIn; 
        }
    return $xmlOut;     
}

function WPxdamsBridge_getTagName ($xmlIn) {      
    
        $xmlOut             = false;
        $startpos           = strpos ($xmlIn , '<' );    // find id there is a tag inside
            
        if ($startpos || ( substr($xmlIn, 0, 1) == '<')) {      // 
            $endtagpos1     = strpos ($xmlIn , ' ' ,$startpos);
            $endtagpos2     = strpos ($xmlIn , '>' ,$startpos);
            if($endtagpos1 && ($endtagpos1< $endtagpos2)) {   
               $endtagpos   = $endtagpos1 ;          // case : after the tag id there is a space
            } else {
               $endtagpos   = $endtagpos2 ;          // case : after the tag id there is a >
            }
            
            $extractedTag   = substr($xmlIn, $startpos + 1, $endtagpos -$startpos -1);         
            $xmlOut         = $extractedTag; 
        }
    return $xmlOut;     
}

function WPxdamsBridge_GetElementByTagOnShoot ($xml, $start, $end) {
                

        $startpos                       = strpos($xml, $start);
        
        if ($startpos === false) {
            return $out['ok']   = false;
        }
        $newStart                       = strpos($xml, '>' , $startpos );
        $endpos                         = strpos($xml, $end);
        
        if ($endpos === false) {       
            $endpos                     = strpos($xml, '/>');
            
            if ($endpos === false) {     
                $endpos                 = strpos($xml, '>');
                
                if ($endpos === false) {
                   return $out['ok']    = false;
 
                } else {
                    $end                = '>';
                    $out['ok']          = true;   
                    $stop               = 1;
                }
            } else {
                $end                    = '/>';
                $out['ok']              = true;
                $stop                   = 2;
            }
           
            if( $out['ok']) {
                $out['post']         = substr ($xml, $endpos + 2); 
                if ($startpos > 0) {
                    $out['pre']         = substr ($xml, 0, $startpos);
                }
            }
           return $out;
        }
        $endpos                 = $endpos+strlen($end);   
   
        $lengt                  = $endpos - $newStart - 1;
        $lengt                  = $lengt - strlen($end);
       // $tag                    = substr ($xml, $startpos, $lengt);
        $tag                    = substr ($xml, $newStart+1, $lengt);

        $newStart               = 0;
	$newStart               = strpos($tag, 'CDATA[' );
	if ($newStart) {
            $newStart           = $newStart + 6;
            $length             = strrpos($tag , ']') - $newStart -1;
            $tag                = substr ($tag, $newStart, $length);
	}
        
        $out['ok']              = true;
        $out['requestedValue']  = $tag;
        if ($startpos > 0) {
            $out['pre']         = substr ($xml, 0, $startpos);
        }

        
        if (strlen($xml) > ($endpos) ) {    // CBRQQ 
 
           $out['post']         = substr ($xml, $endpos);   
        }
       
        return $out;
            
  
}


//  case parsing of XML complete    

function WPxdamsBridge_loadItemCustomization($archiveLevelId) {
    $out [1] 	= get_option('WPxdamsBridge_output_titlePre_'.$archiveLevelId);
    $out [2] 	= get_option('WPxdamsBridge_output_titlePost_'.$archiveLevelId);
    $out [3] 	= get_option('WPxdamsBridge_output_descPre_'.$archiveLevelId);
    $out [4] 	= get_option('WPxdamsBridge_output_descPost_'.$archiveLevelId);
    
    return $out;
}



function WPxdamsBridge_getItemCustomization($fields_customization_from_db , $currFieldNumber, $type ) {
    
    
    switch($type){
    
        case 'titlePre':
            $temp   = $fields_customization_from_db [1] 	;
        break;        
        
        case 'titlePost':
            $temp   = $fields_customization_from_db [2] 	;
        break;        
    
        case 'descPre':
            $temp   = $fields_customization_from_db [3] 	;
        break;
        
        default:
            $temp   = $fields_customization_from_db [4] ;    
        break;
     }
   
        $tempArray       = explode('%%%', $temp);
        
        $out        = $tempArray[$currFieldNumber];
    
    
    return $out;
}



//  case parsing of XML complete    

function WPxdamsBridge_parseCompleteXML(  $archiveId , $currNode , $requestType, $tempcanc='') {

    global $WPxdamsBridge_cCounter;
    global $archivesConfig;
    global $currentInfo;
    global $element;
    global $rowData;
    //initialize field search
    
    $currNode 					= utf8_encode ( $currNode );
   
    $level                              	= WPxdamsBridge_GetElementLevel($currNode);
    
    $archiveLabel                       	= WPxdamsBridge_get_archive_desc($archiveId);	 			// archive desc
    $archiveLevelId                     	= $level .'@'.$archiveId;  
    $fields_options_from_db 			= get_option('WPxdamsBridge_output_fields_'.$archiveLevelId);	// custom labels from user strored in DB
    $fields_number_from_db  			= get_option('WPxdamsBridge_out_fields_num_'.$archiveLevelId);	// custom labels from user strored in DB
    $fields_customization_from_db               = WPxdamsBridge_loadItemCustomization($archiveLevelId);
    $schema                             	= WPxdamsBridge_getCurrTransformation ();
    $customSettings                             = WPxdamsBridge_get_item_metadata($archiveLevelId);
        
    switch($schema){
    
        case 'lido':
          //  $itemTagStart 			= '<lido>';
          // $itemTagEnd 			= '</lido>';
            $itemId 				= WPxdamsBridge_GetElementByTag($currNode , '<lidoRecID', '</lidoRecID>' ) ;
           
        break;
        case 'eaccpf':
            $itemId 				= WPxdamsBridge_GetElementByTag($currNode , '<recordId>', '</recordId>' ) ;
           
        break;
        case 'mods':
            $itemTagStart 			= '<mods ';
            $itemTagEnd 			= '</mods>';
            $itemId 				= WPxdamsBridge_get_xml_field ('<mods '.$currNode , 'ID'); // necessario perchÃ¨ ID in posizione zero
        break;
        default:
            $itemTagStart 			= '<c ';
            $itemTagEnd 			= '</c>';
            $itemId 				= WPxdamsBridge_get_xml_field ($currNode , ' id');
        break;
    }	
    
        
    $currentInfo ['requestedId']                = $itemId;	
    $currentInfo ['archiveDesc']                = WPxdamsBridge_get_archive_desc($archiveId);			// archive desc
    $currentInfo ['requestedItemLevel']         = $level;
   
    $currentInfo ['mediaFileName']              = WPxdamsBridge_getAttachments($currNode, $archiveLevelId);
    $currentInfo ['videoFileName']              = WPxdamsBridge_videoUrl($currNode, $archiveLevelId);
    $currentInfo ['fields_options_from_db']     =  $fields_options_from_db ;
			
    for($i1=0;$i1<$fields_number_from_db;$i1++)      // for any field present in the configuration file
	{	
	 			
	WPxdamsBridge_resetGetElement ();
				
        if (WPxdamsBridge_fieldIsVisible($fields_options_from_db, $i1 )) {       // id it is visible         

            $desc                               =  WPxdamsBridge_getFieldCustomDesc($fields_options_from_db, $i1 ) ;
            $name                               =  WPxdamsBridge_getFieldName($fields_options_from_db, $i1 ) ;
            
            $xpathYes                           =  strpos($name, '/');
            $toPublishItem          		=  '';
	      
            if ($xpathYes) {                                 // case 1 it's described by a path eg. level1/level2/level3
	        $pathItem 			= explode('/', $name);
				
                $toPublishItem   		= WPxdamsBridge_recursiveTagSearch(  $pathItem , $currNode, 1, 1, $i1, $fields_options_from_db, 0, ""  ,  $customSettings  ,$requestType );
                
                if($toPublishItem) {
                   if (WPxdamsBridge_getGroupEnd ($i1 , $customSettings) ) {
                       $toPublishItem   	= $toPublishItem  .WPxdamsBridge_getGroupEnd ($i1 , $customSettings) ;
                   }     
                }
                $jump                           = WPxdamsBridge_getJump (  $i1,  $pathItem, $fields_options_from_db  );
				
            } else {
                $toPublishItem           	= WPxdamsBridge_extractSimpleTag(  $name , $currNode);
                $jump                           = 0;
            }
            $element [$name] [0]        	= $toPublishItem;	
            if ( $i1 == ($currentInfo['itemmultisearch'] - 1)) {
                $currentInfo ['authoritySearchValue'] =  $rowData; //  $toPublishItem;  //  itemmultisearch setted in shortcode with number of fields
            }
        }
        $i1                                 = $i1	+ $jump ;
    }
	return $element;
}

function WPxdamsBridge_getJump (  $currFieldNumber,  $currPathItem, $fields_options_from_db  ) { // find all the occurrence of a tag in a block
    // to jump any field already extract in the recursive serach for grouped fields
	
    $pathItemNum            = count($currPathItem);
    $groupedFields          = explode('[', $currPathItem [$pathItemNum-1]  );
    $jump                   = $groupedFields [0] - 1 ;
                                
    for($i=1;$i < $groupedFields [0];$i++) { 
	
        $name               = WPxdamsBridge_getFieldName($fields_options_from_db, $i + $currFieldNumber ) ;
        $pathItem2          = explode('/', $name);
        $jump               = $jump + 	WPxdamsBridge_getJump (  $i + $currFieldNumber,  $pathItem2 , $fields_options_from_db  );
    }

    return    $jump   ;
}
function WPxdamsBridge_extractSimpleTag(  $fieldName , $currNode) { // find all the occurrence of a tag in a block
    $tagEnd                 =  '</'.$fieldName.'>';
    $tagStart               =  '<'.$fieldName;
    $prevNode               = '';
    $temporaryNode          = $currNode;
    $separator              = '';
						
    while ( $temporaryNode != $prevNode) {    // find different occurences of a tag
        $prevNode           = $temporaryNode;
        $temp               = WPxdamsBridge_GetElementByTag($temporaryNode, $tagStart, $tagEnd ); 
        $temp               = WPxdamsBridge_cleanAndReordXmlTag ($temp);
        $toPublishItem      = $toPublishItem .$separator .  $temp; 
        if (WPxdamsBridge_existNewElementByTag($temporaryNode, $tagStart) ) {
            $temporaryNode  = WPxdamsBridge_getNewBlockToExplore ($temporaryNode); 
        }
        $separator              = ', ';  // memo... here you can manage multiple occurence of same field separtor
    }
    return    $toPublishItem   ;
}

//canc?
function WPxdamsBridge_extractTagNodes(  $pathItem , $currNode) { // find all the occurrence of a tag in a block
        $GtagEnd            =  '</'.$pathItem .'>';
        $GtagStart          =  '<'.$pathItem ;
        $splittedNodes       = explode($GtagEnd , $currNode."endOfString");  // exception case : tag = end of string than $tagOccurence = 1 and after = 0
        $tagOccurence       = count($splittedNodes) - 1;	
          
        
        return  $splittedNodes  ; 
                                        // exception case : tag end = end of string than $tagOccurence = 0

}
function WPxdamsBridge_recursiveTagSearch(  $pathItem , $currNode, $level , $startLevel, $currFieldNumber, $fields_options_from_db, $sameLevelWithFollowers, $descIn ,   $customSettings  , $requestType ) { // find all the occurrence of a tag in a block
        
		global $rowData;
		// to navigate the part of xml containg the different tags of the xpath
        
        $pathItemNum                    = count($pathItem);        
        if ($level==$startLevel){  // for any initial search of a field I test if there are successive grouped fields
            $sameLevelWithFollowers     = WPxdamsBridge_findCommonPath_forFollowers( $pathItem , $currFieldNumber);
        }

        $GtagEnd                        = '</'.$pathItem[$level- 1] .'>'; 
        $GtagStart                      = '<'.$pathItem [$level- 1];
                                                   
		//  divide in subnodes by any occurrence of the closing tag	and for any node I find the tag
		
        $splittedNodes                  = explode($GtagEnd , $currNode."endOfString");  // exception case : tag = end of string than $tagOccurence = 1 and after = 0
        $tagOccurence                   = count($splittedNodes) - 1;	
        
        
       // echo ('<br>cbr1 tag -- '.str_replace('<', '%',$GtagEnd).'  - <br>');
        
        $splittedNodes                  = WPxdamsBridge_split_similar_nodes ( $GtagStart ,$GtagEnd , $currNode."endOfString"); 
        
        if( $splittedNodes) {
            $keys                       = array_keys($splittedNodes ); 
            $tagOccurence               = count($splittedNodes) -1 ;
        } else {
            $tagOccurence               = 0;
        }        
        
        $insertedValue                  = false;    
        
        for($iOc=0;$iOc < $tagOccurence;$iOc++) {
                           
            $currNode                   = WPxdamsBridge_truncXmlbyTag(  $GtagStart  , $splittedNodes [$keys[$iOc]]);  //  truncate before opening tag

            if ($level==$pathItemNum-1){      // if current level = last level of the path find the value else truncate the node
                            
                $temp                   = WPxdamsBridge_findAttValue( $pathItem [$pathItemNum-1], $splittedNodes [$keys[$iOc]]);
                $itemAttVal             = $temp[1];   // $temp  1= value of the attribute  2 = requested value for the attribute 3 = they match 4 = don't publish                                                  //  $out            = WPxdamsBridge_cleanXmlTag ($currNode);   RIPRISTINARE
                $dontPublishValue       = $temp[4]; 
        
                if(($temp[2] && $temp[3]) || (!$temp[2])) {
                    if($temp[2] && $temp[3]) {
                        $itemAttVal = ''; //in this case the attribute has been used only to match the occurrence
                    }
                           //  echo( '<br>....---- desc-'.$descIn .'.valore attributo-'.$temp[2].'-valore test '.$temp[3].'cbr <br>');     
                    $pre1                   = "";
                    $post1                  = "";
                    $pre2                   = "";
                    $post2                  = "";
                            
                    $out                    = WPxdamsBridge_cleanAndReordXmlTag ($currNode,  WPxdamsBridge_isTagToClean($currFieldNumber, $customSettings));
             
                    if ($descIn) {
// normally added in publishing phase
                        $before             =  $descIn;   // for nested fields I insert the field description in the result
                        $pre1               =  WPxdamsBridge_getTitlePre ($currFieldNumber, $customSettings) ;
                        $post1              =  WPxdamsBridge_getTitlePost ($currFieldNumber, $customSettings)  ;   
                    }
            
                
                    if (( $itemAttVal || $out) && ($requestType=='single')) {   // it doesn't add format option for title
                        if ($out) {
                            $pre2           =  WPxdamsBridge_getValuePre ($currFieldNumber, $customSettings) ;
                            $post2          =  WPxdamsBridge_getValuePost ($currFieldNumber, $customSettings) ;
                            if($insertedValue) {
                                $separator2 =  WPxdamsBridge_getValueSeparator ($currFieldNumber, $customSettings) ;
                            }
                            $insertedValue  = true; // insert the separatori only after the first occurrence
                        }
                    
                    }
                    if ($dontPublishValue) {
                        $out                = ' '; 
                    }
                    $resultTag              = $resultTag.$pre1.$before.$post1 .$separator2 .$pre2 .$out.  $itemAttVal.$post2;
                    $rowData                = $out;
		// to navigate th
                }
            } else {
			    // find deeper in the node the tag  ELIMINARE  $fields_customization_from_db 
                $result                 = WPxdamsBridge_recursiveTagSearch(  $pathItem , $currNode, $level + 1, $startLevel,  $currFieldNumber, $fields_options_from_db, $sameLevelWithFollowers,$descIn ,   $customSettings   , $requestType )  ;
                $resultTag              = $resultTag. $result	;
              
                if ( $level == $sameLevelWithFollowers  ){
                    $groupedFieldsNum	= explode('[', $pathItem [$pathItemNum-1]  );

                    for($i=1;$i < $groupedFieldsNum[0];$i++) {  
                    
                        $desc           = WPxdamsBridge_getFieldCustomDesc($fields_options_from_db, $currFieldNumber + $i ) ;     // following fields case  
                        $name           = WPxdamsBridge_getFieldName($fields_options_from_db, $currFieldNumber + $i ) ;
                        $pathItem2      = explode('/', $name);
                        $pathItemNum2   = count($pathItem2);
                        $nestedFields   = WPxdamsBridge_recursiveTagSearch(  $pathItem2 , $currNode, $sameLevelWithFollowers + 1, $sameLevelWithFollowers + 1,  $currFieldNumber +$i , $fields_options_from_db, $sameLevelWithFollowers, $desc,   $customSettings ,$requestType  );
                        
                        if ($nestedFields) {
                           $groupedFields  = $groupedFields.$nestedFields ;
                        }
                    }
                    $resultTag          = $resultTag. $groupedFields;
                    $groupedFields      = '';
                }
            } 
        } 
        
        return  $resultTag;  
                                                
}

function WPxdamsBridge_split_similar_nodes ( $GtagStart ,$GtagEnd , $currNode) { 
    
    
    $posStart                       = strpos('$'.$currNode, $GtagStart);
    
    if($posStart) {
       $splitted                    = explode($GtagStart , $currNode);    // divide ogni occorrenza
       $count                       = count($splitted); 
       $initial                     = $splitted[0];  // manage inital part to avoit to discard it
       for($i=1;$i < $count;$i++) {

           $posEnd                  = strpos($splitted[$i], $GtagEnd);    // prova a eliminare il tag chiusura
           if ($i > 1) {
               $initial             = '';
           }
           $saveOccurence=true;
           if($posEnd) {
              
               $lastindex               = 1;
               $splitted2               = explode($GtagEnd , $splitted[$i]); 
               if ($mergeOccurrence) {       // in this case the new occurence of is nested int the previous one
                    if ($splitted2[2]){
                       $mergeLast       = $GtagEnd.$splitted2[1]; 
                       $mergePrevious   = $previousString ;
                       $previousString  = '';
                       $mergeOccurrence = 0;
                    } else {
                       $saveOccurence   =false; 
                       $previousString  = $previousString . $GtagStart.$splitted[$i]; 
                       
                    }
                   
   
               }
               if($saveOccurence  ) { 
                    $out[$i-1]           = $initial. $mergePrevious.$GtagStart.$splitted2[0]. $mergeLast ;
                    $mergePrevious       =  '';
                    $mergeLast           =  '';
               }
               if ($i== $count-1) {
                   $out[$i]         = $splitted2[$lastindex]; 
               }
           } else {
               $posEnd              = strpos('$'.$splitted[$i], '/>');    // evaluate case with no specific closing tag
               $posTemp             = strpos('$'.$splitted[$i], '<');  
            
               if($posEnd) {
                    if($posTemp > $posEnd ) {                         // yes the tag is closed by  '/>'
                        $splitted2  = explode('/>' , $splitted[$i]);  
                        $out[$i-1]  = $GtagStart.$splitted2[0].'/>';
                        if ($i== $count-1) {
                            $out[$i]= $splitted2[1]; 
                        } else {
                          $mergeOccurrence = $mergeOccurrence + 1;
                          $previousString  = $previousString . $GtagStart.$splitted[$i];
                        }                        
                    } else {
                        $out[$i-1]  = $GtagStart.str_replace('endOfString', '',  $splitted[$i] );
                        if ($i== $count-1) {
                            $out[$i]= 'endOfString'; 
                        }
                        
                    }
                } else {
                     $mergeOccurrence = $mergeOccurrence + 1;
                     $previousString  = $previousString . $GtagStart.$splitted[$i]; 
                }
           }                     
        
       } 
    }
    
    return $out;
                          
}

function WPxdamsBridge_split_similar_nodesOld2 ( $GtagStart ,$GtagEnd , $currNode) { 
    
    
    $posStart                   = strpos('$'.$currNode, $GtagStart);
    
    if($posStart) {
       $splitted                = explode($GtagStart , $currNode);    // divide ogni occorrenza
       $count                   = count($splitted); 
       $initial                 = $splitted[0];  // manage inital part to avoit to discard it
       for($i=1;$i < $count;$i++) {
           
           $posEnd              = strpos($splitted[$i], $GtagEnd);    // prova a eliminare il tag chiusura
           if ($i > 1) {
               $initial         = '';
           }
           if($posEnd) {
                $splitted2      = explode($GtagEnd , $splitted[$i]);  
                $out[$i-1]      = $initial.$GtagStart.$splitted2[0];
                if ($i== $count-1) {
                    $out[$i]    = $splitted2[1]; 
                }
           } else {
                $posEnd         = strpos($splitted[$i], '/>');  
                if($posEnd) {
                    $splitted2  = explode('/>' , $splitted[$i]);  
                    $out[$i-1]  = $GtagStart.$splitted2[0].'/>';
                    if ($i== $count-1) {
                        $out[$i]= $splitted2[1]; 
                    }
                }
           }
       } 
    }
    
    return $out;
                                        
}


function WPxdamsBridge_split_similar_nodes_old ( $GtagStart ,$GtagEnd , $currNode) {    // canc
    
    
    
    $newXML             ='$'.$currNode;
    $lenghtS            = strlen($GtagStart);
    $lenghtE            = strlen($GtagEnd);
    $newStart           = 0;
    $i                  =0;
    $continue           = true;

    
  
    while ($continue) {
        
        $pos            = strpos($newXML, $GtagStart, $newStart);
        if ($pos && $i <5 ) {
            $endPos     = strpos($newXML, $GtagStart,  $lenghtS + $pos) ;  // first case there are more than one occurrence
            $add        = -1;
            if (!$endPos) {
               // echo('ooooooooooooooooooooo');
                $endPos = strpos($newXML, $GtagEnd, $lenghtS + $pos) ;    //  second case end tag complete
                $add    =  $lenghtS   + 1    ;
            }
            if (!$endPos) {
            //    echo('ccccccccccccccccccccc');
                $endPos = strpos($newXML, '/>', $lenghtS + $pos) ;  // third cade />
                $add        = 2;
            }
            if ($endPos) {
                $endPos= $endPos + $add;
                $newLenght  = $endPos - $newStart ;
                $temp       = substr($currNode, $newStart, $newLenght - $add -1);
                $out [$i]     = $temp;
                $newStart   = $endPos ;
         //       echo ('<br> posizione '.$pos.'/'.$endPos.'/'.$newStart .' splittato in '. str_replace ('<', '__' ,$out [$i]). '<br>');
                $i=$i +1;
            } else {    
                $continue   = false;
            }          
        } else {    
            $continue   = false;
        }
        
    }
    $out [$i]     = substr($currNode,  $newStart );
                return $out;
                                        
}

function WPxdamsBridge_findCommonPath_forFollowers ( $pathItem , $currFieldNumber) { 

// find all common occurrence of  tag among grouped fields
                           	
    global $currentInfo;
    $pathItemNum                = count($pathItem);
       
    $groupedFields		= explode('[', $pathItem [$pathItemNum-1]  );
    $fields_options_from_db     = $currentInfo ['fields_options_from_db'];
                            
    for($i=1;$i < $groupedFields [0];$i++) {    
        if (WPxdamsBridge_fieldIsVisible($fields_options_from_db, $i + $currFieldNumber )) {       // id it is visble         

            $desc		= WPxdamsBridge_getFieldCustomDesc($fields_options_from_db, $i + $currFieldNumber ) ;
            $name		= WPxdamsBridge_getFieldName($fields_options_from_db, $i + $currFieldNumber ) ;
            $pathItem2 		= explode('/', $name);
            $pathItemNum2       = count($pathItem2);
            for($iTag=0;$iTag < $pathItemNum2 ;$iTag++)  
                
                if ($iTag < $pathItemNum ) {    
                    if ($pathItem2 [$iTag] == $pathItem [$iTag]  ) {
                         $tagMatching [$iTag]=$tagMatching [$iTag]+1;
                    }
                }
            } 

       
    } 
     if ($pathItemNum2)  {
       for($iTag=0;$iTag < $pathItemNum ;$iTag++)  {
       
            if ($tagMatching [$iTag]==$groupedFields [0]-1){
                $sameLevel=$sameLevel+1;
            }
       }    
     }   
 
    return $sameLevel;
}

function WPxdamsBridge_findAttValue( $pathItem , $xml) { // find an attribute of a tag
                           	
        $out[2]         = false;
        $out[3]         = false;
        $out[4]         = false;        
        
        $dontPublishValue   = strpos($pathItem, '@]') ;  // third cade />
        
        if($dontPublishValue) {
            //echo('<br>....'.$pathItem.'<br>');
            $out[4]     = true;  
            $pathItem   = str_replace ('@]' , ']' , $pathItem );
                    ;
        }
        
        $canc		= explode('[',$pathItem );

                
        if ($canc [1]) {
            $canc2	= explode('=',$canc [1]);
            $itemAtt	= str_replace (']' , '' , $canc2 [0] );
            $canc2 [1]  = str_replace (']' , '' , $canc2 [1] ) ;
        } else{
            $itemAtt	= '';	
        }
        
        if ($itemAtt) {
            $itemAtt    =  WPxdamsBridge_get_xml_field ($xml, $itemAtt);
            if ($itemAtt) {
                $out[1]	= ' ['. $itemAtt . '] ';
            }    
        }
        if ($canc2 [1] ) {
            $out[2]	= $canc2 [1];
            if ($canc2 [1] == $itemAtt) {
                $out[3] = true;
            }
        }
        
        return $out;
}                            
function WPxdamsBridge_truncXmlbyTag( $tagStart , $currNode) { // find all the occurrence of a tag in a block
   
    $tag            = $tagStart." ";
    $text           = "$".$currNode ;
    $tagLen         = strlen($tagStart) ;
     
    $pos            = strpos( $text,$tag );
 
    if ($pos) {      
        $pos        = strpos( $text, '>' , $pos)  + 1 ;
    } else {
        $pos        = strpos( $text,$tagStart.'>' )  + 1 + $tagLen ;
    }
    $out                = substr ($text, $pos  );
    
    return $out ;
}

function WPxdamsBridge_truncXmlbyTagOLD( $tagStart , $currNode) { // find all the occurrence of a tag in a block
   
    $tag = $tagStart." ";
    $text=        "initial".$currNode ;
     
     $pos = strpos( $text,$tag );
 
    if ($pos) {
        $tempCanc           = explode($tagStart." " ,  "initial".$currNode); 
        $startpos           = intval(strpos($tempCanc [1], '>'  ));
        $lengt              = strlen($tempCanc [1]) - $startpos ;
        $startpos           = $startpos + 1 ;
        $tempCanc [1]       = substr ($tempCanc [1], $startpos , $lengt);
    } else {
        $tempCanc           = explode($tagStart.">" ,  $currNode); 

    }
    return $tempCanc [1] ;
}

//  management of the short code for publishing a specific item of an archive 

function WPxdamsBridge_getAttachments($currNode, $archiveLevelId) {

	$media_fields_from_db  	= get_option('WPxdamsBridge_media_fields_'.$archiveLevelId);	// custom media field strored in DB
	if ($media_fields_from_db){
	
	    $option                 = strpos($media_fields_from_db, '[');
            if ($option) {
                
                $tag                = explode('[' , $media_fields_from_db ); 
                $start              = $tag[0];
                $startAttribute     = str_replace(']','',$tag[1]);
                $jump               = strlen($startAttribute); 
                $startPos           = strpos($currNode, $start );    // find first occurrence
            } else {
               
                $jump               = strlen($media_fields_from_db );
	        if ( WPxdamsBridge_isMods(WPxdamsBridge_getCurrentArchiveId()) ) {
                    $start          = '<'. $media_fields_from_db;
                    $end            = '</'. $media_fields_from_db.'>';
                } else { 
                    $start          = $media_fields_from_db;
                    $startAttribute = $media_fields_from_db;
                }	
            }	
            $startPos               = strpos($currNode, $start );    // find first occurrence
         
		
            while ($startPos) { 
        //                 
               
                if ( WPxdamsBridge_isMods(WPxdamsBridge_getCurrentArchiveId()) ) { 
                        
                    $temp           = WPxdamsBridge_GetValueByTag ($currNode , $start, $end, $startPos );
                } else { 
                    $temp           = WPxdamsBridge_get_xml_field ($currNode , $startAttribute, $startPos );
                }
                
                $out[]              = $temp;
                $temp1              = $temp1.' - '.$temp. ' / ' .$startPos;
                $startPos           = strpos($currNode, $start, $startPos + $jump );    // find new occurrence
            }
        }
	return $out;
}

function WPxdamsBridge_videoUrl($currNode, $archiveLevelId) {

	$video_fields_from_db  	= get_option('WPxdamsBridge_video_fields_'.$archiveLevelId);	// custom media field strored in DB

    if ($video_fields_from_db)	{
		
		$tag					= explode('/' , $video_fields_from_db ); 
		$jump                   = strlen($tag[0] ); 
		$start					= $tag[0];
		$startPos 				= strpos($currNode, $start );    // find first occurrence
		$log=	$video_fields_from_db. ' - ' . $start. ' s ' . $startPos;
        
		
		while ($startPos) { 

			$temp		= WPxdamsBridge_get_xml_field ($currNode , $tag[1], $startPos );
			
            $out[]                  = $temp;
			$startPos               = strpos($currNode, $start, $startPos + $jump );    // find new occurrence
		}
		$out['log']=$log;
	}
	return $out;
}


//  management of the short code for publishing a specific item of an archive 



function WPxdamsBridge_image_publishing_process($atts, $content = null) {
   
		extract(shortcode_atts(array(
				'type' => 'info'
				), $atts));
		// $type contains parameters e. [xdamsItem type="warning"]  		
		// $content contains data between shortcode /shortcode	
		
		if(WPxdamsBridge_get_option('active',$type) == 1){

                        $content   	= trim($content);
			
			//  this is only to load data from file 			
			$outItem 	= WPxdamsBridge_single_item_request ($content, $type);
			$outItem	= WPxdamsBridge_getImage();   // get the current image
		}
		
		return $outItem;
} 


//  management of the short code for publishing a specific item of an archive 

function WPxdamsBridge_page_publishing_process($atts, $content = null) {
   
		extract(shortcode_atts(array(
				'type' => 'info'
				), $atts));
		// $type contains parameters e. [xdamsItem type="warning"]  		
		// $content contains data between shortcode /shortcode	
		
		if(WPxdamsBridge_get_option('active',$type) == 1){

            $content   	= trim($content);
			$outItem 	= WPxdamsBridge_single_item_request ($content, $type);
		}

		
		return $outItem;
} 
//  management of the short code for publishing a results page for an archive 

function WPxdamsBridge_listing_publishing_process($atts, $content = null, $tag) {
                  
		extract(shortcode_atts(array(
				'type'                  => 'info'     ,
                                'vocabulary'            => 'no' ,
				'itemmultisearch'       => '0' ,
				'redirect'              => '' ,                           // only authority
                                'height'                => '500'    ,
                                'ratio'                 => ''    ,
                                'listtemplate'          => '',
                                'vocabularytemplate' 	=> '',
                    		'listdesc1'             => '',
				'listdesc2'             => '',                     
                                'menutemplate'          => '',          // to publish or not the menu with the list          
                                'showarchives'          => 'yes',
                                'showlist'              => 'no',
                                'interval'              => '4000'
				), $atts));
		
		// $type contains parameters e. [xdamsItem type="audiovisivo"]  		
		// $content contains data between shortcode /shortcode	
		global $currentInfo;
		$content                                    = trim($content);
                
                $currentInfo['sliderHeight']                = $height ;
                $currentInfo['sliderInterval']              = $interval ;
		$currentInfo['showarchives']                = $showarchives;
		$currentInfo['showlist']                    = $showlist;
		$currentInfo['menutemplate']                = $menutemplate;                
		$currentInfo['vocabularytemplate']          = $vocabularytemplate;      
                $currentInfo['listdesc1']                   = $listdesc1;  
                $currentInfo['listdesc2']                   = $listdesc2; 
                $currentInfo['itemmultisearch']             = $itemmultisearch;
		$currentInfo['redirect']                    = $redirect;
			
		if(WPxdamsBridge_get_option('active',$type) == 1){
		
                    $inputFields                            = WPxdamsBridge_get_search_input_options('xdamsList',$content);

                    if($inputFields['xdamsItem']){ 
					
                        if ($type == "@all")  {  $type      = $inputFields['archID'] ;}
                        $outItem                            = $outItem . WPxdamsBridge_single_item_request($inputFields['xdamsItem'], $type);  // publish 1 item 
			
                        if($itemmultisearch > 0){ 
						   
                            $inputFields['fulltextsearch']	= $currentInfo ['authoritySearchValue'] ;
                            
                            $inputFields['listTemplate']  	= $listtemplate;
                            $outItem                      	= $outItem .WPxdamsBridge_execute_search($inputFields, "@all", $tag, $vocabulary);  // publish results list 
			}
                    } else {

		    // get parameters to access to remote server
                        if ($content) {    // case listing with a search criteria
                            $inputFields                    = WPxdamsBridge_extract_search_conditions ( $inputFields, $content );
                        } else {
                        $inputFields['fulltextsearch']      = 'list';
                        $inputFields['listing']             = 'list';
                        }
                    $inputFields['listTemplate']            = $listtemplate;
                    $inputFields['vocabularytemplate']      = $vocabularytemplate;  
                    $outItem                                = $outy."".WPxdamsBridge_execute_search($inputFields, $type, $tag, $vocabulary);  // publish results list 
                    }	
		}	
		return $outItem; //'->'.$currentInfo ['remotefile']; //debug requeste file -OK
}

function WPxdamsBridge_extract_search_conditions ( $inputFields, $content ) {
    
    $operator                               = ' OR ';
    $pos                                    = strpos ($content , $operator);
                                        
    if (!$pos) { 
        $operator                           = ' AND ';
        $pos                                = strpos ($content , $operator);
    } 
                                        
    if ($pos) {        
        $splittedcontent                    = explode($operator, $content); 
        $paramNum                           = count($splittedcontent);
        $operator                           = str_replace(' ' , '%20' , $operator);
        $inputFields['xDamsOperator']       = $operator;
        $inputFields['xDamsOperatorInPage'] = $operator;
    } else {
        $splittedcontent[0]                 = $content;
        $paramNum                           = 1;
    }

    for($i=1;$i<=$paramNum;$i++) {	
            
        $singleCondition                    = explode("=", $splittedcontent[$i-1]   );
        $inputFields[$i]                    = str_replace(' ' , '%20' ,$singleCondition[1]);	
        $inputFields['xDamsfield'][$i]      = $singleCondition[0];
         
    }
    
    $inputFields['fieldsNum']               = $paramNum;
    $inputFields['notEmpyFields']           = $paramNum; 
    
    return   $inputFields;
}
// management of the short code for publishing a results page for an archive 


function WPxdamsBridge_search_publishing_process($atts, $content = null) {
   
		
		extract(shortcode_atts(array(
				'type'              => 'info',
				'itemmultisearch'   => '0' ,
				'formtemplate'      => '',
				'listtemplate'      => '',
                                'menutemplate'      => '',                     
                                'formdescpost'      => '',
                    		'listdescpre'       => '',
				'listdescpos'       => '',                    		
                                'itemdescpre'       => '',
				'itemdescpos'       => '',
                                'boxdim'            => '500',
				'redirect'          => '',
                                'redirectitem'      => '',
                                'showarchives'     => 'yes',
                                'showlist'          => 'no',
                                'form'              => 'basic'
				), $atts));
		// $type contains archive parameters	
		global $currentInfo;
                $currentInfo['redirect']        = $redirect;
                $currentInfo['redirectItem']    = $redirectitem;
                $currentInfo['formDescPost']    = $formdescpost ;
                $currentInfo['searchBoxWidth']  = $boxdim;
		$currentInfo['showarchives']    = $showarchives;
		$currentInfo['showlist']        = $showlist;
		$currentInfo['menutemplate']    = $menutemplate;
                $currentInfo['itemmultisearch'] = $itemmultisearch;   
                
                
                if(($inputFields['xdamsItem'] ) && ($itemmultisearch > 0)){ 
					
                      //  if ($type == "@all")  {  $type      = $inputFields['archID'] ;}
                        $outItem                        = $outItem . WPxdamsBridge_single_item_request($inputFields['xdamsItem'], $type);  // publish 1 item 
						   
                        $inputFields['fulltextsearch']	= $currentInfo ['authoritySearchValue'] ;

			}
                
                
                
                
                
                $outItem = $outItem .WPxdamsBridge_search_process ($att, $content , $type, 'freeSearch', $form, $formtemplate , $listtemplate, $listdescpre, $listdescpos,  $itemdescpre, $itemdescpos);    
			
		return $outItem;
}
function WPxdamsBridge_ad_search_publishing_process($atts, $content = null) {
   
		extract(shortcode_atts(array(
				'type' 		=> 'info',
				'formtemplate' 	=> '',
				'listtemplate' 	=> '',
                                'listdescpre' 	=> '',
				'listdescpos' 	=> '',
                                'itemdescpre' 	=> '',
				'itemdescpos' 	=> '',                   
				'form' 		=> 'basic'
				), $atts));
		// $type contains archive parameters 		
		
		
		$outItem = WPxdamsBridge_search_process ($att, $content , $type, 'adSearch', $form, $formtemplate , $listtemplate, $listdescpre, $listdescpos, $itemdescpre, $itemdescpos);    
		
		return $outItem;
}


function WPxdamsBridge_search_process($atts, $content = null, $type, $searchType, $searchFormat, $formTemplate, $listTemplate, $listdescpre=null, $listdescpos=null,  $itemdescpre=null,  $itemdescpos=null) {
 
               
		WPxdamsBridge_log( '_aa_par'.time(), 'WPxdamsBridge_search_process');
   
		global $currentInfo;
              
		if(WPxdamsBridge_get_option('active',$type) == 1){
		    // get parameter to access to remote server
			
			$inputFields    	 = WPxdamsBridge_get_search_input_options('','');
				
			// if some fields of the search form are not empty we call remote search - $inputFields[0] > 0
			if($inputFields['xdamsItem']){
                            if ($type == "@all")  {  $type          = $inputFields['archID'] ;}
                            $outItem                                = $outItem . WPxdamsBridge_single_item_request($inputFields['xdamsItem'], $type);  // publish 1 item 			
                            if($itemdescpre) { $itemdescpre         = $itemdescpre.'<br>';};
                            if($itemdescpos) { $itemdescpos         = '<br>'.$itemdescpos;};
                            $outItem = $itemdescpre.$outItem2 .$outItem.$itemdescpos ; 
                                
                        } else {
			    if($inputFields['notEmpyFields'] || ($searchFormat=='full')){
                                if($searchType=='freeSearch') {                               // to add shortcode conditions to search text
                                    $inputFields['searchType']      = $searchType;
                                    $inputFields                    = WPxdamsBridge_extract_search_conditions ( $inputFields, $content );
                                    $inputFields['fulltextsearch']  = str_replace('Ã©', '%E9', $inputFields['fulltextsearch']);
                                    $currentInfo['freesearchvalue'] =  $inputFields['fulltextsearch'];
                                }       
                                $inputFields['xDamsOperator']       = '%20AND%20';
                                $inputFields['listTemplate']        = $listTemplate;
                                $outItem                            = WPxdamsBridge_execute_search($inputFields, $type, $tag);  // publish results list
                            }	
                            if (($searchFormat!='mixed') || (!$inputFields['notEmpyFields']))	{	
                                if  ($searchType == 'freeSearch') {
                                    $outItem2                       = WPxdamsBridge_publish_fulltext_search_form($content, $inputFields, $type , $formTemplate , $listdescpre);
                                } else {
                                    $outItem2                       = WPxdamsBridge_publish_search_form($content, $inputFields, $type ,  $formTemplate  ,$listdescpre );    // publish form	
                                }
                            }
                            if($listdescpre) { $listdescpre = $listdescpre.'<br>';};
                            if($listdescpos) { $listdescpos = '<br>'.$listdescpos;};
                            $outItem = $listdescpre.$outItem2 .$outItem.$listdescpos ;            
			} 			
		}		
		return $outItem;//  .' - '.$currentInfo ['remotefile']	; // solo nella ricerca
}


function WPxdamsBridge_get_search_input_options($shortcode, $content) {
  	
	// get form fields and test which fields are not empty 

		// case 1 verify advanced search	

		$count  =  $_POST['c_fieldNum_WPxdamsBridge'];
	
		for($i=1;$i<=$count;$i++) {	
			$fieldname					= 'c_xdamfield_WPxdamsBridge_'.$i;
			$field[$i]					= $_POST[$fieldname];
			$fieldname2					= 'c_xdamsfieldId_WPxdamsBridge_'.$i;
			$field['xDamsfield'][$i]                        = $_POST[$fieldname2];

			if($field[$i]){ $numFields++; }		
		}	
		$field['fieldsNum']                                     = $_POST['c_fieldNum_WPxdamsBridge'];;
		$field['notEmpyFields']                                 = $numFields;
		
		
		// here we examine request to find if it contains fulltext search field 
		if(!$field['notEmpyFields']){
		
		    if  ($_POST["c_xdamfield_WPxdamsBridge_fulltextsearch"]) {    // case 1 it's the first query by request form (free search)
			
                        $field['fulltextsearch']                = $_POST["c_xdamfield_WPxdamsBridge_fulltextsearch"];
                        $field['notEmpyFields']                 = 1;
                    } else {
                        $param                                  = WPxdamsBridge_get_request_parameter(); // case 2 pagination (free search)
                        $field['picToShow']                     = $param['picToShow'] ;;
                        $field['pageToShow']                    = $param['pageToShow'] ;
                        $field['viewType']                      = $param['viewType'] ;
                        $field['archID']                        = $param['archID'];
                        $field['vocabularyValue']               = $param['vocabularyValue'];	
                        $field['startParam']                    = $param['startParam'];		
                        $field['updown']                        = $param['updown'];						
			if ($param['searchfield']) {
					
                            $field['fulltextsearch']            = $param['searchfield'] ;
                            $field['notEmpyFields']		= 1;
                        } else 	{
                            if($param['requestParamNum'] && $param['pageToShow']){                 //  case 3 there are some parameters for query but it'snt free search (advanced)
						
                                $field['fieldsNum']             = $param['requestParamNum'];
                                $field['notEmpyFields']         = $param['requestParamNum'];
                                for($i=1;$i<=$field['fieldsNum'];$i++) {	
                                    $field[$i]			= $param['requestParam'][$i];  // valore campo
                                    $field['xDamsfield'][$i]	= $param['requestField'][$i];  // nome campo
				}
                            }
			}
                    }
		}
         
		// here we examine request to find if it contains '&xdamsItem=xxxxxxx' 
		if(!$inputFields['notEmpyFields']){
                  
			
			$field['xdamsItem']		= $param['xdamsItem'];
			$field['xdamsTreePath']         = $param['xdamsPrevPath'];
		}
		return $field;
                
}
function WPxdamsBridge_log($field , $value) {

	global $WPxdamsBridge_log_active;
	
	if ($WPxdamsBridge_log_active==0) {
           update_option( '_wpxx_log'.$field,  $value);
	} 
    
}
function WPxdamsBridge_load_UTF8code ( ) {
    $out = array(
 
    'o%CC%88'
,   'O%CC%88' 
,   'u%CC%88'            
,   'U%CC%88'
,    '%C3%80'   //   Ã€
,    '%C3%81'   //   Ã�
,    '%C3%82'   //   Ã‚
,    '%C3%83'   //   Ãƒ
,    '%C3%84'   //   Ã„
,    '%C3%85'   //   Ã…
,    '%C3%86'   //   Ã†
,    '%C3%87'   //   Ã‡
,    '%C3%88'   //   Ãˆ
,    '%C3%89'   //   Ã‰
,    '%C3%8A'   //   
,    '%C3%8B'   //   Ã‹
,    '%C3%8C'   //   ÃŒ
,    '%C3%8D'   //   Ã�
,    '%C3%8E'   //   ÃŽ
,    '%C3%8F'   //   Ã�
,    '%C3%90'   //   Ã�
,    '%C3%91'   //   Ã‘
,    '%C3%92'   //   Ã’
,    '%C3%93'   //   Ã“
,    '%C3%94'   //   Ã”
,    '%C3%95'   //   Ã•
,    '%C3%96'   //   Ã–
,    '%C3%97'   //   Ã—
,    '%C3%98'   //   Ã˜
,    '%C3%99'   //   Ã™
,    '%C3%9A'   //   Ãš
,    '%C3%9B'   //   Ã›
,    '%C3%9C'   //   Ãœ
,    '%C3%9D'   //   Ã�
,    '%C3%9E'   //   Ãž
,    '%C3%9F'   //   ÃŸ
,    '%C3%A0'   //   Ã 
,    '%C3%A1'   //   Ã¡
,    '%C3%A2'   //   Ã¢
,    '%C3%A3'   //   Ã£
,    '%C3%A4'   //   Ã¤
,    '%C3%A5'   //   Ã¥
,    '%C3%A6'   //   Ã¦
,    '%C3%A7'   //   Ã§
,    '%C3%A8'   //   Ã¨
,    '%C3%A9'   //   Ã©
,    '%C3%AA'   //   Ãª
,    '%C3%AB'   //   Ã«
,    '%C3%AC'   //   Ã¬
,    '%C3%AD'   //   Ã­
,    '%C3%AE'   //   Ã®
,    '%C3%AF'   //   Ã¯
,    '%C3%B0'   //   Ã°
,    '%C3%B1'   //   Ã±
,    '%C3%B2'   //   Ã²
,    '%C3%B3'   //   Ã³
,    '%C3%B4'   //   Ã´
,    '%C3%B5'   //   Ãµ
,    '%C3%B6'   //   Ã¶
,    '%C3%B7'   //   Ã·
,    '%C3%B8'   //   Ã¸
,    '%C3%B9'   //   Ã¹
,    '%C3%BA'   //   Ãº
,    '%C3%BB'   //   Ã»
,    '%C3%BC'   //   Ã¼
,    '%C3%BD'   //   Ã½
,    '%C3%BE'   //   Ã¾
,    '%C3%BF'   //   Ã¿
            );
    
    
    return $out;
}          
 function WPxdamsBridge_load_SCHAR () { 
     $out       = array(
         
    'o%CC%88'
,   'O%CC%88' 
,   'u%CC%88'            
,   'U%CC%88'
,       'Ã€'
,       'Ã�'
,       'Ã‚'
,       'Ãƒ'
,       'Ã„'
,       'Ã…'
,       'Ã†'
,       'Ã‡'
,       'Ãˆ'
,       'Ã‰'
,       '%C3%8A'
,       'Ã‹'
,       'ÃŒ'
,       'Ã�'
,       'ÃŽ'
,       'Ã�'
,       'Ã�'
,       'Ã‘'
,       'Ã’'
,       'Ã“'
,       'Ã”'
,       'Ã•'
,       'Ã–'
,       'Ã—'
,       'Ã˜'
,       'Ã™'
,       'Ãš'
,       'Ã›'
,       'Ãœ'
,       'Ã�'
,       'Ãž'
,       'ÃŸ'
,       'Ã '
,       'Ã¡'
,       'Ã¢'
,       'Ã£'
,       'Ã¤'
,       'Ã¥'
,       'Ã¦'
,       'Ã§'
,       'Ã¨'
,       'Ã©'
,       'Ãª'
,       'Ã«'
,       'Ã¬'
,       'Ã­'
,       'Ã®'
,       'Ã¯'
,       'Ã°'
,       'Ã±'
,       'Ã²'
,       'Ã³'
,       'Ã´'
,       'Ãµ'
,       'Ã¶'
,       'Ã·'
,       'Ã¸'
,       'Ã¹'
,       'Ãº'
,       'Ã»'
,       'Ã¼'
,       'Ã½'
,       'Ã¾'
,       'Ã¿'
            );
   return $out;    
 } 
       
function WPxdamsBridge_load_UNICODE () {   
    $out     = array(

     '%F6'
,    '%F6'   
,    '%FC'
,    '%FC' 
,    '%C0'  //   Ã€
,    '%C1'  //   Ã�
,    '%C2'  //   Ã‚
,    '%C3'  //   Ãƒ
,    '%C4'  //   Ã„
,    '%C5'  //   Ã…
,    '%C6'  //   Ã†
,    '%C7'  //   Ã‡
,    '%C8'  //   Ãˆ
,    '%C9'  //   Ã‰
,    '%CA'  //   
,    '%CB'  //   Ã‹
,    '%CC'  //   ÃŒ
,    '%CD'  //   Ã�
,    '%CE'  //   ÃŽ
,    '%CF'  //   Ã�
,    '%D0'  //   Ã�
,    '%D1'  //   Ã‘
,    '%D2'  //   Ã’
,    '%D3'  //   Ã“
,    '%D4'  //   Ã”
,    '%D5'  //   Ã•
,    '%D6'  //   Ã–
,    '%D7'  //   Ã—
,    '%D8'  //   Ã˜
,    '%D9'  //   Ã™
,    '%DA'  //   Ãš
,    '%DB'  //   Ã›
,    '%DC'  //   Ãœ
,    '%DD'  //   Ã�
,    '%DE'  //   Ãž
,    '%DF'  //   ÃŸ
,    '%E0'  //   Ã 
,    '%E1'  //   Ã¡
,    '%E2'  //   Ã¢
,    '%E3'  //   Ã£
,    '%E4'  //   Ã¤
,    '%E5'  //   Ã¥
,    '%E6'  //   Ã¦
,    '%E7'  //   Ã§
,    '%E8'  //   Ã¨
,    '%E9'  //   Ã©
,    '%EA'  //   Ãª
,    '%EB'  //   Ã«
,    '%EC'  //   Ã¬
,    '%ED'  //   Ã­
,    '%EE'  //   Ã®
,    '%EF'  //   Ã¯
,    '%F0'  //   Ã°
,    '%F1'  //   Ã±
,    '%F2'  //   Ã²
,    '%F3'  //   Ã³
,    '%F4'  //   Ã´
,    '%F5'  //   Ãµ
,    '%F6'  //   Ã¶
,    '%F7'  //   Ã·
,    '%F8'  //   Ã¸
,    '%F9'  //   Ã¹
,    '%FA'  //   Ãº
,    '%FB'  //   Ã»
,    '%FC'  //   Ã¼
,    '%FD'  //   Ã½
,    '%FE'  //   Ã¾
,    '%FF'  //   Ã¿
            );  
    
    
      return $out; 
} 
       
 function WPxdamsBridge_UNICODE_encode ($in , $option=1 ) {
 
        $replaceOut     =  WPxdamsBridge_load_UNICODE ();
        
        if ($option=='2') {
            $searchIn   = WPxdamsBridge_load_SCHAR () ;
        }else {
            $searchIn   = WPxdamsBridge_load_UTF8code ();
        }
        $out            = str_replace ($searchIn,$replaceOut, $in  );
            
    return $out;
}

 function WPxdamsBridge_UNICODE_decode ($in , $option=1 ) {
 
        $replaceOut     = WPxdamsBridge_load_SCHAR ();
        $searchIn       = WPxdamsBridge_load_UNICODE () ;

        $out            = str_replace ($searchIn,$replaceOut, $in  );
            
    return $out;
}

function WPxdamsBridge_get_request_parameter() {
		
        global $currentInfo;
		
        $currPage                                       =  $_SERVER['REQUEST_URI'];

        $currPage                                       = WPxdamsBridge_UNICODE_encode ($currPage);
                
        $splittedrequest                                =  explode("?", $currPage);
        $field['wpPageURL']                             =  $splittedrequest [0];
        $field['xdamsTreePath']                         =  $currPage ;
        $reqParameters                                  =  explode("&", $splittedrequest[1]);
	$field['newpage']                               =  $field['wpPageURL'] .'?'. $reqParameters  [0]; 
        $field['LOG']                                   =  $reqParameters[0];  // app debugging


        if($reqParameters[0]) {	

            $field['LOG']                               =  $field['LOG'].$reqParameters[0]; // app debugging
            $splitted0 					=  explode("=", $reqParameters [0]);
            $field[$splitted0 [0]]                      = $splitted0 [1];
            $currentInfo ['devLog']                     = $currentInfo ['devLog'].'STEP 0 '.$splitted0 [0]. ' - '.$splitted0 [1];
            if ( $splitted0 [0]  == 'xdamsItem') {
                $field['treeLastLevel'] =  $splitted0 [1]    ;          
            }
            if ( $splitted0 [0]  == 'pageToShow') {
                $field['pageToShow'] =  $splitted0 [1]    ;          
            }            

        }
	
        if($reqParameters[1]) {	
            
            $field['LOG']  						=  $field['LOG'].$reqParameters[0];
            $splitted1 					= explode("=", $reqParameters [1]);
            $field[$splitted1 [0]]                      = $splitted1 [1];
            $currentInfo ['devLog']			= $currentInfo ['devLog'].'STEP 1 '.$splitted1 [0]. ' - '.$splitted1 [1];
            if ( $splitted1 [0]  == 'xdamsItem') {
                $field['treeLastLevel'] =  $splitted1 [1]    ;        
            } 
            if ( $splitted1 [0]  == 'pageToShow') {
                $field['pageToShow'] =  $splitted1 [1]    ;          
            }
        }
        if($reqParameters[2]) {
            
            $count 					= count ($reqParameters); // restituisce solo parametri aggiuntivi
            $field['requestParamNum']			= $count - 2;  // the first is the page of wordpress and second is the page of xdams
            for($i=2;$i<=$count;$i++) {
                $splitted1 				= explode("=", $reqParameters [$i]);
                $field[$splitted1 [0]]			= $splitted1 [1];  // SERVE ? penso di si nel caso full text search
                $field['requestField'][$i-1]            = $splitted1 [0];
                $field['requestParam'][$i-1]            = $splitted1 [1];
                
                if ( $field['requestField'][$i-1]  == 'xdamsItem') {
                    $field['treeLastLevel'] =  $field['requestParam'][$i-1]     ;
                    
                     
                }
                if ( $field['requestField'][$i-1]  == 'showdetails') {
                    $field['showdetails'] =  $field['requestParam'][$i-1]     ;
                     
                }
                if ( $field['requestField'][$i-1]  == 'pageToShow') {
                    $field['pageToShow'] =  $field['requestParam'][$i-1]     ;
                     
                }
                $currentInfo ['devLog']                 = $currentInfo ['devLog'].'STEP N '.$field['requestField'][$i-1] . ' - '.$field['requestParam'][$i-1];
            }			
        }		
	//  echo('<br> ----- page to '.$field['pageToShow']);	
        return $field	 ;
} 

//  publish on front end the search form

function WPxdamsBridge_publish_search_form ($shortCodeContent = null, $inputFields, $archiveId , $formTemplate , $listdescpre=null ) {
   
		// 
		global $archivesConfig;
		global $currentInfo;
		
                
		$shortCodeContent                   = trim($shortCodeContent);
		$archivesConfig                     = WPxdamsBridge_get_archives_config();  //  load archives search configuration 
		$archiveLabel                       = WPxdamsBridge_get_archive_desc($archiveId);;	
		$xDamsFields                        = WPxdamsBridge_get_fields_list($archiveId );  //  available fields
		$count                              = $xDamsFields ['metadata'][1] ;// number of available fields			
		$visibleIndex                       = 0;
		
		if ($shortCodeContent !='all') {
                    $xDamsFields ['name'][0]        = $shortCodeContent;
                    $count                          = 1;
		} 

		$currentInfo ['archiveDesc']        = $archiveLabel;
		$currentInfo ['archiveId']          = $archiveId ;
		$currentInfo ['xDamsFields']        = $xDamsFields; 
		$currentInfo ['formFieldsNumber']   = $count; 
		
	
  ///   load search form 
		$xdamsFRM                           = get_option('WPxdamsBridge_form_'.$archiveId);
		if ($formTemplate) {      // form specified in the post
			$xdamsFRM             	 		= $formTemplate;
		}
		if ($xdamsFRM) {
			include ('WPxdams_custom/'.$xdamsFRM);
		} else {
			include ('WPxdams_templates/WPxdamsBridge_search_form.php');
		}
 		return $out;

} 
function WPxdamsBridge_publish_fulltext_search_form ($shortCodeContent = null, $inputFields, $archiveId, $formTemplate, $listdescpre=null ) {
       
		global $archivesConfig;
		global $currentInfo;		

		$archiveLabel                       = WPxdamsBridge_get_archive_desc($archiveId);
		$searchBoxWidth                     = $currentInfo ['searchBoxWidth']  ;
                $inputFields['fulltextsearch']      = WPxdamsBridge_UNICODE_decode ($inputFields['fulltextsearch']);
                
		if ($formTemplate) {
			$filename                   = 'WPxdams_custom/'.$formTemplate;
		} else {
			$filename                   = 'WPxdams_templates/WPxdamsBridge_textsearch_form.php';
		}				
		
		$currentInfo ['archiveDesc']        = $archiveLabel;
		$currentInfo ['archiveId']          = $archiveId ;
		$currentInfo ['xDamsFields']        = $xDamsFields; 
		
		include ($filename);
			
		return $out;
} 

//******************************************************** 


// reset cCounter - cCounter has managed to find more occurences of an xml tag in a file

function WPxdamsBridge_resetGetElement () {

    global $WPxdamsBridge_cCounter;

    $WPxdamsBridge_cCounter=0;

    return;
}

// reset cCounter - cCounter has managed to find more occurences of an xml tag in a file this function find rhe ner start to find multiple tag

function WPxdamsBridge_getNewBlockToExplore ($inData) {

    global $WPxdamsBridge_cCounter;
	
	$inLen = strlen($inData) ;
	$newLen = $inLen - $WPxdamsBridge_cCounter ; 

	$outData = substr($inData, $WPxdamsBridge_cCounter, $newLen );
	$outLen = strlen($outData) ; //canc

    return $outData;
}

function WPxdamsBridge_getFirstBlockToExplore ($xml, $end) {

    global $WPxdamsBridge_cCounter;
	
    $WPxdamsBridge_cCounter = 0;
    $endpos                 = strpos($xml, $end);
    $WPxdamsBridge_cCounter = $endpos;
    $lengt                  = $endpos;
    $tag                    = substr ($xml, 0, $lengt);

    return $outData;
}
function WPxdamsBridge_extractItemHier ($xml) {
	
    global	$currentInfo;
   
    $preview2One            = WPxdamsBridge_get_option('preview2',$currentInfo ['archiveId']); 
    $hierDelimiter1         = WPxdamsBridge_get_option('Hdel1',$currentInfo ['archiveId']);
    $hierDelimiter2         = WPxdamsBridge_get_option('Hdel2',$currentInfo ['archiveId']);
    $hierDescPrefix         = WPxdamsBridge_get_option('Hprefix' ,$currentInfo ['archiveId']);
     
    $hierField1Pre          = WPxdamsBridge_get_option('Hfld1Pr',$currentInfo ['archiveId']);
    $hierField1Post         = WPxdamsBridge_get_option('Hfld1Po',$currentInfo ['archiveId']);
    $hierField2Pre          = WPxdamsBridge_get_option('Hfld2Pr',$currentInfo ['archiveId']);
    $hierField2Post         = WPxdamsBridge_get_option('Hfld2Po',$currentInfo ['archiveId']);


    $singleLevel            = explode ('||', $xml);
    $levelsNum              = count($singleLevel);
    $out                    = '';
 
   
        
    
    if (substr($hierDescPrefix, 0, 4) == 'http' ) {
        $hierDescPrefix     = '<img src="'.$hierDescPrefix.'">'   ;
    }

    for($i=0;$i<$levelsNum;$i++) {
    
           
        if($hierField1Post) {
            $temp1          = explode ('[@'.$hierField1Post.'@]',$singleLevel[$i]);
            
        } else {
            $temp1 [0]      = $singleLevel[$i];
           
        }
       
        if($hierField1Pre) {
            $temp1A         =  explode ('[@'.$hierField1Pre.'@]', $temp1 [0]);
            
        } else {
            $temp1A [1]     = $temp1 [0];
            
        }        
        $field1             = trim(utf8_encode($temp1A [1])) ;

	if ($preview2One==3) {
             // extract second  field
            
            if($hierField2Post) {
                $temp2      = explode ('[@'.$hierField2Post.'@]',$singleLevel[$i]);
            } else {
                $temp2 [0]  = $singleLevel[$i];
            }
            
            if($hierField2Pre) {
                $temp2A         =  explode ('[@'.$hierField2Pre.'@]',$temp2 [0]);
            } else {
                $temp2A [1]     = $temp2 [0];
            }        
            $field2             = trim(utf8_encode($temp2A [1])) ;
             if($field2 >'') {
                $field2         = $hierDelimiter1.$field2.$hierDelimiter2;
             }
            
	}
        
        $out                = $out.'<p class="xdHierLevel">'.$spacing.$hierDescPrefix. $field1.$field2.'<p>' ;   
        $spacing            = $spacing . '&ensp;&ensp;';
    }
    
    return $out.'<br><br>';
}

function WPxdamsBridge_extractSingleHierLevels ($xml) {
	
    global	$currentInfo;
   
    $preview2One            = WPxdamsBridge_get_option('preview2',$currentInfo ['archiveId']); 
    /*
    $hierDelimiter1         = WPxdamsBridge_get_option('Hdel1',$currentInfo ['archiveId']);
    $hierDelimiter2         = WPxdamsBridge_get_option('Hdel2',$currentInfo ['archiveId']);
    $hierDescPrefix         = WPxdamsBridge_get_option('Hprefix' ,$currentInfo ['archiveId']);
 */    
    $hierField1Pre          = WPxdamsBridge_get_option('Hfld1Pr',$currentInfo ['archiveId']);
    $hierField1Post         = WPxdamsBridge_get_option('Hfld1Po',$currentInfo ['archiveId']);
    $hierField2Pre          = WPxdamsBridge_get_option('Hfld2Pr',$currentInfo ['archiveId']);
    $hierField2Post         = WPxdamsBridge_get_option('Hfld2Po',$currentInfo ['archiveId']);


    $singleLevel            = explode ('||', $xml);
    $levelsNum              = count($singleLevel);
  //  $out                    = '';
 
   
        
 /*   
    if (substr($hierDescPrefix, 0, 4) == 'http' ) {
        $hierDescPrefix     = '<img src="'.$hierDescPrefix.'">'   ;
    }
*/
    $field1[0]                  = $levelsNum;
    
    for($i=0;$i<$levelsNum;$i++) {
     
        if($hierField1Post) {
            $temp1              = explode ('[@'.$hierField1Post.'@]',$singleLevel[$i]); 
        } else {
            $temp1 [0]          = $singleLevel[$i];
        }
       
        if($hierField1Pre) {
            $temp1A             =  explode ('[@'.$hierField1Pre.'@]', $temp1 [0]);
        } else {
            $temp1A [1]         = $temp1 [0];
        }        
        $field1 [$i+1]          = trim(utf8_encode($temp1A [1])) ;
        $field1 [$i+1]          = trim(str_replace ('<hier>' , '' , $field1 [$i+1] ));
/*
	if ($preview2One==3) {
             // extract second  field
            
            if($hierField2Post) {
                $temp2      = explode ('[@'.$hierField2Post.'@]',$singleLevel[$i]);
            } else {
                $temp2 [0]  = $singleLevel[$i];
            }
            
            if($hierField2Pre) {
                $temp2A         =  explode ('[@'.$hierField2Pre.'@]',$temp2 [0]);
            } else {
                $temp2A [1]     = $temp2 [0];
            }        
            $field2             = trim(utf8_encode($temp2A [1])) ;
             if($field2 >'') {
                $field2         = $hierDelimiter1.$field2.$hierDelimiter2;
             }
            
	}
     */   
      //  $out                = $out.'<p class="xdHierLevel">'.$spacing.$hierDescPrefix. $field1.$field2.'<p>' ;   
     //   $spacing            = $spacing . '&ensp;&ensp;';
    }
    
    return $field1;
}

function WPxdamsBridge_extractItemHierOLD ($xml) {   // to delete
	
    global	$currentInfo;
    
    $preview2One            = WPxdamsBridge_get_option('preview2',$currentInfo ['archiveId']); 

    $singleLevel            = explode ('||', $xml);
    $levelsNum              = count($singleLevel);
    $out                    = '';
 
    $hierDescPrefix         = WPxdamsBridge_get_option('Hprefix' ,$currentInfo ['archiveId']);
    $hierField              = WPxdamsBridge_get_option('Hfield' ,$currentInfo ['archiveId']);
    $hierField              = '[@'.$hierField .'@]';   
    
    if (substr($hierDescPrefix, 0, 4) == 'http' ) {
        $hierDescPrefix     = '<img src="'.$hierDescPrefix.'">'   ;
    }

    for($i=0;$i<$levelsNum;$i++) {
        $temp               = explode ($hierField,$singleLevel[$i]);
        $pos                = strrpos ($temp[0], ']');
        
        if ($pos) {
            $temp[0]         = substr($temp[0], $pos+1, strlen($temp[0]));
        }
        $title              = utf8_encode($temp[0])  ;
        $temp               = explode ('[@lev@]',$temp[01]);
        $temp               = explode (']',$temp[0]);
        $levInd             = count( $temp)-1;
        $level              = $temp[$levInd]  ;
	if ($preview2One==3) {
            $addLevel       = ' ['. $level .']';
	}
        $out                = $out.'<p class="xdHierLevel">'.$spacing.$hierDescPrefix. $title.$addLevel.'<p>' ;   
        $spacing            = $spacing . '&ensp;&ensp;';
    }
    
    return $out.'<br><br>';
}

// Extracts content from XML tag

function WPxdamsBridge_GetElementByName ($xml, $start, $end) {

    global $WPxdamsBridge_cCounter;
    
  

    $startpos = strpos($xml, $start);
 
    if ($startpos === false) {
        return false;
    }
   
    $endpos = strpos($xml, $end);
    $endpos = $endpos+strlen($end);   
    $WPxdamsBridge_cCounter = $endpos;
    $endpos = $endpos-$startpos;
    $endpos = $endpos - strlen($end);
    $tag = substr ($xml, $startpos, $endpos);
    $tag = substr ($tag, strlen($start));

    
    
    return $tag;
}

function WPxdamsBridge_GetValueByTag ($xml, $start, $end, $startPosition) {  //this function differd from the following one because it doesn't use a public counter


    $startpos = strpos($xml, $start, $startPosition);
	
    if ($startpos === false) {
        return false;
    }
	$newStart = strpos($xml, '>' , $startpos );
    $endpos = strpos($xml, $end, $startPosition);
    $endpos = $endpos+strlen($end);   
    
    $lengt = $endpos - $newStart - 1;
    $lengt = $lengt - strlen($end);
    $tag = substr ($xml, $startpos, $lengt);
    $tag = substr ($xml, $newStart+1, $lengt);

    return $tag;
}
function WPxdamsBridge_GetElementByTag ($xml, $start, $end) {

    global $WPxdamsBridge_cCounter;

    $startpos                   = strpos($xml, $start);
    if ($startpos === false) {
        return false;
    } 
    $newStart                   = strpos($xml, '>' , $startpos );
    $isClosed                   = strpos($xml, '/>' , $startpos ); // case tag has no value
    
    if ( $isClosed==$newStart - 1) {  // yes it's this case
         $WPxdamsBridge_cCounter = $isClosed + 1;
          return false; 
    }
    
    $endpos                     = strpos($xml, $end);
    if ($endpos){
        $endpos                 = $endpos+strlen($end);   
        $WPxdamsBridge_cCounter = $endpos;
        $lengt                  = $endpos - $newStart - 1;
        $lengt                  = $lengt - strlen($end);
        $tag                    = substr ($xml, $startpos, $lengt);
        $tag                    = substr ($xml, $newStart+1, $lengt);
//   $tag = substr ($tag, strlen($start));

        $newStart               = 0;
        $newStart               = strpos($tag, 'CDATA[' );
        if ($newStart) {
            $newStart           = $newStart + 6;
            $length             = strrpos($tag , ']') - $newStart -1;
            $tag                = substr ($tag, $newStart, $length);
	}
     }  else {
         return false; 
     }
    return $tag;
}
function WPxdamsBridge_existNewElementByTag ($xml, $start) {

    global $WPxdamsBridge_cCounter;

    $startpos = strpos($xml, $start, $WPxdamsBridge_cCounter);
    if ($startpos === false) {
        return false;
    } 
	return true ;
	
}

// extract level of an item

function WPxdamsBridge_GetElementLevel ($xml) {   //20160301

    global $currentInfo; 

    $schema =  WPxdamsBridge_getCurrTransformation ();
    
        
    switch($schema){
    
        case 'eaccpf':
            $tag            = 'item';
           
            break;
        
        case 'lido':
            $tag            = WPxdamsBridge_GetElementByTag($xml , '<recordType>', '</recordType>' ) ;
            $tag            = str_replace('<term>', '', $tag);  // clean the string
            $tag            = str_replace('</term>', '', $tag);
           
            break;        
        case 'mods':
            $startpos = strpos($xml, '<level>');
            if ($startpos === false) {
                return false;
            }
            $startpos       = $startpos + 7;   // starting from level=" it finds the end of the string
            $endpos         = strpos($xml, '</level>', $startpos);
            $endpos         = $endpos+1;   
            $endpos         = $endpos-$startpos;
            $endpos         = $endpos - 1;
            $tag            = substr ($xml, $startpos, $endpos);        
            break;
            
        default:
            $startpos = strpos($xml, 'level="');
            if ($startpos === false) {
                return 'fonds';
            }
            $startpos       = $startpos + 7;   // starting from level=" it finds the end of the string
            $endpos         = strpos($xml, '"', $startpos);
            $endpos         = $endpos+1;   
            $endpos         = $endpos-$startpos;
            $endpos         = $endpos - 1;
            $tag            = substr ($xml, $startpos, $endpos);            
            break;
    }	
    return $tag;
}
function WPxdamsBridge_importSearchFieldInDB ($archiveId) {

    $xDamsFields            = WPxdamsBridge_get_fields_listFromFile($archiveId);  //  available fields
    $count                  = $xDamsFields ['metadata'][1];
     
    for($i=0;$i<$count;$i++) {	
	 
	$optionsTable  =   $optionsTable .  $xDamsFields ['name'][$i].'%%%' .$xDamsFields ['label'][$i].'%%%' .'1'.'%%%'  ;
        
    }
    update_option('WPxdamsBridge_fields_num_'.$archiveId,$count);
    update_option('WPxdamsBridge_search_fields_'.$archiveId,$optionsTable);

}


function WPxdamsBridge_getHierStandardConfig () {
    
    $out ['count'] = 5;

    $out [1]['pre1'] = ''; 
    $out [1]['post1'] = 'tit'; 
    $out [1]['pre2'] = 'arch'; 
    $out [1]['post2'] = 'lev'; 
    $out [1]['desc'] = 'storico'; 
    
    $out [2]['pre1'] = 'titProp'; 
    $out [2]['post1'] = 'data'; 
    $out [2]['pre2'] = 'data'; 
    $out [2]['post2'] = 'aut'; 
    $out [2]['desc'] = 'audiovisivo'; 
    
    $out [3]['pre1'] = ''; 
    $out [3]['post1'] = 'tit'; 
    $out [3]['pre2'] = 'luogo'; 
    $out [3]['post2'] = 'editore'; 
    $out [3]['desc'] = 'bibliografia'; 
    
    $out [4]['pre1'] = ''; 
    $out [4]['post1'] = 'tit'; 
    $out [4]['pre2'] = 'lev'; 
    $out [4]['post2'] = 'all'; 
    $out [4]['desc'] = 'fotografico'; 
    
    $out [5]['pre1'] = 'ogtn'; 
    $out [5]['post1'] = 'sgti'; 
    $out [5]['pre2'] = 'sgti'; 
    $out [5]['post2'] = 'sgtt'; 
    $out [5]['desc'] = 'iconografia'; 

    return $out;
}
/*  **************************************************
      back end function to create index
    **************************************************
*/
function WPxdamsBridge_count_xdams_records ($inputFields, $archiveId) {


	global $archivesConfig;
	global $currentInfo;
        $currentInfo['archiveId']   = $archiveId;
        $r                          = WPxdamsBridge_getTransformation($archiveId);
       
	//global $element;

	$remoteFile                 = $inputFields ['remotefile'];

	WPxdamsBridge_resetGetElement ();

	$Nodes = WPxdamsBridge_importFileToArray ($remoteFile ,  $archiveId);    //20160301
        
        
        
	if ($Nodes == false) {
		$out  = 0; 
	} else {
		$out  = $currentInfo ['numItem'];  
	} 
        
        return $out;
}

/*  **************************************************
      back end function to create index
    **************************************************
*/
function WPxdamsBridge_import_xdams_records ($inputFields, $archiveId) {

   

	global $archivesConfig;
	global $currentInfo;
      
        $currentInfo['archiveId']   = $archiveId;
        $r                          = WPxdamsBridge_getTransformation($archiveId);

        update_option('WPxdamsBridge_logimport_step1',$inputFields ['queryNum'] );        
              
        $remoteFile                 = $inputFields ['remotefile'].'?perpage='. $inputFields ['perPage'].'&pageToShow='.$inputFields ['queryNum'] ;

        WPxdamsBridge_resetGetElement ();

	$Nodes = WPxdamsBridge_importFileToArray ($remoteFile ,  $archiveId);    //20160301
       
	if ($Nodes == false) {
         //   update_option('www_import_step1a',$inputFields ['queryNum'] ); 
		die("could not open XML input, please contact the webmaster");                  
	} else {
          //  update_option('www_import_step1b',$inputFields ['queryNum'] ); 
		$out ['message'] = 'ok'; 
                if ( $inputFields ['queryNum'] ==1 ) {
                    WPxdamsBridge_reset_tree ($archiveId); 
                }    
	}

        $json = '{
                            "live": false,
                            "info": "Wait............. procedure in progress...  "
                    }' ; 

        $fp =   fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json', 'w');     
                fwrite($fp,$json);
                fwrite($fp,"\n"); 
                fclose($fp); 
            
	$count= count($Nodes) - 1;
        
        if($inputFields ['queryNum']>1) {
            $inserted        = WPxdamsBridge_get_last_inserted_record_in_DB ($archiveId); 
            update_option('WPxdamsBridge_tree_lastimported_id_'.$archiveId,$inserted );
        } 
        update_option('WPxdamsBridge_tree_lastimporting_page_'.$archiveId, $inputFields ['queryNum'] );
  //      update_option('www_import_step1d','num query da elaborare '.$inputFields ['queryNum'].' - num nodi '.$count ); 

	for ($i=0; $i<$count; $i++) {  
                $element 			= array();
		$currNode 			= $Nodes[$i] ;	
	//	update_option('www_import_step2a',$i ); 
		$element	 		= WPxdamsBridge_parseCompleteXML($archiveId,  $currNode , 'list') ;   // unused  $outItem2
		WPxdamsBridge_resetGetElement ();
		WPxdamsBridge_existsNextField();
                
		$out ['itemId'][]               = $currentInfo ['requestedId'];
                
        //        update_option('www_import_step2b',$currentInfo ['requestedId'].' i '. $i ); 
                $keys 		 		= array_keys($element); 
		$rCount 			= count($keys);
		$requestedItemLevel             = WPxdamsBridge_getCurrentItemType() ;
                
	       
                $stamp    ='  No ';
                for ($ii=0; $ii<$rCount; $ii++) {   // really it only one?
		  $result                       =  $element [$keys[$ii]] [0];
                  if ($element [$keys[$ii+1]] [0] && WPxdamsBridge_get_option('preview',$archiveId) >1 )  {        
                    $result                     = $result .' '. $element [$keys[$ii+1]] [0]; // data to be visualized in list or item title
		  }
                  $result2                      = $requestedItemLevel;
                  
                  if($keys[$ii]==$inputFields ['hierTitle'][$requestedItemLevel.'@'.$archiveId]){
                      $stamp = $element [$keys[$ii]] [0];
                      $index = $ii;
                  }
		}
                      
                $c= $c.'<br>'.$currentInfo ['requestedId'].' campo corrente '.$keys[$ii].' livello estratto '.
                    $requestedItemLevel.'@'.$archiveId.' livello Hier  '.$inputFields ['hierTitle'][$requestedItemLevel.'@'.$archiveId] .
                    ' valore '.$stamp                    ;	
            
                $remoteFileHier     =  WPxdamsBridge_get_remote_files ( $archiveId , $currentInfo ['requestedId']);
                
                if ($remoteFileHier['getHier']) {                               
                    $HierNodes                      = WPxdamsBridge_importFileToArray ($remoteFileHier['remoteFileHier']   , $archiveId, 'Hier');
                    $currHierNode                   = stripslashes($HierNodes[0]); 
                    $currHierLevels                 = WPxdamsBridge_extractSingleHierLevels ($currHierNode);
                }
                
                if ($currHierLevels[0]>1) {
                    $my_father_is                   = $currHierLevels[$currHierLevels[0]-1];
                } else {
                    $my_father_is                   = '';
                }  
                //update_option('www_import_step2c',$currentInfo ['requestedId'] );
                global $wpdb;
    
                $a=$wpdb->insert ( 'xd_tree' , array (  'xdams_id'      => $currentInfo ['requestedId'] 
                                                    ,   'archive'       => $archiveId 
                                                    ,   'value'         => $stamp    // .'  -- ' . $my_father_is .'  oo' 
                                                    ,   'my_father_is'  => $my_father_is 
                                                    ,   'level'         => $requestedItemLevel)
                        )
                    ;
                    $wpdb->print_error();
                // update_option('www_import_step2D',$currentInfo ['requestedId'] );
                if (($i % 5) == 0) {
                    $total = ($inputFields ['queryNum'] * $inputFields ['perPage']) + $i - $inputFields ['perPage'];
                    $json = '{
                            "live": false,
                            "info": "Wait................ procedure in progress...  recorded: '.$i.' items of block number '.$inputFields ['queryNum'].' total '.$total.'"
                         }' ;                    
                   
                    $fp = fopen('../wp-content/plugins/WPxdamsBridge/WPxdams_messages/status.json', 'w');     
                    fwrite($fp,$json);
                    fwrite($fp,"\n"); 
                    fclose($fp);
                }
     
            //    update_option('www_import_step4',$currentInfo ['requestedId'] );     
                    
		$out ['results'][] 		= $result;
		$out ['itemLevel'][]            = $result2;           
	}
       
 //       update_option('www_import_step5_'.$archiveId,'num query elborata '.$inputFields ['queryNum'].' - num nodi '.$count .' / '. $i); 
        $inserted        = WPxdamsBridge_get_last_inserted_record_in_DB ($archiveId); 
        update_option('WPxdamsBridge_tree_lastimported_page_'.$archiveId,$inputFields ['queryNum'] );
        update_option('WPxdamsBridge_tree_lastimported_id_'.$archiveId,$inserted );     
        
        $total = ($inputFields ['queryNum'] * $inputFields ['perPage']) + $i - $inputFields ['perPage'];

	$out ['totItem']                        = $currentInfo ['numItem'] ;
	$out ['curPage']                        = $currentInfo ['numPage'] ;
	$out ['totPage']                        = $currentInfo ['totPage'] ;
        $out ['msg']                            = 'last recorded item = n. '.$i.' of block number '.$inputFields ['queryNum'].' total recorded = '.$total;                        
         
	return $out;
}

/*  ***************************************************
     preliminary back end function to create new index
    ***************************************************
*/

function WPxdamsBridge_count_records_in_DB ($archiveId) {
    
    global $wpdb;
        
    $query      = "SELECT * FROM xd_tree where archive = '".$archiveId."'";
  
    $risultati  = $wpdb->get_results($query);
    $out        = $wpdb->num_rows;
   
  
    return $out;
}    

function WPxdamsBridge_get_last_inserted_record_in_DB ($archiveId) {
    
    global $wpdb;
        
    $query      = "SELECT MAX(id) as lastinserted FROM xd_tree where archive = '".$archiveId."'";
  
    $risultati  = $wpdb->get_results($query);
    
    foreach ($risultati as $value) {
        $out[] = $value->lastinserted;
    }
    
    
        update_option ('WPxdamsBridge_tree_wuery_biblioBG',$query  .'...'.$out [0] );
  
    return $out [0];
} 
       
/*  ***************************************************
     preliminary back end function to create new index
    ***************************************************
*/

function WPxdamsBridge_reset_tree ($archiveId) {
    
    global $wpdb;
        
    $query      = "SELECT DISTINCT * FROM xd_tree ";
    
    $risultati  = $wpdb->get_results($query);
    
    if ($risultati) {   // first option table doesen't exixts
        
       // echo("esiste tabella canc ");  //da cancellare

	$a=$wpdb->delete ( 'xd_tree' , array ('archive' => $archiveId ));
    
     //   echo("delete ok  ");  //da cancellare

    } else {
       
     //   echo("non esiste tabella canc ");
	
	$charset_collate = $wpdb->get_charset_collate();
	$table_name =  'xd_tree';

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		xdams_id varchar(50) NOT NULL,
		archive varchar(50) NOT NULL,
                value text ,
                level varchar(50) ,
		my_father_is text,
		UNIQUE KEY id (id),
                PRIMARY KEY xdamsid (xdams_id,archive )
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

   //     echo('<br>'.$a.'inserito canc');
        
    }
    
}



/*  ***************************************************
     create relationship among archive nodes
    ***************************************************
*/

function WPxdamsBridge_find_my_father ($archiveId) {
    
    global $wpdb;
        
    $query      = "SELECT * FROM xd_tree where archive = '".$archiveId."'";
  
    $risultati  = $wpdb->get_results($query);
     echo('<br>esito:');
            foreach($risultati as $row) {
            echo('<br><strong>processed record -> </strong>'.$row->xdams_id.' <strong> record title:</strong> '.$row->value .'<strong> ---- son of:</strong> '.$row->my_father_is);
            $newquery      = "SELECT * FROM xd_tree where archive = '".$archiveId."' and xdams_id='".$row->xdams_id."'";
             $risultati2  = $wpdb->get_results($newquery);
             foreach($risultati2 as $row2) {
              //      echo( '......'.$row2->xdams_id .'###'.$row2->value );
            }
    }
    
   
  
    return $out;
}   


/*  ***************************************************
     create relationship among archive nodes
    ***************************************************
*/

function WPxdamsBridge_getChildsByDB ($archiveId, $father='',$currPage=1) {
    
    global $wpdb;
    global  $currentInfo;
    //$myFatherIs='Archivio Collaborativo (fotografico)';
   
    if($father) {
        $query          = "SELECT * FROM xd_tree where archive = '".$archiveId."' and xdams_id='".$father."'";
        $a=1;
    } else {
        if($currentInfo['treestartlevel']) {
            $a=2;
            $query      = "SELECT * FROM xd_tree where archive = '".$archiveId."' and xdams_id='".$currentInfo['treestartlevel']."'";
        } else {  
            $a=3;
            $query      = "SELECT min(xdams_id) as xdams_id , value FROM xd_tree where archive ='".$archiveId."' ";
       }
    }
    
  // echo('<br><strong>Albero processed record -> </strong>'.$query.$a.'<br>'); 
    
    $pre        = '  (';
  
    
    $risultati  = $wpdb->get_results($query);
    
    foreach($risultati as $row) {    
     
        $searchCriteria                 = trim(str_replace("'", "\'", $row->value)  )  ;
        
        $countQuery                     = "SELECT count(*) as totnumber FROM xd_tree where archive = '".$archiveId."' and my_father_is='".$searchCriteria."'";
        $countrisult                    = $wpdb->get_results($countQuery );
       
        $limitMin   = (($currPage - 1) * 10)  ;
        $limitMax   = (($currPage) * 10)  ;
      // echo('<br><strong>PAGING -> </strong>'.$limitMin.'.... '.$limitMax.'... '.$currPage.' numero '.$countQuery .'----<br>');
        
        
        foreach($countrisult as $rowR) {
    //        echo('<br><strong>Livello processed record -> </strong>'.$rowR->totnumber.' query '.$countQuery.'<br>');
             $results ['totItem']             = $rowR->totnumber;
        }
        $results ['curPage']            = $currPage;
        $results ['totPage']            = ceil(($rowR->totnumber)/10);
        
        $currentInfo ['treeResult']      = $results ;
    //    echo('<br><strong>trovati </strong>'.$results ['totItem'].' pagina '. $results ['curPage'].' di '.$results ['totPage'] .'<br>');
 
        $newquery                       =  "SELECT * FROM xd_tree where archive = '".$archiveId."' and my_father_is='".$searchCriteria."' limit ".$limitMin." , ".$limitMax;
    //    echo('<br><strong>Livello processed record -> </strong>'.$newquery.'<br>'); 
 
        $risultati2                     = $wpdb->get_results($newquery );
    
        $schema                         =  WPxdamsBridge_getTransformation ($archiveId);
        
        switch($schema){
            case 'mods':
                $condition              = "([XML,/mods/@ID]=";	
                break;
            case 'lido':
                $condition              = "([XML,/lido/lidoRecID/]=";	
                break;            
            case 'eaccpf':
                $condition              = "([XML,/eac-cpf/control/recordId/]=";	
                break;
            default:
                $condition              = "([XML,/c/@id]=";
                break;
        }

    foreach($risultati2 as $row2) {
          //      echo('<br><strong>processed record -> </strong>'.$row2->xdams_id.'<br> <strong> record title:</strong> '.$row2->value .'<br><strong> son of:</strong> '.$row2->my_father_is.'<br>');
                if ($i > 0) {
                    $out        =   $out .' OR '; 
                }
                $out            =   $out .$condition .$row2->xdams_id.')';     
                $i              =   $i + 1; 
            }
       }
    
       if ($out) {
            $out                =  $pre. $out .' ) '; 
       }     

    return $out;
} 

function WPxdamsBridge_get_hier ($archiveId , $requestedId) {
    
        $remoteFile                             =  WPxdamsBridge_get_remote_files ( $archiveId , $requestedId) ;                         
        $HierNodes                              = WPxdamsBridge_importFileToArray ($remoteFile['remoteFileHier']   , $archiveId, 'Hier');
		
	if( $HierNodes){       
            $currHierNode                       = stripslashes($HierNodes[$i]);           
            $currentInfo ['singleItemHier'][0]  = WPxdamsBridge_extractItemHier ($currHierNode);
	}
} 


function WPxdamsBridge_getTreeLevelDescription ($archiveId, $requestedId) {
    
    global $wpdb;  
    $newquery       =  "SELECT * FROM xd_tree where archive = '".$archiveId."' and xdams_id='".$requestedId."' ";     
    $risultati2     = $wpdb->get_results($newquery);
    
    foreach($risultati2 as $row2) {
        $out        =   $row2->value;     
    }
		
    return $out;

} 

/*  **************************************************
      this is the end....
    **************************************************
*/
?>
