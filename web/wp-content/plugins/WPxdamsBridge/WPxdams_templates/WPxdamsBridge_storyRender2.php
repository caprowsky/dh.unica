

<?php


    $storyId                            = trim($content);
    $backgroundImgUrl                   = get_option('WPxdamsBridge_backgroundImgUrl_'.$storyId);
    $storyTitle                         = get_option('WPxdamsBridge_storyTitle_'.$storyId);
    $slidesNumber                       = get_option('WPxdamsBridge_story_fieldsNumber_'.$storyId); // number of archives;
    $prog                               =  0;
    $imgHeight                          =  $currentInfo['sliderHeight'] - 100;
	
 // html and javascript to build the carousel
    $startContainer_carousel            = WPxdamsBridge_getCarouselHTML ('start',$currentInfo['sliderHeight']);
    $stopCarousel                       = WPxdamsBridge_getCarouselHTML ('stopCarousel');
    $startThumbsNavigation              = WPxdamsBridge_getCarouselHTML ('startThumbsNavigation');
    $stopThumbsNav_container_Script     = WPxdamsBridge_getCarouselHTML ('stop', '',$currentInfo['sliderInterval']);;

    for($i=1;$i<=$slidesNumber   ;$i++) {	
   
        $toSplit             = get_option('WPxdamsBridge_story_'.$storyId.'_'.$i);
        $temp                = explode('%%%', $toSplit);
  
        $elementId           = $temp [0];
        $des [$i]            = $temp [1];
        $archId [$i]         = $temp [2];
        $storedUrl           = $temp [3];
       
        if ($storedUrl [$i] ) {
            $url [$i]   = $storedUrl;
        } else {
            if ($elementId){
                $result      = WPxdamsBridge_single_item_request ( $elementId, $archId [$i]);
                $url [$i]    = WPxdamsBridge_getMediaFileURL(); 
            }    
        }

        $itemClass          = 'item';
        if ($prog==0) {
            $itemClass  ='active item'; 
            $insertTitle =  $storyTitle  ;  
            
        };                                
                           
        if($type=='2') {
                $carouselItem   =  $carouselItem. ' 
                                        <div class="'.$itemClass.'" data-slide-number="'.$prog.'" style="height: '.$currentInfo['sliderHeight'].'px;">
                                             <div class="carousel-preview">
                                                 '.'<img src="'.$url [$i]. '" class="img-responsive" style="max-height: '. $imgHeight.'px;min-height: '. $imgHeight.'px;">
                                             </div>    
                                             <div class="carousel-caption" style="text-align: bottom">
                                                <p>'.$des [$i].'</p>                                            
                                            </div>
                                        </div>';
        } else {
               $carouselItem   	=  $carouselItem. ' 
                                        <div class="'.$itemClass.'" data-slide-number="'.$prog.'" style="height: '.$currentInfo['sliderHeight'].'px;">
                                             <div class="carousel-preview;">
                                                 '.'<img src="'.$url [$i]. '" class="img-responsive" style="max-height: '. $currentInfo['sliderHeight'].'px;min-height: '. $currentInfo['sliderHeight'].'px;float:left;">
                                                        <h1>'. $insertTitle. '</h1>
                                                        <p  style="font-size: 24px; vertical-align: align: left; bottom;min-height: '. $imgHeight.'px;">'.$des [$i].'</p>
                                             </div>
                                        </div>';
        }
 
        $thumbClass     	= '';
        if ($prog==0) {
                $thumbClass         ='class="selected"';
                    
        }; 
        $thumbsItem     	= $thumbsItem.'
                                <li>'.'<a id="carousel-selector-'.$prog.'"' . $thumbClass .'>'.'<img src="'. $url [$i].'" class="img-responsive"></a></li>';
				
        $prog                   =  $prog + 1; 
        $insertTitle            = '';
		
       
    }
    $out            =  $out	. $startContainer_carousel 
				. $carouselItem
				. $stopCarousel 
				. $startThumbsNavigation 
				. $thumbsItem 
				. $stopThumbsNav_container_Script; 
   

?>

