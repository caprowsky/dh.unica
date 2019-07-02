<?php		
/*
  simple template for results page breadcrumbs
  
  WPxdamsBridge_getNewRequestURL() = url including first two parameter: type of archibve and paging 
  
*/
		$outBreadcrumbs			= ' '.'<br>';
		$newpage		= WPxdamsBridge_getNewRequestURL();		
						
		if (WPxdamsBridge_isARequestForAllArchives()) {
			$outBreadcrumbs		= $outBreadcrumbs. '<a href="'.WPxdamsBridge_getWPPageURL().  '"> Tutti gli Archivi</a>'; // add level 'all archives' to breadcrumbs
		}
                if($currentInfo['treestartlevel']){
                    $archiveLabel       = WPxdamsBridge_getTreeLevelDescription(WPxdamsBridge_getCurrentArchiveId(), $currentInfo['treestartlevel']);
                 //   echo($currentInfo['treestartlevel']);
                } 
                
                $outBreadcrumbs			= $outBreadcrumbs.'> <a href="'.$newpage.  '">'.$archiveLabel.'</a>';  // add level 'current archive' to breadcrumbs
                
		if ($lastpage ) {
			
		    WPxdamsBridge_startTreeBreadcrumbsPublishing() ;
                    $text       = ' > ';
                    
                    while (WPxdamsBridge_existsNextTreeLevel()) {
                                $border = $border + 1;
			
			        $levelID = WPxdamsBridge_getNextTreeLevelId();
                                if ($levelID) {
                                    // echo('<br>....... '.$levelID);
                                    $description    = WPxdamsBridge_getTreeLevelDescription(WPxdamsBridge_getCurrentArchiveId(), $levelID);
                                    $text           = $text .' > ';
                                    $pathr          = $pathr . '&xdamsItem='.  $levelID ;
                                    $outBreadcrumbs            = $outBreadcrumbs.  '<br> '.$text.'<span class="xd-treelevel"> <a href="'.$newpage. '&archID='.WPxdamsBridge_getCurrentArchiveId().'&pageToShow=1'.$pathr. '">'. $description .'</a></span>'; //
                                }
                    }
                    $text       = $text .' > ';
                    
		}
                $currentInfo ['treeNavLevel']        = $pathr;
		$currentInfo ['breadcrumbs']        = $outBreadcrumbs;
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		