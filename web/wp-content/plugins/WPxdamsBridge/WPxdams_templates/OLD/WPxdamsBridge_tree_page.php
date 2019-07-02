<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published
					 
	$archiveId		= WPxdamsBridge_getCurrentArchiveId() ;
	$archiveLabel           = WPxdamsBridge_get_archive_desc($archiveId);
	$lastpage		= WPxdamsBridge_getCurrentTreeRequest();
		
// **************  to manage paging - not active now but mandatory field

	$pos 			= strpos($lastpage, 'pageToShow');
	if (!$pos) {
            $pageToShow         = '&pageToShow=1';
	}		
		
// *************** breadcrumbs **********************
		
	include ('WPxdamsBridge_tree_page_breadcrumbs.php');

        $out                    = $out .'<br><br>';
		
//  ************ to publish the result list *******************

	if (WPxdamsBridge_searchHasResults()) {

            WPxdamsBridge_startSearchResultsPublishing() ;
				
            while (WPxdamsBridge_existsNextResult()) {	
                    $out  	=  $out.'<a href="'.$lastpage. $pageToShow .'&xdamsItem='.WPxdamsBridge_getNextResultID() . '">'.WPxdamsBridge_getNextResult() .'</a><br>';
				
            }
	}
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		