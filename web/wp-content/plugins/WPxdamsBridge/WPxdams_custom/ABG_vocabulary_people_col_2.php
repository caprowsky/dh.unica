<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published
   
	$archiveLabel       = WPxdamsBridge_getCurrentArchiveDesc()  	;		// archive desc
	$newpage            = WPxdamsBridge_getNewRequestURL();
	$out                ='';
	$i					= 0;
	
        $prog               = 1;
//  to publish result list 
        $out                = WPxdamsBridge_getVocabularyNav ($archiveId).'<br>';
        $out                = '
        <div class="abg-result-list-col-1">
           '.$out .'<br><br><br>
           '.WPxdamsBridge_getListDesc1 ().'
        </div>
        <div class="abg-result-list-col-2">';
        

//	if (WPxdamsBridge_searchHasResults()) 
    //        {
            WPxdamsBridge_startSearchResultsPublishing() ;
            
            while (WPxdamsBridge_existsNextResult()) {
                $i              = $i +1;
		$term           = WPxdamsBridge_getNextResult();
                $onlyTerm       = explode('(', $term);
                $textIn         = $onlyTerm[0];          
                
		$out            =  $out.'<div id="xdlistlink" class="xdlistlink list-people"> '.				
				'<a href="'.$newpage.'&archID='.$archiveId.'&vocabularyValue='.  $textIn   . ' ">';
	
                $out            =  $out.$term  .'</a></div>';
                $prog           = $prog   +1;
				
            }
            
             $out            =  $out.'<br><br>';
            
            if (($i>0) && $currentInfo ['xmlResult'] ['backParam'] ) {
                $out        	=  $out.'<a href="'.$newpage.'&archID='.$archiveId.'&startParam='
							. $currentInfo ['xmlResult'] ['backParam']  . '&updown=down">back</a>   ';
            }                       
            if ($currentInfo ['xmlResult'] ['startParam'] ) {
                $out        	=  $out.'<a href="'.$newpage.'&archID='.$archiveId.'&startParam='
                                . $currentInfo ['xmlResult'] ['startParam'] . '">more</a>';
			}	

				
			
			
//	}
        
        $out        	=  $out.'</div>'.'<br><br>';
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		