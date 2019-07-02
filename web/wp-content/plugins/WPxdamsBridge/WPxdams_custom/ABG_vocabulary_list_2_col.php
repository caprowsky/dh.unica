<?php		
/*
  simple template for results page
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
            '.WPxdamsBridge_getTotalResultItems().' '.WPxdamsBridge_getTerms('text_results', WPxdamsBridge_getTotalResultItems()) .'<br>
            '.WPxdamsBridge_getTotalResultPages() .' '.WPxdamsBridge_getTerms('text_pages' , WPxdamsBridge_getTotalResultPages()).' <br><br>
            '.WPxdamsBridge_getListDesc1 ().'    
        </div>
        <div class="abg-result-list-col-2">
			<div class="xd-vocabulary-selected-title">'.WPxdamsBridge_getVocabularySearchString().'</div>';

//	if (WPxdamsBridge_searchHasResults()) {

            $Menu           = WPxdamsBridge_getPagingMenuBootstrap(0, 0).'';
            $out            =  $out.$Menu ;
            
            WPxdamsBridge_startSearchResultsPublishing() ;

			
            while (WPxdamsBridge_existsNextResult()) {

		$lev        = '';
                $resultId   = WPxdamsBridge_getNextResultID();
		$out        = $out.'<li id="xdlistlink" class="xdlistlink"> '.				
				' <a href="'.$newpage.'archID='.$archiveId.'&xdamsItem='.$resultId  . '"> ';
                
		if (WPxdamsBridge_getNextResultLevel() && WPxdamsBridge_get_option('preview',$archiveId) == 3) 	{	
                    $lev    = '['.WPxdamsBridge_getNextResultLevel().'] ';
		}

                $out        = $out.$lev.WPxdamsBridge_getNextResult() .'</a></li>';
                $prog       = $prog   +1;     
            }
//	}
           
        $out                =  $out.'</ul>'.$Menu.'</div></div>'; 
	
	
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>
