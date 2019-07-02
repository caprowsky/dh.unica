<?php
/*
this file contains the external calls to xDams
*/

// call for executing a search on xDams and prepare results to publish

function WPxdamsBridge_importFileToArray($file,$archiveId, $Hier=null ) {   

// open file and search general information after it split file in single nodes
        
    
    global $currentInfo;

    
    
	$file=str_replace(' ', '%20', $file);
	

	
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $file);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $output = curl_exec($ch); 
        
  
    foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $getline){
    
		$pos = strpos('p'.$getline, '<response');
                $a=$a+1;
				
		if($pos) {	
		    $currentInfo ['numItem'] = WPxdamsBridge_get_xml_field ($getline , 'found');
		    $currentInfo ['numPage'] = WPxdamsBridge_get_xml_field ($getline , 'page');
		    $currentInfo ['totPage'] = WPxdamsBridge_get_xml_field ($getline , 'totPages');	      
		}
                      
		$data = $data . $getline;
    } 
        curl_close($ch);
    $count = 0;
    $pos=0;   
    $schema =  WPxdamsBridge_getCurrTransformation ();
        
    switch($schema){
    
        case 'lido':
            $itemTagStart 		= '<lido>';
            $itemTagEnd 		= '</lido>';
        break;
        case 'mods':
            $itemTagStart 		= '<mods ';
            $itemTagEnd 		= '</mods>';
            if ($Hier == 'Hier') {
                 $itemTagStart 		= '<mods>';
            } 
        break;
        case 'eaccpf':
            
            $itemTagStart 		= '<eac-cpf>';
            $itemTagEnd 		= '</eac-cpf>';

        break;
        default:
            $itemTagStart 		= '<c ';
            $itemTagEnd 		= '</c>';
                        
            if ($Hier == 'Hier') {
                 $itemTagStart 		= '<c>';
            } 
        break;
    }
       
    
// Goes throw XML file and creates an array of all <XML_TAG> tags.
	while ($Nodes[$count] = WPxdamsBridge_GetElementByName($data, $itemTagStart, $itemTagEnd )) {    // find different occurences of a tag
		$count++;
                
		$data = WPxdamsBridge_getNewBlockToExplore ($data);       
	}
  
 return $Nodes;
 }
 
 
 
function WPxdamsBridge_importVocabularyToArray($file,$archiveId ) {    // UNUSED CURLOLD open file and search general information after it split file in single nodes
	
	global $currentInfo;
 
	if (!($fp = fopen($file, "r"))) {        // CURLOD unused
		return false;
	}
	while ($getline = fread($fp, 4096)) {
		$pos = strpos($getline, '<response');

                $data = $data . $getline;
        }

        // to have te some structure of the other files
        $currentInfo ['numItem'] = 1; //NO DATA waiting for a new release with general information
	$currentInfo ['numPage'] = 1;
	$currentInfo ['totPage'] = 1;
	$count = 0;
	$pos=0;

	$itemTagStart 		= '<response';
	$itemTagEnd 		= '</response>';


// Goes throw XML file and creates an array of all <XML_TAG> tags.
	while ($Nodes[$count] = WPxdamsBridge_GetElementByName($data, $itemTagStart, $itemTagEnd )) {    // find different occurences of a tag
		
               $count++;
		$data = WPxdamsBridge_getNewBlockToExplore ($data);

	}
    
 return $Nodes;
 }
 
 function WPxdamsBridge_execute_search($inputFields, $archiveId, $tag, $vocabulary='no') {


    global $currentInfo;
    global $archivesConfig;
	
    $archivesConfig = WPxdamsBridge_get_archives_config();  //  load archives search configuration 
 
    if ($archiveId == "@all")  {     // case 1 - multiarchives
	
        $count2                             = $archivesConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives
        $archivesList                       = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array containing only archives
	$inputFields['multiarchives']       = true;
                
        if($currentInfo ['searchfield'] ) { 
            $searchField                    = '&searchfield='.$currentInfo ['searchfield'];     
	}
        if ($inputFields['fulltextsearch']) {
            $searchField                    = '&searchfield='.$inputFields['fulltextsearch'];            
	}
        
   //     $currentInfo ['multiArchivesResults'] = '££$$%%&&??@@' ; // for multiarchive search it marks position of archives results

        $searchResultsNumber                = 0;
        $itemmultisearch                    = (int)$currentInfo['itemmultisearch'];   // if $itemmultisearch is more than 0 we are in the case of single page for authority
	
      
        
        for($i=0;$i<$count2;$i++) {  //
                      
            if(WPxdamsBridge_get_option('active',$archivesList ['id'][$i]) == 1){
                if(($archivesList ['id'][$i] ==$inputFields['archID'] ) && ($itemmultisearch < 1)){
					
                    $currLabel              = $archivesList ['label'][$i];
                   
                } else {  
                   
                    $searchResultsNumber    = WPxdamsBridge_getSearchResultsNumber ($inputFields, $archivesList ['id'][$i], $tag);

                    if($searchResultsNumber ){
                        
                        $searchOK           =  'yes';
						
                        if ($currentInfo['showlist']=='yes' && (!$inputFields['archID'])) {
							
                            $currLabel              = $archivesList ['label'][$i];
                            $inputFields['archID']  = $archivesList ['id'][$i];
                        } else {
							 
                            $newURL				=  WPxdamsBridge_getNewRequestURL();
                            if(($currentInfo['redirect']  )) { // && ($itemmultisearch > 0)){   // case search by filed extract from an itme - numeber of field to find
                                $pos        = strpos('p'.$currentInfo['redirect'],'?');
                                if ($pos) {
                                    $add    = '&';
                                }   else { 
                                    $add    = '?';
                                }
                                $newURL				= get_bloginfo('wpurl').$currentInfo['redirect'].$add;
                            }
                            $menuArchives       =  $menuArchives 
					.'<br><a href="'.$newURL
					.'archID='.$archivesList ['id'][$i].$searchField.'"> '.$archivesList ['label'][$i].'  </a> ('.$searchResultsNumber.' '.WPxdamsBridge_getTerms('text_results').')'; 
                        }
                    }                  
                }
            }	
        }
		
//		ACCESSO MULTIARCHIVIO
        if ($searchOK !=  'yes') {
            $out2                           = WPxdamsBridge_getTerms('text_not_found');
        } else {               
            $out2                           = ' ';		
        }	
		
        if (($inputFields['archID']) && ( $currentInfo['itemmultisearch'] < 1)) {
		
            $archiveResults                 =  WPxdamsBridge_inArchive_search($inputFields, $inputFields['archID'], $tag, 'no');
            $out                            =  $out.' '
                                            .  $archiveResults.'';	
            $currentInfo['multiCurrArchive'] = $currLabel;
        }

        $currentInfo ['multiArchivesResults'] = $menuArchives;
 
       
        if ($currentInfo['showarchives']  == 'yes') {  
            if($currentInfo['menutemplate'] ){
                include ('WPxdams_custom/'.$currentInfo['menutemplate']); 
            } else {   
			
                include ('WPxdams_templates/WPxdamsBridge_results_page_menu.php'); 
            }            
        }    
         
    } else {
        $out                                = WPxdamsBridge_inArchive_search($inputFields, $archiveId, $tag, $vocabulary);
        $out                                = $out.'';		
    }
  return $out ;
 }
 
// call for executing a search on xDams and prepare results to publish

function WPxdamsBridge_inArchive_search($inputFields, $archiveId, $tag, $vocabulary) {
	
    global $currentInfo;
    global $archivesConfig;   
	
    $currentInfo ['fulltextsearch']     = $inputFields['fulltextsearch'];
    $currentInfo ['archiveDesc']        = WPxdamsBridge_get_archive_desc($archiveId);		
    $xdamsURL                           = WPxdamsBridge_get_option('url',$archiveId);
    $newpage                            = WPxdamsBridge_getNewRequestURL();
    $inputFields ['remotefile']         = $xdamsURL.'?';
    $currentInfo ['archiveId']          = $archiveId;       

    if (WPxdamsBridge_isActiveXslt($archiveId)) {
    $inputFields ['remotefile']         = $inputFields ['remotefile']	."xsltType=title";
    }

    if ($inputFields['viewType'] ) { 
        $tag                            = $inputFields['viewType']; // to force change from preview to list and from list to preview
        $currentInfo ['viewType']       = $inputFields['viewType'];
    }
  
// to prepare the request parameters
    
    $inputFields['xmlSchema'] =  WPxdamsBridge_getTransformation ($archiveId);
	
    if ($inputFields['fulltextsearch'])    // case 1 - free search 
	{  
    
        $inputFields ['navParam']			= '&searchfield='.$inputFields['fulltextsearch'];     // CBRQQ
 
            if(!$inputFields ['listing']) {                     // search a term - otherwise list any items 
              
                $inputFields ['freesearchclause']       = '([@]='.str_replace(' ', '%20', $inputFields['fulltextsearch'].')');
            }
             
            $inputFields = WPxdamsBridge_getInArchiveSearchParam($inputFields , $archiveId);
        } else{
        
            if ($vocabulary=='no' || $inputFields['vocabularyValue']) {   // case 2 - advanced search or search after vocabulary list
            
                $inputFields = WPxdamsBridge_getInArchiveSearchParam($inputFields , $archiveId);
            } else {
			
                if ($inputFields['startParam']) {
                    $startParam = $inputFields['startParam'];
                    $currentInfo ['morePages'] = 'yes';
                } else {
        
                    $startParam = '0';
                }
                if ($inputFields['updown'] == 'down') {
                    $updown = 'down';
                    $perPage = $vocabulary + 2;
                } else {
                    $updown = 'up';
                    $perPage = $vocabulary + 1;  // one more then request to manage eventually new page
                }
                $inputFields ['updown'] = $updown;
                $inputFields ['perpage'] = $perPage;
			 // one more then request to manage eventually new page
                $inputFields ['remotefile'] = $inputFields ['remotefile'].'mode=vocabulary&searchAlias=XML,'. $inputFields ['xDamsfield'][1].
                                            '&totResult='.$perPage .'&orientation='.$updown.'&startParam=%20'.$startParam;	
               
            } 
        }
     
//   to retrieve data asking file to remote server	
    
  //  $schema =  WPxdamsBridge_getTransformation ($archiveId);
        
        switch( $inputFields['xmlSchema']){
    
        case 'xslt':
           $xmlResult          = WPxdamsBridge_parse_xml_xslt_case ($inputFields);
            break;
        case 'lido':
           $xmlResult          =WPxdamsBridge_parse_xml_list_case ($inputFields, $archiveId);
	    break;
        default: 
                if ($vocabulary=='no' || $inputFields['vocabularyValue']) {  
                     
                    $xmlResult          = WPxdamsBridge_parse_xml_list_case ($inputFields, $archiveId);
                } else {	 
               
                    $xmlResult		= WPxdamsBridge_parse_xml_vocabulary_case ($inputFields, $archiveId);
                }
            break;
        }

        if ($startParam == '0') {
        $xmlResult ['backParam']  ='';
        }
        $currentInfo ['navParam'] 			= $inputFields ['navParam'];
        $currentInfo ['vocabularyValue']                = $inputFields ['vocabularyValue'];
        $currentInfo ['xmlResult'] 			= $xmlResult; 
        $currentInfo ['archiveId']			= $archiveId;
        $currentInfo ['viewType']			= $tag;
        $currentInfo ['remotefile']			= $inputFields ['remotefile']	;
        $currentInfo ['picToShow'] 			= $inputFields ['picToShow'];
        $currentInfo ['currInputFields'] 		= $inputFields ;
        $currentInfo ['multiCurrArchive']           =  $currentInfo ['archiveDesc'];
        WPxdamsBridge_resetGetElement () ;
			
// to publish in the final page	
        switch($tag){
    
            case 'xdamsPreview':
		
            include ('WPxdams_templates/WPxdamsBridge_preview_page.php');
            break;
                        
                case 'xdamsDynSlider':
			if($inputFields['listTemplate']) {
				$templateFile = 'WPxdams_custom/'.$inputFields['listTemplate'];
			} else {
				$templateFile = 'WPxdams_templates/WPxdamsBridge_dynamic_slider_page.php';
			} 
			include ($templateFile);		
            
                break;
	
                case 'xdamsListImg':
                $customImgListPage	= WPxdamsBridge_get_option('list',$archiveId);
                if($inputFields['listTemplate']) {    // parameter from shortcode
                    include     ('WPxdams_custom/'.$inputFields['listTemplate']);
                } else {
                    if ($customImgListPage)  {  
                      include ('WPxdams_custom/'.$customImgListPage);
                    } else {
                        include ('WPxdams_templates/WPxdamsBridge_pics_results_page.php');   
                    }
                }
            break;
	
            default:
                $currentInfo ['viewType'] = 'xdamsList'; 
                 
                if ($vocabulary=='no' || $inputFields['vocabularyValue']) {
                   
                    if($inputFields['multiarchives']) {
                        $temp	= WPxdamsBridge_get_option('alllist',$archiveId);
                            if ($temp) {
				$inputFields['listTemplate'] = $temp;
                            }
                    } else {
                        if(!$inputFields['listTemplate']) {
                            $inputFields['listTemplate']    = WPxdamsBridge_get_option('listC',$archiveId);
                        }    
                    }	
                    if($inputFields['listTemplate']) {
                        $templateFile = 'WPxdams_custom/'.$inputFields['listTemplate'];
                        
                    } else {
                        $templateFile = 'WPxdams_templates/WPxdamsBridge_results_page.php';
                    } 
                    include ($templateFile);
                } else {
                    
                    if($inputFields['vocabularytemplate']) {
                        include ('WPxdams_custom/'.$inputFields['vocabularytemplate']);
                    } else {
                        
                        include ('WPxdams_templates/WPxdamsBridge_vocabulary_page.php');
                    }      
                } 
            break;
        }
					
    return $out	;
}

function WPxdamsBridge_getInArchiveSearchParam($inputFields , $archiveId) {
    global $currentInfo;
  
    $inputFields ['searchCriteriaMsg']          = $inputFields ['searchCriteriaMsg'].'<br> ricerca eseguita per:'
						.$inputFields['notEmpyFields']. '- ';  // html that will be built and published

    
   
    
    if($inputFields ['pageToShow'] && (!$currentInfo ['newSearchStart']  ) ) {    // manage page navigation
        $inputFields ['remotefile']             = $inputFields ['remotefile'].'&pageToShow='.$inputFields['pageToShow'];
    }
    if ($inputFields['vocabularyValue']) {   // force value in the vocabulary case
	$inputFields [1]                        = utf8_decode($inputFields['vocabularyValue']);
         
    }   
    
    $searchPathIndex        			= 1;   // to manage multiple condition
    $count                                      = $inputFields['fieldsNum']	;  // number of visible fields in search form
    
    if (!areAllRecordsPublic ($archiveId)) {
        switch( $inputFields['xmlSchema']){
    
            case 'eaccpf':
                $publicClause          = '';
                break;            
            case 'xslt':
                $publicClause          = '';
                break;
            case 'lido':
                $publicClause          = '';
                break;
            case 'mods':
                $publicClause          = '%20AND%20[XML,/mods/accessCondition/]=external';
                $publicClauseNofields  = '&xwQuery=([XML,/mods/accessCondition/]=external)'; // case = no search criteria  CBRQQ
                break;
            default:
                $publicClause          = '%20AND%20[XML,/c/@audience]=external';   
                $publicClauseNofields  = '&xwQuery=([XML,/c/@audience]=external)'; // case = no search criteria  CBRQQ
                break;
        }
    }
    

    $conditionsInserted= 0;
    
    
    for($i=1;$i<=$count;$i++) { 
        
      //  if($i==1) { $searchPath                 = '&xwQuery=';}
            
	if( $inputFields[$i] &&   ($inputFields ['xDamsfield'][$i]!='pageToShow') && ($inputFields ['xDamsfield'][$i]!='viewType') ) { 
            
            if($inputFields['vocabularyValue']) {
                
                $searchValue                    =  '"%20'.$inputFields[$i].'"'. $publicClause;
                
              
            } else {
                $searchValue                    = $inputFields[$i]. $publicClause;     //str_replace('%20', ' ',  $inputFields[$i]). $publicClause;
            }
       
            $storedOptions                      = WPxdamsBridge_search_form_options($inputFields ['xDamsfield'][$i], $archiveId); // get the field description
            $inputFields ['searchCriteriaMsg']  = $inputFields ['searchCriteriaMsg'].'<br> '.$storedOptions['desc']  .' -> '.$inputFields[$i]. '['.$inputFields ['xDamsfield'][$i].']';
            $navParam                           = $navParam.'&'.$inputFields ['xDamsfield'][$i].'='.$searchValue ;
             
            
            if (WPxdamsBridge_isAField($inputFields ['xDamsfield'][$i])) {
                
                $conditionsInserted             = 1;
                if($inputFields['xDamsOperatorInPage']) {
                    $inputSeparator             = $inputFields['xDamsOperatorInPage'];  // case 1 additional condition in free search
                } else {
                    $inputSeparator             = $inputFields['xDamsOperator'];  // AND or OR specified in the request
                }
                
                if($searchPathIndex>1) {
                    $searchPath                 = $searchPath.  $inputSeparator   ;  // AND or OR specified in the request
                }
                $searchPathIndex                = $searchPathIndex+1;
                if ($inputFields ['xDamsfield'][$i] =='@') {
                    $searchPath                 = $searchPath.'(['.$inputFields ['xDamsfield'][$i].']='.$searchValue.')';  // caso ricerca full text nello shortcode
                } else {
                    $searchPath                 = $searchPath.'([XML,'.$inputFields ['xDamsfield'][$i].']='.$searchValue.')';  // cambiare qui per ricerca su pi� parametri
                }
            }
            
	}		
    }
    
    
    if ($conditionsInserted<1) {
        if($publicClauseNofields) {
           
            $searchPath                         = $publicClauseNofields;
        }
        if($inputFields ['freesearchclause']) {
            
            if($publicClauseNofields) {
                 $searchPath                    =  $searchPath.'%20AND%20';
            }
            
            $searchPath                         =$searchPath  .$inputFields ['freesearchclause'];    // case = no search criteria  CBRQQ
        }
        $pos                                    = strpos($searchPath , 'xwQuery');
        if ((!$pos)  && $searchPath ){  //cbrQQ
           $searchPath                          = '&xwQuery='.$searchPath;
        }
    } else {
        $searchPath                             =  '&xwQuery=('.$searchPath .')';
        if($inputFields ['freesearchclause']) {
            $searchPath                         = $searchPath.'%20AND%20'.$inputFields ['freesearchclause'];    // case = no search criteria  CBRQQ
        } 
    }
  //  echo('<br>---|'.$inputFields ['freesearchclause'].'|---|'.$conditionsInserted.'|-<br>');    
    
    $inputFields ['remotefile']			= $inputFields ['remotefile'].$searchPath;
    $inputFields ['navParam']			= $navParam;
    
    if ($currentInfo ['stampa'] == 1) {
        echo('<br>- stampa log -----|'.$inputFields ['remotefile'].'|-<br>');
    }	
    return $inputFields ;		
}


function WPxdamsBridge_getSearchResultsNumber($inputFields, $archiveId, $tag) {
	
	
	
    WPxdamsBridge_log( '_aa_par'.time(), 'WPxdamsBridge_getSearchResultsNumber');

    global $currentInfo;
	global $archivesConfig;

	$xdamsURL 					= WPxdamsBridge_get_option('url',$archiveId);
	$remoteFile                                     = $xdamsURL.'?';
        $currentInfo ['archiveId']                      = $archiveId;       

	if (WPxdamsBridge_isActiveXslt($archiveId)) {
            $remoteFile                                 = $remoteFile."xsltType=title";
	}
	$inputFields ['remotefile']                     = $remoteFile;
      
        $inputFields['xmlSchema'] =  WPxdamsBridge_getTransformation ($archiveId);
        
        if (!areAllRecordsPublic ($archiveId)) {
            switch( $inputFields['xmlSchema']){
    
                case 'eaccpf':
                    $publicClause          = '';
                break;             
                case 'xslt':
                    $publicClause          = '';
                break;
                case 'lido':
                    $publicClause          = '';
                break;
                case 'mods':
                    $publicClause          = '%20AND%20[XML,/mods/accessCondition/]=external';
                break;
                default:
                    $publicClause          = '%20AND%20[XML,/c/@audience]=external';    
                break;
            }
        }
        	
	// case 1 - free search 
	
        if ($inputFields['fulltextsearch'])
            {   
            
		if(!$inputFields ['listing']) {         // search a term - otherwise list any items 
                    $inputFields ['remotefile']		= $inputFields ['remotefile'].'&xwQuery=[@]='.$inputFields['fulltextsearch'];
		}
		if($inputFields ['pageToShow']) {       // manage page navigation
			$inputFields ['remotefile']	= $inputFields ['remotefile'].'&pageToShow='.$inputFields['pageToShow'];
		}

		
              
		if (WPxdamsBridge_isActiveXslt($archiveId)) {
			$xmlResult			= WPxdamsBridge_parse_xml_xslt_case ($inputFields);
  		} else { 
			$xmlResult			= WPxdamsBridge_parse_xml_list_case ($inputFields, $archiveId);
   		}
			 
		$currentInfo ['archiveId']		= $archiveId;
		$currentInfo ['xmlResult'] 		= $xmlResult;
		$currentInfo ['navParam'] 		= '&searchfield='.$inputFields['fulltextsearch']; 
		$numItem				= WPxdamsBridge_getTotalResultItems() ;
		WPxdamsBridge_resetGetElement () ;
 
        } else {
		// case 2 - advanced search 

		$count                                  = $inputFields['fieldsNum']	;  // number of visible fields in search form
		$searchPath             		= '&xwQuery=';
		$searchPathIndex        		= 1;   // to manage multiple condition
                
                if($inputFields['xDamsOperatorInPage']) {
                    $inputSeparator                     = $inputFields['xDamsOperatorInPage'];  // case 1 additional condition in free search
                } else {
                    $inputSeparator                     = $inputFields['xDamsOperator'];  // AND or OR specified in the request
                }
        //        $inputSeparator                         = str_replace('%20', ' ',  $inputSeparator);
			
		for($i=1;$i<=$count;$i++) 
                    { 
                    if($inputFields[$i]) { 
                
                        if($searchPathIndex>1) {
                            $searchPath                 = $searchPath. $inputSeparator   ;  // AND or OR specified in the request
                        }
                        $searchPathIndex        	= $searchPathIndex+1;
                        $storedOptions          	= WPxdamsBridge_search_form_options($inputFields ['xDamsfield'][$i], $archiveId); // get the field description
                        $navParam               	= $navParam.'&'.$inputFields ['xDamsfield'][$i].'='.$inputFields[$i];
                        if ($inputFields ['xDamsfield'][$i] =='@') {
                            $searchPath             	= $searchPath.'['.$inputFields ['xDamsfield'][$i].']='.$inputFields[$i].  $publicClause;  // cambiare qui per ricerca su pi� parametri
                        } else {
                            $searchPath             	= $searchPath.'[XML,'.$inputFields ['xDamsfield'][$i].']='.$inputFields[$i].  $publicClause;  // cambiare qui per ricerca su pi� parametri
                        }
                    }		
            }
            $inputFields ['remotefile']			= $inputFields ['remotefile'].$searchPath;
            
            if ($currentInfo ['stampa'] == 1) {
                   echo('<br> ---- stampa log --- ' .$inputFields ['remotefile'].'<br>');
            }
            
            
            if (WPxdamsBridge_isActiveXslt($archiveId)) {
		$xmlResult                		= WPxdamsBridge_parse_xml_xslt_case ($inputFields);
            } else {
		$xmlResult             		 	= WPxdamsBridge_parse_xml_list_case ($inputFields, $archiveId);
            }
			
            $currentInfo ['picToShow'] 			= $inputFields ['picToShow'];
            $currentInfo ['navParam'] 			= $navParam;
            $currentInfo ['xmlResult'] 			= $xmlResult; 
            $currentInfo ['archiveId']			= $archiveId;
            $numItem					= WPxdamsBridge_getTotalResultItems() ;
		
            WPxdamsBridge_resetGetElement () ;
        }
	
	return $numItem ; 
}
function WPxdamsBridge_parse_xml_xslt_case ($inputFields) {    // DAMODIFICARE CURL CURLOLD

	$remoteFile     = $inputFields ['remotefile'];
        
                    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $configFile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);  

//	if(!$p_file=fopen($remoteFile,"r")){   // DAMODIFICARE CURL CURLOLD
        if(!$output ){          
	   $out ['message'] = "errore nella lettura dei file locali";
        } else  {
	   $out ['message'] = 'ok';
	}
	
	$i=0;
//	while(!feof($p_file) && $i < 5000) CURLOLD
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $row)
		{
		//	$row 	= fgets($p_file, 4096);
			$row 	= utf8_encode ($row);
			$row1 	= str_replace("<", "", $row);
			
			$pos 	= strpos($row, 'response');
			
			if($pos) {
				$numItem = WPxdamsBridge_get_xml_field ($row , 'found');
				$numPage = WPxdamsBridge_get_xml_field ($row , 'page');
				$totPage = WPxdamsBridge_get_xml_field ($row , 'totPages');
				if ($numItem) {	
					$out ['totItem'] = $numItem;
					$out ['curPage'] = $numPage;
					$out ['totPage'] = $totPage;
				}		
			} else  {
				$pos = WPxdamsBridge_get_xml_field ($row , 'c id');
				if($pos) {
					$itemId	= $pos;
				    $step	='start';
				} else  {
					$pos   = WPxdamsBridge_get_xml_field ($row , '/c>');
					if($pos) { 
						$step	='fine';
					}
				}
			}
			
			if ($step == 'start')  {
				$content		= WPxdamsBridge_get_xml_list_item ($row); 
				if ($content) {
					$desc	 			= WPxdamsBridge_get_xml_field ($row , 'presentation');
					$element [$desc] 	= $element [$desc] .' - '.$content;
				}
			}
			
			if ($step == 'fine')  {
				$keys = array_keys($element); 
				$count = count($keys);
				$outriga = '';
				$sep = '';
 
				for($i1=0;$i1<$count;$i1++) {	
					$len =strlen($element [$keys[$i1]]);
					if ($i1 > 0 ) {$sep = ' - ';}					
					$outriga  	= $outriga.$sep. substr ($element [$keys[$i1]], 3, $len) ; 
					
				}
				$out ['itemId'][] 	= $itemId;
				$out ['results'][] 	= $outriga;
				$element = array();
				$step = '';
			}			
		
			$i++;
		}

		return $out;
}

function WPxdamsBridge_parse_xml_vocabulary_case ($inputFields, $archiveId) {

        global $currentInfo;
        $file                       = $inputFields ['remotefile'];
        $out ['message']            = "could not open XML input, please contact the webmaster";
    
        // curl management introduced START
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);    

            
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $getline){	
            $mystring               =$mystring.$getline;
        }
         // curl management introduced END
        
        if ($mystring){
                $out ['message']    = 'ok'; 
                $splitted           = explode('<key', $mystring );  // find any occurence
                $count              = count($splitted);

                if ($inputFields['updown'] == 'down' && $count ==  ($inputFields ['perpage']+1) ) {  // to manage back button I have to examine one more than request
                    $start          = 2;
                } else {
                    $start          = 1;
                }                                
            
                for ($i=$start; $i<$count; $i++) {
                    
                    $splitted2      = explode('>', $splitted[$i]);  //  for any occurence it cleans data
                    $splitted3      = explode('</key',$splitted2[1] );
                    $splitted4      = explode('freq=',$splitted2[0] );
                    $freq           = str_replace('"', '',$splitted4[1]);
                    if ($i==$start) {
                        $first = $splitted3[0];
                    }

                    if (strtolower($last [0])<= strtolower($splitted3[0][0])) {

                        if ($i < $count - 1) {   // don't print the last value requested only to evaluate next page
                            $out ['results'][]  = utf8_encode ( $splitted3[0]).' ('.$freq .')'; 
			}
			$data2                  = $data2.'<br>'.$splitted[$i];
			$last                   = $splitted3[0];
                        
                    } else {

                        $i=$count;
                        $last                   = '';
                        if ($inputFields['updown'] == 'down') {  // If I go back I have to find anytime the maximum number of results
                           $first               = '';
                        }	
                    }
                }

                if ($inputFields['updown'] == 'down' && $count <  ($inputFields ['perpage']+1)) {  // to force no back button in case of no more results back
                    $first                          = '';
                }
                $out ['backParam']              = $first;   
                $out ['startParam']             = $last;
                $out ['totItem']                = $ind= $ind+1; ;
                $out ['curPage']                = 1 ;
                $out ['totPage']                = '<br>count '. $count .' per page '.  $inputFields ['perpage'] .' first ' .$first. ' start '.$start.$inputFields['updown']  ; 
            }
	return $out;
}

function WPxdamsBridge_parse_xml_list_case ($inputFields, $archiveId) {


	global $archivesConfig;
	global $currentInfo;
	global $element;

	$remoteFile     = $inputFields ['remotefile'];

//	

	WPxdamsBridge_resetGetElement ();
        
                

	$Nodes = WPxdamsBridge_importFileToArray ($remoteFile ,  $archiveId);    //20160301
	 
	if ($Nodes == false) {
		die("could not open XML input, please contact the webmaster");
	} else {
		$out ['message'] = 'ok'; 
	}
	
	$count= count($Nodes) - 1;
        
	for ($i=0; $i<$count; $i++) {
//	 echo('<br>cbr.............. '.$i .'---'. $remoteFile.'<br>');
         
                $element 			= array();
		$currNode 			= $Nodes[$i] ;	
		// if($i==3) {echo('<br>cbr.............. '.$i .'---'. $currNode.'<br>');}
		$element	 		= WPxdamsBridge_parseCompleteXML($archiveId,  $currNode , 'list', $i) ;   // unused  $outItem2
		WPxdamsBridge_resetGetElement ();
		WPxdamsBridge_existsNextField();
		$out ['itemId'][]               = $currentInfo ['requestedId'];
       
		$keys 		 		= array_keys($element); 
		$rCount 			= count($keys);
		$requestedItemLevel             = WPxdamsBridge_getCurrentItemType() ;
	
                for ($ii=0; $ii<1; $ii++) {   // only one  -derived by exixting code     
                    
		  $result                       = '<span class="xd-title-list-2"> '. $element [$keys[$ii]] [0]  .'</span>';
                  if ($element [$keys[$ii+1]] [0] && WPxdamsBridge_get_option('preview',$archiveId) > 1 )  {        // add second field
                    $result                     = $result .'<span class="xd-title-list-2"> '. $element [$keys[$ii+1]] [0]  .'</span>'; // data to be visualized in list or item title
		  }
                  if ($element [$keys[$ii+2]] [0] && WPxdamsBridge_get_option('preview',$archiveId) > 3 )  {        // add second field
                    $result                     = $result .' <span class="xd-title-list-3"> '. $element [$keys[$ii+2]] [0]  .'</span>'; // data to be visualized in list or item title
		  }
                  if ($element [$keys[$ii+3]] [0] && WPxdamsBridge_get_option('preview',$archiveId) == 5 )  {        // add second field
                    $result                     = $result .' <span class="xd-title-list-4"> '. $element [$keys[$ii+3]] [0] .'</span>'; // data to be visualized in list or item title
		  }
                  
                  $result2                      = $requestedItemLevel;
                  $currentInfo ['authoritySearchValue'] =    $element [$keys[$currentInfo['itemmultisearch'] - 1]] [0];  //  itemmultisearch setted in shortcode with number of fields
		  
		}
		$out ['results'][] 		= $result;
		$out ['itemLevel'][]            = $result2;
		$out ['itemPic'][] 		= WPxdamsBridge_getMediaFileName() ; 
	}
	$out ['totItem']                        = $currentInfo ['numItem'] ;
	$out ['curPage']                        = $currentInfo ['numPage'] ;
	$out ['totPage']                        = $currentInfo ['totPage'] ;
              
                  
	return $out;
}

function WPxdamsBridge_get_xml_list_item ($row) {
	$first 			= strpos($row, 'xDamsElement');
	if($first) {
		$first 		= strpos($row, '>', $first);
		$last 		= strpos($row, '<', $first+1);
		$out 	 	= substr($row, $first + 1, $last - $first -1) ;
	}
     
	return $out;
} 

// manage publishing of a singke item (case 1 simplified XML)

function WPxdamsBridge_single_item_request ($requestedId, $archiveId) {

// this call function WPxdamsBridge_parse_xml_for_item which give a double dimension array with description of a field and 
// in the second dimension an array of multiple value returned by server

		global $archivesConfig;	
		global $currentInfo;
		global $element;
		global $elementCounter;
		$Nodes = array();
		
		$elementCounter					= 0;
		$archivesConfig 				= WPxdamsBridge_get_archives_config();  //  load archives search configuration 
                

               
		$out									= '' ;
                $requestedId   		   			= trim($requestedId);
		$currentInfo ['archiveDesc']	 		= WPxdamsBridge_get_archive_desc($archiveId);			// archive desc
		$currentInfo ['requestedId']			= $requestedId;	
		$currentInfo ['archiveId']			= $archiveId;	

		if (WPxdamsBridge_isActiveXslt($archiveId)) {   // WARNING verificare gestione FOPEN   CURLOLD
		    
			$element				= WPxdamsBridge_parse_xml_for_item ($requestedId, $archiveId);
			$currentInfo ['requestedItemLevel']	= $element ['requestedItemLevel'];	
			unset ($element ['requestedItemLevel']);	
            			
		} else {
                        $remoteFile     =  WPxdamsBridge_get_remote_files ( $archiveId , $requestedId) ;

			WPxdamsBridge_resetGetElement ();
                        
                        
		
			$Nodes                                  = WPxdamsBridge_importFileToArray ($remoteFile['remoteFile']    , $archiveId);   //20160301
			
                        if ($Nodes == false) {
                            $out                                = "sorry! could not open XML input for the archive: ".$archiveId. '-' ;
			} else {
                            $out                                = $out .' ';
                            if ($remoteFile['getHier']) {
                
                                $HierNodes                      = WPxdamsBridge_importFileToArray ($remoteFile['remoteFileHier']   , $archiveId, 'Hier');
                                
                            }
                        }
			$count= count($Nodes) - 1;
                        
		// Gets infomation from tag siblings.
			for ($i=0; $i<$count; $i++) {
                                
				$currNode                       = $Nodes[$i] ;
                                $currHierNode                   = stripslashes($HierNodes[$i]);
                           //  echo($remoteFileHier .'ppp'.$count.$HierNodes[$i]);
                              
				$element                        = WPxdamsBridge_parseCompleteXML($archiveId,  $currNode , 'single') ;   // unused  $outItem2
                                
                                $currentInfo ['singleItemHier'][0] = WPxdamsBridge_extractItemHier ($currHierNode);
                                 
			}
		}

	/// to publish page
	
		if ($element)  {
		  	$xdamsFRM 			= get_option('WPxdamsBridge_page_'.$archiveId );   /////xxxx
			if ($xdamsFRM) {
				include ('WPxdams_custom/'.$xdamsFRM);
			} else {
                            
				include ('WPxdams_templates/WPxdamsBridge_item_page.php');
			}                                
		} else { 
		  $out			= $out.'<br>'. WPxdamsBridge_getTerms('text_11').'<br> ';//. $remoteFile ;
		}
        
                
                if ($currentInfo ['stampa'] == 1) {
              
                   $out= $out .'<br>- stampa log ------<br> '.$remoteFile['remoteFile' ]. ' <br>-----<br>';
                }
		return $out ;
                
}
/*
 *   please transfer this function in function.php file
 */

function WPxdamsBridge_get_remote_files ( $archiveId ,$requestedId) {   
    
    	$xdamsPSW                       = WPxdamsBridge_get_option('psw', $archiveId);
	$xdamsURL                       = WPxdamsBridge_get_option('url', $archiveId);
                        
        $schema                         =  WPxdamsBridge_getTransformation ($archiveId);
        
        switch($schema){
            case 'mods':
                $out['remoteFile']      = $xdamsURL."?xwQuery=[XML,/mods/@ID]=".$requestedId;	
                $out['remoteFileHier']  = $xdamsURL."?xwQuery=[XML,/mods/@ID]=".$requestedId.'&mode=hier';
                $out['getHier']         = true;	
                break;
            case 'lido':
                $out['remoteFile']      = $xdamsURL."?xwQuery=[XML,/lido/lidoRecID/]=".$requestedId;	
                $out['remoteFileHier']  = $xdamsURL."?xwQuery=[XML,/lido/lidoRecID/]=".$requestedId;
               $out['getHier']          = false;
                break;            
            case 'eaccpf':
                $out['remoteFile']      = $xdamsURL."?xwQuery=[XML,/eac-cpf/control/recordId/]=".$requestedId;	
                $out['remoteFileHier']  = $xdamsURL."?xwQuery=[XML,/eac-cpf/control/recordId/]=".$requestedId;
               $out['getHier']          = false;
                break;
            default:
                $out['remoteFile']      = $xdamsURL."?id=".$requestedId;
                $out['remoteFileHier']  = $xdamsURL."?xwQuery=[XML,/c/@id]=".$requestedId.'&mode=hier';
                $out['getHier']         = true;
                break;
        }
    
    
    return $out;
}


function WPxdamsBridge_get_childs ($content, $archiveId, $currLevel) {

		global $currentInfo;
		
                if(!$currLevel['pageToShow']) {
                    $currLevel['pageToShow']=1;
                }
                  
                $levelCondition= WPxdamsBridge_getChildsByDB($archiveId,$currLevel['treeLastLevel'],$currLevel['pageToShow']);  //contains string to add to rest request
                
                $archiveLabel                   = WPxdamsBridge_get_archive_desc($archiveId);	
		$currentInfo ['archiveDesc']	=  $archiveLabel ;	
		$currentInfo ['archiveId']	= $archiveId;	
		$currentInfo ['wpPageURL']	= $currLevel['wpPageURL'];
                $currentInfo ['isATreeNav']	= true;

  		$newpage 			= $_SERVER['REQUEST_URI'];
		$splittedrequest		= explode("&", $newpage);
		$newpage 			= $splittedrequest[0]; 
                if ($splittedrequest[1]) {
                    $splittedrequest[0]	= $splittedrequest [0].'&';
                }
         	
		$lastpage 			= $splittedrequest[1]; 
		$requestedId			= $currLevel['xdamsItem']	; //lllllllllllllllllllllllllll
		$lastpage 			= $currLevel['xdamsTreePath'];
                $xdamsURL                       = WPxdamsBridge_get_option('url', $archiveId);
		$inputFields ['remotefile'] 	= $xdamsURL .'?xsltType=title&xwQuery='.$levelCondition;  
                
               
		$currentInfo ['currLevel']	= $currLevel;

                if (($currLevel['showdetails'] =='yes') or (!$levelCondition)  ){
                   $singleItem                  =  WPxdamsBridge_single_item_request ( $currLevel['treeLastLevel'],WPxdamsBridge_getCurrentArchiveId());
                   if ($levelCondition)  {
                        $singleItemSidebar      = $singleItem;
                   } 
                }              
                
              
        //        if ($currLevel['showdetails'] !='yes') {
                    if (WPxdamsBridge_isActiveXslt($archiveId)) {
			$xmlResult		= WPxdamsBridge_parse_xml_xslt_case ($inputFields);
                    } else {
			$xmlResult		= WPxdamsBridge_parse_xml_list_case ($inputFields ,  $archiveId);
                    }
            //    }
  
  
                    
                
                $xmlResult ['totItem']                  =  $currentInfo ['treeResult'] ['totItem'] ;
                $xmlResult ['curPage']                  =  $currentInfo ['treeResult'] ['curPage'] ;
                $xmlResult ['totPage']                  =  $currentInfo ['treeResult'] ['totPage'] ;
                $xmlResult ['curPage']                  =  $currLevel['pageToShow'];
                
               
                $currentInfo ['multiCurrArchive']       = $archiveLabel ;
		$currentInfo ['xmlResult']              =  $xmlResult; 
                
 
                
                
       //     $archiveId		= WPxdamsBridge_getCurrentArchiveId() ;
	//$archiveLabel           = WPxdamsBridge_get_archive_desc($archiveId);
                $lastpage		= WPxdamsBridge_getCurrentTreeRequest();
		
// **************  to manage paging - not active now but mandatory field

                $pos 			= strpos($lastpage, 'pageToShow');
                if (!$pos) {
                    $pageToShow         = '&pageToShow=1';
                }
                
                
                
 
                if($currentInfo['treetemplate'] ){
                    include ('WPxdams_custom/'.$currentInfo['treetemplate']); 
                } else {   	
                 
                    include ('WPxdams_templates/WPxdamsBridge_tree_page_breadcrumbs.php'); 
                }            

                if($currentInfo['formtemplate'] ){
                   
                   if (($levelCondition)){
                       
                    include ('WPxdams_custom/'.$currentInfo['formtemplate']); 
                } }  
                
                if ($currentInfo ['listtemplate']) {
                    include ('WPxdams_custom/'.$currentInfo['listtemplate']); 
                } else {
                    include ('WPxdams_templates/WPxdamsBridge_tree_page.php'); 
                }
		
                $out                            = $out . '<input type="hidden" name="c_treepath_WPxdamsBridge" value="'.$currpage	.'" />'. $temp; 


		return $out;
}
function WPxdamsBridge_parse_xml_for_config ($requestedItem, $archiveConfFile) {   // leave $requestedItem = null for config files

// parse xml file to estract description and values of item fields
    
        $configFile = get_bloginfo('wpurl').'/wp-content/plugins/WPxdamsBridge/WPxdams_config/'.$archiveConfFile;
    
    
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $configFile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);  

//	if(!$p_file=fopen($configFile,"r")){ CURLOLD
        if(!$output ){ 
	   $out = "errore nella lettura dei file locali";
	} else {
	   $out = $out."<BR>t<BR>";
	}
       
	$i=0;
//	while(!feof($p_file) && $i < 5000) CURLOLD
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $row)
		{
		//	$row = fgets($p_file, 4096);
			$row1 = str_replace("<", "", $row);
			$pos = strpos($row, 'response');  // never
			
			if($pos) {
				$numItem = WPxdamsBridge_get_xml_field ($row , 'found');
				$numPage = WPxdamsBridge_get_xml_field ($row , 'page');
				$totPage = WPxdamsBridge_get_xml_field ($row , 'totPages');
			} else  {
				$pos = WPxdamsBridge_get_xml_field ($row , 'c id');
				if($pos) {
					$itemId	= $pos;
					if (!$requestedItem) 			 {$requestedItem	= $itemId; } // if requestedItem is blank it takes the first
					if ($itemId == $requestedItem) {$step			= 'start'; }
				} else  {
					$pos   = WPxdamsBridge_get_xml_field ($row , '/c>');
					if($pos && ($itemId == $requestedItem)) { 
						$step	='fine';
					}
				}
			}
			if ($step == 'start')  {
				$content	= WPxdamsBridge_get_xml_list_item ($row); 
				if ($content=='active') {
					$desc	 	= WPxdamsBridge_get_xml_field ($row , 'presentation');
                                         
					if ($desc) {
						$role ="";
						$element [$desc] [] = $content.$role;
                                                $element [$desc] ['row']  = $row;    // save orginal row to manage position
						$element [$desc] ['multiple'] = 'no';
						$multiple		= WPxdamsBridge_get_xml_field ($row , 'multiple');    
						if ($multiple) { 
							$element [$desc] ['multiple'] = $multiple;
						}
                                                $element [$desc] ['label'] = $desc.'o';
						$label		= WPxdamsBridge_get_xml_field ($row , 'label');  
                                                
						if ($label) { 
							$element [$desc] ['label'] = $label;
						}
					}
				}
			}
			if ($step == 'fine')  {
				$i = 50000;
			}			
			$i++;
		}

		return $element;
}
function WPxdamsBridge_parse_xml_for_item ($requestedId , $archiveId) {    // WARNING DA MODIFICARE CURLOLD

// parse xml file to estract description and values of item fields
	
	
	$xdamsPSW 		= WPxdamsBridge_get_option('psw', $archiveId);
	$xdamsURL 		= WPxdamsBridge_get_option('url', $archiveId);
	$remoteFile 	= $xdamsURL."?xsltType=result&id=".$requestedId;

	if(!$p_file=fopen($remoteFile,"r")){   // WARNIG verificare gestione FOPEN   CURLOLD XSLT
	   $out = "errore dal server";
	 } else  {
	   $out = $out."<BR><BR>";
	}
	$i=0;
	while(!feof($p_file) && $i < 5000)
		{
			$row = fgets($p_file, 4096);
			$row 	= utf8_encode ($row);
			$row1 = str_replace("<", "", $row);
			$pos = strpos($row, 'response');
			
			if($pos) {
				$numItem = WPxdamsBridge_get_xml_field ($row , 'found');
				$numPage = WPxdamsBridge_get_xml_field ($row , 'page');
				$totPage = WPxdamsBridge_get_xml_field ($row , 'totPages');
			} else  {
				$pos = WPxdamsBridge_get_xml_field ($row , 'c id');
				if($pos) {
					$itemId	= $pos;
					if (!$requestedId) 			 {$requestedId	= $itemId; } // if requestedId is blank it takes the first
					if ($itemId == $requestedId) {$step			= 'start'; }
					$element['requestedItemLevel']				= WPxdamsBridge_get_xml_field ($row , 'level');
				} else  {
					$pos   = WPxdamsBridge_get_xml_field ($row , '/c>');
					if($pos && ($itemId == $requestedId)) { 
						$step	='fine';
					}
				}
			}
			if ($step == 'start')  {
				$content	= WPxdamsBridge_get_xml_list_item ($row); 
				if ($content) {
					$desc	 	= WPxdamsBridge_get_xml_field ($row , 'presentation');
					if ($desc) {
						$role ="";
	                    if ($desc=='persone' || $desc=='enti') {
							$role	 	= WPxdamsBridge_get_xml_field ($row , 'role');    
						     if ($role) { $role=' ['.$role.']';}
						}
						$element [$desc] [] = $content.$role;
					}
				}
			}
			if ($step == 'fine')  {
				$i = 50000;
			}			
			$i++;
		}

		return $element;
}

function WPxdamsBridge_get_fields_list($archiveId) {
    
    $fieldsNumber           = get_option('WPxdamsBridge_fields_num_'.$archiveId ); 
          
		
    $temp                   = get_option('WPxdamsBridge_search_fields_'.$archiveId ); 
    $fieldsList             = explode('%%%', $temp);
           
    for($i=0;$i<$fieldsNumber;$i++) {
        $position = $i* 3;
        $outarray ['name'][$i] 		= $fieldsList  [$position];
        $outarray ['label'][$i] 	= $fieldsList  [$position + 1];
        $outarray ['visibility'][$i] 	= $fieldsList  [$position + 2];
    }	

    $outarray ['metadata'][1]=$i;
				
    return $outarray; 
}

function WPxdamsBridge_get_fields_listFromFile($archiveId) {

	$configFile = get_bloginfo('wpurl').'/wp-content/plugins/WPxdamsBridge/WPxdams_config/'.$archiveId.'.json';
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $configFile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);  

//	if(!$p_file=fopen($configFile,"r")){  CURLOLD
        if(!$output ){              
	   echo("errore: manca file di configurazione<BR>".$configFile);
	   return;
	}
	
	$i=0;
//	while(!feof($p_file) && $ind < 500) CURLOLD
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $row)
		{
		    $ind++;
		//	$row = fgets($p_file, 4096);
			if($row) {
                            $pos            = strrpos($row, '#field');
			    if($pos) {
				   
				   $first   = strpos($row, 'label":');
				   if($first) {
						$first                  = strpos($row, '"', $first+7);
						$last                   = strpos($row,  '"', $first+1);
						$outarray ['label'][$i] = substr($row, $first+1, $last-$first-1);
				   }
				   $first = strpos($row, 'id":');
				   if($first) {
						$first                  = strpos($row, '"', $first+4);
						$last                   = strpos($row,  '"', $first+1);
						$outarray ['name'][$i]  = substr($row, $first+1, $last-$first-1); 

				   }
				   if($outarray ['name'][$i] && $outarray ['label'][$i]) {
				     $i++;
				   }
			   }
			}	
		}

	$outarray ['metadata'][1]=$i;
				
	return $outarray; 
} 


//  get information about archives available

function WPxdamsBridge_import_archives_config() {
    
    global $conta;
    $conta = $conta +1 ;
	
	$configFile = get_bloginfo('wpurl').'/wp-content/plugins/WPxdamsBridge/WPxdams_config/archives.json';
        

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $configFile);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);  
	
        

	// if($p_file=@fopen($configFile, "r")){ CURLOLD
        if($output ){  
	   $out = 'letto file di configurazione '.$configFile.'<BR>'; 
           
            $i=0;$i2=0;
	
// loop reads the archive (type=archive) and item for each archive (type=archLevel) producing a list of available items (tipi di scheda)	
    //      while(!feof($p_file) && $ind < 500)    CURLOLD
            foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $row)
		{
		    $ind++;
		//	$row = fgets($p_file, 4096);
			if($row) {
//  here read archive
				$pos = strrpos($row, '#archive');
			    if($pos) {
				   
				   $first = strpos($row, 'label":');
				   if($first) {
						$first = strpos($row, '"', $first+7);
						$last = strpos($row, '"', $first+1);
						$outarray ['label'][$i] = substr($row, $first+1, $last-$first-1);
				   }
				   $first = strpos($row, 'id":');
				   if($first) {
						$first = strpos($row,'"', $first+4);
						$last = strpos($row, '"', $first+1);
						$outarray ['id'][$i] = substr($row, $first+1, $last-$first-1); 

				   }
				   $first = strpos($row, 'xOut":');
				   if($first) {
						$first = strpos($row, '"', $first+6);
						$last = strpos($row, '"', $first+1);
						$outarray ['xOut'][$i] = substr($row, $first+1, $last-$first-1); 

				   }				   
				   if($outarray ['id'][$i] && $outarray ['label'][$i]) {
				     $i++;
				   }
			   }
//  here read items for archive
				$pos = strrpos($row, '#archLevel');
			    if($pos) {
				   
				   $first = strpos($row, 'label":');
				   if($first) {
						$first = strpos($row, '"', $first+7);
						$last = strpos($row, '"', $first+1);
						$outarray2 ['label'][$i2] = substr($row, $first+1, $last-$first-1);
				   }
				   $first = strpos($row, 'id":');
				   if($first) {
						$first = strpos($row, '"', $first+4);
						$last = strpos($row, '"', $first+1);
						$outarray2 ['id'][$i2] = substr($row, $first+1, $last-$first-1); 

				   }
				   $first = strpos($row, 'father":');
				   if($first) {
						$first = strpos($row, '"', $first+8);
						$last = strpos($row, '"', $first+1);
						$outarray2 ['father'][$i2] = substr($row, $first+1, $last-$first-1); 
						$outarray2 ['fatherDesc'] [$i2] ="Error";
						for($ind2=0;$ind2<=$i;$ind2++) {
						   if($outarray2 ['father'][$i2] == $outarray ['id'][$ind2] )
						      { $outarray2 ['fatherDesc'] [$i2] = $outarray ['label'][$ind2];
                                                         
                                                      }
						}
                                             
				   }	
				   $first = strpos($row, 'configfile":');
				   if($first) {
                                                
						$first = strpos($row, '"', $first+12);
						$last = strpos($row, '"', $first+1);
						$outarray2 ['configfile'][$i2] = substr($row, $first+1, $last-$first-1); 

				   }	
				   $first = strpos($row, 'mediafield":');
				   if($first) {
                                     
						$first = strpos($row, '"', $first+12);
						$last = strpos($row, '"', $first+1);
						$outarray2 ['mediafield'][$i2] = substr($row, $first+1, $last-$first-1);
                                       

				   }	
				   $first = strpos($row, 'videofield":');
				   if($first) {
						$first = strpos($row, '"', $first+12);
						$last = strpos($row, '"', $first+1);
						$outarray2 ['videofield'][$i2] = substr($row, $first+1, $last-$first-1); 

				   }				   
				   if($outarray2 ['id'][$i2] && $outarray2 ['label'][$i2]) {
				     $i2++;
				   }
			   }			   
			}	
		}
        } else  {
	   $out = "errore manca file di configurazione<BR>".$configFile;
           
	}
	$outarray2 ['file_reading_msg'] = $out;        
	$outarray2 ['WPxdamsBridge_archivesItemNumber'][0]=$i2;
	$outarray2 ['WPxdamsBridge_archivesNumber'][0]=$i;
	$outarray2 ['WPxdamsBridge_archivesList'][0]=$outarray;        
        
       
	
	return $outarray2;  
} 
 
function WPxdamsBridge_get_archives_config(){
    
	$temp = get_option('WPxdamsBridge_setting_saved' );   /////xxxx
	
	if ($temp=='yes') {
            $temp                               = get_option('WPxdamsBridge_archives_id' ); 
            $archivesID                         = explode('%%%', $temp);
		
            $temp                               = get_option('WPxdamsBridge_archives_des' ); 
            $archivesDes                        = explode('%%%', $temp);
                
            $temp                               = get_option('WPxdamsBridge_archives_xOut' ); 
            $archivesXOut                       = explode('%%%', $temp);
                
            $archivesNumber                     = count($archivesID)-1;	
            for($i=0;$i<$archivesNumber;$i++) {
                $outarrayIn ['id'][$i] 		= $archivesID [$i];
				$outarrayIn ['label'][$i] 	= $archivesDes [$i];
                $outarrayIn ['xOut'][$i] 	= $archivesXOut [$i];
                $arcDesc    [$archivesID [$i]]  = $archivesDes [$i];
            }	
           
             
            $temp                               = get_option('WPxdamsBridge_archives_items' ); 
            $archivesItemID                     = explode('%%%', $temp);
            
            $archivesItemsNumber                = count($archivesItemID) - 1;	
            
            if ($archivesItemsNumber  <1)    {    // manage migration from 1.0 to 1.1
                $importConfig                   = WPxdamsBridge_import_archives_config() ;
                $archivesItemsNumber            = $importConfig['WPxdamsBridge_archivesItemNumber'][0];
                for($i3=0;$i3<$archivesItemsNumber;$i3++) {
                    $archivesItemID [$i3]        = $importConfig ['id'][$i3];  
                    $tempId                      = $tempId.$importConfig ['id'][$i3] .'%%%';
                    $tempLabel                   = $tempLabel.$importConfig ['label'][$i3] .'%%%';
                    $tempFather                  = $tempFather.$importConfig ['father'][$i3] .'%%%';
                }
                update_option('WPxdamsBridge_archives_itemFather',$tempFather  ); 
                update_option('WPxdamsBridge_archives_itemLabel' ,$tempLabel  ); 
                update_option('WPxdamsBridge_archives_itemId' ,$tempId  );   
            }
                
            $temp                               = get_option('WPxdamsBridge_archives_itemFather' ); 
            $archivesItemFather                 = explode('%%%', $temp);
	
            
            $temp                               = get_option('WPxdamsBridge_archives_itemLabel' ); 
            $archivesItemLabel                  = explode('%%%', $temp);
            
           
            for($i2=0;$i2<$archivesItemsNumber;$i2++) {
                $outarray2 ['label'][$i2] 	= $archivesItemLabel  [$i2];
				$outarray2 ['id'][$i2]   	= $archivesItemID [$i2];
                $outarray2 ['father'][$i2]	= $archivesItemFather [$i2];
                $outarray2 ['fatherDesc'] [$i2] = $arcDesc    [$archivesItemFather [$i2]];
				$outarray2 ['videofield'] [$i2] = get_option('WPxdamsBridge_video_fields_'. $archivesItemID [$i2].'@'. $archivesItemFather [$i2]);
                $outarray2 ['mediafield'] [$i2] = get_option('WPxdamsBridge_media_fields_'. $archivesItemID [$i2].'@'. $archivesItemFather [$i2]);           
            }
	
	$outarray2 ['WPxdamsBridge_archivesItemNumber'][0]=$i2;
	$outarray2 ['WPxdamsBridge_archivesNumber'][0]=$archivesNumber;
	$outarray2 ['WPxdamsBridge_archivesList'][0]=$outarrayIn;
        
	} else {
           
                            
		$outarray2		= WPxdamsBridge_import_archives_config();
                $outarray2 ['WPxdamsBridge_updateAllConfiguration'][0]='yes';
	}
	return $outarray2;  
}


function WPxdamsBridge_exportDBsettings($nomefile){               
   
    global $wpdb;
    
    $results = $wpdb->get_results( 
                "
                    SELECT *
                    FROM $wpdb->options
                    WHERE 
                        option_name like 'WPxdamsBridge_%' 
                "
    );
    
    $fp = fopen($nomefile, 'w');    // OK scrive in locale
    fwrite($fp,'{     "items":   [');
    fwrite($fp,"\n");
    
    foreach ( $results as $result ) {
        $out= $out. '{"type":"#record",   "option_name": "'. ($result->option_name).'" , "option_value": "'. ($result->option_value).'" }'."\n";
     
    //    fwrite($fp,$out);
     //  fwrite($fp,"\n");
    }
	

    fwrite($fp,$out); 

    fwrite($fp,'}');
    fclose($fp);
		
    return ;
}

function WPxdamsBridge_loadLanguage ($language, $archiveId){  
    
    if ($language=='main' && $archiveId=='general@'){
         $fileLang  = get_bloginfo('wpurl').'/wp-content/plugins/WPxdamsBridge/WPxdams_messages/'.$archiveId.'_lang_'.$language.'.properties';
    } else {
        $fileLang   = get_bloginfo('wpurl').'/wp-content/plugins/WPxdamsBridge/WPxdams_custom/languages/'.$archiveId.'_lang_'.$language.'.properties';
    }
     
    if(WPxdamsBridge_url_exist ($fileLang)){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fileLang);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);  
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $output) as $contents){
            $term       = explode('=',$contents );
            if ($term[1]){
                $out[$term[0]]=$term[1];           
            }    
	}

	
    } else {       
	$out['%%%error_code']='004';  
	$out['%%%errore file']='No File: '.$fileLang;      
    }
        
  return $out;
}



function WPxdamsBridge_loadSettings ($filename){    
    
        $fileIn  = get_bloginfo('wpurl').'/wp-content/plugins/'.$filename;
 

        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fileIn);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $handle = curl_exec($ch); 
        curl_close($ch);   
        
        if(!$handle) {       
            $out['%%%error_code']='004';  
            $out['%%%errore file']='No File: '.$fileIn;
        }
        
	   
//	$handle=fopen($fileIn,"r");
  //      $row = '';
	
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $handle) as $row){
   //     while (!feof($handle) && $i < 10000) {
           
       //     $row        = fgets($handle, 1024);                     
            $i1=$i1+1;
            $pos        = strrpos($row, '#record');
            if($pos) {
		$i          = $i+1;		   
                $first = strpos($row, 'option_name":');
                if($first) {
                    $first = strpos($row, '"', $first+13);
                    $last = strpos($row, '"', $first+1);
                    $out ['option_name'][$i] = substr($row, $first+1, $last-$first-1);
                }  
                $first = strpos($row, 'option_value":');
                if($first) {
                    $first = strpos($row, '"', $first+14);
                    $last = strpos($row, '"', $first+1);
                    $out ['option_value'][$i] = substr($row, $first+1, $last-$first-1);
                }
            }         
        }
    //    fclose($handle);
 
       
    $out ['results_number'][0]=$i;
    $out ['rows'][0]=$i1;
            
  return $out;
}
 
/*  **************************************************
      this is the end....
    **************************************************
*/
 

?>
