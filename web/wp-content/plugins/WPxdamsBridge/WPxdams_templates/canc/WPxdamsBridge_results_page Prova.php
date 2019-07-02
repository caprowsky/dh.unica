<?php		


	global $WPxdamsBridge_cCounter;
	global $archivesConfig;
	global $currentInfo;
	global $element;
	$Nodes = array();


	$archivesConfig 	= WPxdamsBridge_get_archives_config();
	
	$file = "http://hosting.xdams.org/xDams-labs/rest/polovt/archivioprovincialemsxDamsPhoto/4e82abc9b6844bf54edb8f34254c30c3?xsltType=result&id=IT-xDams-archivioprovincialems-FT0001-000001";
	$file = "http://hosting.xdams.org/xDams-labs/rest/polovt/archivioprovincialemsxDamsPhoto/4e82abc9b6844bf54edb8f34254c30c3?xsltType=result&id=IT-xDams-archivioprovincialems-FT0001-000017";




	WPxdamsBridge_resetGetElement ();
$Nodes = WPxdamsBridge_importFileToArray ($file);
if ($Nodes == false) {
	die("could not open XML input");
}
$count= count($Nodes) - 1;
$outItem = $outItem . '<br>  trovato   '.$currentInfo ['numItem']. ' pagina '.$currentInfo ['numPage']. ' tot pagina '. $currentInfo ['totPage'];

$currentInfo ['archiveId']		= $type;	

// Gets infomation from tag siblings.
for ($i=0; $i<$count; $i++) {

    $currNode 	= $Nodes[$i] ;
	
	$outItem2 	= WPxdamsBridge_parseCompleteXML($type,  $currNode ) ;

} 
$outItem  		= 'nodi='.$count.'<br>'.$outItem;
include ('WPxdamsBridge_item_page2.php');

	        $outItem  		= $outItem.$out;	
		
/*  **************************************************
      this is the end....
    **************************************************
*/		
	