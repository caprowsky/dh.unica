<?php
/*
  simple template for search form 
*/
	
// 	$out 				= string which contains the html that will be published
	
        $visibleIndex		= 0;		
	$archiveId              = WPxdamsBridge_getCurrentArchiveId();
		
	WPxdamsBridge_getSearchFormFields() ;  // to initialize the search form fields 
		
	$out = '<div class="abg-result-list-col-1">
                        <div class="wrap">'.
				 
					'<form id="xDamsSearchForm" name="WPxdamsBridge_search" action="" method="post" >
						
						<fieldset class="options">   '   ; 
        

        while  (WPxdamsBridge_existsNextFormField()) {
                

		$storedOptions          = WPxdamsBridge_search_form_options(WPxdamsBridge_getFormFieldName() , $archiveId); // get the field description
			
		if ($storedOptions['visibility'] =='1') {  
                    
                    if($listdescpre) {
                        $descLabel      = WPxdamsBridge_getTranslatedTerm($storedOptions['desc']);
                    } else {
                        $descLabel      = WPxdamsBridge_getTranslatedTerm($storedOptions['desc']);
                    }
			
                    $visibleIndex	= $visibleIndex+ 1;
                    
                    $fieldValueSearch   = stripslashes(getFieldValueSearch($visibleIndex));
                    $out		= $out . '<br><br> '.$descLabel .'<br>
								<input type="text" name="c_xdamfield_WPxdamsBridge_'.$visibleIndex.'" style="width: 500px;" value="'.$fieldValueSearch .'" />  
								<input type="hidden" name="c_xdamsfieldId_WPxdamsBridge_'.$visibleIndex.'" value="'.WPxdamsBridge_getFormFieldName().'" />  ';;
		}
	} 
	$out                            = $out . '	<input type="hidden" name="c_fieldNum_WPxdamsBridge" value="'.$visibleIndex.'" />  
						</fieldset>
						
						<p class="submit">
							<input type="submit" name="WPxdamsBridge_ad_search_button" value="cerca" class="btn-adv-search" />
						</p> 
						
						
						
					</form> 
				</div>
                                '.$totPage.' '.WPxdamsBridge_getTerms('text_pages').'
                            </div>';	
		
				
$out                            = $out .$temp;

 



 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
