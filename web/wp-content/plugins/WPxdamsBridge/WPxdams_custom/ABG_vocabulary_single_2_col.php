<?php
/*
  simple template for search form - use $out to build HTML
*/

        $archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc()  	;	// archive desc
        $requestedItemLevel	= WPxdamsBridge_getCurrentItemType() ;          // kind of requested item (fond, subfond, item etc.) 
        $outHier                = WPxdamsBridge_getItemHier();		// archive desc
	$newpage                = WPxdamsBridge_getNewRequestURL();
       
        if (WPxdamsBridge_isToRedirectIUrl ()) {
            $newpage            = WPxdamsBridge_getRedirectedUrl();
        }

        $out                =  $out  .'
                    <div class="abg-result-list-col-1">
                        '.$out .'<p>'.$outHier.'</p>
                                <br>
                                <br> 
                              
                                '.WPxdamsBridge_getListDesc1 ().'    
                     </div>';

	
        $out                =  $out .'
                    <div class="abg-result-list-col-2">';

	if (WPxdamsBridge_getPageMediaPreview()) {
            $out 		=  $out . WPxdamsBridge_getPageMediaPreview().'<br>';
	}			
                
                        
                        
        while (WPxdamsBridge_existsNextField()) {
                              
            $labelOut           = WPxdamsBridge_getNextFieldLabel();
            $valueOut           = WPxdamsBridge_getNextFieldValue();
            if ($valueOut) {
                $out            = $out. $labelOut.$valueOut.'';
            }
	}
                    
        if (WPxdamsBridge_areMultipleImages()) {
            $out                =  $out .WPxdamsBridge_getAllImages();
        }
        $out 			=  $out .'
                            <div class="xdamsReport" id="xdamsReport"><br><br>[xDams O.S. - '
                                .WPxdamsBridge_getTerms('text_recordId').': '.WPxdamsBridge_getCurrentItemId() 
                                .'<BR>In: '. $archiveLabel.'   -  '
                                .WPxdamsBridge_getTerms('text_recordType').': '.$requestedItemLevel.']
                            </div><br><br>
                    </div>';
 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
