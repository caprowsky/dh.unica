<?php
/*
function for publishing pages
*/


//  

function WPxdamsBridge_theStory() {
   
		$postid 	= get_the_ID();
		$storyId 	= get_post_meta( $postid, 'WPxdamsBridgeExhibition', false );
		$out 		= WPxdamsBridge_story_publishing_process($atts, $storyId [0]);
		
		return $out;
}


//  give description of current archive 

function WPxdamsBridge_isThePostAStory($content) {
   
	$out            = false	 ;       
        $pos            = strpos($content, '[/xdamsStory]');
                
        if ($pos) {
            $out        = true	 ;  
        } else {
            $pos            = strpos($content, '[/xdamsStoryTelling]');
                
            if ($pos) {
                $out        = true	 ;  
            }    
        }		
	return $out;
}
function WPxdamsBridge_isNotAStoryFullscreen($content) {
   
	$out            = true	 ;       
        
                
        if (WPxdamsBridge_isThePostAStory($content)) {
            
            $pos        = strpos($content, "ratio='fullscreen'");
            
            if ($pos) {
                
                $out    = false	 ;
            }
        }
			
	return $out;
}

//    give description of current archive 

function WPxdamsBridge_getCurrentArchiveDesc() {
   
		global $currentInfo;
		
		
		return $currentInfo ['archiveDesc'];
}
//  give id of current item 

function WPxdamsBridge_getCurrentItemId() {
   
		global $currentInfo;
		
		
		return $currentInfo ['requestedId'];
}

//  give type of current item (level) 

function WPxdamsBridge_getCurrentItemType() {
   
		global $currentInfo;
		
                if($currentInfo ['requestedItemLevel']) {
                    $out = $currentInfo ['requestedItemLevel'];
                } else {
                    $out ='fonds';
                }
		
		return $out;
}

//  give id of current archive 

function WPxdamsBridge_getCurrentArchiveId() {
   
		global $currentInfo;
		
		
		return $currentInfo ['archiveId'];
}

function WPxdamsBridge_getMediaFileName() {
   
	global $currentInfo;

	return $currentInfo ['mediaFileName'];
}



function WPxdamsBridge_getMediaFileURL($dim=null) {

	$out = false; 
		
	if (WPxdamsBridge_getMediaFileName()) {
		
            $mediaFiles = WPxdamsBridge_getMediaFileName() ;
            update_option(1,$mediaFiles [0]);
          
            if  (WPxdamsBridge_isAnExternalURL( $mediaFiles [0])) {
                update_option(2,$mediaFiles [0]);
                $out            = '###'.$mediaFiles [0]; 
            } else {
                if (WPxdamsBridge_isAnImage($mediaFiles [0])) 	{    
                    update_option(3,$mediaFiles [0]);
                    $out        = WPxdamsBridge_get_option('media', WPxdamsBridge_getCurrentArchiveId());
                    $picDim     = 0;
                    if ($dim)   { $picDim = $dim;} 
                    $out        = $out.$picDim.'?imageName=/high/'. $mediaFiles [0];
                } else {
                    $out        =   WPxdamsBridge_get_option('attachments', WPxdamsBridge_getCurrentArchiveId());
                    $out        = $out.'high/'. $mediaFiles [0];
                }
            }    
        }	
		
    return $out;
}
function WPxdamsBridge_getExtension($inputFile) {  
    
        $extensions     = explode('.', $inputFile);
        $num            = count($extensions);
        $out            = $extensions[$num-1];
    
         
    return $out;
}
function WPxdamsBridge_isAnImage($inputFile) {  
    
        $out                = false  ;   
        $managedExtensions  = '##/jpg/JPG/png/PNG/##';
        $ext                = WPxdamsBridge_getExtension($inputFile);
        $pos                = stripos( $managedExtensions, '/'.$ext.'/');
        
         
        if ($pos) {
            $out            = true  ;  
        }
        
       
    return $out;
}
function WPxdamsBridge_isExternalPage($in) {

    $out = false;
        
    if (substr($in, 0,3)=='###') 	{
           $out= true;
    } 

    return $out;
}
function WPxdamsBridge_cleanExternalPage($in) {

    $out= str_replace('###','',$in );

    return $out;
}

function WPxdamsBridge_getPreviewIco() {

	$out = get_bloginfo('wpurl').'/wp-content/plugins/WPxdamsBridge/WPxdams_templates/img/ICOdownload.jpg';
        
	return $out;
}
function WPxdamsBridge_getImage() {

	$in = WPxdamsBridge_getMediaFileURL(); 
   
	if ($in) {
      
            if (WPxdamsBridge_isAnImage($in) ) 	{
                $in= str_replace('###','',$in );
                $out 	= '<div id="xdamsPreviewFile"  class="xdamsPreviewFile"><a href="'.$in.'"><img src="'.$in.'"></a></div>';
           } else {
                 if (WPxdamsBridge_isExternalPage($in)) 	{
                    $out 	= '<div id="xdamsPreviewFile"  class="xdamsPreviewFile"><a href="'.WPxdamsBridge_cleanExternalPage($in).'">'.WPxdamsBridge_getTerms('text_external_preview').'</a></div>';
                    $out        =  $out .'<br><iframe src="'.WPxdamsBridge_cleanExternalPage($in).'" width="100%" frameborder="0" height="720px"></iframe><br>';
                 } else {
                    $out 	= '<div id="xdamsPreviewFile"  class="xdamsPreviewFile"><a href="'.$in.'"><br><img src="'.WPxdamsBridge_getPreviewIco().'"><br>leggi il documento originale</a></div>';
                }
            }
	}
        
	return $out;
}

function WPxdamsBridge_getVideo() {

	global $currentInfo;
	
	$out = $currentInfo ['videoFileName'][0];

	if ($out) {
            $out 	= $out ;
	} else {
            $out	= false;
        }    
	return $out;
}

function WPxdamsBridge_getPageMediaPreview() {
    
	$out = WPxdamsBridge_getVideo(); 
	
	if ($out) {
	    $pos	= strpos ($out , '://www.youtube.com/watch');
		if ($pos) { 
			$idYT 	= WPxdamsBridge_getYoutubeID($out) ;
			$out2		= ' <iframe width="560" height="315" src="https://www.youtube.com/embed/'.$idYT.'" frameborder="0" allowfullscreen></iframe>';
		}
		$out 		= '<div id="xdamsPreviewFile"  class="xdamsPreviewFile" ><a href="'.$out.'" target="_blank">'.$out.'</a></div>';
		
		$out		= $out2.'<br><br>'.$out;	
       
	} else {
		 $out = WPxdamsBridge_getImage(); 
    }   
        
	return $out;
}

/**
 * funtion to extract id of a youtube video
 */
function WPxdamsBridge_getYoutubeID($youtube_link) {
		$newpage                =   $youtube_link;	
		$splittedrequest 	=   explode("?", $newpage);
		$reqParameters 		=   explode("&", $splittedrequest[1]);
    
		//individua id 
		
		$count = count($reqParameters);
		for($i=0;$i<$count;$i++)
                    {
                    if($reqParameters[$i]=="") continue;
                    $spittedparameter   =   explode("=", $reqParameters [$i]);
                    if ($spittedparameter [0]=="v") {$video_id = $spittedparameter [1];}

                    }
return 	$video_id;		
}
function WPxdamsBridge_isAnExternalURL($inString) {   // DOC 
    
    $pos = WPxdamsBridge_itContanins($inString , 'http') ;
    
    if ($pos > 0)  {
        $out = true;
    } else {
        $out = false;
       } 

    return $out;
}

function WPxdamsBridge_itContanins($inString , $inTerms) {   // DOC if contanins give the position strating from 1 else 0
    
    $pos = strpos('A'.$inString, $inTerms);

    return $pos;
    
}
function WPxdamsBridge_getAllImages() {    // publish all attached  images

                global $currentInfo;
		
		$out =false; 

		if ($currentInfo ['mediaFileName']) {
                    $mediaPath      = get_option('WPxdamsBridge_media_'.$currentInfo ['archiveId']);
                    $filePath       = get_option('WPxdamsBridge_attachments_'.$currentInfo ['archiveId']);
                    $mediaFiles     = $currentInfo ['mediaFileName'] ;
                    $filesNum       = count( $mediaFiles);
                    $out            = '<div>';
                    
                    for($i2=1;$i2<$filesNum;$i2++) {
                        if (WPxdamsBridge_isAnImage($mediaFiles [$i2])) 	{
                            $a=WPxdamsBridge_isAnExternalURL( $mediaFiles [$i2]);

                            if  (WPxdamsBridge_isAnExternalURL( $mediaFiles [$i2])) {
                                $out = $out. '<div id="xdamsMultiFile"  class="xdamsMultiFile"><a href="'.$mediaFiles [$i2].'" target="_blank"><img src="'.$mediaFiles [$i2].'"></a></div>';
                            } else {
                                $out = $out. '<div id="xdamsMultiFile"  class="xdamsMultiFile"><a href="'.$mediaPath.'0?imageName=/high/'. $mediaFiles [$i2].'" target="_blank"><img src="'.$mediaPath.'0?imageName=/high/'. $mediaFiles [$i2].'"></a></div>';
                            }   
                        } else {
                            if  (WPxdamsBridge_isAnExternalURL( $mediaFiles [$i2])) {
                                $out = $out. '<div id="xdamsMultiFile"  class="xdamsMultiFile"><a href="'.$mediaFiles [$i2].'" target="_blank"><img src="'.WPxdamsBridge_getPreviewIco().'"><br>('.$mediaFiles [$i2].')<br>leggi il documento originale</a></div>';
                            } else {
                                $out = $out. '<div id="xdamsMultiFile"  class="xdamsMultiFile"><a href="'.$filePath.'high/'. $mediaFiles [$i2].'" target="_blank"><img src="'.WPxdamsBridge_getPreviewIco().'"><br>('.$mediaFiles [$i2].')<br>leggi il documento originale</a></div>';
                            }
                        }
                    }
                    $out            = $out.'</div>';
		}
                
		return $out;
}
function WPxdamsBridge_areMultipleImages() {  // publish all attached  images

                global $currentInfo;
		
		$out =false; 

		if ($currentInfo ['mediaFileName']) {
                   
                    $mediaFiles     = $currentInfo ['mediaFileName'] ;
                    $filesNum       = count( $mediaFiles);
                    if ($filesNum >1 ) {
                    
                        $out = true;
                    }
		}
                
		return $out;
}

function WPxdamsBridge_getNextFieldLabel() {
   
		global $nextFieldOut ;

		return $nextFieldOut;
}
function WPxdamsBridge_getNextFieldValue() {
   
		global $nextFieldOutVal ;

		return $nextFieldOutVal;
}

function WPxdamsBridge_manageLanguage() {   // update doc
    
    global $currentInfo  ;
    global $translatedTerms;
    
    $archiveId                                                  = WPxdamsBridge_getCurrentArchiveId() ;
    $currentInfo['currLanguage']                                = get_locale();
    $mainLanguage                                               = WPxdamsBridge_get_option('mlang');
    
    
    if(!$mainLanguage) {
       $mainLanguage                                            ='it_IT';
    }
                   
    if($mainLanguage !=  $currentInfo['currLanguage'] ) {
        if($mainLanguage !=  $currentInfo['currLanguage'] ) {
            $translatedTerms[$currentInfo['currLanguage'] ]     = WPxdamsBridge_loadLanguage (  $currentInfo['currLanguage'] , $archiveId);
            $currentInfo['pleaseTranslate']                     = true;
        }
    }
    
    
  return $out=true;
}
function WPxdamsBridge_loadGeneralTerms() {   // update doc  attenzione gestire linge principali diverse
    
    global $currentInfo  ;
    global $generalSentences;
    
   
    $currentInfo['currLanguage']        = get_locale();
    $mainLanguage                       = WPxdamsBridge_get_option('mlang');
    $toLoadLanguage                     = $currentInfo['currLanguage']   ;
    
    if(!$mainLanguage) {
       $mainLanguage                    ='it_IT';
    }

    $generalSentences                   = WPxdamsBridge_loadLanguage (  $toLoadLanguage, 'general@');
	
  //  if ($generalSentences['%%%error_code'] == '004') {
    $defaultSentences                   = WPxdamsBridge_loadLanguage (  'main', 'general@');
           
    $keys                               = array_keys($defaultSentences); 
    $count                              = count($keys);      
                
    for($i2=0;$i2<$count;$i2++) 
        {
        if(!$generalSentences[$keys[$i2]]) {
                          $generalSentences[$keys[$i2]]=$defaultSentences[$keys[$i2]]; 
        }                   
    }
   // }
  
  return $out=true;
}

function WPxdamsBridge_getTerms($textIn) {   // update doc
    
    global $currentInfo  ;
    global $generalSentences;
    
    $out = $generalSentences [$textIn];

  return $out;
}

function WPxdamsBridge_pleaseTranslate() {    // update doc
    
    global $currentInfo  ;
    
    return $currentInfo['pleaseTranslate'];
}

function WPxdamsBridge_getCurrentLanguage() {    // update doc
    
    global $currentInfo  ;
    
    return $currentInfo['currLanguage'];
}

function WPxdamsBridge_getTranslatedTerm($originalTerm) {    // update doc
    
    global $currentInfo  ;
    global $translatedTerms;

    if ( WPxdamsBridge_pleaseTranslate() &&  $translatedTerms[$currentInfo['currLanguage']][$originalTerm])	{
        $originalTerm  = $translatedTerms[$currentInfo['currLanguage']][$originalTerm];
                             
    }
    
    return $originalTerm ;
}

// function for publishing on page

function WPxdamsBridge_existsNextField() {
   
		global $element;
		global $elementCounter;
		global $fields_options_from_db ;
      //         global $fields_customization_from_db;
		global $nextFieldOut ;
		global $nextFieldOutVal;
                global $translatedTerms;
                global $pleaseTranslate;
                global $customSettings;
			
		$requestedItemLevel                     = WPxdamsBridge_getCurrentItemType() ;
		$archiveId                              = WPxdamsBridge_getCurrentArchiveId() ;
		$archiveLevelId                         = $requestedItemLevel.'@'.$archiveId;
 
		if ($elementCounter==null){	
                    $elementCounter                     =0;	// custom labels from user strored in DB		
		}
		if ($elementCounter==0){	
                    $fields_options_from_db             = get_option('WPxdamsBridge_output_fields_'.$archiveLevelId);	// custom labels from user strored in DB
        
                    
                    $customSettings                     = WPxdamsBridge_get_item_metadata($archiveLevelId);
                    WPxdamsBridge_manageLanguage();

		}
		
		$keys                                   = array_keys($element); 
		$cCount                                 = count($keys);
		$publish                                = 'no';
		$nextFieldOut                           = false;
		$nextFieldOutVal                        = false;
	
		if ($elementCounter > $cCount ) {
                    $publish			= 'end';
		}
		$sep2 = '  ';
                
               echo('pppp' .$archiveLevelId.'aaa<br>'   );
		
                while ($publish =='no'){

			$idField                        = $keys[$elementCounter];   // id of fields
		
			$count2				= count($element [$idField]);  // number of fields
                        $fieldIndex                     = WPxdamsBridge_getFieldIndex($idField);
			$outdesc			= WPxdamsBridge_getFieldLabel($idField ,  $fieldIndex , $customSettings);

			$publish		= 'yes';
				
                        for($i2=0;$i2<$count2;$i2++) 
                                    {
                                        $stringToTest   		= str_replace('<br>', '', $element [$idField][$i2]);  // strinf is formatted to be printed - need to clean 
                                        $stringToTest   		= str_replace(' ', '', $stringToTest); 
                                                
                                        if ($stringToTest) {
                                            $elements   		= $elements .$sep2.$element [$idField][$i2];
                                        }
                        }	
                        $nextFieldOut       		= $nextFieldOut.$outdesc;
                        $nextFieldOutVal    		= $nextFieldOutVal.$elements ;
                                    
                        if ($nextFieldOutVal) {  

                                        if(WPxdamsBridge_isASingleField($idField) ) {
                                            $nextFieldOutVal            =   WPxdamsBridge_getValuePre ($fieldIndex , $customSettings) .$nextFieldOutVal  ;
										}
                                            if (WPxdamsBridge_addPostValueField($idField)) {
                                                $nextFieldOutVal 	= $nextFieldOutVal.WPxdamsBridge_getValuePost ($fieldIndex ,$customSettings)  ;
                                            }
                        }
			$elementCounter                 = $elementCounter + 1;
			if ($elementCounter > $cCount ) {
			   $publish                     = 'end';
			}

		}

                
		return $nextFieldOut;
}
 function WPxdamsBridge_isASingleField($fieldName) {   // #####documentare  to evaluate if is a single field with no path description
    
		$out				= true;
		$fields             = explode('/', $fieldName );
	    
		$number             = count($fields)-1;	
		if (count($fields) > 0) {
			$test 			=  explode('[',$fields [$number] );
			if ($test[0] >0) {
			$out			= false;
			}
		}
		return $out ;
}
 function WPxdamsBridge_addPostValueField ($fieldName) {   // #####documentare  to evaluate if is a group of field 
    
		$out				= true;
		$fields             = explode('/', $fieldName );
	    
		$number             = count($fields)-1;	
		if (count($fields) > 0) {
			$test 			=  explode('[',$fields [$number] );
			if ($test[0] == 1) {
			$out			= false;
			}
		}
		return $out ;
}
 function WPxdamsBridge_getFieldIndex($fieldName) {   // #####documentare

		global $fields_options_from_db ;
    
		$fields             = explode('%%%', $fields_options_from_db );
		$number             = count($fields)-1;	
		
		for($i=0;$i<$number;$i++) {
		    $i1 = $i * 3;
                    if ($fieldName == $fields [$i1] ) {
                        $out        = $i;  // custom description
                    }	
		}
		return $out;
 }
 function WPxdamsBridge_getFieldLabel($fieldName, $fieldIndex, $customSettings ) {  // #####documentare


                //global $customSettings ;

                $out        = $customSettings ['label'][$fieldIndex];

                if (!$out)	{               //not exists a custom label
                    $out    = $fieldName;
                }

                $out        =  $customSettings ['titlePre'][$fieldIndex] .WPxdamsBridge_getTranslatedTerm ($out).$customSettings['titlePost'][$fieldIndex];    // translation
                
		return $out;
 }
 function WPxdamsBridge_isTagToClean ($fieldIndex, $customSettings) {   // #####documentare

              //  global $customSettings ;
                
		return $customSettings ['tagClean'][$fieldIndex] ;
 }
 function WPxdamsBridge_getTitlePre ($fieldIndex, $customSettings) {   // #####documentare

              //  global $customSettings ;
                
		return $customSettings ['titlePre'][$fieldIndex] ;
 }
 
 function WPxdamsBridge_getTitlePost ($fieldIndex, $customSettings) {   // #####documentare

            //    global $customSettings ;
                
		return $customSettings ['titlePost'][$fieldIndex] ;
 }
  function WPxdamsBridge_getValuePre ($fieldIndex, $customSettings) {   // #####documentare

              //  global $customSettings ;
                
		return $customSettings ['descPre'][$fieldIndex] ;
 }
 
 function WPxdamsBridge_getValuePost ($fieldIndex, $customSettings) {   // #####documentare

            //    global $customSettings ;
                
		return $customSettings ['descPost'][$fieldIndex] ;
 }
  function WPxdamsBridge_getFieldLabelCANC($fieldName, $fieldIndex) {

                global $customSettings ;
                 

                        $out        = $customSettings ['label'][$fieldIndex];

                if (!$out)	{               //not exists a custom label
                    $out            = $fieldName;
                }
                       
                
                    $out                =  $customSettings ['titlePre'][$fieldIndex] .WPxdamsBridge_getTranslatedTerm ($out).$customSettings['titlePost'][$fieldIndex];    // translation
                
		return $out;
 }
			
function WPxdamsBridge_getCurrentResultPage() {
   
		global $currentInfo;
		
	    $xmlResult = $currentInfo ['xmlResult'] 	;
		
		
		return $xmlResult ['curPage']  ;
}
//  give num page of a result list 

function WPxdamsBridge_getTotalResultPages() {
   
		global $currentInfo;
		
	   $xmlResult = $currentInfo ['xmlResult'] 	;
		
		
		return $xmlResult ['totPage']  ;
}
function WPxdamsBridge_getResultMessage() {
   
		global $currentInfo;
		
	   $xmlResult = $currentInfo ['xmlResult'] 	;
		
		
		return $xmlResult ['message']   ;
}
function WPxdamsBridge_searchHasResults() {
   
		$out=false;
		if (WPxdamsBridge_getResultMessage() == 'ok') 
			{$out=true;
		
		}
		return $out  ;
}
function WPxdamsBridge_getTotalResultItems() {
   
		global $currentInfo;
		
	   $xmlResult = $currentInfo ['xmlResult'] 	;
		
		
		return $xmlResult ['totItem']  ;
}
function WPxdamsBridge_getNewRequestURL() {
   
		global $currentInfo;
                $language = '';
                
                if (WPxdamsBridge_pleaseTranslate() )  {
                    $lang = WPxdamsBridge_getCurrentLanguage();
                    $language = '&lang=en&';
                }
		
		$managePermalink = '';
		
		if ( get_option('permalink_structure') ) { 
			$pos 	= strpos($currentInfo ['newRequestURL'], '?');
			if (!$pos) {
				$managePermalink = '?';
			}
		}
                 
		if ($currentInfo['freesearchvalue']) {
                    $searchFields = 'searchfield='.$currentInfo['freesearchvalue'].'&';
                }
                
                $out = $currentInfo ['newRequestURL'].$managePermalink.$language.$searchFields   ;

		return $out ;
}
function WPxdamsBridge_getWPPageURL() {
   
		global $currentInfo;
                
                if (WPxdamsBridge_pleaseTranslate() )  {
                    $lang = WPxdamsBridge_getCurrentLanguage();
                    $language = '&lang=en&';
                }
		
		return $currentInfo['wpPageURL'].'?'. $language ;
}



function WPxdamsBridge_getNavParam() {
   
		global $currentInfo;
		
		$out = $currentInfo ['navParam'];
                
                // clean from external/internal option
                
                $out = str_replace ('%20AND%20[XML,/c/@audience]=external', '', $out );
                
		return $out ;
}
function WPxdamsBridge_getSearchFormFields() {    // in search form publishing
   
		
		global $WPxdamsBridge_cCounter;
                
                WPxdamsBridge_manageLanguage() ;
		
		$WPxdamsBridge_cCounter = -1 ;  //to start fields publishing
		
		return  ;
}

function WPxdamsBridge_getFormFieldName() {   // in search form publishing
   
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$out					= false;
		$xDamsFields			= $currentInfo ['xDamsFields'] 	;
		$out 					= $xDamsFields ['name'][$WPxdamsBridge_cCounter]	;
		
		return $out  ;
}


function WPxdamsBridge_existsNextFormField() {   // in search form publishing
   
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$out					= false;
		$WPxdamsBridge_cCounter = $WPxdamsBridge_cCounter + 1;
//		$xmlResult 				= $currentInfo ['xmlResult'] 	;
		$count 					= $currentInfo ['formFieldsNumber'] ;
	
		if ($count  > $WPxdamsBridge_cCounter) {
		   $out					= true;
		}
		
		return $out  ;
}


function WPxdamsBridge_existsNextResult() {
                        
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$out=false;
                if ( $currentInfo ['loopStarted'] == 'yes') {
                    $WPxdamsBridge_cCounter	= $WPxdamsBridge_cCounter + 1;
		}
                
		$xmlResult                  = $currentInfo ['xmlResult'] 	;		
                $count                      = count($xmlResult ['results'])  ;   // number of item for this page
                          
		if ($count  > $WPxdamsBridge_cCounter) {
		   $out                     = true;
		}

                $currentInfo ['loopStarted'] = 'yes';  //only first time leave counter to zero

		return $out  ;
}

function WPxdamsBridge_getNextResult() {
   
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$xmlResult 	= $currentInfo ['xmlResult'] 	;
		$out            = $xmlResult ['results'][$WPxdamsBridge_cCounter]  ;  // p,ease see WPxdamsBridge_parseCompleteXML_listCase in external calls
		
		
		return $out  ;
}
function WPxdamsBridge_getNextResultLevel() {
   
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$xmlResult 	= $currentInfo ['xmlResult'] 	;
		$out = $xmlResult ['itemLevel'][$WPxdamsBridge_cCounter]  ;
				
		return $out  ;
		
}
function WPxdamsBridge_getNextResultPreview($dim, $inProperty='') {
   
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$xmlResult 	= $currentInfo ['xmlResult'] 	;
	//	$out 		= $xmlResult ['itemPic'][$WPxdamsBridge_cCounter]  ;
		
		if ($xmlResult ['itemPic'][$WPxdamsBridge_cCounter]) {
			$itemPic 	= $xmlResult ['itemPic'][$WPxdamsBridge_cCounter]  ;
			$urlimg 	= get_option('WPxdamsBridge_media_'.$currentInfo ['archiveId']);
			$out 		= $urlimg.$dim.'?imageName=/high/'.$itemPic[0];
			$out 	= '<img src="'.$out.'" ' .$inProperty.' >';
		}		
		return $out  ;
}
		
function WPxdamsBridge_getNextResultID() {
   
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$xmlResult 	= $currentInfo ['xmlResult'] 	;
		$out = $xmlResult ['itemId'][$WPxdamsBridge_cCounter]  ;
		

		
		return $out  ;
}

// to manage a single archive tree request or a request of all kind of archives

function WPxdamsBridge_isARequestForAllArchives() {
   
		global $currentInfo;
		
		$out=false;
				
		$currLevel		= $currentInfo ['currLevel'];
		
		if ($currLevel['root'] 	== 1) {
			$out = true  ;
		}

		
		return $out  ;
}
//  manage the request in case of hierarchical navigation 

function WPxdamsBridge_getCurrentTreeRequest() {
   
		global $currentInfo;
		
		$currLevel		= $currentInfo ['currLevel'];
		
		$out			= $currLevel['xdamsTreePath'];
		
		if ( get_option('permalink_structure') ) { 
			$pos 	= strpos($out, '?');
			if (!$pos) {
				$out = $out. '?';
			}
		}
	
		$pos 	= strpos($out, 'archID');
		if (!$pos) {
			$out = $out. '&archID='.WPxdamsBridge_getCurrentArchiveId() ;
		}


		
		return $out  ;
}

// for hierarchical navigation : test for fetching

function WPxdamsBridge_existsNextTreeLevel() {
   
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$out=false;
		
		$currLevel	= $currentInfo ['currLevel'] 	;
		$count 		= count($currLevel ['requestParam']);   // number of level of the request
		if ($count  > $WPxdamsBridge_cCounter) {
		   $out=true;
		
		}
		
		return $out  ;
}
// for hierarchical navigation : fetch

function WPxdamsBridge_getNextTreeLevelId() {
   
		global $currentInfo;
		global $WPxdamsBridge_cCounter;
		
		$currLevel	= $currentInfo ['currLevel'] 	;
		$out = $currLevel ['requestParam'][$WPxdamsBridge_cCounter]  ;
		
		$WPxdamsBridge_cCounter	= $WPxdamsBridge_cCounter + 1;
		
		return $out  ;
}

// for hierarchical navigation : start

 
function WPxdamsBridge_startTreeBreadcrumbsPublishing (){
   
		
		global $WPxdamsBridge_cCounter;
		
		$WPxdamsBridge_cCounter	= 1;
		
		return true  ;
}

function WPxdamsBridge_startSearchResultsPublishing() {
    
                
                global $currentInfo;
        
                $currentInfo ['loopStarted'] = 'no';
   
		WPxdamsBridge_resetGetElement () ;
		
		return true  ;
}


//  give javascript for slider 

function WPxdamsBridge_getSliderJS($slideWidth) {
    
        $js_slideDim    ="'width:".$slideWidth."%;'";
   
	$JS= "   <script  type='text/javascript' >
          	$(function(){
			
		var ticker = function(){
			
			 ticker_timeout = setTimeout(function(){
			        
                                var slide_dim ='width:9%;';
                                
                                slide_dim    = ".$js_slideDim.";
                             
				$('#exhitionSlider li:first').animate( {marginLeft: '-25%'}, 2450, function(){
				
					$(this).detach().appendTo('ul#exhitionSlider').attr('style', slide_dim);	
					
				});
				
				ticker();
				
			}, 5500);		
		};
	
		
		$('#exhitionSlider').hover(function() { 
		
		    $('#exhitionSlider').stop();
		    
		    clearTimeout(ticker_timeout);   
		        
		}, function() {
		
		    ticker();
		});
	
		ticker();
	
	});
         </script>
    ";
    
    return $JS;
}

function WPxdamsBridge_getPicToShowForSwapping() {

	$numPage	= WPxdamsBridge_getCurrentResultPage()  ;  
	$picToShow      = (($numPage -1 ) * 10 )+ 1;
	$picToShow      = '&picToShow='.$picToShow;

return $picToShow;
}  

function WPxdamsBridge_getArchIdParam() {

    $newpage	= WPxdamsBridge_getNewRequestURL();
	$archiveId		=  WPxdamsBridge_getCurrentArchiveId();
	
	$archIDparam    = 'archID='.$archiveId;
	if (strpos($newpage, 'archID=')) {
		$archIDparam     = "";                               // archID already present in the request
	}

    return $archIDparam ;
} 
function WPxdamsBridge_getCurrViewType() {

	global $currentInfo;

return $currentInfo ['viewType'] ;
} 
function WPxdamsBridge_getPicsResultSwitchON($inText = null, $viewToChange= null) {
    
        $viewType               = WPxdamsBridge_getCurrViewType();
        $imgUrl                 = plugins_url();
		$a					=$viewType ;
        
        if ($viewToChange) {
            $viewType           = $viewToChange; // not active now
        } else {  
            if ($viewType    == 'xdamsListImg') {
                $viewType       = 'xdamsPreview'; 
                $showText       =  '<img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/preview.jpg">';
				$tultip       	=  'Preview Mode';
            } else {
                $viewType       = 'xdamsListImg'; 
                $showText       =  '<img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/table.jpg">';
				$tultip       	=  'Show Icons';
            }
        }    
        $newpage				= WPxdamsBridge_getNewRequestURL();
	$archIDparam                            = WPxdamsBridge_getArchIdParam() ;
	$numPage				= WPxdamsBridge_getCurrentResultPage()  ;  
        $picToShow				= WPxdamsBridge_getPicToShowForSwapping();
      
        if ( $inText ) {
            $showText =  $inText;
		}
	
        $viewTypeSwapOn	= ' <div id="xdamsNavMenuBlockR" class="xdamsNavMenuBlock"><a href="'.$newpage.$archIDparam
								.'&pageToShow='.$numPage. $picToShow .'&viewType='.$viewType.'" title="'.$tultip.'">'
								.$showText.'</a></div>';

    return $viewTypeSwapOn;
} 

function WPxdamsBridge_getPicsResultSwitchOFF($inText = null) {
    
        $viewType           = WPxdamsBridge_getCurrViewType();
        $imgUrl             = plugins_url(); 
        
        if ($viewType    == 'xdamsListImg') {
            $showText       =  '<img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/table_no.jpg">';
        } else {
            $showText       =  '<img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/preview_no.jpg">';
        }
		
	if ( $inText ) {
            $showText = $inText;
	}
	
        $viewTypeSwapOFF	= ' <div id="xdamsNavMenuBlock" class="xdamsNavMenuBlock"> ' 
						.$showText.' </div>';

    return $viewTypeSwapOFF;
} 
function WPxdamsBridge_getMenuLastPage($inText = null) {
    
        $viewType               = WPxdamsBridge_getCurrViewType();
        $newpage		= WPxdamsBridge_getNewRequestURL();
	$archIDparam            = WPxdamsBridge_getArchIdParam() ;
	$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
	$navParam		= WPxdamsBridge_getNavParam() . '&viewType='.$viewType;	
	$showText 		= $totPage;
        $numPage		= WPxdamsBridge_getCurrentResultPage()  ; 
		
	if ( $inText ) {
            $showText = $inText;
	}
        if ( $numPage < $totPage ) {
            $lastPage               = '<a href="'.$newpage.$archIDparam.'&pageToShow='.$totPage. $navParam.'">'.$showText.'</a><br>';
        }

    return $lastPage;
}

function WPxdamsBridge_getMenuPrevPage($inText = null) {

        $viewType               = WPxdamsBridge_getCurrViewType();
        $newpage		= WPxdamsBridge_getNewRequestURL();
	$archIDparam            = WPxdamsBridge_getArchIdParam() ;
	$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
	$navParam		= WPxdamsBridge_getNavParam() . '&viewType='.$viewType;	
	$numPage		= WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
	$showText 		= $totPage;
	$separ2			= '';	
	$ppre   		= $numPage - 1;
	$showText 		= $ppre ;
		
	if ( $inText ) {
            $showText = $inText;
        }
	if ($numPage > 1) {
            $pre		= '<a href="'.$newpage.$archIDparam.'&pageToShow='.$ppre.$navParam.'">'.$showText.'</a>';
        }	
    return $pre;
}

function WPxdamsBridge_getMenuFirstPage($inText = null) {

        $viewType               = WPxdamsBridge_getCurrViewType();    
        $newpage		= WPxdamsBridge_getNewRequestURL();
	$archIDparam            = WPxdamsBridge_getArchIdParam() ;
	$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
	$navParam		= WPxdamsBridge_getNavParam() . '&viewType='.$viewType;	
	$numPage		= WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
	$showText 		= 1 ;
		
	if ( $inText ) {
            $showText = $inText;
        }

        if ($numPage > 2) {

            $pre		= '<a href="'.$newpage.$archIDparam.'&pageToShow=1'.$navParam.'">'.$showText.'</a>'	;
        }
	
    return $pre;
}

function WPxdamsBridge_getMenuNextPage($inText = null) {

        $viewType               = WPxdamsBridge_getCurrViewType();
        $newpage		= WPxdamsBridge_getNewRequestURL();
	$archIDparam            = WPxdamsBridge_getArchIdParam() ;
	$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
	$navParam		= WPxdamsBridge_getNavParam() . '&viewType='.$viewType;	
	$numPage		= WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
	$showText 		= $totPage;
	$separ			= "...";	
	$ppost                  = $numPage + 1;
	$showText 		= $ppost ;
		
	if ( $inText ) {
            $showText = $inText;
        }
	if ($ppost < $totPage  ) {
	    
	     $post		= '<a href="'.$newpage.$archIDparam.'&pageToShow='.$ppost . $navParam.'">'.$showText.'</a>';
	}
	
    return $post;
}

function WPxdamsBridge_getPagingMenu($switchON = 1) {
    
    $numItem		= WPxdamsBridge_getTotalResultItems()   ;   // total number of result items
    $numPage		= WPxdamsBridge_getCurrentResultPage()  ;   // number of current page
    $totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
    $separ1             = ' ';
    $separ2             = ' ';
    
    if ( $numPage > 3  ) {
            $separ1 = '... ';
    }    
    if ( $numPage + 2 < $totPage  ) {
            $separ2 = '... ';
    } 
    $lastPage           = WPxdamsBridge_getMenuLastPage(); 
    $pre                = WPxdamsBridge_getMenuPrevPage();
    $post               = WPxdamsBridge_getMenuNextPage();
    $first              = WPxdamsBridge_getMenuFirstPage();
    
    $main				=  '<div id="xdamsNavMenuBlock0"  class="xdamsNavMenuBlock">'.WPxdamsBridge_getTerms('text_found_long').' '.$numItem.'<br>'.WPxdamsBridge_getTerms('text_pages').' ' .$first.$separ1.$pre.' '.$numPage. ' ' .$post.$separ2.$lastPage.'</div>';
    
    if ($switchON ==1)      {          
		$viewTypeSwitchON   = WPxdamsBridge_getPicsResultSwitchON()  ; 
		$viewTypeSwitchOFF  = WPxdamsBridge_getPicsResultSwitchOFF();    
    }
    $Menu				= '<br><div id="xdamsNavMenu" class="xdamsNavMenu">';
    $Menu				= $Menu.$main;
    
    $out				= $Menu.'' . $viewTypeSwitchON.$viewTypeSwitchOFF.'</div>';
                   

    return $out;
}
function WPxdamsBridge_getPrevPic ($inText = null) {
    
        global  $currentInfo;
        $newpage		= WPxdamsBridge_getNewRequestURL();
	$archIDparam            = WPxdamsBridge_getArchIdParam() ;
        $numItem		= WPxdamsBridge_getTotalResultItems() ;
        $numPage		= WPxdamsBridge_getCurrentResultPage()  ;   // number of current page 
        $picToShow              =  $currentInfo['picToShow'];  
        
	if ( $inText ) {
            $showText = $inText;
        } else {  
            $showText = "Prev " ;
        }     
        
        if ($picToShow  > 1) {
	    $picpre   	= $picToShow - 1;;
	}
       
        $picCurPage     = ($picToShow % 10) - 1;
        if ($picCurPage == -1) {
            $picCurPage = 9;
        }
        
        $pagepre   	= $numPage - 1;
        if ($picCurPage > 0) {
            $pagepre   	= $numPage;
        } 

        
        if ($picpre) {
            $out	=  '<a href="'.$newpage. $archIDparam .'&pageToShow='.$pagepre . '&picToShow='.$picpre.'&viewType=xdamsPreview">'.$showText.'</a> ' ;
	} else {
            $out	= $showText;
        }
        
	
    
    return $out;
}
function WPxdamsBridge_getNextPic ($inText = null) {
    
        global  $currentInfo;
        $newpage		= WPxdamsBridge_getNewRequestURL();
	$archIDparam            = WPxdamsBridge_getArchIdParam() ;
        $numItem		= WPxdamsBridge_getTotalResultItems() ;
        $numPage		= WPxdamsBridge_getCurrentResultPage()  ;   // number of current page 
        $picToShow              = $currentInfo['picToShow'];  
        
        if (!$picToShow) {$picToShow=1;}
        
	if ( $inText ) {
            $showText = $inText;
        } else {  
            $showText = "Next" ;
        }     
        
        if ($picToShow  < $numItem) {
	    $picpost   	= $picToShow + 1;;
	}
        
        $picCurPage     = ($picToShow % 10) - 1;
        if ($picCurPage == -1) {
            $picCurPage = 9;
        }

        $pagepost	= $numPage + 1;	
        if ($picCurPage < 9) {
            $pagepost 	= $numPage;
        }
      
        if ($picpost) {
            $out	= '<a href="'.$newpage. $archIDparam .'&pageToShow='.$pagepost . '&picToShow='.$picpost.'&viewType=xdamsPreview">'.$showText.'</a>';
	}  else {
            $out	= $showText;
        }
    
    return $out;
}

function WPxdamsBridge_getCarouselHTML ($part, $heigth=null,  $interval=4000) {
    
if ($heigth)     {
  
    $heigth     =' style="height: '.$heigth.'px"';
}
    
$startContainer = '
         <div class="bootContainer">
             <div class="starter-template">
                 <div class="bootContainer">';

        $startCarousel = '  
                    <!-- thumb navigation carousel -->
                    <!-- main slider carousel -->
                    <div class="row">
                        <div class="col-md-12" id="slider" >

                            <div class="col-md-12" id="carousel-bounding-box">
                                <div id="myCarousel" class="carousel slide">
                                    <!-- main slider carousel items -->
                                    <div class="carousel-inner"  '.$heigth.' >';
         $stopCarousel = '
                                    </div>
                                    <!-- main slider carousel nav controls --> 
                                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>

                                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>';
        $startThumbsNavigation = '
                    <!--/main slider carousel-->
                    <div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">
                     <div class="center-thumbs">
                        <!-- thumb navigation carousel items -->
                        <ul class="list-inline">
                        ';

        $stopThumbsNavigation = '
                        </ul>
                      </div>
                    </div>
                    ' ;
         
        
        $stopContainer = '
                 </div>
             </div>
         </div>';
        
        $bootstrapScript = '       
         <script>
            $("#myCarousel").carousel({
                interval: '.$interval.'
            });

            // handles the carousel thumbnails
            $("[id^=carousel-selector-]").click( function(){
                var id_selector = $(this).attr("id");
                var id = id_selector.substr(id_selector.length -1);
                id = parseInt(id);
                $("#myCarousel").carousel(id);
                $("[id^=carousel-selector-]").removeClass("selected");
                $(this).addClass("selected");
            });

            // when the carousel slides, auto update
            $("#myCarousel").on("slid", function (e) {
                var id = $(".item.active").data("slide-number");
                id = parseInt(id);
                $("[id^=carousel-selector-]").removeClass("selected");
                $("[id=carousel-selector-"+id+"]").addClass("selected");
            });
        </script> ';

	switch($part){
			case 'start':
				$out= $startContainer.$startCarousel ;
            break;
			 
			case 'stopCarousel':
				$out= $stopCarousel;
            break;
			
			case 'startThumbsNavigation':
				$out= $startThumbsNavigation;
            break;
			
			case 'stop':
				$out= $stopThumbsNavigation. $stopContainer . $bootstrapScript;
            break;
	                    

        }
    
    return $out;
}


function getFieldValueSearch ($fieldIndex) {   // documentare
    
        global      $currentInfo;
        
        $inputFields 		= $currentInfo ['currInputFields'] 	;
        
        if (WPxdamsBridge_isAField($inputFields ['xDamsfield'][$fieldIndex])) {
			$out 			= $inputFields[$fieldIndex];
        }                
        
    
    return $out;
    
    }
    
function areAllRecordsPublic ($archiveId) {   // documentare
    
        $test           = WPxdamsBridge_get_option('allRecords',$archiveId);
        $out            = false;
        
        if ($test == 1) {
            $out        = true;
        }                
    return $out;

    }
    