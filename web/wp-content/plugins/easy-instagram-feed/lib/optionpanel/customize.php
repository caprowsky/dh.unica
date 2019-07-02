<?php 
if(isset($_POST['rest']))
{	
	$eif_settings = array();
	$eif_settings = array(
		'eif_access_token' => '',
		'eif_feed_width' => '100',
		'eif_feed_width_unit' => '%',
		'eif_feed_height' => '100',
		'eif_feed_height_unit' => '%',
		'eif_feed_background_color' => '#fff',
		'eif_feed_image_padding_unit'=> 'px',
		'eif_feed_image_padding_size' => '5',
		'eif_feed_image_padding' => 'px',
		'eif_feed_column_numbers'=> '4',
		'eif_feed_number_of_images' => '20',
		'eif_feed_image_resolution' => 'low_resolution',
		'eif_feed_image_sorting' => 'newer',
		'eif_feed_show_button_status'=>'yes',
		'eif_feed_button_background_color' => '#000000',
		'eif_feed_button_text_color'=> '#fff',
		'eif_feed_follow_button_text' => 'Follow on Instagram',
		'eif_feed_load_more_button_status'=> 'yes',
		'eif_feed_load_more_button_back_color'=> '#000000',
		'eif_feed_load_more_button_text_color' => '#fff',
		'eif_feed_load_more_button_text' => 'Load More',
		'eif_feed_image_border' => 'yes',
		'eif_feed_image_shadow' => 'yes',
		'eif_feed_image_overlay' => 'yes',
		'eif_instagram_custom_css' => '',
		'eif_instagram_custom_js' => '',
		'eif_plugin_version' => 'newversion'
		);


	// add the default settings value to the databsae
	update_option('eif_settings',$eif_settings);
	
}


if(isset($_POST['submit2'])){  
			if($_POST['eif_feed_load_more_button_status'])
			{
			$val = "yes";
			}
			else
			{
			$val = "no";
			}
			if($_POST['eif_feed_show_button_status'])
			{
			$load_val = "yes";
			}
			else
			{
			$load_val = "no";
			}

			if($_POST['eif_feed_image_border'])
			{
			$image_border = "yes";
			} else
			{
			$image_border = "no";
			}
			if($_POST['eif_feed_image_shadow']){
			$image_shadow = 'yes';
			}
			else{
			$image_shadow = 'no';
			}
			if($_POST['eif_feed_image_overlay']){
			$image_overlay = 'yes';
			}
			else{
			$image_overlay = 'no';
			}

				$eif_settings = array();
				$eif_settings = get_option('eif_settings');
				// update feeds section configuration settings.
				
				$eif_settings['eif_feed_width'] = $_POST['eif_feed_width'];
				$eif_settings['eif_feed_width_unit'] = $_POST['eif_feed_width_unit'];
				$eif_settings['eif_feed_height'] = $_POST['eif_feed_height'];
				$eif_settings['eif_feed_height_unit'] = $_POST['eif_feed_height_unit'];
				$eif_settings['eif_feed_background_color'] = $_POST['eif_feed_background_color'];
				$eif_settings['eif_feed_image_sorting'] = $_POST['eif_feed_image_sorting'];
				$eif_settings['eif_feed_number_of_images'] = $_POST['eif_feed_number_of_images'];
				$eif_settings['eif_feed_column_numbers'] = $_POST['eif_feed_column_numbers'];
				$eif_settings['eif_feed_image_resolution'] =$_POST['eif_feed_image_resolution'];
				$eif_settings['eif_feed_image_padding_unit'] = $_POST['eif_feed_image_padding_unit'];
				$eif_settings['eif_feed_image_padding_size']= $_POST['eif_feed_image_padding_size'];
				$eif_settings['eif_feed_show_button_status'] = $load_val;
				$eif_settings['eif_feed_button_background_color'] = $_POST['eif_feed_button_background_color'];
				$eif_settings['eif_feed_button_text_color'] = $_POST['eif_feed_button_text_color'];
				$eif_settings['eif_feed_follow_button_text'] = $_POST['eif_feed_follow_button_text'];
				$eif_settings['eif_feed_load_more_button_status'] = $val;
				$eif_settings['eif_feed_load_more_button_back_color'] = $_POST['eif_feed_load_more_button_back_color'];
				$eif_settings['eif_feed_load_more_button_text_color'] = $_POST['eif_feed_load_more_button_text_color'];
				$eif_settings['eif_feed_load_more_button_text'] = $_POST['eif_feed_load_more_button_text'];
				$eif_settings['eif_feed_image_border'] = $image_border;
				$eif_settings['eif_feed_image_shadow'] = $image_shadow;
				$eif_settings['eif_feed_image_overlay'] = $image_overlay;
				//wp_die(print_r($eif_settings['eif_feed_background_color']));
				   
					// update options
					update_option('eif_settings',$eif_settings);
    

}?>
<form  name="eif_form" method="post"><?php $eif_settings = get_option('eif_settings');  //wp_die(print_r(get_option('eif_settings'))); ?>
<h3><?php _e('Customize feed area','eif');?></h3>

<table class="form-table">
		
        <tr valign="top">
        <th scope="row"><label><?php _e('Width of feed area','eif');?></label></th>
            <td>
                <input type="text" id="eif_feed_width"  name="eif_feed_width" value="<?php esc_attr_e($eif_settings['eif_feed_width']); ?>" size="5" />
                <select name="eif_feed_width_unit">
                    <option value="px" <?php if($eif_settings['eif_feed_width_unit'] == "px") echo 'selected="selected"' ?> ><?php _e('px','eif'); ?></option>
                    <option value="%" <?php if($eif_settings['eif_feed_width_unit'] == "%") echo 'selected="selected"' ?> ><?php _e('%','eif'); ?></option>
                </select>
            </td>
        </tr>
         
        <tr valign="top">
        <th scope="row"><label><?php _e('Height of feed area','eif');?></label></th>
            <td>
                <input type="text" id="eif_feed_height"  name="eif_feed_height" value="<?php esc_attr_e($eif_settings['eif_feed_height']); ?>" size="5" />
                <select name="eif_feed_height_unit">
                    <option value="px" <?php if($eif_settings['eif_feed_height_unit'] == "px") echo 'selected="selected"' ?> ><?php _e('px','eif'); ?></option>
                    <option value="%" <?php if($eif_settings['eif_feed_height_unit'] == "%") echo 'selected="selected"' ?> ><?php _e('%','eif'); ?></option>
                </select>
            </td>
        </tr>
        
        <tr valign="top">
        <th scope="row"><label><?php _e('Background color of feed section','eif');?></label></th>
            <td>
                <input type="text" name="eif_feed_background_color" value="<?php esc_attr_e($eif_settings['eif_feed_background_color']);?>" class="eif-color-field" />
            </td>
        </tr>
		
       
    </table>
	<table class="form-table">
    <hr />
        <h3><?php _e('Photos','eif');?></h3>
		<tr valign="top">
			<th scope="row"><label><?php _e('Order by','eif');?></label></th>
				<td>
					<select name="eif_feed_image_sorting">
						<option value="newer" <?php if($eif_settings['eif_feed_image_sorting'] == "newer") echo 'selected="selected"' ?> ><?php _e('Newest to Oldest','eif'); ?></option>
						<option value="random" <?php if($eif_settings['eif_feed_image_sorting'] == "random") echo 'selected="selected"' ?> ><?php _e('Random','eif'); ?></option>
					</select>
				</td>	
		</tr>
		<tr>
			<th scope="row"><label><?php _e('Number of photos','eif');?></label></th>
			<td>
				<input type="text" id="eif_feed_number_of_images" name="eif_feed_number_of_images" value="<?php esc_attr_e($eif_settings['eif_feed_number_of_images']);?>">
			<?php _e('Specify number of photos to show initially. Maximum 33 media items returned in a single request. In case of multiple id and hashtag, you will get, this much number of media items for each ids/tags.','eif');?>
			</td>
		</tr>
		<tr>
			<th scope="row"><label> <?php _e('Number of columns','eif');?></label></th>
			<td>
				<select name="eif_feed_column_numbers">
					<option value="1"<?php  if($eif_settings['eif_feed_column_numbers']=="1") echo 'selected="selected"' ; ?>><?php echo '1'; ?></option>
					<option value="2"<?php  if($eif_settings['eif_feed_column_numbers']=="2") echo 'selected="selected"' ; ?>><?php echo '2'; ?></option>
					<option value="3"<?php  if($eif_settings['eif_feed_column_numbers']=="3") echo 'selected="selected"' ; ?>><?php echo '3'; ?></option>
					<option value="4"<?php  if($eif_settings['eif_feed_column_numbers']=="4") echo 'selected="selected"' ; ?>><?php echo '4'; ?></option>
					<option value="5"<?php  if($eif_settings['eif_feed_column_numbers']=="5") echo 'selected="selected"' ; ?>><?php echo '5'; ?></option>
					<option value="6"<?php  if($eif_settings['eif_feed_column_numbers']=="6") echo 'selected="selected"' ; ?>><?php echo '6'; ?></option>
					<option value="7"<?php  if($eif_settings['eif_feed_column_numbers']=="7") echo 'selected="selected"' ; ?>><?php echo '7'; ?></option>
					<option value="8"<?php  if($eif_settings['eif_feed_column_numbers']=="8") echo 'selected="selected"' ; ?>><?php echo '8'; ?></option>
					<option value="9"<?php  if($eif_settings['eif_feed_column_numbers']=="9") echo 'selected="selected"' ; ?>><?php echo '9'; ?></option>
					<option value="10"<?php if($eif_settings['eif_feed_column_numbers']=="10") echo 'selected="selected"' ; ?>><?php echo '10'; ?></option>
				</select>
			</td>
		</tr>
		
		<tr>
		<th scope="row"><label><?php _e('Image resolution','eif');?></label></th>
		<td>
			<select name="eif_feed_image_resolution">
				<option value="thumbnail"<?php if($eif_settings['eif_feed_image_resolution']=="thumbnail'") echo 'selected="selected"'; ?>><?php _e('Thumbnail (150*150)','eif');?></option>
				<option value="low_resolution"<?php if($eif_settings['eif_feed_image_resolution']=="low_resolution") echo 'selected="selected"'; ?>><?php _e('Medium (306*306)','eif');?></option>
				<option value="standard_resolution"<?php if($eif_settings['eif_feed_image_resolution']=='standard_resolution') echo 'selected="selected"'; ?>><?php _e('Full Size (640*640)','eif');?></option>
			</select>
		</td>
		</tr>
		
		<tr>
		<th scope="row"><label> <?php _e('Padding around images','eif');?><label></th>
		<td>
			<input type="text" id="eif_feed_image_padding_size" name="eif_feed_image_padding_size" value="<?php esc_attr_e($eif_settings['eif_feed_image_padding_size']); ?>">
			<select name="eif_feed_image_padding_unit">
				<option value="px"<?php if($eif_settings['eif_feed_image_padding']=='px') echo 'selected="selected"';?>><?php _e('px','eif');?></option>
				<option value="%"<?php if($eif_settings['eif_feed_image_padding']=='%') echo 'selected="selected"';?>><?php _e('%','eif');?></option>
			</select>
		</td>
		</tr>
		
		<tr>
		<th scope="row"<label><?php _e('Image overLay','eif');?></label></th>
		<td><input type="checkbox" name="eif_feed_image_overlay" id="eif_feed_image_overlay" value="yes" <?php if($eif_settings['eif_feed_image_overlay']=='yes'){echo 'checked';}?>> </td>
		</tr>
		
		<tr>
		<th scope="row"<label><?php _e('Border around image','eif');?></label></th>
		<td><input type="checkbox" name="eif_feed_image_border" id="eif_feed_image_border" value="yes" <?php if($eif_settings['eif_feed_image_border']=='yes'){echo 'checked';}?>> </td>
		</tr>
		
		<tr>
		<th scope="row"<label><?php _e('Image shadow','eif');?></label></th>
		<td><input type="checkbox" name="eif_feed_image_shadow" id="eif_feed_image_shadow" value="yes" <?php if($eif_settings['eif_feed_image_shadow']=='yes'){echo 'checked';}?>> </td>
		</tr>
		
		
		<tr>
			<th scope="row"><label><?php _e('Enable Pop-up Lightbox','eif');?><label></th>
					<td>

			<input type="checkbox" name="light_box" id="light_box" value="yes" disabled=""><span style="font-style:Italic;"> <?php _e('Available in advance version','eif');?></span>
			</td>
		</tr>
		
 </table>
 

 
<table class="form-table">
 <hr/>
	 <h3><?php _e('Header','eif');?> </h3>
	 <tr valign="top">
		<th scope="row"><label><?php _e('Show the header','eif');?></label></th>
		<td>
			<input type="checkbox" name="header" value="yes" disabled=""><span style="font-style:Italic;"> <?php _e('Available in advance version','eif');?></span>
		</td>
	 </tr>
	 <tr valign="top">
	 <th scope="row"><label><?php _e('Header text color','eif');?></label></th>
	 <td style="display:none;">
			<input type="text" name="header_text_color" id="header_text_color" class="eif-color-field" ><span style="font-style:Italic;"> <?php _e('Available in advance version','eif');?></span>
		 </td></td><td><span style="font-style:Italic;"><?php _e('Available in advance version','eif');?></span></td>
		 </tr>
</table>

<table class="form-table">
 <hr/>
	 <h3><?php _e('Caption','eif');?> </h3>
	 <tr valign="top">
		<th scope="row"><label><?php _e('Show caption','eif');?></label></th>
		<td>
			<input type="checkbox" name="caption" value="yes" disabled=""> <span style="font-style:Italic;"> <?php _e('Available in advance version','eif');?></span>
		</td>
	 </tr>
	 <tr valign="top">
	 <th scope="row"><label><?php _e('Maximum text length','eif');?></label></th>
	 <td>
			<input type="text" name="text_length" id="text_length" disabled=""> <span style="font-style:Italic;"> <?php _e('Available in advance version','eif');?></span>
	 </td>
	 <tr>
	  <th scope="row"><label><?php _e('Text color','eif');?></label></th>
	 <td style="display:none;">
			<input type="text" name="caption_text_color" id="caption_text_color" class="eif-color-field" ><span style="font-style:Italic;"> <?php _e('Available in advance version','eif');?></span>
		 </td></td><td><span style="font-style:Italic;"><?php _e('Available in advance version','eif');?></span></td>
		 </tr>
		 <tr>
		 <th scope="row"><label><?php _e('Text size','eif');?></label></th>
	 <td>
			<select disabled="">
  <option value="10"><?php echo '10';?></option>
  <option value="12"><?php echo '12';?></option>
  <option value="14"><?php echo '14';?></option>
  <option value="16"><?php echo '16';?></option>
</select> <span style="font-style:Italic;"><?php _e('Available in advance version','eif');?></span>
		 </td>
		 </tr>
</table>
<table class="form-table">
 <hr/>
	 <h3><?php _e('Likes and comments','eif');?></h3>
	 <tr valign="top">
		<th scope="row"><label><?php _e('Show number of likes','eif');?></label></th>
		<td>
			<input type="checkbox" name="like_show" value="yes" disabled=""> <span style="font-style:Italic;"><?php _e('Available in advance version','eif');?></span>
		</td>
	 </tr>
	 <tr valign="top">
		<th scope="row"><label><?php _e('Show number of comments','eif');?></label></th>
		<td>
			<input type="checkbox" name="show_comments" value="yes" disabled=""> <span style="font-style:Italic;"><?php _e('Available in advance version','eif');?></span>
		</td>
	 </tr>
	  <tr valign="top">
	 <th scope="row"><label><?php _e('Background color','eif');?></label></th>
	 <td style="display:none;">
			<input type="text" name="icons_color" id="icons_color" class="eif-color-field" >
		 </td><td><span style="font-style:Italic;"><?php _e('Available in advance version','eif');?></span></td>
		 </tr>
	 
</table>



 <table class="form-table">
	 <hr/>
	 <h3><?php _e("'Load More' button","eif");?> </h3>
	 <tr valign="top">
		<th scope="row"><label><?php _e("Show the 'Load More' button","eif");?></label></th>
		<td>
			<input type="checkbox" name="eif_feed_load_more_button_status" value="yes" <?php if($eif_settings['eif_feed_load_more_button_status']=='yes'){echo 'checked';}?>>
		</td>
	 </tr>
	<tr valign="top">
		 <th scope="row"><label><?php _e('Button background color','eif');?></label></th>
		 <td>
			<input type="text" name="eif_feed_load_more_button_back_color" value="<?php if(esc_attr_e($eif_settings['eif_feed_load_more_button_back_color']));?>" class="eif-color-field"/>
		 </td>
	</tr>
	<tr valign="top">
		 <th scope="row"><label><?php _e('Button text color','eif');?></label></th>
		 <td>
			<input type="text" name="eif_feed_load_more_button_text_color" value="<?php if(esc_attr_e($eif_settings['eif_feed_load_more_button_text_color']));?>" class="eif-color-field"/>
		 </td>
	</tr>
	<tr valign ="top">
		<th scope="row"><label><?php _e('Button text','eif');?></label></th>
		<td>
			<input type="text" name="eif_feed_load_more_button_text" value="<?php if(esc_attr_e($eif_settings['eif_feed_load_more_button_text']));?>" size="60">
		</td>
	</tr>
 </table>
 
 <table class="form-table">
	<hr/>
	<h3><?php _e("'Follow on Instagram' button",'eif');?></h3>
	<tr valign="top">
		<th scope="row"><label><?php _e('Show the follow button','eif');?></label></th>
		<td>
			<input type="checkbox" name="eif_feed_show_button_status" value="yes"<?php if($eif_settings['eif_feed_show_button_status']=='yes'){echo 'checked';} ?>>
		
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label><?php _e('Button background color','eif');?></label></th>
		<td>
			<input type="text" name="eif_feed_button_background_color" value="<?php if(esc_attr_e($eif_settings['eif_feed_button_background_color'])); ?>" class="eif-color-field">
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label><?php _e('Button text color','eif');?></label></th>
		<td>
			<input type="text" name="eif_feed_button_text_color" value="<?php if(esc_attr_e($eif_settings['eif_feed_button_text_color']));?>" class="eif-color-field"/>
		</td>
	</tr>
	<tr valign ="top">
		<th scope="row"><label><?php _e('Button text','eif');?></label></th>
		<td>
			<input type="text" name="eif_feed_follow_button_text" value="<?php if(esc_attr_e($eif_settings['eif_feed_follow_button_text']));?>" size="60">
		</td>
	</tr>
	
 </table>
    <input type="submit" name="submit2" value="<?php _e('Save','eif'); ?>" class="button button-primary"/>
	<input type="submit" name="rest" value="<?php _e('Reset','eif'); ?>" class="button button-primary"/>
	<?php wp_nonce_field('easy_instagram_media_security_check','eif_easy_instagram_media_security_check_custom_settings'); ?>
</form>
