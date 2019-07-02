<?php
/*
 functions to manage admin panel
*/


{
global $wpdb;
	$fileName           = 'WPxdamsBridge/WPxdams_custom/savedsettings.json';
	$importLink         =  '<a href="admin.php?page=WPxdamsBridge_import_from_config"> import settings from the config files</a>'; 
        $importLink2        =  '<a href="admin.php?page=WPxdamsBridge_import_settings"> import saved settings from exported files</a>'; 
	
	$stamp              = '<div class="wrap">
						<h2>Export DB Saved Settings in a File</h2>
						<form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
							<p>By this page it\'s possibile to export settings data already stored in the database </p> '.
                                                            'You can also '.$importLink	.' or '. $importLink2.	
							'<fieldset class="options"><br>'.              					 
								'<input type="hidden" name="c_xdams_exportFileName" value="'.$fileName	.'" /><strong>Destination file: </strong>'.$fileName.
						   '</fieldset>';
	$stamp = $stamp.      '
							<p class="submit">
								<input type="submit" name="WPxdamsBridge_submit_button_export" value="Export" />
							</p> ';
	$stamp = $stamp. 			
                            '</div>'
  ;
 	
        $results = $wpdb->get_results( 
                "
                    SELECT *
                    FROM $wpdb->options
                    WHERE 
                        option_name like 'WPxdamsBridge_%' 
                "
        );

        foreach ( $results as $result ) {
	
            $out= $out.'<tr><td>'. ($result->option_name).' </td><td> '.($result->option_value).' </td><tr>';
        
        }
	  
        print($stamp);	
	echo ('<table>'.$out.'</table>');	
}


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>


