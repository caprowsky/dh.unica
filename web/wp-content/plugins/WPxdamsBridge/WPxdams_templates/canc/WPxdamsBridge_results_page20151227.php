<?php		
/*
  simple template for results page
*/


		
// 	$out 				= string which contains the html that will be published
//	$xDamsResult		= information items coming from search in xDams
//						  - $xDamsResult ['name'][$i]  - > name of field
//						  - $xDamsResult ['metadata'][1]  - >  number of available fields
// 	$inputFields[$i]	= value of input field
//						  - $inputFields ['xDamsfield'][$i] original field name in xDams
//  {$inputFields ['remotefile'] = executed search
//   $hiddenCriteria    = search criteria for paging (not used?)
//   $navParam			= search criteria for paging 

	$archiveLabel 			= WPxdamsBridge_getCurrentArchiveDesc()  	;		// archive desc
	$newpage				= WPxdamsBridge_getNewRequestURL();

//  to publish result list 


		if ($xmlResult ['message'] == 'ok') 
			{
			$numItem		= WPxdamsBridge_getTotalResultItems()   ;   // total number of result items
			$numPage		= WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
		//	$numPage		= $xmlResult ['curPage']  ;    // number of current page
			$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
			$separ			= "...";
			$separ2			= "...";
			
			//  case free search otherwise $param contains a list of field/value generated in WPxdamsBridge_execute_search
	//		if ($inputFields['fulltextsearch']) {  
	//			$navParam	= '&searchfield='.$inputFields['fulltextsearch'];
	//		}
			
		$navParam	= WPxdamsBridge_getNavParam() ;	
			
			// navigation menu
			$lastPage		= '<a href="'.$newpage.'&pageToShow='.$totPage. $navParam.'">'.$totPage.'</a><br>';
			if ($numPage > 1) {
			    $ppre   	= $numPage - 1;;
				$pre		= '<a href="'.$newpage.'&pageToShow='.$ppre.$navParam.'">'.$ppre.'</a>';
				if ($numPage > 2) {
					if ($numPage == 3) {
						$separ2	= " ";
					}
					$pre	= '<a href="'.$newpage.'&pageToShow=1'.$navParam.'">1</a>'.$separ2.$pre	;
				}
			}	
			if ($numPage < $totPage  ) {
			     $ppost		= $numPage + 1;	
			     $post		= '<a href="'.$newpage.'&pageToShow='.$ppost . $navParam.'">'.$ppost.'</a>';
			}
			if ($numPage == $totPage || $ppost ==  $totPage) {
			     $lastPage	="";
				 $separ		="";
			}
             			
			$out		= '<br><br>numero occorrenze totali: '.$numItem.'<br>pagine: '.$pre.' '.$numPage. ' ' .$post.$separ.$lastPage.'<br><br>';
			
			$count 		= count($xmlResult ['results']);   // number of item for this page
			
			for($i1=0;$i1<$count;$i1++) {	
				
				$out  	=  $out.'<a href="'.$newpage.'&archid='.$archiveId.'&xdamsItem='.$xmlResult ['itemId'][$i1] . '">'.$xmlResult ['results'][$i1].'</a><br>';
					
			}
			$out		= $out.$tracking.'<br>'.$searchCriteria.'<br>'.$hiddenCriteria. 'arthivio '.$archiveLabel .$numPage .'----'	;
			
		}
		
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		