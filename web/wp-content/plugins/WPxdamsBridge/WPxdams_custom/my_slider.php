<?php		
/*
  simple template for results page
*/
		
// 	$out = string which contains the html that will be published
					  
    
     
    $imgHeight=  $currentInfo['sliderHeight'] - 50;
    $newpage            		= WPxdamsBridge_getWPPageURL();	
   
    
    // html and javascript to build the carousel
    $startContainer_carousel 		= WPxdamsBridge_getCarouselHTML ('start',$currentInfo['sliderHeight']);
    $stopCarousel 			= WPxdamsBridge_getCarouselHTML ('stopCarousel');
    $startThumbsNavigation 		= WPxdamsBridge_getCarouselHTML ('startThumbsNavigation');
    $stopThumbsNav_container_Script     = WPxdamsBridge_getCarouselHTML ('stop', '',$currentInfo['sliderInterval']);
        
//  to publish result list 

    if (WPxdamsBridge_searchHasResults()) 
            {
            $Menu			= '<div>'.WPxdamsBridge_getPagingMenu(0).'</div>';
			
            WPxdamsBridge_startSearchResultsPublishing() ;

            $out                        =  '<div>';
            $prog                       =  0;
            while (WPxdamsBridge_existsNextResult()) 
                {
                $nextResultId 		= WPxdamsBridge_getNextResultID();      // single item ID
		$nextResultPic		= WPxdamsBridge_getNextResultPreview('0', 'class="img-responsive" style="max-height: '. $imgHeight.'px;"') ;     // large pic
		$nextResultPre		= WPxdamsBridge_getNextResultPreview('100' , 'class="img-responsive"') ;  // pic for preview
		$nextResult 		= WPxdamsBridge_getNextResult();        // text to show
                              
                $itemClass     		= 'item';
                if ($prog==0) {$itemClass  ='active item';};                                
                                
                $carouselItem   	=  $carouselItem. ' 
                                        <div class="'.$itemClass.'" data-slide-number="'.$prog.'" style="height: '.$currentInfo['sliderHeight'].'px;">
                                            <div class="carousel-preview">
                                            '.'<a href="'.$newpage.'&archID='.$archiveId.'&xdamsItem='.$nextResultId . '">'.
                                           $nextResultPic.
                                            '
                                            </a></div>    
                                            <div class="carousel-caption">
												
                                                 <p>'.$nextResult.'</p></a>
                                               
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
	
            $out      		=  'my template<br>'. $out	
							. $startContainer_carousel 
							. $carouselItem
							. $stopCarousel 
							. $startThumbsNavigation 
							. $thumbsItem 
							. $stopThumbsNav_container_Script
                                                        . $Menu;

    }
		 
		 
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		