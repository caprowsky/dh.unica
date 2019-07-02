

<?php


    $storyId    		= trim($content);
    $backgroundImgUrl 		= get_option('WPxdamsBridge_backgroundImgUrl_'.$storyId);
    $storyTitle                 = get_option('WPxdamsBridge_storyTitle_'.$storyId);
    $slidesNumber               = get_option('WPxdamsBridge_story_fieldsNumber_'.$storyId); // number of archives;
       
    
    // mage the dimension depending by slides number
    if ($slidesNumber <= 10) {
        $totalWidth             = 550;
        $slideWidth             = 9.50;
    } else {
        $additionalSlides       = $slidesNumber - 10;
        $totalWidth             = 550+($additionalSlides*70);
        
        $availableSpace         = 95 - (0.5* $slidesNumber); 
        $slideWidth             =  $availableSpace/$slidesNumber;
        
    }
    
    $JS                         = WPxdamsBridge_getSliderJS($slideWidth);
       
    $first = '<div id="xdamsStory" style="background-image: url('. $backgroundImgUrl .')">
                      <h4>'.  $storyTitle.' </h4>
	            <div id="storyContainer">
                    
                       <ul id="exhitionSlider" style="width:'.$totalWidth.'%;">
                       
              ';
    $last = '	      </ul>
				</div>
           </div>'.$slideWidth;

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
       
       $outList               = $outList.'
							<li id="slide'.$i.'"  style="width:'.$slideWidth.'%;" ><a href="#"><img src="'.$url[$i] .'"/><h5>'.$des [$i].'</h5></a></li>
                            ';
     
       
   }
   
   $out = $JS.$first.$outList.$last;

?>

