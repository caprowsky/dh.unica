<?php
/*
  simple template for search form - use $out to build HTML
*/
        
		if ($inputFields['fulltextsearch']) {
			$inputValue	=$inputFields['fulltextsearch'];
		}
		$archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc();	
		$redirect               = WPxdamsBridge_getSearchRedirectionUrl();
                $currresults            = WPxdamsBridge_getTotalResultItems().' '.WPxdamsBridge_getTerms('text_results') ;
                if ($inputValue) {
                    $per                = ' per 
                                                <div class="abg-result-list-search-value">'.$inputValue.'</div>';
                }
                
		$out		= 	'<div class="abg-result-list-col-1">'.
						'
						<div class="wrap-search-sidebar">
                        <form id="xDamsSearchForm" class="search-sidebar" name="WPxdamsBridge_search" action="'.$redirect.'" method="post" >
						
					    <fieldset class="options">   '   ;   
		$out		= $out . '	
								<input type="text" name="c_xdamfield_WPxdamsBridge_fulltextsearch" style="width: '.$searchBoxWidth.'px;" value="'.$inputValue.'" /> ' 
								;	  
		$out		= $out . '	  
						</fieldset>
                        
                        </form>
						
                        <button type="submit" name="WPxdamsBridge_text_search_button" class="btn btn-search" value="cerca"> <i class="fa fa-search"></i></button>
                        
						<!--p class="submit">
							<input type="submit" name="WPxdamsBridge_text_search_button" value="search"  />
						</p--> 
						
						</div>'.WPxdamsBridge_getTextPostForm ().'
						
                                                
                        <div class="abg-result-list-total-results">'.$currresults.$per.'</div>
					 
				</div>';


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
