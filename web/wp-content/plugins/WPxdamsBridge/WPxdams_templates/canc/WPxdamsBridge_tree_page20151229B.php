<?php		
/*
  simple template for results page
*/


		
// 	$out 				= string which contains the html that will be published
//	$xDamsResult		= information items coming from search in xDams
//						  - $xDamsResult ['name'][$i]  - > name of field
//						  - $xDamsResult ['metadata'][1]  - >  number of available fields



//  
		   WPxdamsBridge_resetGetElement () ;
		$archiveId		= WPxdamsBridge_getCurrentArchiveId() ;
		$archiveLabel 	= WPxdamsBridge_get_archive_desc($archiveId);
		$newpage		= WPxdamsBridge_getNewRequestURL();
		$lastpage		= WPxdamsBridge_getCurrentTreeRequest();
		
		// *************** breadcrumbs **********************
		
		$out			= ' sei in :'.$lastpage.WPxdamsBridge_getNewRequestURL().'<br>';
				
		if (WPxdamsBridge_isARequestForAllArchives()) {
			$out		= $out. '<a href="'.$newpage.  '"> Tutti gli Archivi</a>'; // add level 'all archives' to breadcrumbs
		}
		$out			= $out.'> <a href="'.$newpage.'&archID='. $archiveId .  '">'.$archiveLabel.'</a>';  // add level 'current archive' to breadcrumbs
		
		if ($lastpage ) {

			while (WPxdamsBridge_existsNextTreeLevel()) {
			        $levelID = WPxdamsBridge_getNextLevelId();
			        $pathR	= $pathR . '&xdamsItem='.  $levelID ;
			}
			// first level results page
			$first = strpos( $lastpage, '&archID=');
			if (!$first) {	
				$lastpage= $lastpage . '&archID='.$archiveId;
			}
		}

//  to publish result list 
     /*
		if ($xmlResult ['message'] == 'ok') 
			{
			$numItem	= $xmlResult ['totItem']   ;   // total number of result items
			$numPage	= $xmlResult ['curPage']  ;    // number of current page
			$totPage	= $xmlResult ['totPage']  ;    // total number of pages
			$out		= $out .'<br><br>numero occorrenze totali: '.$numItem.'                 pagina: '.$numPage.' di '.$totPage.'<br><br>';
			
			$count 		= count($xmlResult ['results']);   // number of item for this page
			
			for($i1=0;$i1<$count;$i1++) {	
				
					$out  	= $out. '<a href="'.$lastpage. '&xdamsItem='.$xmlResult ['itemId'][$i1] . '">'.$xmlResult ['results'][$i1].'</a><br>';
					
			}
		}
		*/
		if (WPxdamsBridge_searchHasResults()) {

			$numItem		= WPxdamsBridge_getTotalResultItems()   ;   // total number of result items
			$numPage		= WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
			$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages			
			
			$out		= $out .'<br><br>numero occorrenze totali: '.$numItem.'                 pagina: '.$numPage.' di '.$totPage.'<br><br>';
		
		
			WPxdamsBridge_resetGetElement () ;
				
			while (WPxdamsBridge_existsNextResult()) {	
				$out  	=  $out.'<a href="'.$lastpage.'&xdamsItem='.WPxdamsBridge_getNextResultID() . '">'.WPxdamsBridge_getNextResult() .'</a><br>';
				
			}
		}
		$out = $out . '<input type="hidden" name="c_treepath_WPxdamsBridge" value="'.$currpage	.'" />'; 
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		