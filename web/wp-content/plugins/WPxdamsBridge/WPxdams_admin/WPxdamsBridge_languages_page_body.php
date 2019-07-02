<?php
/*
 functions to manage search form fields settings
*/



  // LOOP for archives that have to be configured beginning from general terms 

 $menuArchives                          =  'You can configure: ' .
		'<a href="admin.php?page=WPxdamsBridge_languages_general@"> Termini Generici  </a><br>';  

for($i=0;$i<$countArchives;$i++) {
   
    $currentArchive                     = 'archivio'; //?
    $separator                          = '  -  ';
    if ($i==0) { 
	$separator                      = '<br>Settings for Archives: ';
    }
    $menuArchives                       =  $menuArchives. $separator .
		'<a href="admin.php?page=WPxdamsBridge_languages_'.$archivesList ['id'][$i].'"> '.$archivesList ['label'][$i].'  </a>';
}	

// load search fields  and output fields
if ($archiveId !='general@') {
    include ('WPxdamsBridge_languages_archive.php')   ;
 } 
 
for  ($iCols=0;$iCols<$colsNumber;$iCols++) {
//	echo($iCols.$langs[$iCols].'<br>');
    $storedTerms[$iCols] = WPxdamsBridge_loadLanguage ($langs[$iCols], $archiveId);
}

 
sort($workArray);
$countTerms =    count($workArray);
$termsKey     = array_keys($workArray);

for($i=0;$i<$countTerms;$i++) {	
     $additionalCol         = '';
     if ($workArray[$i]) {
         $additionalCol         = '';
        if ($archiveId =='general@') {
            $additionalCol         =   '
                <td>'. $generalTerms[$workArray[$i]].'</td>';
            /*                '<td>'.  
                    '<input type=""text" id="c_mainvalue_WPxdamsBridge['.$i.']" name="c_mainvalue_WPxdamsBridge['.$i.']" value="'. $generalTerms[$workArray[$i]].'"/> '.
                '</td>'*/
        }   
        $optionsTable  =   $optionsTable .      
			  ' 	<tr>  
                                    <td> 
							'.$workArray[$i].'
                                                        <input type="hidden" id="c_langfield_WPxdamsBridge['.$i.']['.$iCols.']" name="c_langfield_WPxdamsBridge['.$i.']" value="'.$workArray[$i].'"/>    
						</td>'. $additionalCol;
        for  ($iCols=0;$iCols<$colsNumber;$iCols++) {
            $term = $storedTerms[$iCols][$workArray[$i]];
            $optionsTable  =   $optionsTable .'
						<td> 
                                                    <input type=""text" id="c_langvalue_WPxdamsBridge['.$i.']['.$iCols.']" name="c_langvalue_WPxdamsBridge['.$i.']['.$iCols.']" value="'.$term.'"/>            
						</td>';
        }               
      
        $optionsTable  =   $optionsTable .'
                			</tr> ';
    }
}
if ($archiveId =='general@') {	
	$addNewLanguage =  '
               <p class="submit">
                    <input type="submit" name="WPxdamsBridge_submit_buttonADDLANG" value="ADD A NEW LANGUAGE" />
                </p>
                    <fieldset class="options">';
}  
$before		= 
	'<div class="wrap">		
	    <br>
            <h2>Translate Your Terms for '. $archiveLabel . ' </h2> '.	 
            '<form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
                    <p>By this page it\'s possible to configure your custom search fields among the available ones </p> 
			'.$menuArchives.'<br> 
            '.$addNewLanguage.'
			<fieldset class="options">	
			<input type="hidden" id="c_languagesNumber_WPxdamsBridge"name="c_languagesNumber_WPxdamsBridge" value="'.$colsNumber.'"> 
			<input type="hidden" id="c_archiveId_WPxdamsBridge" name="c_archiveId_WPxdamsBridge" value="'.$archiveId.'"> 
                        <input type="hidden" id="c_fieldsNumber_WPxdamsBridge" name="c_fieldsNumber_WPxdamsBridge" value="'.$countTerms.'">    
			<br>
			<table>    
					<tr> 
						<td><strong>Languages</strong></td>';
if ($archiveId =='general@') {
    $before         =   $before.'
        <td> Main Language </td>';
}

for  ($iCols=0;$iCols<$colsNumber;$iCols++) {
    $before         =   $before.'
						<td> <input type=""text" style="width:70px" name="c_language_WPxdamsBridge['.$iCols.']" value="'.$langs[$iCols].'"/></td>';
}    
$before         =   $before.'
					</tr>
					<tr> 
						<td><br><strong>Message ID</strong></td>';
						
//  fase 1 --------------------------------------------------------------------------------------------------------------------						
						
						
if ($archiveId =='general@') {
    $before         =   $before.'
        <td><br><strong>Label</strong> </td>';
}
for  ($iCols=0;$iCols<$colsNumber;$iCols++) {
    $before         =   $before.'       
						<td><br><strong>Translation</strong> </td>';
}            

$before         =   $before.'					
					</tr>'; 
$after		=
          '		  </table> 
                      </fieldset>'
					  . $warning .'
                      <p class="submit">
                      <input type="submit" name="WPxdamsBridge_submit_buttonSAVELANG" value="Update Settings" />
                      </p>
                </form>
	  </div>
     <div>'	  ;
  
// fine fase 1 -------------------------------------------------------------------------------------------------------------


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
