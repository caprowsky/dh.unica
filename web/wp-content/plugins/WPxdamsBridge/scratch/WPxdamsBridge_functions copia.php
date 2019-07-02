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
				'type' => ''
				), $atts));
		// $type contains parameters e. [xdamsItem type="warning"]  		
		// $type contains data between shortcode /shortcode	
		global $archivesConfig;	
		
		if (!$type) {
			$currLevel			= WPxdamsBridge_get_request_parameter();
			$type				= $currLevel['archID']	;
			$root			 	= 1 	;  // indica che primo livello � "tutti gli archivi"
		}
		
		if ($type) {
		    
			if(WPxdamsBridge_get_option('active',$type) == 1){
				$currLevel		= WPxdamsBridge_get_request_parameter();					 
				$archivesConfig 	= WPxdamsBridge_get_archives_config();  //  load archives search configuration 
				$currLevel['root'] 	= $root;
				$outItem 		= WPxdamsBridge_get_childs ($content, $type, $currLevel);
				$outItem 		= '<div class="alert"> ' .$outItem.'</div>'.' richiesta a URL '. $xdamsURL .' con password '. $xdamsPSW ;
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
				'<a href="'.$currPage.'?&archID='.$archivesList ['id'][$i].'"> '.$archivesList ['label'][$i].'  </a>';
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
   
        $out = str_replace('<p>','1£$%&=p2£$%&=',$xmlIn);
	$out = str_replace('</p>','1£$%&=/p2£$%&=',$out);	
        $out = str_replace('<span>','1£$%&=span2£$%&=',$out);
	$out = str_replace('</span>','1£$%&=/span2£$%&=',$out);	
        $out = str_replace('<strong>','1£$%&=strong2£$%&=',$out);
	$out = str_replace('</strong>','1£$%&=/strong2£$%&=',$out);
        $out = str_replace('<h1>','1£$%&=h12£$%&=',$out);
	$out = str_replace('</h1>','1£$%&=/h12£$%&=',$out);
        
	return $out;     
}
function WPxdamsBridge_enableHtmlChar ($xmlIn) {   // uncorrect html tag can produce error in search              
   
        $out = str_replace('1£$%&=','<',$xmlIn);
	$out = str_replace('2£$%&=','>',$out);	
        
	return $out;     
}
function WPxdamsBridge_cleanAndReordXmlTag ($xmlIn, $onlyMainValue=false) {                 
   
        $stop = true;
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

function WPxdamsBridge_eliminateTag ($xmlIn, $onlyMainValue=false) {                 
   
        $startpos                   =  strpos ($xmlIn , '<' );    // find id there is a tag inside
            
        if ($startpos || ( substr($xmlIn, 0, 1) == '<')) {      // if eliminates
            $extractedTag           =  WPxdamsBridge_getTagName ($xmlIn);
            $tagEnd                 =  '</'.$extractedTag.'>';
            $tagStart               =  '<'.$extractedTag;
            $xml1                   =  WPxdamsBridge_GetElementByTagOnShoot ($xmlIn, $tagStart, $tagEnd);
            $xmlOut                 =  $xmlIn;
            if ($xml1['ok']) {
                $xmlOut             = $xml1['pre'];
                if(!$onlyMainValue){
                    $xmlOut         = $xmlOut .' '.$xml1['requestedValue'] ;
                }
                $xmlOut             = $xmlOut .' '.$xml1['post'] ;
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
                

        $startpos               = strpos($xml, $start);
        
        if ($startpos === false) {
            return $out['ok']   =false;
        }
        $newStart               = strpos($xml, '>' , $startpos );
        $endpos                 = strpos($xml, $end);
        if ($endpos === false) {
            $endpos             = strpos($xml, '/>');
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
        if (strlen($xml) > ($endpos+strlen($end)) ) {
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

function WPxdamsBridge_parseCompleteXML(  $archiveId , $currNode , $requestType) {

    global $WPxdamsBridge_cCounter;
    global $archivesConfig;
    global $currentInfo;
    global $element;
    
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
            $itemTagStart 			= '<lido>';
            $itemTagEnd 			= '</lido>';
            $itemId 				= WPxdamsBridge_GetElementByTag($currNode , '<lidoRecID', '</lidoRecID>' ) ;
           
        break;
        case 'mods':
            $itemTagStart 			= '<mods ';
            $itemTagEnd 			= '</mods>';
            $itemId 				= WPxdamsBridge_get_xml_field ('<mods '.$currNode , 'ID'); // necessario perchè ID in posizione zero
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
                $jump                           = WPxdamsBridge_getJump (  $i1,  $pathItem, $fields_options_from_db  );
				
            } else {
                $toPublishItem           	= WPxdamsBridge_extractSimpleTag(  $name , $currNode);
                $jump                           = 0;
            }
            $element [$name] [0]        	= $toPublishItem;	
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
        
        for($iOc=0;$iOc < $tagOccurence;$iOc++) {
            $currNode                   = WPxdamsBridge_truncXmlbyTag(  $GtagStart  , $splittedNodes [$iOc]);  //  truncate before opening tag
                                                            
            if ($level==$pathItemNum-1){      // if current level = last level of the path find the value else truncate the node
               
                $itemAttVal             = WPxdamsBridge_findAttValue( $pathItem [$pathItemNum-1], $splittedNodes [$iOc]);
                                                                       //  $out            = WPxdamsBridge_cleanXmlTag ($currNode);   RIPRISTINARE
                $pre1                   = "";
                $post1                  = "";
                $pre2                   = "";
                $post2                  = "";
               
                $out                    = WPxdamsBridge_cleanAndReordXmlTag ($currNode,  WPxdamsBridge_isTagToClean($currFieldNumber, $customSettings));
		if ($descIn) {

                    $before             =  $descIn;   // for nested fields I insert the field description in the result
                    $pre1               =  WPxdamsBridge_getTitlePre ($currFieldNumber, $customSettings) ;
                    $post1              =  WPxdamsBridge_getTitlePost ($currFieldNumber, $customSettings)  ;   
                }
                if ($out && ($requestType=='single')) {   // it doesn't add format option for title
                    $pre2               =  WPxdamsBridge_getValuePre ($currFieldNumber, $customSettings) ;
                    $post2              =  WPxdamsBridge_getValuePost ($currFieldNumber, $customSettings) ;
                }
                $resultTag              =  $resultTag.$pre1 .$before.$post1 .$pre2 . $out.  $itemAttVal. $post2;
                
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
                }
            } 
        } 
        
        return  $resultTag.$groupedFields;  
                                        
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
                           	
        $canc		= explode('[',$pathItem );
                            
        if ($canc [1]) {
            $itemAtt	= str_replace (']' , '' , $canc [1] );
        } else{
            $itemAtt	= '';	
        }
        
        if ($itemAtt) {
            $itemAttVal     =  WPxdamsBridge_get_xml_field ($xml, $itemAtt);
            if ($itemAttVal) {
                $itemAttVal	= ' ['. $itemAttVal . '] ';
            }    
        }
        return $itemAttVal;
}                            
function WPxdamsBridge_truncXmlbyTag( $tagStart , $currNode) { // find all the occurrence of a tag in a block
   
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
				'type' => 'info'     ,
                                'vocabulary' => 'no' ,
                                'height' => '500'    ,
                                'ratio' => ''    ,
                                'listtemplate' 	=> '',
                                'interval' => '4000'
				), $atts));
		
		// $type contains parameters e. [xdamsItem type="audiovisivo"]  		
		// $content contains data between shortcode /shortcode	
		global $currentInfo;
		$content= trim($content);
                
                $currentInfo['sliderHeight'] = $height ;
                $currentInfo['sliderInterval'] = $interval ;
		
		if(WPxdamsBridge_get_option('active',$type) == 1){
		
			$inputFields                                        = WPxdamsBridge_get_search_input_options('xdamsList',$content);

			if($inputFields['xdamsItem']){ 
			    if ($type == "@all")  {  $type = $inputFields['archID'] ;}
                            $outItem                                    = $outItem . WPxdamsBridge_single_item_request($inputFields['xdamsItem'], $type);  // publish 1 item 
			} else {

		    // get parameters to access to remote server
				if ($content) {    // case listing with a search criteria
                                        $inputFields                = WPxdamsBridge_extract_search_conditions ( $inputFields, $content );

				} else {
	
					$inputFields['fulltextsearch']      = 'list';
					$inputFields['listing']             = 'list';
				}
				$inputFields['listTemplate']			= $listtemplate;
				$outItem                             	= $outy."".WPxdamsBridge_execute_search($inputFields, $type, $tag, $vocabulary);  // publish results list 
			}	
		}	
		return $outItem; //.'->'.$currentInfo ['remotefile']; //debug requeste file -OK
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
        $inputFields[$i]                    = $singleCondition[1];	
        $inputFields['xDamsfield'][$i]      = $singleCondition[0];
    }
    
    $inputFields['fieldsNum']               = $paramNum;
    $inputFields['notEmpyFields']           = $paramNum; 
    
    return   $inputFields;
}
// management of the short code for publishing a results page for an archive 


function WPxdamsBridge_search_publishing_process($atts, $content = null) {
   
		
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
		
		$outItem = WPxdamsBridge_search_process ($att, $content , $type, 'freeSearch', $form, $formtemplate , $listtemplate, $listdescpre, $listdescpos,  $itemdescpre, $itemdescpos);    
			
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
                                    $inputFields['fulltextsearch']  = str_replace('é', '%E9', $inputFields['fulltextsearch']);
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
,    '%C3%80'   //   À
,    '%C3%81'   //   Á
,    '%C3%82'   //   Â
,    '%C3%83'   //   Ã
,    '%C3%84'   //   Ä
,    '%C3%85'   //   Å
,    '%C3%86'   //   Æ
,    '%C3%87'   //   Ç
,    '%C3%88'   //   È
,    '%C3%89'   //   É
,    '%C3%8A'   //   
,    '%C3%8B'   //   Ë
,    '%C3%8C'   //   Ì
,    '%C3%8D'   //   Í
,    '%C3%8E'   //   Î
,    '%C3%8F'   //   Ï
,    '%C3%90'   //   Ð
,    '%C3%91'   //   Ñ
,    '%C3%92'   //   Ò
,    '%C3%93'   //   Ó
,    '%C3%94'   //   Ô
,    '%C3%95'   //   Õ
,    '%C3%96'   //   Ö
,    '%C3%97'   //   ×
,    '%C3%98'   //   Ø
,    '%C3%99'   //   Ù
,    '%C3%9A'   //   Ú
,    '%C3%9B'   //   Û
,    '%C3%9C'   //   Ü
,    '%C3%9D'   //   Ý
,    '%C3%9E'   //   Þ
,    '%C3%9F'   //   ß
,    '%C3%A0'   //   à
,    '%C3%A1'   //   á
,    '%C3%A2'   //   â
,    '%C3%A3'   //   ã
,    '%C3%A4'   //   ä
,    '%C3%A5'   //   å
,    '%C3%A6'   //   æ
,    '%C3%A7'   //   ç
,    '%C3%A8'   //   è
,    '%C3%A9'   //   é
,    '%C3%AA'   //   ê
,    '%C3%AB'   //   ë
,    '%C3%AC'   //   ì
,    '%C3%AD'   //   í
,    '%C3%AE'   //   î
,    '%C3%AF'   //   ï
,    '%C3%B0'   //   ð
,    '%C3%B1'   //   ñ
,    '%C3%B2'   //   ò
,    '%C3%B3'   //   ó
,    '%C3%B4'   //   ô
,    '%C3%B5'   //   õ
,    '%C3%B6'   //   ö
,    '%C3%B7'   //   ÷
,    '%C3%B8'   //   ø
,    '%C3%B9'   //   ù
,    '%C3%BA'   //   ú
,    '%C3%BB'   //   û
,    '%C3%BC'   //   ü
,    '%C3%BD'   //   ý
,    '%C3%BE'   //   þ
,    '%C3%BF'   //   ÿ
            );
    
    
    return $out;
}          
 function WPxdamsBridge_load_SCHAR () { 
     $out       = array(
         
    'o%CC%88'
,   'O%CC%88' 
,   'u%CC%88'            
,   'U%CC%88'
,       'À'
,       'Á'
,       'Â'
,       'Ã'
,       'Ä'
,       'Å'
,       'Æ'
,       'Ç'
,       'È'
,       'É'
,       '%C3%8A'
,       'Ë'
,       'Ì'
,       'Í'
,       'Î'
,       'Ï'
,       'Ð'
,       'Ñ'
,       'Ò'
,       'Ó'
,       'Ô'
,       'Õ'
,       'Ö'
,       '×'
,       'Ø'
,       'Ù'
,       'Ú'
,       'Û'
,       'Ü'
,       'Ý'
,       'Þ'
,       'ß'
,       'à'
,       'á'
,       'â'
,       'ã'
,       'ä'
,       'å'
,       'æ'
,       'ç'
,       'è'
,       'é'
,       'ê'
,       'ë'
,       'ì'
,       'í'
,       'î'
,       'ï'
,       'ð'
,       'ñ'
,       'ò'
,       'ó'
,       'ô'
,       'õ'
,       'ö'
,       '÷'
,       'ø'
,       'ù'
,       'ú'
,       'û'
,       'ü'
,       'ý'
,       'þ'
,       'ÿ'
            );
   return $out;    
 } 
       
function WPxdamsBridge_load_UNICODE () {   
    $out     = array(

     '%F6'
,    '%F6'   
,    '%FC'
,    '%FC' 
,    '%C0'  //   À
,    '%C1'  //   Á
,    '%C2'  //   Â
,    '%C3'  //   Ã
,    '%C4'  //   Ä
,    '%C5'  //   Å
,    '%C6'  //   Æ
,    '%C7'  //   Ç
,    '%C8'  //   È
,    '%C9'  //   É
,    '%CA'  //   
,    '%CB'  //   Ë
,    '%CC'  //   Ì
,    '%CD'  //   Í
,    '%CE'  //   Î
,    '%CF'  //   Ï
,    '%D0'  //   Ð
,    '%D1'  //   Ñ
,    '%D2'  //   Ò
,    '%D3'  //   Ó
,    '%D4'  //   Ô
,    '%D5'  //   Õ
,    '%D6'  //   Ö
,    '%D7'  //   ×
,    '%D8'  //   Ø
,    '%D9'  //   Ù
,    '%DA'  //   Ú
,    '%DB'  //   Û
,    '%DC'  //   Ü
,    '%DD'  //   Ý
,    '%DE'  //   Þ
,    '%DF'  //   ß
,    '%E0'  //   à
,    '%E1'  //   á
,    '%E2'  //   â
,    '%E3'  //   ã
,    '%E4'  //   ä
,    '%E5'  //   å
,    '%E6'  //   æ
,    '%E7'  //   ç
,    '%E8'  //   è
,    '%E9'  //   é
,    '%EA'  //   ê
,    '%EB'  //   ë
,    '%EC'  //   ì
,    '%ED'  //   í
,    '%EE'  //   î
,    '%EF'  //   ï
,    '%F0'  //   ð
,    '%F1'  //   ñ
,    '%F2'  //   ò
,    '%F3'  //   ó
,    '%F4'  //   ô
,    '%F5'  //   õ
,    '%F6'  //   ö
,    '%F7'  //   ÷
,    '%F8'  //   ø
,    '%F9'  //   ù
,    '%FA'  //   ú
,    '%FB'  //   û
,    '%FC'  //   ü
,    '%FD'  //   ý
,    '%FE'  //   þ
,    '%FF'  //   ÿ
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
            $splitted0 							=  explode("=", $reqParameters [0]);
            $field[$splitted0 [0]]                      = $splitted0 [1];
            $currentInfo ['devLog']                     = $currentInfo ['devLog'].'STEP 0 '.$splitted0 [0]. ' - '.$splitted0 [1];
        }
	
        if($reqParameters[1]) {	
            $field['LOG']  						=  $field['LOG'].$reqParameters[0];
            $splitted1 					= explode("=", $reqParameters [1]);
            $field[$splitted1 [0]]                      = $splitted1 [1];
            $currentInfo ['devLog']			= $currentInfo ['devLog'].'STEP 1 '.$splitted1 [0]. ' - '.$splitted1 [1];
        }
        if($reqParameters[2]) {
            $count 					= count ($reqParameters); // restituisce solo parametri aggiuntivi
            $field['requestParamNum']			= $count - 2;  // the first is the page of wordpress and second is the page of xdams
            for($i=2;$i<=$count;$i++) {
                $splitted1 				= explode("=", $reqParameters [$i]);
                $field[$splitted1 [0]]			= $splitted1 [1];  // SERVE ? penso di si nel caso full text search
                $field['requestField'][$i-1]            = $splitted1 [0];
                $field['requestParam'][$i-1]            = $splitted1 [1];
                $currentInfo ['devLog']                 = $currentInfo ['devLog'].'STEP N '.$field['requestField'][$i-1] . ' - '.$field['requestParam'][$i-1];
			//	$field['nodePath'][$i]	= $splitted1 [1];
            }			
        }		
		
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
	
	$WPxdamsBridge_cCounter=0;
	$endpos = strpos($xml, $end);
    $WPxdamsBridge_cCounter = $endpos;
    $lengt = $endpos;
    $tag = substr ($xml, 0, $lengt);

    return $outData;
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
                return false;
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
 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
