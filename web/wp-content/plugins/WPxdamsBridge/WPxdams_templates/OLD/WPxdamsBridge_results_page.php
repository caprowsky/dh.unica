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
		$lev        ='';
		$out        =  $out.'<div id="listLink" class="listLink"> '.				
				'<a href="'.$newpage.'&archID='.$archiveId.'&xdamsItem='.WPxdamsBridge_getNextResultID() . '">';
		if (WPxdamsBridge_getNextResultLevel() && WPxdamsBridge_get_option('preview',$archiveId) == 3) 	{	
                    $lev    =  '['.WPxdamsBridge_getNextResultLevel().'] ';
		}	
                $out        =  $out.$lev.WPxdamsBridge_getNextResult() .'</a></div><br>';
                $prog       = $prog   +1;
				
			}
	}
        
       
                
        $out                =  $Menu.$out.$Menu; //'file ricerca'.    $inputFields ['remotefile'];
	
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		