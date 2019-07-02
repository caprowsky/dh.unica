

<?php


    $exhibitionId    		= trim($content);
    $backgroundImgUrl 		= get_option('WPxdamsBridge_backgroundImgUrl_'.$exhibitionId);
    $exhibitionTitle		= get_option('WPxdamsBridge_exhibitionTitle_'.$exhibitionId);
    $slidesNumber               = get_option('WPxdamsBridge_exhibitions_fieldsNumber_'.$exhibitionId); // number of archives;
       
    
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
       
    $first = '<div id="xdamsExhibition" style="background-image: url('. $backgroundImgUrl .')">
                      <h4>'.  $exhibitionTitle.' </h4>
	            <div id="exhibitionContainer">
                    
                       <ul id="exhitionSlider" style="width:'.$totalWidth.'%;">
                       
              ';
    $last = '	      </ul>
				</div>
           </div>'.$slideWidth;

    for($i=1;$i<=$slidesNumber   ;$i++) {	
   
       $toSplit             = get_option('WPxdamsBridge_exhibitions_'.$exhibitionId.'_'.$i);
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

