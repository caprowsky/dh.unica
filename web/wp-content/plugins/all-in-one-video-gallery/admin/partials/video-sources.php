<?php

/**
 * Videos: "Video Sources" meta box.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<table class="aiovg-table widefat">
  	<tbody>
    	<tr>
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "Type", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>        
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "Type", 'all-in-one-video-gallery' ); ?></strong></p>
      			<select name="type" id="aiovg-video-type" class="select">
                	<?php 
					$types = aiovg_get_video_source_types( true );
					foreach ( $types as $key => $label ) {
						printf( '<option value="%s"%s>%s</option>', $key, selected( $key, $type, false ), $label );
					}
					?>
        		</select>
      		</td>
    	</tr>
    	<tr class="aiovg-toggle-fields aiovg-type-default">
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "MP4", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "MP4", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap aiovg-media-uploader">
          			<input type="text" name="mp4" id="aiovg-mp4" class="text" placeholder="<?php esc_attr_e( 'Enter your Direct File URL here (OR) use the Upload Media button', 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_url( $mp4 ); ?>" />
          			<a class="button aiovg-upload-media hide-if-no-js" href="javascript:;" id="aiovg-upload-mp4" data-format="mp4">
		  				<?php esc_html_e( 'Upload Media', 'all-in-one-video-gallery' ); ?>
          			</a>
       			</div>
        
        		<br />
        
        		<ul class="aiovg-checkbox-list horizontal">
          			<li>
                    	<label>
                        	<input type="checkbox" name="has_webm" id="aiovg-has-webm" value="1" <?php checked( $has_webm, 1 ); ?> />
							<?php esc_html_e( "WebM", 'all-in-one-video-gallery' ); ?>
                        </label>
                    </li>
          			<li>
                    	<label>
                        	<input type="checkbox" name="has_ogv" id="aiovg-has-ogv" value="1" <?php checked( $has_ogv, 1 ); ?> />
							<?php esc_html_e( "OGV", 'all-in-one-video-gallery' ); ?>
                       	</label>
                	</li>
        		</ul>
      		</td>
    	</tr>
    	<tr id="aiovg-field-webm" class="aiovg-toggle-fields">
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "WebM", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "WebM", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap aiovg-media-uploader">
          			<input type="text" name="webm" id="aiovg-webm" class="text" placeholder="<?php esc_attr_e( 'Enter your Direct File URL here (OR) use the Upload Media button', 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_url( $webm ); ?>" />
          			<a class="button aiovg-upload-media hide-if-no-js" href="javascript:;" id="aiovg-upload-webm" data-format="webm">
		  				<?php esc_html_e( 'Upload Media', 'all-in-one-video-gallery' ); ?>
          			</a>
       			</div>
      		</td>
    	</tr>  
    	<tr id="aiovg-field-ogv" class="aiovg-toggle-fields">
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "OGV", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "OGV", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap aiovg-media-uploader">
          			<input type="text" name="ogv" id="aiovg-ogv" class="text" placeholder="<?php esc_attr_e( 'Enter your Direct File URL here (OR) use the Upload Media button', 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_url( $ogv ); ?>" />
          			<a class="button aiovg-upload-media hide-if-no-js" href="javascript:;" id="aiovg-upload-ogv" data-format="ogv">
		  				<?php esc_html_e( 'Upload Media', 'all-in-one-video-gallery' ); ?>
          			</a>
       			</div>
      		</td>
    	</tr>  
    	<tr class="aiovg-toggle-fields aiovg-type-youtube">
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "YouTube", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "YouTube", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="youtube" id="aiovg-youtube" class="text" placeholder="<?php printf( '%s: https://www.youtube.com/watch?v=twYp6W6vt2U', esc_attr__( 'Example', 'all-in-one-video-gallery' ) ); ?>" value="<?php echo esc_url( $youtube ); ?>" />
       			</div>
      		</td>
    	</tr>
    	<tr class="aiovg-toggle-fields aiovg-type-vimeo">
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "Vimeo", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "Vimeo", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="vimeo" id="aiovg-vimeo" class="text" placeholder="<?php printf( '%s: https://vimeo.com/108018156', esc_attr__( 'Example', 'all-in-one-video-gallery' ) ); ?>" value="<?php echo esc_url( $vimeo ); ?>" />
       			</div>
      		</td>
    	</tr>
        <tr class="aiovg-toggle-fields aiovg-type-dailymotion">
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "Dailymotion", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "Dailymotion", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="dailymotion" id="aiovg-dailymotion" class="text" placeholder="<?php printf( '%s: https://www.dailymotion.com/video/x11prnt', esc_attr__( 'Example', 'all-in-one-video-gallery' ) ); ?>" value="<?php echo esc_url( $dailymotion ); ?>" />
       			</div>
      		</td>
    	</tr>
        <tr class="aiovg-toggle-fields aiovg-type-facebook">
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "Facebook", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "Facebook", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="facebook" id="aiovg-facebook" class="text" placeholder="<?php printf( '%s: https://www.facebook.com/facebook/videos/10155278547321729', esc_attr__( 'Example', 'all-in-one-video-gallery' ) ); ?>" value="<?php echo esc_url( $facebook ); ?>" />
       			</div>
      		</td>
    	</tr>
        <tr class="aiovg-toggle-fields aiovg-type-embedcode">
            <td class="label aiovg-hidden-xs">
                <label><?php esc_html_e( "Embed Code", 'all-in-one-video-gallery' ); ?></label>
            </td>
            <td>
                <p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "Embed Code", 'all-in-one-video-gallery' ); ?></strong></p>
                <textarea name="embedcode" id="aiovg-embedcode" class="textarea" placeholder="<?php esc_attr_e( 'Enter your Iframe Embed Code here', 'all-in-one-video-gallery' ); ?>" rows="6"><?php echo esc_textarea( $embedcode ); ?></textarea>
            </td>
        </tr>
        <?php do_action( 'aiovg_admin_add_video_source_fields', $post->ID ); ?>
   	 	<tr>
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "Image", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "Image", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap aiovg-media-uploader">
          			<input type="text" name="image" id="aiovg-image" class="text" placeholder="<?php esc_attr_e( 'Enter your Direct File URL here (OR) use the Upload Media button', 'all-in-one-video-gallery' ); ?>" value="<?php echo esc_url( $image ); ?>" />
          			<a class="button aiovg-upload-media hide-if-no-js" href="javascript:;" id="aiovg-upload-image" data-format="image">
		  				<?php esc_html_e( 'Upload Media', 'all-in-one-video-gallery' ); ?>
          			</a>
      			</div>
      		</td>
    	</tr> 
    	<tr>
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "Duration", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "Duration", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="duration" id="aiovg-duration" class="text" placeholder="6:30" value="<?php echo esc_attr( $duration ); ?>" />
       			</div>
      		</td>
    	</tr>
    	<tr>
      		<td class="label aiovg-hidden-xs">
        		<label><?php esc_html_e( "Views", 'all-in-one-video-gallery' ); ?></label>
      		</td>
      		<td>
        		<p class="aiovg-hidden-sm aiovg-hidden-md aiovg-hidden-lg"><strong><?php esc_html_e( "Views", 'all-in-one-video-gallery' ); ?></strong></p>
      			<div class="aiovg-input-wrap">
          			<input type="text" name="views" id="aiovg-views" class="text" value="<?php echo esc_attr( $views ); ?>" />
       			</div>
      		</td>
    	</tr>     
  	</tbody>
</table>

<?php
// Add a nonce field
wp_nonce_field( 'aiovg_save_video_sources', 'aiovg_video_sources_nonce' );