<?php		
/*
  simple template for publish item metadata on a page
*/
	
			$archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc()  	;	// archive desc
			$requestedItemLevel	= WPxdamsBridge_getCurrentItemType() ;          // kind of requested item (fond, subfond, item etc.) 
                        $outHier                = WPxdamsBridge_getItemHier();
			

			if (WPxdamsBridge_getPageMediaPreview()) {
				$out 		=  $out . WPxdamsBridge_getPageMediaPreview().'<br>';
			}			
                        $out 		=  $out . '<p>'.$outHier.'</p>';
                        
                        
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
                        
                        $out 			=  $out .'<div class="xdamsReport" id="xdamsReport"><br><br>[xDams O.S. - '
                                                        .WPxdamsBridge_getTerms('text_recordId').': '.WPxdamsBridge_getCurrentItemId() 
							.'<BR>In: '. $archiveLabel.'   -  '
                                                        .WPxdamsBridge_getTerms('text_recordType').': '.$requestedItemLevel.']</div><br><br>';





/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		