<?php
/*
  simple template for search form 
*/


		
// 	$out 				= string which contains the html that will be published
//	$shortCodeContent 	= text defined by user for title
//	$archiveLabel		= Label for archive id
//	$count 				= number of available fields for searching in archive
//	$xDamsFields		= information about all field available foe a specific archive
//						  - $xDamsFields ['name'][$i]  - > name of field
//						  - $xDamsFields ['metadata'][1]  - >  number of available fields
//  WPxdamsBridge_search_form_options - > functions which gives user preference
//						  -	'visibility' if a field have to be published
//						  - 'desc'       user defined description 
//  	
		
		
		$visibleIndex		= 0;
		$out= '<div class="wrap">'.
					'<h2>' . $shortCodeContent .$archiveLabel.' CUSTOM</h2>
					<form id="xDamsSearchForm" name="WPxdamsBridge_search" action="" method="post" >
						<p>By this page it\'s possible to search content in the xDams archives</p> 
					    <fieldset class="options">   '   ;   
		
		
		for($i=1;$i<$count;$i++) {		
		
			$storedOptions 	=   WPxdamsBridge_search_form_options($xDamsFields ['name'][$i], $archiveId); // get the field description
			
			if ($storedOptions['visibility'] =='1') {       
				$visibleIndex	= $visibleIndex+ 1;
				$out			= $out . '	<p> '.$storedOptions['desc'] .'</p>
								<input type="text" name="c_xdamfield_WPxdamsBridge_'.$visibleIndex.'" value="'.$field[$visibleIndex].'" />  
								<input type="hidden" name="c_xdamsfieldId_WPxdamsBridge_'.$visibleIndex.'" value="'.$xDamsFields ['name'][$i].'" />  ';;
			} 
		} 						 
		 $out= $out . '	<input type="hidden" name="c_fieldNum_WPxdamsBridge" value="'.$visibleIndex.'" />  
						</fieldset>
						<p class="submit">
							<input type="submit" name="WPxdamsBridge_submit_button" value="search" />
						</p> 
						
						
						
					</form> 
				</div>';	
		
				


 



 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
