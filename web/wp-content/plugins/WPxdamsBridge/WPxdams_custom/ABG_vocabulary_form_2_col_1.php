<?php
/*
  simple template for search form - use $out to build HTML
*/

   
	$archiveLabel       = WPxdamsBridge_getCurrentArchiveDesc()  	;		// archive desc
	$newpage            = WPxdamsBridge_getNewRequestURL();
       
        if (WPxdamsBridge_isToRedirectIUrl ()) {
            $newpage            = WPxdamsBridge_getRedirectedUrl();
        }
         

        $prog               = 1;
//  to publish result list 

        $out                = WPxdamsBridge_getVocabularyNav ($archiveId).'<br>';
        $out                = '
                    <div class="abg-result-list-col-1">
                        '.$out .'
                                <br>
                                <br> 
                                '.WPxdamsBridge_getTotalResultPages() .' '.WPxdamsBridge_getTerms('text_pages').' 
                                '.WPxdamsBridge_getListDesc1 ().'    
                     </div>';


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
