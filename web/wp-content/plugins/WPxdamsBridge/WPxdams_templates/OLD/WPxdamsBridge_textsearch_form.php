<?php
/*
  simple template for search form - use $out to build HTML
*/
        
		if ($inputFields['fulltextsearch']) {
			$inputValue	=$inputFields['fulltextsearch'];
		}
		$archiveLabel 		= WPxdamsBridge_getCurrentArchiveDesc();	
		
		$out		= 	'<div class="wrap">'.
						'<h2>'  .' '.$archiveLabel.'</h2>
						<form id="xDamsSearchForm" name="WPxdamsBridge_search" action="" method="post" >
						
					    <fieldset class="options">   '   ;   
		$out		= $out . '	
								<input type="text" name="c_xdamfield_WPxdamsBridge_fulltextsearch" style="width: 500px;" value="'.$inputValue.'" /> ' 
								;	  
		$out		= $out . '	  
						</fieldset>
						<br>
						<p class="submit">
							<input type="submit" name="WPxdamsBridge_submit_button" value="search" />
						</p> 
						
						
						
					</form> 
				</div>';


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
