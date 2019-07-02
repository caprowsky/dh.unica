<?php
/*
  simple template for search form - use $out to build HTML
*/
        
		if ($inputFields['fulltextsearch']) {
			$inputValue	= str_replace('%20', ' ' , $inputFields['fulltextsearch']);
		}
		$archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc();	
		$redirect               = WPxdamsBridge_getSearchRedirectionUrl();
                $currresults            = WPxdamsBridge_getTotalResultItems().' elementi ';// WPxdamsBridge_getTerms('text_results') ;
           //     if ($inputValue) {
        //            $per                = ' per 
       //                                         <div class="abg-result-list-search-value">'.$inputValue.'</div>';
      //          }

                if($singleItemSidebar) {
                //    $singleItemSidebar  = WPxdamsBridge_ABG_cleanItem($singleItemSidebar);
                    $itemDetails        =  '
                                                <div class="xd-sidebar-item">Dettaglio livello:
                                                    <div class="xd-sidebar-item-detail">
                                                        '. WPxdamsBridge_ABG_cleanItem($singleItemSidebar).'
                                                    </div>
                                                    <div class="xd-sidebar-itemLevel-label">
                                                         tipo scheda:
                                                    </div>
                                                    <div class="xd-sidebar-itemLevel">
                                                        '. WPxdamsBridge_ABG_getLevel($singleItemSidebar).'
                                                    </div>
                                                </div>';
                }
                if(WPxdamsBridge_getTotalResultItems() > 0 ) {
                    $printResults      =  '  
                                                <div class="abg-result-list-total-results">'.$currresults.$per.'</div>'. '
                                                '.WPxdamsBridge_getTotalResultPages() .' '.WPxdamsBridge_getTerms('text_pages');
                } 
                
                $boxOption = 'text';
         
                
		$out		= 	$out. '
                                        <div class="abg-result-list-col-1">'.
						'
                                            <div class="abg-hier-nav">
                                                '. WPxdamsBridge_getBreadcrumbs ().'
                                            </div> 	'
                                            .$printResults.$itemDetails.'
                                            
                                            <br><br>
                                            <div class="wrap-search-sidebar"> 
    
                                                <form id="xDamsSearchForm" class="search-sidebar" name="WPxdamsBridge_search" action="'.$redirect.'" method="post" >
                                                    <form id="xDamsSearchForm" name="WPxdamsBridge_search" action="'.$redirect.'" method="post" >
                                                        <fieldset class="options">   '   ;   
		/*
                $out                = $out . '	
								<input type="'.$boxOption.'" name="c_xdamfield_WPxdamsBridge_fulltextsearch" style="width: '.$searchBoxWidth.'px;" value="'.$inputValue.'" />  
 
                                                                <button type="submit" name="WPxdamsBridge_text_search_button" class="btn btn-search" value="cerca"> <i class="fa fa-search"></i></button>
                        ' ;
		*/
                
                
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
						
                                                   
                                                <div class"xd-other-archives">'.$multiArchivesList.'</div>
                                                ' .WPxdamsBridge_getTextPostForm ().'
                                                 
				</div>';


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
