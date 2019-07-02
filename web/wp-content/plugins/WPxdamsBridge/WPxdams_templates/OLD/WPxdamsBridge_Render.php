

<?php


     $exhibitionId    		= trim($content);
	 $backgroundImgUrl 		= get_option('WPxdamsBridge_backgroundImgUrl_'.$exhibitionId);
       
    // global $url;
	 
     
     $first = '<div id="xdamsExhibition" style="background-image: url('. $backgroundImgUrl .')">
	            <div id="exhibitionContainer">
                    <ul id="exhitionSlider">
              ';
     $last = '	      </ul>
				</div>
           </div>';

for($i=1;$i<7+1;$i++) {	
  
  //  $storedOptions =   WPxdamsBridge_search_form_options($xDamsFields ['name'][$i], $archiveId);
      
       $toSplit         = get_option('WPxdamsBridge_exhibitions_'.$exhibitionId.'_'.$i);
       $temp            = explode('%%%', $toSplit);
       
       
       
       $elementId       = $temp [0];
       $des [$i]        = $temp [1];
       $archId [$i]     = $temp [2];
       
       if ($archId [$i]) {
           $result      = WPxdamsBridge_single_item_request ( $elementId, $archId [$i]);
           $url [$i]    = WPxdamsBridge_getMediaFileURL(); 
       } else {
            $url [$i]   = $elementId;
       }
       
       $outList               = $outList.'
							<li id="slide'.$i.'"><a href="#"><img src="'.$url[$i] .'"/><h5>'.$des [$i].'</h5></a></li>
                            ';
       
       
       
       
   }
   
   
   $out = $first.$outList.$last;

?>

