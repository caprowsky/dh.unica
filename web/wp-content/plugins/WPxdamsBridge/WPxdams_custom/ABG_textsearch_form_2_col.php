<?php
/*
  simple template for search form - use $out to build HTML
*/
        
		if ($inputFields['fulltextsearch']) {
			$inputValue	= str_replace('%20', ' ' , $inputFields['fulltextsearch']);
		}
		$archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc();	
		$redirect               = WPxdamsBridge_getSearchRedirectionUrl();
                $currresults            = WPxdamsBridge_getTotalResultItems().' '.WPxdamsBridge_getTerms('text_results') ;
                if ($inputValue) {
                    $per                = ' per 
                                                <div class="abg-result-list-search-value">'.$inputValue.'</div>';
                }
                
                $boxOption = 'text';
                
                
		$out		= 	'
                                        <div class="abg-result-list-col-1">'.
						'
						<div class="wrap-search-sidebar">
                                                    <form id="xDamsSearchForm" class="search-sidebar" name="WPxdamsBridge_search" action="'.$redirect.'" method="post" >
						
                                                        <fieldset class="options">   '   ;   
		$out                = $out . '	
								<input type="'.$boxOption.'" name="c_xdamfield_WPxdamsBridge_fulltextsearch" style="width: '.$searchBoxWidth.'px;" value="'.$inputValue.'" /> 
								 <button type="submit" name="WPxdamsBridge_text_search_button" class="btn btn-search" value="cerca"> <i class="fa fa-search"></i></button>
                                                                 ';
                
                if (WPxdamsBridge_getMultiArchivesResults ()) {						;
                    $multiArchivesList  = '
                                                                <div class="abg-multiarchives-results">
                                                                '.WPxdamsBridge_getTerms('text_found_also').'<br>
                                                                '.WPxdamsBridge_getMultiArchivesResults ().'
                                                                </div>';
                }
		$out                = $out . '	  
                                                        </fieldset>
                        
                                                    </form>
						
                                                   
                        
                        <!--p class="submit">
                                                    <input type="submit" name="WPxdamsBridge_text_search_button" value="search"  />
                        </p--> 
						
                                                </div>
						
                                                
                                                <div class="abg-result-list-total-results">'.$currresults.$per.'</div>'. '
                            
                                                '.WPxdamsBridge_getTotalResultPages() .' '.WPxdamsBridge_getTerms('text_pages').'
                                                <div class"xd-curr-archive">In '.WPxdamsBridge_getMultiArchivesCurrent ().'</div>      
                                                <div class"xd-other-archives">'.$multiArchivesList.'</div>
                                                ' .WPxdamsBridge_getTextPostForm ().'
                                                 
				</div>';


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
