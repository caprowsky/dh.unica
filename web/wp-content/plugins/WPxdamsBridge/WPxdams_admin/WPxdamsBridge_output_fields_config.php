<?php
/*
 functions to manage search form fields settings
*/

  $archiveLevId                 = WPxdamsBridge_get_archivesItem_id();
  
 
  $archiveLabel                 = WPxdamsBridge_get_archivesItem_desc($archiveLevId);  		// desc of an item of an archive
  $archiveConfFile              = WPxdamsBridge_get_archivesItem_file($archiveLevId);  		// configuration file of an item of an archive
  $xDamsFields                  = WPxdamsBridge_get_item_metadata($archiveLevId , $archiveConfFile);		// get field list
 
  $digitalMediaField            = WPxdamsBridge_get_archivesMediaFiles($archiveLevId);
  $digitalVideoField            = WPxdamsBridge_get_archivesVideoFiles($archiveLevId);
  
  if ($digitalMediaField) { $digitalMediaDesc =  '.img file in  ---> '.  '<input type="text" id="c_archiveMedia_WPxdamsBridge"name="c_archiveMedia_WPxdamsBridge" value="'.$digitalMediaField.'">' ;};
  if ($digitalVideoField) { $digitalVideoDesc =  '.video url in ---> '. $digitalVideoField;};

//  $xDamsFields 	= WPxdamsBridge_get_page_fields_list($archiveLevId );		// get field list
// to publish link to configuration page of any available archives  
  
  $count			= $archivesConfig ['WPxdamsBridge_archivesItemNumber'][0];

  for($i=0;$i<$count;$i++) {
   
//	$currentArchive	= 'archivio'; //?
	if ($i==0) { 
            $separator= '<br><br>Please configure your archives items publishing forms:<br><strong>'.$archivesConfig ['fatherDesc'][$i].' : </strong>';
        } else {
            if ($lastPublishedArchive == $archivesConfig ['father'][$i] ) { 
                $separator =  ' - ';
                
            } else {  
                $separator =  ' <br><strong>'.$archivesConfig ['fatherDesc'][$i].' : </strong>';
               
            }
         }
	$menuArchives=  $menuArchives. $separator .
		'<a href="admin.php?page=WPxdamsBridge_configure_output_fields_'.$archivesConfig ['id'][$i].'@'.$archivesConfig ['father'][$i].'"> '
		.' '.$archivesConfig ['label'][$i].'  </a>';
         $lastPublishedArchive = $archivesConfig ['father'][$i];
  }	
 
// [end] to publish link to configuration page of any available archives  


  $count		= $xDamsFields ['metadata'][1] ;// number of available fields
  $i			=1;

 
  $before		= 
	'<div class="wrap">		
	     
         <h2>Select your output fields for -	'. $archiveLabel . ' </h2> '.	 
		   '<form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">
            <p>
           <fieldset class="options"><br> '.
	   
		   ' <input type="hidden" id="c_fieldsNumber_WPxdamsBridge"name="c_fieldsNumber_WPxdamsBridge" value="'.$count.'"> 
			 <input type="hidden" id="c_archiveLevId_WPxdamsBridge"name="c_archiveLevId_WPxdamsBridge" value="'.$archiveLevId.'"> '.
		 //    <input type="hidden" id="c_archiveMedia_WPxdamsBridge"name="c_archiveMedia_WPxdamsBridge" value="'.$digitalMediaField.'"> 
			'<input type="hidden" id="c_archiveVideo_WPxdamsBridge"name="c_archiveVideo_WPxdamsBridge" value="'.$digitalVideoField.'">  
				 <table class="table" id="diagnosis_list">
                                 
					<thead>
					    <tr>
                                                <th> N.</th>
						<th> Field Id</th>
						<th> Label</th>
						<th> Attribute</th>
						<th> Custom Label</th>
						<th> Visible on pages &nbsp;&nbsp;</th>
                                                <th> Clean XML (1) &nbsp;&nbsp;</th>
                                                <th> Title Pre &nbsp;&nbsp;</th>
                                                <th> Title Post &nbsp;&nbsp;</th>
                                                <th> Desc Pre &nbsp;&nbsp;</th>
                                                <th> Desc Post &nbsp;&nbsp;</th>
                                                <th> Separator &nbsp;&nbsp;</th>
                                                <th> Group End &nbsp;&nbsp;</th>
                                                <th> Delete Permanently &nbsp;&nbsp;</th>
						<th> Is Multiple ?</th>
                                             </tr>   
					</thead>
                                        <tbody>';
   
					// to publish any field -- original label - custom label - visibility check   
  
 $fields_options_from_db 		= get_option('WPxdamsBridge_output_fields_'.$archiveLevId);
 
 //$count 						= get_option('WPxdamsBridge_out_fields_num_'.$archiveLevId);	
 
 for($i=0;$i<$count;$i++) {	

	$xDamsFields ['label'][$i] 	= str_replace('�', 'a', $xDamsFields ['label'][$i]);
	$xDamsFields ['name'][$i] 	= str_replace('�', 'a', $xDamsFields ['name'][$i]);
        $storedOptions 			= WPxdamsBridge_output_list_options($xDamsFields ['label'][$i], $archiveLevId, $fields_options_from_db , $count );
	
	$checkedString = '';
        $checkedClean = '';
      //  
	if ($xDamsFields['visibility'][$i]  =='1') {            
            $checkedString = "checked";
	}
    
        if ($xDamsFields['tagClean'][$i]  =='1') {            
            $checkedClean = "checked";
	}
        $itemAtt		= '';	
	$pos = strrpos( $xDamsFields ['name'][$i], '/' );
	$fieldLabel = $xDamsFields ['label'][$i] ;
	$fieldsGrouped = 'not';
	if ($pos)  { 
                $canc 				= substr($xDamsFields ['name'][$i], $pos+1);  // case xpath1/xpath2/number of grouped field [attribute]	
		$canc				= explode('[',$canc);
		if ($canc [0] > 1) {
			$fieldsGrouped	= $canc	[0];	  //number of following field grouped with the present
		}
               
		if ($canc [1]) {
			$itemAtt		= str_replace (']' , '' , $canc [1] );
	
		}
		$fieldLabel = substr($fieldLabel, 0 , $pos);  	
	
	}
        // manage string to avoit html error
        $rowValue =   str_replace('<', '£$%&',  $xDamsFields ['row'][$i]);
        $rowValue =   str_replace('>', '&%$£',  $xDamsFields ['row'][$i]);
        $rowValue =   str_replace('"', '-&-%-',  $xDamsFields ['row'][$i]);

        
	$optionsTable  =   $optionsTable .          
			  ' 	<tr> 
                                    <td class="priority"> '.$i. '
                                     </td><td>                                 
							<input type="text" style="width: 200px;" name="c_fieldName_WPxdamsBridge['.$i.']" value="'.$xDamsFields ['name'][$i].'" />  
                                    </td><td>
							<input type="hidden" name="c_fieldDesc_WPxdamsBridge['.$i.']" value="'.$xDamsFields ['olabel'][$i].'" />  '.
							$xDamsFields ['olabel'][$i].'
                                    <input type="hidden" name="c_fileRow_WPxdamsBridge['.$i.']" value="'.$rowValue.'" />  
                                    </td><td>'.
						     $itemAtt.'								
                                    </td><td> 
							<input type="text" style="width: 130px;" name="c_fieldCustom_WPxdamsBridge['.$i.']" value="'.$xDamsFields ['label'][$i].'" />  
                                    </td><td> 
							<input type="checkbox" name="c_field_check_WPxdamsBridge['.$i.']"'. $checkedString. '  value="1"/>
                                    </td><td>
                                                        <input type="checkbox" name="c_field_clean_WPxdamsBridge['.$i.']"'. $checkedClean. '  value="1"/>
                                    </td><td>
                                    			<input type="text" style="width: 110px;" name="c_titlePre_WPxdamsBridge['.$i.']" value="'. str_replace("\.@@.", '&quot;',$xDamsFields ['titlePre'][$i]).'" />  
                                    </td><td>
                                    			<input type="text" style="width: 110px;" name="c_titlePost_WPxdamsBridge['.$i.']" value="'.str_replace("\.@@.", '&quot;',$xDamsFields ['titlePost'][$i]).'" />  
                                    </td><td>
                                    			<input type="text" style="width: 110px;" name="c_descPre_WPxdamsBridge['.$i.']" value="'.str_replace("\.@@.", '&quot;',$xDamsFields ['descPre'][$i]).'" />  
                                    </td><td>
                                    			<input type="text" style="width: 110px;" name="c_descPost_WPxdamsBridge['.$i.']" value="'.str_replace("\.@@.", '&quot;',$xDamsFields ['descPost'][$i]).'" />  
                                    </td><td>
                                    			<input type="text" style="width: 80px;" name="c_descSeparator_WPxdamsBridge['.$i.']" value="'.$xDamsFields ['descSeparator'][$i].'" />  
                                    </td><td>
                                    			<input type="text" style="width: 110px;" name="c_groupEnd_WPxdamsBridge['.$i.']" value="'.$xDamsFields ['groupEnd'][$i].'" />  
                                    </td><td>                                    
							<input type="checkbox" name="c_field_delete_WPxdamsBridge['.$i.']"'. '  value="1"/>
                                    </td><td>' 
							.$xDamsFields ['multiple'][$i].' 
                                    </td>
				</tr> '
			  ;
  }	

// [end] to publish any field -- original label - custom label - visibility check    
/*
  $after		=
          '		</table> 

		  </fieldset>
		   '.  $digitalMediaDesc .'<br>'.$digitalVideoDesc .'      
           <p class="submit">
	    <input type="submit" name="WPxdamsBridge_submit_button3" value="Update Settings" />
	   </p> '.

	  '</form> 
	  </div>
	  <div>'	  ;
  
  */
     $after=            '
                        </tbody>
                    </table>
                </fieldset>
                '.  $digitalMediaDesc .'<br>'.$digitalVideoDesc .'   
                   to save the modified settings please push the folllowing button 
                    <p class="submit">
                        <input type="submit" name="WPxdamsBridge_submit_button3" value="Update Settings" />  
                        
                    </p> 
                     otherwise to add a new field push the following button 
                     <p class="submit">
                        
                         <input type="submit" name="WPxdamsBridge_submit_button3B" value="Update and Add" />  
                    </p> 
                    
            </form> 
            <p>  (1) Same tag includes subtags in the value, if you check this flag system will return only the main value excluding subtags</p>
		
            <p>  By this page it\'s possible to configure your custom output fields (visible on website page) among the available ones </p>
			'.$menuArchives.'<br> 
	</div>
    <div>
<script>
function renumber_table(tableID) 
    {

	$(tableID + " tr").each(function() 
        {
            count = $(this).parent().children().index($(this)) ;
            $(this).find(".priority").html(count);
            $(this).find("input[type=\'text\']").each(function()
            {
                $(this).attr("name",$(this).attr("name").replace(/\[(\d+)\]/,"[" + count + "]"));
            });
            $(this).find("input[type=\'hidden\']").each(function()
            {
                $(this).attr("name",$(this).attr("name").replace(/\[(\d+)\]/,"[" + count + "]"));
            });
            $(this).find("input[type=\'checkbox\']").each(function()
            {
                $(this).attr("name",$(this).attr("name").replace(/\[(\d+)\]/,"[" + count + "]"));
            });
        });
    }
</script>
';
  
  
  

    print ($before . $optionsTable . $after);


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>
