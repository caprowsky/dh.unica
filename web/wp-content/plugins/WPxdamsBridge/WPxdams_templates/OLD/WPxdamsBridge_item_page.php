<?php		
/*
  simple template for publish item metadata on a page
*/
	
			$archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc()  	;	// archive desc
			$requestedItemLevel	= WPxdamsBridge_getCurrentItemType() ;          // kind of requested item (fond, subfond, item etc.) 

			$sep 			= ': <br>';

			if (WPxdamsBridge_getPageMediaPreview()) {
				$out 		=  $out . WPxdamsBridge_getPageMediaPreview().'<br>';
			}			

			while (WPxdamsBridge_existsNextField()) {
                            $labelOut           = WPxdamsBridge_getNextFieldLabel();
                            $valueOut           = WPxdamsBridge_getNextFieldValue();
                            if ($valueOut) {
                                $out            = $out. $labelOut.': '.$valueOut.'<br>'.'<br>';
                            }
			}
                    
                        if (WPxdamsBridge_areMultipleImages()) {
                            $out                =  $out .WPxdamsBridge_getAllImages();
                        }
                        
                        $out 			=  $out .'<div class="xdamsReport" id="xdamsReport"><br><br>[ID scheda: '.WPxdamsBridge_getCurrentItemId(). 
							 '<BR>In: '. $archiveLabel.'   -  Tipo scheda: '.$requestedItemLevel.']</div>';
		
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		