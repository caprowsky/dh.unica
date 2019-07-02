<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published
					  
	global $currentInfo ;
	
	$archiveId				= WPxdamsBridge_getCurrentArchiveId();
	$archiveLabel                           = WPxdamsBridge_getCurrentArchiveDesc()  	;		// archive desc
        $newpage                            	= WPxdamsBridge_getWPPageURL();	
        $newpage                            	= WPxdamsBridge_getNewRequestURL();
	$numItem                                = WPxdamsBridge_getTotalResultItems()   ;   // total number of result items
	$numPage                                = WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
	$totPage                                = WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
        
        $out					='';
	$picToShow                              =  $currentInfo['picToShow'];  
	$picToShow                              =  $currentInfo['picToShow'];  
        
        if (!$picToShow ) {
            $picToShow                          = 1; 
        }
        
        
	
//  to publish result list 

	if (WPxdamsBridge_searchHasResults()) 
            {               
// MENU
            $viewTypeSwitchON   = WPxdamsBridge_getPicsResultSwitchON()  ; 
            $viewTypeSwitchOFF  = WPxdamsBridge_getPicsResultSwitchOFF();
                        
            $out                = $out.'     
                                        <div id="xdamsNavMenu" class="xdamsNavMenu">';
            $out                = $out.'    
                                                <div id="xdamsNavMenuBlock0"  class="xdamsNavMenuBlock">'.WPxdamsBridge_getPrevPic ('<i class="fa fa-arrow-left" aria-hidden="true"></i> precedente').' - '.WPxdamsBridge_getNextPic ('successivo <i class="fa fa-arrow-right" aria-hidden="true"></i>');
            $out                = $out.' <div class="numero-foto"> <strong>'.$picToShow.'</strong> di '.$numItem.' </div> '.'
                                                </div>';
            $out                = $out.'
                                                '.$viewTypeSwitchON.'
                                                '.$viewTypeSwitchOFF.'
                                        </div>';
// END MENU

            WPxdamsBridge_startSearchResultsPublishing() ;
            
            $out  	=  $out.'
                                        
                                        <div>
                                            ';
            $prog   =  0;
            while (WPxdamsBridge_existsNextResult()) {
                $nextResultId 	= WPxdamsBridge_getNextResultID();
		$nextResultPic	= WPxdamsBridge_getNextResultPreview('0') ;
		$nextResultPre	= WPxdamsBridge_getNextResultPreview('200') ;
		$nextResult 	= WPxdamsBridge_getNextResult();
                $prog2          = (($numPage -1) * 10) + $prog + 1;
                $out2           =  $out2.'
                                            <div id="xdListSlider" class="xdListSlider"> 
                                                <a href="'.$newpage. '&archID='.$archiveId.'&pageToShow='.$numPage . '&picToShow='.$prog2 . '&viewType=xdamsPreview">'.
						$nextResultPre.'</a></div>';				

		if ($prog2 == $picToShow ) {
                    $out  	=  $out.'<div class="wrap-img-foto-slide"> 
                                                <div class="wrap-solo-img-slide"><a href="'.$newpage.'&archID='.$archiveId.'&xdamsItem='. $nextResultId . '">'.
                                                $nextResultPic.'
                                                </a></div>
												<div class="xdListPreviewTitle">'. $nextResult .'</div>'.'
                                            </div>';

		}
		$prog 	=  $prog + 1; 
            }
	
            $out  	=  $out.  $out2 .'    
                                        </div>';

        }
		 
		 
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		