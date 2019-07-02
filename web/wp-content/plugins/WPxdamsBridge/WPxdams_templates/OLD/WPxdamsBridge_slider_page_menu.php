<?php		
/*
  simple template for results page nav menu
*/

/*
	$newpage		= WPxdamsBridge_getNewRequestURL();
	$newpage		= WPxdamsBridge_getWPPageURL().'?';	
	$numItem		= WPxdamsBridge_getTotalResultItems()   ;   // total number of result items
	$numPage		= WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
	$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
*/
        
        if ($picToShow  > 1) {
	    $picpre   	= $picToShow - 1;;
	}
        if ($picToShow  < $numItem) {
	    $picpost   	= $picToShow + 1;;
	}
        
        $picCurPage     = ($picToShow % 10) - 1;
        if ($picCurPage == -1) {
            $picCurPage = 9;
        }
        
        $pagepre   	= $numPage - 1;
        if ($picCurPage > 0) {
            $pagepre   	= $numPage;
        } 
        $pagepost	= $numPage + 1;	
        if ($picCurPage < 9) {
            $pagepost 	= $numPage;
        }
        
        if ($picpre) {
	    $out4	= $out4.' prec '.$picpre. ' pag '.$pagepre; //no
            $out3	= $out3. '<a href="'.$newpage.'&pageToShow='.$pagepre . '&picToShow='.$picpre.'&viewType=xdamsSlider">'.'PREV '.'</a> - ' ;
	} else {
             $out3	= $out3.'PREV - ';
        }
        
       
        if ($picpost) {
	    $out4	= $out4.' succ '.$picpost. ' pag '.$pagepost; //no 
            $out3	= $out3. '<a href="'.$newpage.'&pageToShow='.$pagepost . '&picToShow='.$picpost.'&viewType=xdamsSlider">'.'POST'.'</a>';
	}           

        $imgUrl                 = plugins_url();        
        $viewTypeSwapOff	= '<div id="xdamsNavMenuBlockR" class="xdamsNavMenuBlock"><a href="'.$newpage.'&pageToShow='.$numPage. '&picToShow='.$picToShow .'&viewType=xdamsListImg" title="table mode"><img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/table.jpg"></a></div>';
        $viewTypeSwapOn         = '<div id="xdamsNavMenuBlock" class="xdamsNavMenuBlock"> <img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/preview_no.jpg"></div>';
       
      //  $out5           = '<a href="'.$newpage.'&pageToShow='.$pagepost . '&viewType=xdamsListImg">'.'LIST '.'</a>';
     //   $out            = $out.$viewTypeSwap.'<br>';
      //  $out            = $out.$out3.'  -> foto '.$picToShow.' di '.$numItem.'  '.'<br>';
        
        $out                = $out.'<div id="xdamsNavMenu" class="xdamsNavMenu">';
        
        $out                = $out.'<div id="xdamsNavMenuBlock0"  class="xdamsNavMenuBlock">'.$out3.'  -> foto '.$picToShow.' di '.$numItem.'  '.'</div>';
        $out                = $out.'' . $viewTypeSwapOn.$viewTypeSwapOff.'</div>';
        

			
		
		
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		