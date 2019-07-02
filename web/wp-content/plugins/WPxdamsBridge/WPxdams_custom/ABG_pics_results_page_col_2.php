<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published

		$newpage                = WPxdamsBridge_getNewRequestURL();
		$out                    ='';
	
//  to publish result list 

		if (WPxdamsBridge_searchHasResults()) 
                    {
                    
                    $Menu		= WPxdamsBridge_getPagingMenuBootstrap(0,0);
					
                    WPxdamsBridge_startSearchResultsPublishing() ;
			
                    $out                =  ''.$Menu.'<br><br><br><div id="xdImgResultsPage" class="xdImgResultsPage"> <table ><tr>';
                    $prog               =  0;
                    while (WPxdamsBridge_existsNextResult()) {
                        
                         $resultId      =  WPxdamsBridge_getNextResultID() ;
                         
                         if($resultId) {
                            $out  	=  $out.'<td>';
                            $out  	=  $out.'<div id="xdlistlinkImg" class="xdlistlinkImg"> 
							<a href="'.$newpage.'&archID='.$archiveId.'&xdamsItem='.$resultId . '">'.
							WPxdamsBridge_getNextResultPreview('350').''.
							WPxdamsBridge_getNextResult() .'</a></div>';
                            $out  	=  $out.'</td>';
                            $prog 	=  $prog + 1; 
                            if ($prog == 2) {
				$out  	=  $out.'</tr><tr>';
				$prog 	=  0 ; 
                            }
                        }
                    }
                    $out                =  '<div class="abg-result-list-col-2">'.$out.'</tr></table></div>'.$Menu .'</div>'; //$inputFields ['remotefile']; 
			
              
		}
		 
		 
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		