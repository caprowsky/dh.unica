<?php		
/*
  simple template for results page
*/
		
// 	$out = string which contains the html that will be published
					  

    $newpage            		= WPxdamsBridge_getWPPageURL();	
    
    // html and javascript to build the carousel
    $startContainer_carousel 		= WPxdamsBridge_getCarouselHTML ('start');
    $stopCarousel 			= WPxdamsBridge_getCarouselHTML ('stopCarousel');
    $startThumbsNavigation 		= WPxdamsBridge_getCarouselHTML ('startThumbsNavigation');
    $stopThumbsNav_container_Script     = WPxdamsBridge_getCarouselHTML ('stop');
        
//  to publish result list 

    if (WPxdamsBridge_searchHasResults()) 
            {
            $Menu			= WPxdamsBridge_getPagingMenu(0);
			
            WPxdamsBridge_startSearchResultsPublishing() ;

            $out                        =  $Menu.'<div>';
            $prog                       =  0;
            while (WPxdamsBridge_existsNextResult()) 
                {
                $nextResultId 		= WPxdamsBridge_getNextResultID();      // single item ID
		$nextResultPic		= WPxdamsBridge_getNextResultPreview('0', 'class="img-responsive"') ;     // large pic
		$nextResultPre		= WPxdamsBridge_getNextResultPreview('100' , 'class="img-responsive"') ;  // pic for preview
		$nextResult 		= WPxdamsBridge_getNextResult();        // text to show
                              
                $itemClass     		= 'item';
                if ($prog==0) {$itemClass  ='active item';};                                
                                
                $carouselItem   	=  $carouselItem. ' 
                                        <div class="'.$itemClass.'" data-slide-number="'.$prog.'">
                                            '.'<a href="'.$newpage.'&archID='.$archiveId.'&xdamsItem='.$nextResultId . '">'.
                                           $nextResultPic.
                                            '
                                            <div class="carousel-caption">
												
                                                 <h7>'.$nextResult.'</h7></a>
                                               
                                            </div>
                                        </div>';
 
                $thumbClass     	= '';
                if ($prog==0) {
                    $thumbClass         ='class="selected"';
                    
                }; 
                $thumbsItem     	= $thumbsItem.'
                                <li>'.'<a id="carousel-selector-'.$prog.'"' . $thumbClass .'>'.$nextResultPre.'</a></li>';
				
                $prog                   =  $prog + 1; 
            }
	
            $out                        =  $out	. $startContainer_carousel 
							. $carouselItem
							. $stopCarousel 
							. $startThumbsNavigation 
							. $thumbsItem 
							. $stopThumbsNav_container_Script;

    }
		 
		 
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		