<?php
/*
 functions to manage search form fields settings
*/

$archiveId                              = WPxdamsBridge_get_archive_id();

// echo (strtoupper(PHP_OS).'------'.DIRECTORY_SEPARATOR);
//  manage two different case general terms and terms for a specific archive
if ($archiveId =='general@') {
    
    $archiveLabel           = 'GENERAL TERMS';
    $generalTerms           = WPxdamsBridge_loadLanguage ('main', $archiveId);
    $countTerms             = count( $generalTerms);
    $termsKey               = array_keys($generalTerms);
       
    for($i=0;$i<$countTerms;$i++) {
       
// to invert value and key for general terms
        $switchArray[$generalTerms[$termsKey[$i]]] = $termsKey[$i];
        
      //  echo($termsKey[$i].'---------'.$generalTerms[$termsKey[$i]].'-<br>');
        if ($termsKey[$i] == '%%%error_code')    // there is not config file for general terms
            {
            $errorCode = $generalTerms[$termsKey[$i]];
            
         //   echo('errore code ---------'.$errorCode.'<br>');
        }
        if ($termsKey[$i] == '%%%errore file')
            {
            
            $errorMsg  = $generalTerms[$termsKey[$i]];
          //  echo('errore file ---------'.$errorMsg.'<br>');
        }
    }
    $workArray              = $switchArray;
 
   
} else {
    $archiveLabel           = WPxdamsBridge_get_archive_desc($archiveId);
    $xDamsFields            = WPxdamsBridge_get_fields_list($archiveId );   
}
//  to read archives and languages to manage (from mysql)
$countArchives              = $archivesConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives
$archivesList               = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives
$colsNumberOption           = WPxdamsBridge_get_option('langs', 'general@');


if (!$colsNumberOption) {
    $colsNumber             = 1;
} else {
    $langs                  = explode ('%%%', $colsNumberOption);
    $colsNumber             = count ($langs) - 1;
}

if ($errorCode) {
    $before = '<div class="wrap">		
                <br>
                    <h2>Translate Your Terms for '. $archiveLabel . ' </h2><br> '.	 
                        '<h4>Warning!!!!</h4> <br>a) Error number '.$errorCode. '<br><br>'.
                                'B) Error specification '.$errorMsg. '<br><br>'.
                                'Please verify your config folder'.
                        '</div>';
} else {
    include ('WPxdamsBridge_languages_page_body.php')  ;

}
    
print ( $before . $optionsTable . $after);
 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
