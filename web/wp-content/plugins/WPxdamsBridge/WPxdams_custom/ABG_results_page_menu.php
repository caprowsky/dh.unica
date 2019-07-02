<?php		
/*
  simple template for results page menu
*/
		
	       if(WPxdamsBridge_getMultiArchivesResults ()) { 
		  if(WPxdamsBridge_getMultiArchivesCurrent())
                          
                  {
                       $results         =     WPxdamsBridge_getTotalResultItems().' '.WPxdamsBridge_getTerms('text_results', WPxdamsBridge_getTotalResultItems()).'
                                                <div class"xd-curr-archive">In '.WPxdamsBridge_getMultiArchivesCurrent ().'<br>'.
						   WPxdamsBridge_getTotalResultPages() .' '.WPxdamsBridge_getTerms('text_pages', WPxdamsBridge_getTotalResultPages() ).'</div>';
                 
                      };
		   
		   
		   
		   
            $out         =  '
		
                              <p>
                                <div class="xdmultiarchiveslabel">
                                    '.WPxdamsBridge_getTerms('text_found').'
                                </div>
                                
                                <div class="xdmultiarchivesmenu">'
                                    .WPxdamsBridge_getMultiArchivesResults ().'
                                </div>
                               </p> '.$results.$out; 
       }
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		