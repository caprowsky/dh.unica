<?php		
/*
  simple template for results page breadcrumbs
  
  WPxdamsBridge_getNewRequestURL() = url including first two parameter: type of archibve and paging 
  
*/
		$out			= ' sei in :'.'<br>';
		$newpage		= WPxdamsBridge_getNewRequestURL();		
						
		if (WPxdamsBridge_isARequestForAllArchives()) {
			$out		= $out. '<a href="'.WPxdamsBridge_getWPPageURL().  '"> Tutti gli Archivi</a>'; // add level 'all archives' to breadcrumbs
		}
		$out			= $out.'> <a href="'.$newpage.  '">'.$archiveLabel.'</a>';  // add level 'current archive' to breadcrumbs
		
		if ($lastpage ) {
			
		    WPxdamsBridge_startTreeBreadcrumbsPublishing() ;
			
			while (WPxdamsBridge_existsNextTreeLevel()) {
			
			        $levelID = WPxdamsBridge_getNextTreeLevelId();
			        $pathr	=  '&xdamsItem='.  $levelID ;
					$out  	= $out.  ' > <a href="'.$lastpage. '&pageToShow=1' .$pathr. '">'. $levelID  .'</a>'; //
			}
		}
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		