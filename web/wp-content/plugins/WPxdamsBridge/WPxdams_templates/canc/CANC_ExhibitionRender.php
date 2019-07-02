<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $exhibitionId =  trim($content);	

    $start  = '<div id="exhibitionContainer">
                <ul id="exhitionSlider">';
    
    
    
    $end    = 	'</ul>
               </div>';
/*
  for($i=1;$i<7+1;$i++) {	
      
       $toSplit         = get_option('WPxdamsBridge_exhibitions_'.$exhibitionId.'_'.$i);
       $temp            = explode('%%%', $toSplit);
       $url             = $temp [0];
       $des             = $temp [1];
       
       
       $field           = 'WPxdamsBridge_exhibitions_'.$exhibitionId.'_'.$i;
       $slide           = $slide. ' 
                                  <li id="slide'.$i.'"><a href="#"><img src="'.$url.'"/></h5>'.$des.'</h5></a></li>
                         ';
       
   }    
 */  
     for($i=1;$i<7+1;$i++) {	
      
       $toSplit         = get_option('WPxdamsBridge_exhibitions_'.$exhibitionId.'_'.$i);
       $temp            = explode('%%%', $toSplit);
       $url             = $temp [0];
       $des             = $temp [1];
       
       
       $field           = 'WPxdamsBridge_exhibitions_'.$exhibitionId.'_'.$i;
       $slide           = $slide. ' 
                                  <li id="slide'.$i.'"><a href="#"><img src="'.$url.'"/></h5>'.$des.'</h5></a></li>
                         ';
       
   } 
    
   $outItem             = $start.$slide.$end;
/*       
       
       <div id="exhibitionContainer">
	<ul id="exhitionSlider">
		<li id="slide1"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001015.jpg"/><h5>Apple Store in milan and every body sing a song for the Lord, every body sing a song for the Lord, every body sing a song for the Lord</h5></a></li>
		<li id="slide2"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001017.jpg"/><h5>Chilling</h5></a></li>
		<li id="slide3"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001018.jpg"/><h5>Bicycle path</h5></a></li>
		<li id="slide4"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001020.jpg"/><h5>Skate Park</h5></a></li>
		<li id="slide5"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001025.jpg"/><h5>Club</h5></a></li>
		<li id="slide6"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001032.jpg"/><h5>Red Lights</h5></a></li>
		<li id="slide7"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001052.jpg"/><h5>Graffiti</h5></a></li>
	</ul>
</div>
     
	<div id="exhibitionContainer">
            <ul id="exhitionSlider">
 *              <li id="slide1"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001015.jpg"/></h5>2</h5></a></li>
 *              <li id="slide1"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001017.jpg"/></h5>3</h5></a></li>
 *              <li id="slide1"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001018.jpg"/></h5>5</h5></a></li>
 *              <li id="slide1"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001020.jpg"/></h5></h5></a></li>
 *              <li id="slide1"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001032.jpg"/></h5>8</h5></a></li>
 *              <li id="slide1"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001025.jpg"/></h5>10</h5></a></li>
 *              <li id="slide1"><a href="#"><img src="http://media.regesta.com/xDamsMedia/imageViewPort/xDams.org/xDams.org/archivioprovincialemsxDamsPhoto/0?imageName=/high//inv.%20001052.jpg"/></h5></h5></a></li>
 *      </ul>
               </div>
 * 
 * 
 * 
 * 
 * 
 * 
 * 
**/
       ?>