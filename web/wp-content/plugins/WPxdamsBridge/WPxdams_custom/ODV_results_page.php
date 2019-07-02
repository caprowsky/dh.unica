<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published
   
	$archiveLabel       = WPxdamsBridge_getCurrentArchiveDesc()  	;		// archive desc
	$newpage            = WPxdamsBridge_getNewRequestURL();
	$out                ='';
        $prog               = 1;
//  to publish result list 

	if (WPxdamsBridge_searchHasResults()) 
	
            {

            $Menu           = WPxdamsBridge_getPagingMenu(0).'<br><br><br><br>';

            WPxdamsBridge_startSearchResultsPublishing() ;

			
            while (WPxdamsBridge_existsNextResult()) {

		$lev        = '';
                $resultId   = WPxdamsBridge_getNextResultID();
		$out        = $out.'<div id="xdlistlink" class="xdlistlink"> '.				
				' <a href="'.$newpage.'&archID='.$archiveId.'&xdamsItem='.$resultId  . '">';
                
		if (WPxdamsBridge_getNextResultLevel() && WPxdamsBridge_get_option('preview',$archiveId) == 3) 	{	
                    $lev    = '['.WPxdamsBridge_getNextResultLevel().'] <br>';
		}

                $out        = $out.$lev.WPxdamsBridge_getNextResult() .'</a></div><br>';
                $prog       = $prog   +1;     
            }
	}
           
        $out                =  $Menu.$out.''.$Menu.'<br><br>'; 
	
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		