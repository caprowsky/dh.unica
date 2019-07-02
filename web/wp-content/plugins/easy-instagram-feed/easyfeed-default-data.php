<?php $eif_settings = array();

$eif_settings = array(
    'eif_access_token' => ' ',
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
	if(get_option('eif_settings')==''){
  update_option('eif_settings',$eif_settings); 
	}
?>