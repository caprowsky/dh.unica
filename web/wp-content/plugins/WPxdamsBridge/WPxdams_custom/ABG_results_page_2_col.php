<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published
   
	$archiveLabel       = WPxdamsBridge_getCurrentArchiveDesc()  	;		// archive desc
	$newpage            = WPxdamsBridge_getNewRequestURL();
        
       
        if (WPxdamsBridge_isToRedirectIUrl ()) {
            $newpage            = WPxdamsBridge_getRedirectedUrl();
        }
       
        
	$out                ='<div><ul>';
        $prog               = 1;
//  to publish result list 

	if (WPxdamsBridge_searchHasResults()) 
	
            {

            $Menu           = WPxdamsBridge_getPagingMenuBootstrap(0, 0).'';

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
	}
           
        $out                =  '<div class="abg-result-list-col-2">'.$Menu.''.$out.'</ul></div>'.$Menu.'</div>'; 
	
	//	$out                =  '<div class="abg-result-list-col-2">'.$Menu.'</div>'; 
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>
