<?php		
/*
  simple template for results page nav menu
*/


	$newpage		= WPxdamsBridge_getNewRequestURL();
 	$numItem		= WPxdamsBridge_getTotalResultItems()   ;   // total number of result items
	$numPage		= WPxdamsBridge_getCurrentResultPage()  ;    // number of current page
	$totPage		= WPxdamsBridge_getTotalResultPages()   ;    // total number of pages
	$separ			= "...";
	$separ2			= "...";
	$navParam		= WPxdamsBridge_getNavParam() ;	
	$archIDparam    = 'archID='.$archiveId;
	if (strpos($newpage, 'archID=')) {
		$archIDparam     = "";                               // archID already present in the request
	}
			
// navigation menu   previous page
		
    $picToShow              = (($numPage -1 ) * 10 )+ 1;
	
							=	WPxdamsBridge_getPicToShowForSwapping();
	
    $imgUrl                 = plugins_url();
    $viewType               = '&viewType=xdamsListImg';
        
    $viewTypeSwapOn			= '<div id="xdamsNavMenuBlockR" class="xdamsNavMenuBlock"><a href="'.$newpage.$archIDparam.'&pageToShow='.$numPage. '&picToShow='.$picToShow .'&viewType=xdamsPreview" title="preview mode"><img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/preview.jpg"></a></div>';
    $viewTypeSwapOff        = ' <div id="xdamsNavMenuBlock" class="xdamsNavMenuBlock">    <img src="'.$imgUrl .'/WPxdamsBridge/WPxdams_templates/img/table_no.jpg"> </div>';
        
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
    $out			= $out.'' . $viewTypeSwapOn.$viewTypeSwapOff.'</div>';
			
		
	// $out			= $out.	'<br><br><br><br><br>wwwwwwwwww'.$newpage ."ssssssssssssss".$navParam .'llllll';
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		