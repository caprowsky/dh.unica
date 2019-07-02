<?php		
/*
  simple template for results page
*/

		
	//include ('WPxdamsBridge_tree_page_breadcrumbs.php');
      
         
        $border     = $border *20;   // to create a left margin
        
        if($singleItem) {
    //        $resultsOut                = $resultsOut.'<div style="padding-left:'.$border.'px;">'. $singleItem.'</div>';
        }
        $resultsOut                    = $resultsOut.'';
		
//  ************ to publish the result list *******************

	if (WPxdamsBridge_searchHasResults()) {
            
            if($singleItem) {
           //     $furtherLevels      = '<h6 style="padding-left:'.$border.'px;">next level</h6>';
            }
            
            $Menu                   = ''. WPxdamsBridge_getPagingMenuBootstrap(0, 0).'';

            $resultsOut                    = $resultsOut . $furtherLevels. '<table>' ;
            
            WPxdamsBridge_startSearchResultsPublishing() ;
		
            while (WPxdamsBridge_existsNextResult()) {
            
                    $resultsOut  	=  $resultsOut.'
                                <tr>
                                   
                                    <!--td style="padding-left:'.$border.'px;"-->   
                                    <td style="padding-left:0;" class="link-to-item">
                                        <a href="'.$lastpage. $pageToShow .'&xdamsItem='.WPxdamsBridge_getNextResultID() . '&showdetails=yes" >'.WPxdamsBridge_getNextResult() .'</a>
                                    </td><!--td style="padding-left:10px;">
                                        <a href="'.$lastpage. $pageToShow .'&xdamsItem='.WPxdamsBridge_getNextResultID() . '&showdetails=yes" > [scheda]</a>
                                        <br>
                                    </td -->
                                </tr>';
				
            }
             $resultsOut                = $resultsOut .'</table>' ;
	} else {
         if($singleItem) {
            $resultsOut                = $resultsOut.'<div>'. $singleItem.'</div>';
            }           
        }
	
        $out                = $out. '<div class="abg-result-list-col-2">'.$Menu.''.$resultsOut.'</ul>'.$Menu.'</div></div>'; 
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>
