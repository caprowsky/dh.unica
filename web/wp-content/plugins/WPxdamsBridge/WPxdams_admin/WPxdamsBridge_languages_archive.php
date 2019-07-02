<?php
/*
 file included in wpxdamsbridge_languages. 
 it find all terms for a specific archive
 first step   = search form fields
 second step  = search output field for each kind of itemload
 * 
*/

 // loop for search field  
  
$countSearchFields                    = $xDamsFields ['metadata'][1] ;// number of available fields
$LOGsearchFieldsString = '<br><strong>CAMPI RICERCA</strong>';

for($i=0;$i<  $countSearchFields;$i++) {	
  
    $storedOptions                      = WPxdamsBridge_search_form_options($xDamsFields ['name'][$i], $archiveId);
    $workArray[$storedOptions['desc']]  = $storedOptions['desc']; 
    $LOGsearchFieldsString              = $LOGsearchFieldsString. '<br>' .$storedOptions['desc'] ;
	
}
  
  // loop for archives and inside loop for out put fields
$countAllArchivesItem                = $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];  //number of different items of all archives



for($i=0;$i< $countAllArchivesItem;$i++) {
      
        if ($archiveId   == $archivesConfig ['father'][$i] ) { 
           
            $separator =  ' <br><strong>'.$archivesConfig ['fatherDesc'][$i].' : </strong>';            
            $archiveLevId= $archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i];

            $LOGmenuArchives2           =  $LOGmenuArchives2. $separator .
		'<a href="admin.php?page=WPxdamsBridge_configure_output_fields_'.$archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i].'"> '
		.' '.$archivesConfig ['label'][$i].'  </a>';
                
            $archiveConfFile            = WPxdamsBridge_get_archivesItem_file($archiveLevId);  		// configuration file of an item of an archive
            $itemFields                 = WPxdamsBridge_get_item_metadata($archiveLevId , $archiveConfFile);
            $LOGitemFieldsString        = $LOGitemFieldsString. '<br><strong>' . $archiveLevId.'</strong>' ;
  
  // loop for output fields
            $fields_options_from_db     = get_option('WPxdamsBridge_output_fields_'.$archiveLevId);
            $count2                     = $itemFields ['metadata'][1] ;// number of available fields	
          
            for($i2=0;$i2<$count2;$i2++) {
                
                $storedOptions                      =   WPxdamsBridge_output_list_options($itemFields ['name'][$i2], $archiveLevId, $fields_options_from_db , $count2 );
                $LOGitemFieldsString                =  $LOGitemFieldsString. '<br>' .$storedOptions['desc'];
                
                $workArray[$storedOptions['desc']]  = $storedOptions['desc']; 
              
            }
            
               
       }
  }
  
  
  




 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
