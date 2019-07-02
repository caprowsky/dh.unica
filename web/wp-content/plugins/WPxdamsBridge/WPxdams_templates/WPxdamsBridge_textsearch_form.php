<?php
/*
  simple template for search form - use $out to build HTML
*/
        
		if ($inputFields['fulltextsearch']) {
			$inputValue	=$inputFields['fulltextsearch'];
		}
		$archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc();	
		$redirect               = WPxdamsBridge_getSearchRedirectionUrl();
                
		$out		= 	'<div class="wrap">'.
						'<h2>'  .' '.$archiveLabel.'</h2>
						<form id="xDamsSearchForm" name="WPxdamsBridge_search" action="'.$redirect.'" method="post" >
						
					    <fieldset class="options">   '   ;   
		$out		= $out . '	
								<input type="text" name="c_xdamfield_WPxdamsBridge_fulltextsearch" style="width: '.$searchBoxWidth.'px;" value="'.$inputValue.'" /> ' 
								;	  
		$out		= $out . '	  
						</fieldset>
						
						<p class="submit">
							<input type="submit" name="WPxdamsBridge_text_search_button" value="search"  />
						</p> 
						
						
						
					</form> '.WPxdamsBridge_getTextPostForm ().'
				</div>';


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
