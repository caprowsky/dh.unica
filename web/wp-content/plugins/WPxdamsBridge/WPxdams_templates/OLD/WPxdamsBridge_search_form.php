<?php
/*
  simple template for search form 
*/
	
// 	$out 				= string which contains the html that will be published
	
        $visibleIndex		= 0;		
	$archiveId              = WPxdamsBridge_getCurrentArchiveId();
		
	WPxdamsBridge_getSearchFormFields() ;  // to initialize the search form fields 
		
	$out = '<div class="wrap">'.
				' ricerca in '. WPxdamsBridge_getCurrentArchiveDesc() .
					'<form id="xDamsSearchForm" name="WPxdamsBridge_search" action="" method="post" >
						
						<fieldset class="options">   '   ;   

        while  (WPxdamsBridge_existsNextFormField()) {

		$storedOptions          = WPxdamsBridge_search_form_options(WPxdamsBridge_getFormFieldName() , $archiveId); // get the field description
			
		if ($storedOptions['visibility'] =='1') {  
                    
                    $descLabel          = WPxdamsBridge_getTranslatedTerm($storedOptions['desc']);
				
                    $visibleIndex	= $visibleIndex+ 1;
                    $out		= $out . '<br><br> '.$descLabel .'<br>
								<input type="text" name="c_xdamfield_WPxdamsBridge_'.$visibleIndex.'" style="width: 500px;" value="'.'" />  
								<input type="hidden" name="c_xdamsfieldId_WPxdamsBridge_'.$visibleIndex.'" value="'.WPxdamsBridge_getFormFieldName().'" />  ';;
		}
	} 
	$out                            = $out . '	<input type="hidden" name="c_fieldNum_WPxdamsBridge" value="'.$visibleIndex.'" />  
						</fieldset>
						<br>
						<p class="submit">
							<input type="submit" name="WPxdamsBridge_submit_button" value="search" />
						</p> 
						
						<p>By this page it\'s possible to search content in the xDams archives</p> 
						
					</form> 
				</div>';	
		
				


 



 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
