<?php
/*
 functions to manage admin panel
*/


{
 
    $count		= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];
    $count2		= $archivesConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives
    $archivesList       = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives
    
 
  
    $mainLanguage         = WPxdamsBridge_get_option('mlang');
    if(!$mainLanguage) {
      $mainLanguage='it_IT';
    }
  
    $ArchivesURLS           = $ArchivesURLS.' ';

    for($i=0;$i<$count2;$i++) {  //prepare link to configure search and to set url and password 
   
	$currentArchive	= 'archivio'; //?
	$separator		= '  <br>  ';
	$xdamsxOutOut= ' transformation:';
	
 
		
        if (!$archivesConfig['WPxdamsBridge_updateAllConfiguration'][0]=='yes') {   // first installation case
            $menuArchives=  $menuArchives. $separator .
                '<a href="admin.php?page=WPxdamsBridge_createtree_'.$archivesList ['id'][$i].'"> '.stripslashes($archivesList ['label'][$i]).'  </a>';  
        } else {
            $menuArchives=   "before continuining please save general settings";
        }
            


  }	

	
 	
 
  $stamp = '
             <div class="wrap">'.
                '<h2>WP to xDams Bridge Create Tree Index </h2>
                <form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
                    <p>By this page it\'s possibile to create an index that enable tree navigation</p> 
                    <fieldset class="options">'.$menuArchives. 
                 '
                    </fieldset>
                </form> 
            </div>';


	
	  
    print($stamp);	
		
}


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
