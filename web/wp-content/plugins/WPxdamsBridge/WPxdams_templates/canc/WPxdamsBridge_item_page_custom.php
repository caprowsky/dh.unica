<?php		
/*
  simple template for publish item metadata on a page
*/


		
// 	$out 					= string which contains the html that will be published
//	$element [label][index]	= any field label (label) can have from 1 to N values (index)
// 	$requestedId			= value of input item id
//						  


//  tu publish values of requested search
	
			$archiveLabel 	= WPxdamsBridge_get_archives_desc($archiveId);
			$keys 		 	= array_keys($element); 
			$count 			= count($keys);
			$outriga 		= '<h2>xDams - ID scheda: '.$requestedId. '</h2>In '. $archiveLabel.'<br><br>';
			$sep = ': <br>';
			
			for($i1=0;$i1<$count;$i1++) 
				{	
				if ($i1 > 0 ) {$sep = ': <br>';}
				$desc 		= $keys[$i1];    			// labels of fields
				$count2		= count($element [$desc]);  // number of fields
				$elements	= '';
				$sep2		= '';
				for($i2=0;$i2<$count2;$i2++) 
					{
					if ($i2 > 0 ) {$sep2 = ';  ';}
					$elements 	= $elements .$sep2.$element [$desc][$i2];
				}	
					$outriga  	= $outriga.$desc.$sep. $elements.'<br><br>' ; 
			}
			$out 		=  $outriga.'<br>';
		
		
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		