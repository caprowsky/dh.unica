<?php		
/*
  simple template for results page
*/
		
// 	$out 					= string which contains the html that will be published

		$newpage                = WPxdamsBridge_getNewRequestURL();
		$out                    ='';
                $language               ='';
                
//  to publish result list 

		if (WPxdamsBridge_searchHasResults()) 
                    {
                    
                    $Menu		= WPxdamsBridge_getPagingMenu();
					
                    WPxdamsBridge_startSearchResultsPublishing() ;
			
                    $out                =  '
                                    '.$Menu.'<br><br><br>
                                <div id="xdImgResultsPage" class="xdImgResultsPage">
                                    <div class="row"> ';
                    $col0               = '
                                        <div class="col-md-6"> 
                                            ';
                    $col1               = '
                                        <div class="col-md-6">
                                            ';
              
                    while (WPxdamsBridge_existsNextResult()) {
                        
                         $resultId      =  WPxdamsBridge_getNextResultID() ;
                         
                         if($resultId) {
                            $newItem    = '
                                            <div id="xdlistlinkImg" class="xdlistlinkImg"> 
                                                 <a href="'.$newpage.'&archID='.$archiveId.'&xdamsItem='.$resultId . $language.'">
                                                '.  WPxdamsBridge_getNextResultPreview('350').'<br>'.
                                                    WPxdamsBridge_getNextResult() .'
                                                </a>
                                            </div><br>';
                            switch($prog){
    
                                case 0:
                                     $col0  	=  $col0. $newItem;
                                break;
                                case 1:
                                     $col1  	=  $col1. $newItem;
                                break;
                            
                                default:
                                     $col1  	=  $col1. $newItem;
                                break;
                            }	                           
                            $prog 	=  $prog + 1; 
                            if ($prog > 1) {
				$prog 	=  0 ; 
                            }
                        }
                    }
                    
                    $out                =  $out.$col0.'
                                        </div>'.$col1.'
                                        </div>
                                    </div>
                                </div>'.$Menu;
			
              
		}
		 
		 
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
		
?>		