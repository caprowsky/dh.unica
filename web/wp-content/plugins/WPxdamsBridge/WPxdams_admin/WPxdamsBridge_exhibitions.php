<?php
/*
 functions to manage search form fields settings
*/


 

$exhibitionId                   =  WPxdamsBridge_get_archive_id(); // id of the requested exhibition
$active                         = (WPxdamsBridge_get_option('active',$archiveId) == 1) ? 'checked' : '';  //
$deactive                       = (WPxdamsBridge_get_option('active',$archiveId) == 0) ? 'checked' : '';  //
$exhibitionsNumber              = get_option('WPxdamsBridge_exhibitions_number'); // number of archives;




if (!$exhibitionsNumber) {  $exhibitionsNumber		= 3; };	
$archivesList                   = $archivesConfig ['WPxdamsBridge_archivesList'][0]; //   array contaning only archives

for($i=1;$i<=$exhibitionsNumber;$i++) {

    $separator		= '  -  ';
    if ($i==1) { $separator	= 'You can configure: ';};
    $menuArchives		=  $menuArchives. $separator .
                                    '<a href="admin.php?page=WPxdamsBridge_exhibitions_'.$i.'">Exhibition N. '.$i.'  </a>';
}	

$menuArchives			=  $menuArchives.' - total number of exhibitions <input type="text" style="width:40px;" name="c_exhibitNumber_WPxdamsBridge"'. '  value="'.$exhibitionsNumber . '"/>';
  


$count                          = get_option('WPxdamsBridge_exhibitions_fieldsNumber_'.$exhibitionId); // number of slides;
if (!$count) {  $count          = 7; };//number of different items of all archives   
	
$backgroundImgUrl         = get_option('WPxdamsBridge_backgroundImgUrl_'.$exhibitionId);
$exhibitionTitle          = get_option('WPxdamsBridge_exhibitionTitle_'.$exhibitionId);
  
// create table rows (one for each slide)

for($i=1;$i<$count+1;$i++) {	

     
      
       $toSplit             = get_option('WPxdamsBridge_exhibitions_'.$exhibitionId.'_'.$i);
       $temp                = explode('%%%', $toSplit);
       $id                  = $temp [0];
       $des                 = $temp [1];
       $archID              = $temp [2];
       $url                 = $temp [3];
       $printPic            = '';
       $field               = 'WPxdamsBridge_exhibitions_'.$exhibitionId.'_'.$i;
 
   
        if($url) {
              
                $urlPreview = $url;

        } else { 
                if ($id ) {
                 
                $result     = WPxdamsBridge_single_item_request ( $id , $archID);
                $urlPreview = WPxdamsBridge_getMediaFileURL(); 
                }
        }
        $printPic       = '<div> <img src="'.$urlPreview.'" style="max-width:510px;max-heigth:800px;margin-left:70px;" ></div><br>';
        

        $optionsTable2 = $optionsTable2. '<tr><td class="priority">'.$i.'  </td>
                                            <td> archive ID <br><input type="text" style="width:120px;margin-left:0px;" name="c_imgArchID_WPxdamsBridge['.$i.']"'. '  value="'.$archID. '"/>  <br>
                                                 item ID <br><input type="text" style="width:300px;margin-left:0px;" name="c_itemID_WPxdamsBridge['.$i.']"'. '  value="'.$id. '"/><br>
                                                 alternative URL<br> <input type="text" style="width:450px;margin-left:0px;" name="c_imgUrl_WPxdamsBridge['.$i.']"'. '  value="'.$url. '"/></td>
                                            <td><textarea rows="4" cols="1" style="width:300px ; height:150px; text-align:top  " name="c_fieldCustom_WPxdamsBridge['.$i.']" value="'.$des.'">'. $des. ' </textarea>  </td>  
                                            <td><img src="'.$urlPreview.'" style="max-width:250px;max-heigth:250px;margin-left:0px;" > </td>     
                                            <td><a class="btn btn-delete btn-danger">Delete</a></td></tr>';
  }
  


  $before2= '
    <div class="wrap">		
	     
        <h2>Exhibitions, creation and management </h2> '.
         
            '<form id="ak_sharethis" name="WPxdamsBridge_cnf" action="'.get_bloginfo('wpurl').'/wp-admin/index.php" method="post">'.
		     
                ' <p>By this page it\'s possible to create a new exhibition slider or to manage the existing ones </p> '.
		'<h4> You are managing the exhibition number  '.  	 $exhibitionId . '</h4><br>'.	
			$menuArchives.'<br> 
                <fieldset class="options">
                
                    <input type="hidden" id="c_exhibitionID_WPxdamsBridge" name="c_exhibitionID_WPxdamsBridge" value="'. $exhibitionId .'"><br> '.
                    'Title  
                    <input type="text" style="width:824px" name="c_exhibitionTitle_WPxdamsBridge"'. '  value="'.$exhibitionTitle. '"/><br><br>    
                    <h4>Slides</h4>
                            Number of Slides '.
                    '<input type="text" style="width:30px;margin-left:4px;margin-right:14px;" name="c_fieldsNumber_WPxdamsBridge"  value="'.$count. '"/>'.
                            '
                    Background Image  
                    <input type="text" style="width:700px" name="c_backgroundImgUrl_WPxdamsBridge"'. '  value="'.$backgroundImgUrl . '"/><br><br>


                    <table class="table" id="diagnosis_list">
                        <thead>
                            <tr><th>Order </th><th>Archive ID / Item Id / URL</th><th>Description Text</th><th>Preview</th><th>&nbsp;</th></tr>
                        </thead>
                        <tbody>';

                
   $after2=            '
                        </tbody>
                    </table>
                </fieldset>
                <p class="submit">
                    <input type="submit" name="WPxdamsBridge_submit_button4" value="Update Settings" />
                </p> 
            </form> 
	</div>
    <div>
<script>
function renumber_table(tableID) {
	$(tableID + " tr").each(function() {
		count = $(this).parent().children().index($(this)) + 1;
		$(this).find(".priority").html(count);
	$(this).find("input[type=\'text\']").each(function(){
$(this).attr("name",$(this).attr("name").replace(/\[(\d+)\]/,"[" + count + "]"));
	});
	$(this).find("textarea").each(function(){
$(this).attr("name",$(this).attr("name").replace(/\[(\d+)\]/,"[" + count + "]"));
	});
	});
}
</script>
';


print ( $before2 . $optionsTable2 . $after2);


 
/*  **************************************************
      this is the end....
    **************************************************
*/

?>