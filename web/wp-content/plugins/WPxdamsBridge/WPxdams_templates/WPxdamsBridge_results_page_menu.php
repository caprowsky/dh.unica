<?php		
/*
  simple template for results page menu
*/
		

       if(WPxdamsBridge_getMultiArchivesResults ()){    
            $out         =  $out.'
		
                              <p>
                                <div class="xdmultiarchiveslabel">
                                    '.WPxdamsBridge_getTerms('text_found_in').'
                                </div>
                                
                                <div class="xdmultiarchivesmenu">'
                                    .WPxdamsBridge_getMultiArchivesResults ().'
                                </div>
                               </p> '; 
       }
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		