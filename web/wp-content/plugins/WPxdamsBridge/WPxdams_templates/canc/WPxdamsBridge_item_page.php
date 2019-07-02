<?php		
/*
  simple template for publish item metadata on a page
*/


		
// 	$out 					= string which contains the html that will be published
//	$element [label][index]	= any field label (label) can have from 1 to N values (index)
// 	$requestedId			= value of input item id
//						  


//  tu publish values of requested search

	
			$archiveLabel 			= WPxdamsBridge_get_archive_desc($archiveId);	 			// archive desc
			$archiveLevelId			= 'item@'.$archiveId;
			$fields_options_from_db = get_option('WPxdamsBridge_output_fields_'.$archiveLevelId);	// custom labels from user strored in DB
			
			
			$keys 		 			= array_keys($element); 
			$count 					= count($keys);
			$outriga 				= '<h2>ID scheda: '.$requestedId. '</h2><BR>In '. $archiveLabel.'<br><br>';
			$sep 					= ': <br>';
			
			for($i1=0;$i1<$count;$i1++) 
				{	
				
				if ($i1 > 0 ) {$sep = ': <br>';}
				$desc 				= $keys[$i1];    			// labels of fields
				$count2				= count($element [$desc]);  // number of fields
				$elements			= '';
				$sep2				= '';
				
				$normdesc		 	= str_replace('à', 'a', $desc);
				$storedOptions 		= WPxdamsBridge_output_list_options($normdesc, $archiveLevelId, $fields_options_from_db , $count );  // eliminare i campi input in più ssssssss
				$outdesc			= $storedOptions['desc'];
				if (!$outdesc)	{ $outdesc = $desc; }
				
				if ($storedOptions['visibility'] !='0') {            

					for($i2=0;$i2<$count2;$i2++) 
					{
						if ($i2 > 0 ) {$sep2 = ';  ';}
						$elements 		= $elements .$sep2.$element [$desc][$i2];
					}	
					$outriga  			= $outriga.'<strong>'.$outdesc.'</strong>'.$sep. $elements.'<br><br>' ;
				}	
			}
			$out 					=  $outriga.'<br>'.$out.'<br>';
		
		
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		