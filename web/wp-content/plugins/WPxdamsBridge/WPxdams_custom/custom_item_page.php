<?php		
/*
  simple template for publish item metadata on a page
*/
			$archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc()  	;	// archive desc
			$requestedItemLevel	= WPxdamsBridge_getCurrentItemType() ;          // kind of requested item (fond, subfond, item etc.) 

			$prog= 0; 

			if (WPxdamsBridge_getPageMediaPreview()) {
				$outPreview     = WPxdamsBridge_getPageMediaPreview().'<br>';
			}			

                        $outHier                = WPxdamsBridge_getItemHier();
                        
			while (WPxdamsBridge_existsNextField()) {
                            $labelOut           = WPxdamsBridge_getNextFieldLabel();
                            $valueOut           = WPxdamsBridge_getNextFieldValue();
                            if ($valueOut) {
                                $out            = $out. $labelOut.$valueOut.'<br>';
                            }
			   if ($prog==0) {
				   $out            =    '<h3>'. $valueOut.'</h3>'. $outPreview.'<p>'.$outHier.'</p><p>';
			   }
                           $prog= $prog + 1;
			}
                    
                        if (WPxdamsBridge_areMultipleImages()) {
                            $out                =  $out .WPxdamsBridge_getAllImages();
                        }
                        
                        $out 			=  $out .'</p><div class="xdamsReport" id="xdamsReport"><br><br>[xDams O.S. - '.WPxdamsBridge_getTerms('text_recordId').': '.WPxdamsBridge_getCurrentItemId(). 
							 '<BR>In: '. $archiveLabel.'   -  '.WPxdamsBridge_getTerms('text_recordType').': '.$requestedItemLevel.']</div>';
		
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		