<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published
					 /*
	$archiveId		= WPxdamsBridge_getCurrentArchiveId() ;
	$archiveLabel           = WPxdamsBridge_get_archive_desc($archiveId);
	$lastpage		= WPxdamsBridge_getCurrentTreeRequest();
		
// **************  to manage paging - not active now but mandatory field

	$pos 			= strpos($lastpage, 'pageToShow');
	if (!$pos) {
            $pageToShow         = '&pageToShow=1';
	}
        */
		
// *************** breadcrumbs **********************
        
      
		
	//include ('WPxdamsBridge_tree_page_breadcrumbs.php');
        $out                    =  WPxdamsBridge_getBreadcrumbs ();
        
        $border     = $border *20;   // to create a left margin
        
        if($singleItem) {
            $out                = $out.'<br><br><div style="padding-left:'.$border.'px;">'. $singleItem.'</div>';
        }
        $out                    = $out.'<br><br>';
		
//  ************ to publish the result list *******************

	if (WPxdamsBridge_searchHasResults()) {
            
            if($singleItem) {
                $furtherLevels      = '<h6 style="padding-left:'.$border.'px;">Ulteriori sotto livelli</h6>';
            }
            
            $Menu                   = '<br><br>'. WPxdamsBridge_getPagingMenu(0).'<br><br><br><br>';

            $out                    = $out . $furtherLevels. $Menu .'<table>' ;
            
            WPxdamsBridge_startSearchResultsPublishing() ;
		
            while (WPxdamsBridge_existsNextResult()) {
            
                    $out  	=  $out.'
                                <tr>
                                   
                                    <td style="padding-left:'.$border.'px;">    
                                        <a href="'.$lastpage. $pageToShow .'&xdamsItem='.WPxdamsBridge_getNextResultID() . '" >'.WPxdamsBridge_getNextResult() .'</a>
                                    </td><td style="padding-left:10px;">
                                        
                                        <br>
                                    </td>
                                </tr>';
				
            }
             $out                = $out .'</table>' ;
	}
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		