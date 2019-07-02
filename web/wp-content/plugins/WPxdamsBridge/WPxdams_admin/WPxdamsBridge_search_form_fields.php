<?php
/*
 functions to manage search form fields settings NEW THE PAGE NOW IS ARCHIVE SETTINGS
*/

  $archiveId            = WPxdamsBridge_get_archive_id();
  $active               = (WPxdamsBridge_get_option('active',$archiveId) == 1) ? 'checked' : '';
  $deactive             = (WPxdamsBridge_get_option('active',$archiveId) == 0) ? 'checked' : '';
  
  $allRecordsActive     = (WPxdamsBridge_get_option('allRecords',$archiveId) == 1) ? 'checked' : '';
  $allRecordsDeactive   = (WPxdamsBridge_get_option('allRecords',$archiveId) == 0) ? 'checked' : '';
  
  $previewOne           = (WPxdamsBridge_get_option('preview',$archiveId) == 1) ? 'checked' : '';
  $previewTwo           = (WPxdamsBridge_get_option('preview',$archiveId) == 2) ? 'checked' : '';
  $previewThree         = (WPxdamsBridge_get_option('preview',$archiveId) == 3) ? 'checked' : '';  
  $previewFour          = (WPxdamsBridge_get_option('preview',$archiveId) == 4) ? 'checked' : '';  
  $previewFive          = (WPxdamsBridge_get_option('preview',$archiveId) == 5) ? 'checked' : '';  
  
  $preview2One          = (WPxdamsBridge_get_option('preview2',$archiveId) == 1) ? 'checked' : '';
  $preview2Two          = (WPxdamsBridge_get_option('preview2',$archiveId) == 2) ? 'checked' : '';
  $preview2Three        = (WPxdamsBridge_get_option('preview2',$archiveId) == 3) ? 'checked' : '';  
  
  $customForm           = WPxdamsBridge_get_option('frm',$archiveId);
  $customPage           = WPxdamsBridge_get_option('pag',$archiveId);
  $customListPage	= WPxdamsBridge_get_option('listC',$archiveId);
  $customImgListPage	= WPxdamsBridge_get_option('list',$archiveId);
  $customAllListPage	= WPxdamsBridge_get_option('alllist',$archiveId);
 
  $hierDescPrefix       = WPxdamsBridge_get_option('Hprefix',$archiveId);
  $hierDescPre          = WPxdamsBridge_get_option('Hpre',$archiveId);
  $hierDescPost         = WPxdamsBridge_get_option('Hpost',$archiveId);
  $hierDesc             = WPxdamsBridge_get_option('Hdesc',$archiveId);
  
  
  $hierField1Pre        = WPxdamsBridge_get_option('Hfld1Pr',$archiveId);
  $hierField1Post       = WPxdamsBridge_get_option('Hfld1Po',$archiveId);
  $hierField2Pre        = WPxdamsBridge_get_option('Hfld2Pr',$archiveId);
  $hierField2Post       = WPxdamsBridge_get_option('Hfld2Po',$archiveId);
  $hierDelimiter1       = WPxdamsBridge_get_option('Hdel1',$archiveId);
  $hierDelimiter2       = WPxdamsBridge_get_option('Hdel2',$archiveId);
        
  $archiveLabel         = WPxdamsBridge_get_archive_desc($archiveId);
  $xDamsFields          = WPxdamsBridge_get_fields_list($archiveId );
  
  $count                = $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0]; //number of different items of all archives -non serve???
  $count2               = $archivesConfig ['WPxdamsBridge_archivesNumber'][0]; // number of archives
  $archivesList         = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives
  
  
    for($i=0;$i<$count;$i++) {
      	
	if ($i==0) { 
            $menuItems  = '<br><br>Please configure your publishing forms for '.$archiveLabel.' :';
    
        } 
        if ($archiveId == $archivesConfig ['father'][$i] ) { 
                $menuItems=  $menuItems. $separator .
		'<a href="admin.php?page=WPxdamsBridge_configure_output_fields_'.$archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i].'"> '
		.' '.stripslashes($archivesConfig ['label'][$i]).'  </a>';
                $separator		= '  -  ';
        }	
  }
  
 

  for($i=0;$i<$count2;$i++) {
   
	$currentArchive	= 'archivio'; //?
	$separator		= '  -  ';
	if ($i==0) { $separator= 'You can also configure: ';};
		$menuArchives=  $menuArchives. $separator .
		'<a href="admin.php?page=WPxdamsBridge_configure_archive_settings_'.$archivesList ['id'][$i].'"> '.stripslashes($archivesList ['label'][$i]).'  </a>';
  }	
  
  $count		= $xDamsFields ['metadata'][1] ;// number of available fields
  $i			=1;


  $before		= 
	'<div class="wrap">		
	     
         <h2>Configure your archive settings for	'. $archiveLabel . ' </h2> '.	 
		   '<form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
            <p>By this page it\'s possible to configure your custom search fields among the available ones </p> 
			'.$menuArchives.'<br> '.
          $menuItems.
          ' <fieldset class="options">		   
		    <input type="hidden" id="c_fieldsNumber_WPxdamsBridge"name="c_fieldsNumber_WPxdamsBridge" value="'.$count.'"> 
                    <input type="hidden" id="c_fieldsNumber_WPxdamsBridge"name="c_archiveId_WPxdamsBridge" value="'.$archiveId.'"> 
				<table>  
                                        <tr> 
                                            <td><p>Activate?</p>
                                                <ul>
                                                    <li>
                                                        <input type="radio" name="c_active" value="1" id="c_active_yes" '.$active.' />
                                                        <label for="c_active_yes">Yes</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="c_active" value="0" id="c_active_no" '.$deactive.' />
                                                        <label for="c_active_no">No</label>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td><p>Publish all record?</p>
                                                <ul>
                                                    <li>
                                                        <input type="radio" name="c_allRecords" value="1" id="c_allRecords_yes" '.$allRecordsActive .' />
                                                        <label for="c_allRecords_yes">Yes</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="c_allRecords" value="0" id="c_allRecords_no" '.$allRecordsDeactive.' />
                                                        <label for="c_allRecords_no">No, only "public" selected</label>
                                                    </li>
                                                </ul> 
                                                
                                            </td>
                                            <td> </td>
                                        <tr> 
						<td> <br></td>
						<td> </td>
						<td>  </td>
					</tr>                                            
                                        <tr> 
						<td> Field Name</td>
						<td> Custom Label</td>
						<td style="width:70px;"> Active </td>
                                                <td style="width:70px;"> Delete </td>
					</tr>';
  
  
  
  $fields_options_from_db 	= get_option('WPxdamsBridge_search_fields_'.$archiveId);
  $count 			= get_option('WPxdamsBridge_fields_num_'.$archiveId);
  
  $fields_options_from_db 	= explode('%%%', $fields_options_from_db);
  
 
  
  for($i=0;$i<$count;$i++) {	
   $i1 = ($i ) * 3;
      
  //  $storedOptions =   WPxdamsBridge_search_form_options($xDamsFields ['name'][$i], $archiveId);
	$checkedString = "";
	if ($fields_options_from_db[$i1+2] =='1') {            
            $checkedString = "checked";
	}	
	$optionsTable  =   $optionsTable .          

			  ' 	<tr> 
			  			<td> 
							<input type="text" name="c_fieldName_WPxdamsBridge['.$i.']" value="'.$fields_options_from_db[$i1].'" />  
							 
						</td>'.
			/*			<td>
							<input type="hidden" name="c_fieldDesc_WPxdamsBridge['.$i.']" value="'.$xDamsFields ['label'][$i].'" />  '.
							$xDamsFields ['label'][$i].'
							
						</td>*/
						'<td> 
							<input type="text" name="c_fieldCustom_WPxdamsBridge['.$i.']" value="'.$fields_options_from_db[$i1+1].'" />  
						</td>
						<td> 
							<input type="checkbox" name="c_field_check_WPxdamsBridge['.$i.']"'. $checkedString. '  value="1"/>
						</td>
                                                <td> 
							<input type="checkbox" name="c_delete_check_WPxdamsBridge['.$i.']"'. $deleteString. '  value="1"/>
						</td>
					<tr> '
			  ;
  }			  
  $after		=
          '		</table> 
                        <p>you can build your custom search form in plugin dir/custom</p>              
                        <p><strong>CUSTOMIZE YOUR PAGES </strong> <br>(please leave blank for default or enter the name of custom php file)</p> 
                        <table><tr>
		            <td>         <p><strong>custom search form </strong> </p>
                                        <input type="text" name="c_xdamsfrm_WPxdamsBridge" value="'.$customForm.'" />
                            </td>
                            <td>         <p><strong>single item page</strong></p>
                                        <input type="text" name="c_xdamspage_WPxdamsBridge" value="'.$customPage.'" />
                            
                            </td>
                             <td>         <p><strong>multiarchives results page:</strong></p>
                                        <input type="text" name="c_xdamsalllistpage_WPxdamsBridge" value="'.$customAllListPage.'" /> 
                            </td>
                            <td>         <p><strong>results list page:</strong></p>
                                        <input type="text" name="c_xdamslistpage_WPxdamsBridge" value="'.$customListPage.'" /> 
                            </td>
                            <td>         <p><strong>results list page with images preview:</strong></p>
                                        <input type="text" name="c_xdamsimglistpage_WPxdamsBridge" value="'.$customImgListPage.'" /> 
                            </td>
						
			</tr></table>
			            <p>Preview mode in the results list, please print: </p>
               <ul>
                 <li>
                   <input type="radio" name="c_preview" value="1" id="c_preview_one" '.$previewOne.' />
                     <label for="c_preview_one">Only First Field (in config file) --> e.g. Title</label>
                </li>
                 
                <li>
                   <input type="radio" name="c_preview" value="2" id="c_preview_two" '.$previewTwo.' />
                     <label for="c_preview_two">First Field + Second Field (in config file) --> e.g. Title, Author </label>
                </li>
                <li>
                   <input type="radio" name="c_preview" value="3" id="c_preview_two" '.$previewThree.' />
                     <label for="c_preview_thee">First Field + Second Field (in config file) + Level --> e.g.[Level] Title, Author </label>
                 </li>
                <li>
                   <input type="radio" name="c_preview" value="4" id="c_preview_two" '.$previewFour.' />
                     <label for="c_preview_four">First 3 Fields </label>
                 </li>                <li>
                   <input type="radio" name="c_preview" value="5" id="c_preview_two" '.$previewFive.' />
                     <label for="c_preview_five">First 4 Fields  </label>
                 </li>                 
               </ul>
                            
			
		  </fieldset>
'	  ;
  
    			  
  $after2		=
          '		</table> 
                                  
                        <p><strong>Customize Hierarchy Preview in Item Page </strong> <br></p> 
                        
			<p>in the item page please print: </p>
                        <ul>
                            <li>
                                <input type="radio" name="c_preview2" value="1" id="c_preview2_one" '.$preview2One.' />
                                <label for="c_preview_one">No Hierarchy</label>
                            </li>
                            <li>
                                <input type="radio" name="c_preview2" value="2" id="c_preview2_two" '.$preview2Two.' />
                                <label for="c_preview_two">Only Field 1 --> e.g. title </label>
                            </li>
                            <li>
                                <input type="radio" name="c_preview2" value="3" id="c_preview2_two" '.$preview2Three.' />
                                <label for="c_preview_thee">Field 1 + Field 2 --> e.g. title [Level] </label>
                            </li>
                        </ul>

                        <table>
                          <tr>		            
                            <td>         <p><strong>Description</strong> </p>
                                        <input type="text" name="c_xdams_hier_desc" value="'.$hierDesc.'" />
                            </td>                            
                            <td>         <p><strong>Level prefix</strong></p>
                                        <input type="text" name="c_xdams_hier_prefix" value="'.$hierDescPrefix.'" /> 
                            </td>
                            <td>         <p><strong>Description pre</strong></p>
                                        <input type="text" name="c_xdams_hier_desc_pre" value="'.$hierDescPre.'" /> 
                            </td>
                            <td>         <p><strong>Description post</strong></p>
                                        <input type="text" name="c_xdams_hier_desc_post" value="'.$hierDescPost.'" /> 
                            </td>                            
			  </tr>
                          <tr>
                             
		            <td>         <p><strong>Between fields 1 and 2</strong> </p>
                                        <input type="text" name="c_xdams_hier_delimiter1" value="'.$hierDelimiter1.'" />
                            </td>		            
                            <td>         <p><strong>At the end of the hier level</strong> </p>
                                        <input type="text" name="c_xdams_hier_delimiter2" value="'.$hierDelimiter2.'" />
                            </td>  <td> </td>  <td> </td>		            

                          </tr>                          
                          
                        </table>   
  
			
		  </fieldset>
'	  ;
  
   $hierConfig  = WPxdamsBridge_getHierStandardConfig();
   $hierString  = '<br> <p> <strong>Hierarchy options for visualization </strong>(based on the open source standard distribution)<p>
                        <p> For a standard usage please select only the archive type option. Advanced users can describe
                            the 2 delimiters between which there is the value to show (see advanced manual)<p>
                     <table> 
                        <tr>       
                            <td style="width:180px;">  <strong>Archive type </strong></td>
                            <td>  <strong>Delimiter of Field 1 (pre)</strong></td>
                            <td>  <strong>Delimiter of Field 1 (post)</strong> </td>
                            <td>  <strong>Delimiter of Field 2 (pre)</strong></td>
                            <td>  <strong>Delimiter of Field 2 (post)</strong></td>
                         </tr></strong>

';

 
    if (WPxdamsBridge_get_option('preview3',$archiveId) == 0) {
        $preview3[0] = 'checked';
    }
    for($i=1;$i<=$hierConfig ['count'];$i++) {
        $preview3[$i]   = (WPxdamsBridge_get_option('preview3',$archiveId) == $i) ? 'checked' : '';
        
        $hierString     =  $hierString .'
                         <tr>
                            <td> '.'<input type="radio" name="c_preview3" value="'.$i.'" id="c_preview3_'.$i.'" '.$preview3[$i].' /> '.
                                    $hierConfig [$i]['desc'] .'</td>
                               
                            <td> '.$hierConfig [$i]['pre1'] . '</td>
                            <td> '. $hierConfig [$i]['post1']  . '</td>
                            <td> '. $hierConfig [$i]['pre2']  . '</td>
                            <td> '.$hierConfig [$i]['post2'] . '</td>
                         </tr>
                    ';
        
    }
   
    $hierString =  $hierString .'
                       <tr>
                             <td> <input type="radio" name="c_preview3" value="0" id="c_preview3_0" '.$preview3[0].' />  custom </td>
		            <td>         
                                        <input type="text" name="c_xdams_hier_field1_pre" value="'.$hierField1Pre.'" />
                            </td>		            
                            <td>         
                                        <input type="text" name="c_xdams_hier_field1_post" value="'.$hierField1Post.'" />
                            </td>		            
                            <td>        
                                        <input type="text" name="c_xdams_hier_field2_pre" value="'.$hierField2Pre.'" />
                            </td>                            
                            <td>        
                                        <input type="text" name="c_xdams_hier_field2_post" value="'.$hierField2Post.'" />
                            </td>
                          </tr> 
 
                        <table>  ';
        
  
   $afterSubmit		=
          '
           <p class="submit">
           to save modified data<br>
	    <input type="submit" name="WPxdamsBridge_submit_button2" value="Update Settings" />
	   </p>                   
           <p class="submit">
            to save modified data and add a new field<br>
	    <input type="submit" name="WPxdamsBridge_submit_button2b" value="Update and Add" />
	   </p> '.
	     "Use shortcode [xdamsSearch type='". $archiveId."']".
	  '</form> 
	  </div>
	  <div>'	  ;


    print ($before . $optionsTable . $after.  $after2.$hierString. $afterSubmit);


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
