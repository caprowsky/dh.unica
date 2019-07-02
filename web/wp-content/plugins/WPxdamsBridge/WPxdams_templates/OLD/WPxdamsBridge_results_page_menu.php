<?php		
/*
  simple template for results page nav menu
*/


	$newpage		= WPxdamsBridge_getNewRequestURL();
	$newpage		= WPxdamsBridge_getWPPageURL().'?';	
	$numItem		= WPxdamsBridge_getTotalResultItems()   ;   // total number of result items
	$numPage		= WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
	$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
	$separ			= "...";
	$separ2			= "...";
	$navParam		= WPxdamsBridge_getNavParam() ;	
	$archIDparam            = 'archID='.$archiveId;
	
			
// navigation menu   previous page  Pw4yvzkQrr%Y)V)b
		
    $picToShow              = (($numPage -1 ) * 10 )+ 1;
    $imgUrl                 = plugins_url();
 //   $viewType               = '&viewType=xdamsListImg';
        
  //  $viewTypeSwapOn			= '<div id="xdamsNavMenuBlockR" class="xdamsNavMenuBlock"><a href="'.$newpage.'&pageToShow='.$numPage. '&picToShow='.$picToShow .'&viewType=xdamsSlider" title="preview mode"><img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/preview.jpg"></a></div>';
  //  $viewTypeSwapOff        = ' <div id="xdamsNavMenuBlock" class="xdamsNavMenuBlock">    <img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/table_no.jpg"> </div>';
        
    $navParam               = $navParam .   $viewType  ;
	
	$lastPage				= '<a href="'.$newpage.$archIDparam.'&pageToShow='.$totPage. $navParam.'">'.$totPage.'</a><br>';
	
	if ($numPage > 1) {
	    $ppre   			= $numPage - 1;;
		$pre				= '<a href="'.$newpage.$archIDparam.'&pageToShow='.$ppre.$navParam.'">'.$ppre.'</a>';
		if ($numPage > 2) {
            if ($numPage == 3) {
				$separ2		= " ";
            }
            $pre			= '<a href="'.$newpage.$archIDparam.'&pageToShow=1'.$navParam.'">1</a>'.$separ2.$pre	;
		}
	}	
	
//	next page
	if ($numPage < $totPage  ) {
	     $ppost		= $numPage + 1;	
	     $post		= '<a href="'.$newpage.$archIDparam.'&pageToShow='.$ppost . $navParam.'">'.$ppost.'</a>';
	}
        
	if ($numPage == $totPage || $ppost ==  $totPage) {
	     $lastPage	="";
		 $separ		="";
	}
             			
	$out			= $out.'<div id="xdamsNavMenu" class="xdamsNavMenu">';
    $out			= $out.'' . '<div id="xdamsNavMenuBlock0"  class="xdamsNavMenuBlock">numero occorrenze totali: '.$numItem.'<br>pagine: '.$pre.' '.$numPage. ' ' .$post.$separ.$lastPage.'</div>';
    $out			= $out.'' . $viewTypeSwapOn.$viewTypeSwapOff.'</div><br><br><br><br>';
			
		
		
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		