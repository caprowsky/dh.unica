<?php
/*
 functions to manage admin panel
*/


{

	$fileName	= 'WPxdamsBridge/WPxdams_custom/savedsettings.json';
        $result         = WPxdamsBridge_loadSettings ($fileName);
        $count          =  $result['results_number'][0];
        if($count<1) {
            $out        = '<p><strong>Sorry no file to import!</strong></p>';
        } else {
            $out        = 'total number of rows: '.$count.'/'.  $result ['rows'][0];
            $buttom     = '
							<p class="submit">
								<input type="submit" name="WPxdamsBridge_submit_button_import2" value="Import" />
							</p> ';
        }    
       
       
        for($i2=0;$i2<$count;$i2++) {
          //  $out        = $out. $result['option_name'][$i2].'/'.$result['option_name'][$i2].'<br>';
              $out= $out.'<tr><td>'. $result['option_name'][$i2].' </td><td> '.$result['option_value'][$i2].' </td><tr>';
        }
        $out= '<table>'.$out.'</table>';
	$importLink     =  '<a href="admin.php?page=WPxdamsBridge_import_from_config"> import saved settings from config files</a>'; 
	$exportLink	=  '<a href="admin.php?page=WPxdamsBridge_export_settings"> export saved settings </a>';  	
	
        $stamp 	 	= '<div class="wrap">
						<h2>Import Already DB Saved Settings from a File</h2>
						<form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
							<p>By this page it\'s possibile to import settings data already stored in the database and downloaded in a file</p> '.
                                                            'You can also '.$importLink	.	' or '. $exportLink		.
							'<fieldset class="options"><br>'.              					 
								'<input type="hidden" name="c_xdams_importFileName" value="'.$fileName	.'" /><strong>Source File: </strong>'.$fileName.
						   '</fieldset>';
	$stamp = $stamp.$buttom;
	$stamp = $stamp.'	</div>'.$out
  ;
 	
  
	  
    print($stamp);	
		
}


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>


