<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published
   
	$archiveLabel       = WPxdamsBridge_getCurrentArchiveDesc()  	;		// archive desc
	$newpage            = WPxdamsBridge_getNewRequestURL();
	$out                ='';
	$i					= 0;
	//$vocabularyField	=$inputFields['xDamsfield'][1] ;
        $prog               = 1;
//  to publish result list 

	if (WPxdamsBridge_searchHasResults()) 
            {
            WPxdamsBridge_startSearchResultsPublishing() ;
			
            while (WPxdamsBridge_existsNextResult()) {
				$i = $i +1;
		$term        = WPxdamsBridge_getNextResult();
                $onlyTerm   = explode('(', $term);
		$out        =  $out.'<div id="listLink" class="listLink"> '.				
				'<a href="'.$newpage.'&archID='.$archiveId.'&vocabularyValue='. $onlyTerm[0] . '">';
	
                $out        =  $out.$term .'</a></div><br>';
                $prog       = $prog   +1;
				
			}
 			if (($i>0) && $currentInfo ['xmlResult'] ['backParam'] ) {
				$out        	=  $out.'<a href="'.$newpage.'&archID='.$archiveId.'&startParam='
							. $currentInfo ['xmlResult'] ['backParam']  . '&updown=down">back</a>   ';
			}                       
			if ($currentInfo ['xmlResult'] ['startParam'] ) {
				$out        	=  $out.'<a href="'.$newpage.'&archID='.$archiveId.'&startParam='
							. $currentInfo ['xmlResult'] ['startParam'] . '">more</a><br>';
			}	

				
			
			
	}
        
       
                
    //    $out                =  $out.  $currentInfo ['xmlResult'] ['read']; //'file ricerca'.    $inputFields ['remotefile'];
        
        
        
        
 // http://hosting.xdams.org/xDams-labs/rest/labs/xDamsLabsxDamsHist/4e82abc9b6844bf54edb8f34254c30c3?mode=vocabulary&searchAlias=XML,/c/did/unittitle&totResult=20&orientation=up&startParam=a       
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		