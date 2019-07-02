<?php

/**
 * Admin form: Video player widget.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<div class="aiovg aiovg-widget-form aiovg-widget-form-video">
	<div class="aiovg-widget-field aiovg-widget-field-title">
		<label class="aiovg-widget-label" for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'all-in-one-video-gallery' ); ?></label> 
		<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat aiovg-widget-input-title" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-id">
		<label class="aiovg-widget-label" for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php esc_html_e( 'Select Video', 'all-in-one-video-gallery' ); ?></label> 
		<select name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" class="widefat aiovg-widget-input-id">
			<option value="0">-- <?php esc_html_e( 'Latest Video', 'all-in-one-video-gallery' ); ?> --</option>
			<?php
			$args = array(				
				'post_type' => 'aiovg_videos',			
				'post_status' => 'publish',
				'posts_per_page' => 500,
				'orderby' => 'title', 
				'order' => 'ASC', 
				'no_found_rows' => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false
			);
	
			$aiovg_query = new WP_Query( $args );
			
			if ( $aiovg_query->have_posts() ) {
				$posts = $aiovg_query->posts;

				foreach ( $posts as $post ) {					
					printf(
						'<option value="%d"%s>%s</option>', 
						$post->ID, 
						selected( $post->ID, (int) $instance['id'], false ), 
						esc_html( $post->post_title )
					);
				}
			}
			?>
		</select>
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-width">
		<label class="aiovg-widget-label" for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php esc_html_e( 'Width', 'all-in-one-video-gallery' ); ?></label> 
		<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" class="widefat aiovg-widget-input-width" value="<?php echo esc_attr( $instance['width'] ); ?>" />
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-ratio">
		<label class="aiovg-widget-label" for="<?php echo esc_attr( $this->get_field_id( 'ratio' ) ); ?>"><?php esc_html_e( 'Ratio', 'all-in-one-video-gallery' ); ?></label> 
		<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'ratio' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'ratio' ) ); ?>" class="widefat aiovg-widget-input-ratio" value="<?php echo esc_attr( $instance['ratio'] ); ?>" />
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-autoplay">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'autoplay' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>" class="aiovg-widget-input-autoplay" value="1" <?php checked( 1, $instance['autoplay'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'autoplay' ) ); ?>"><?php esc_html_e( 'Autoplay', 'all-in-one-video-gallery' ); ?></label>
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-loop">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'loop' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'loop' ) ); ?>" class="aiovg-widget-input-loop" value="1" <?php checked( 1, $instance['loop'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'loop' ) ); ?>"><?php esc_html_e( 'Loop', 'all-in-one-video-gallery' ); ?></label>
	</div>

	<label class="aiovg-widget-label aiovg-widget-label-header"><?php esc_html_e( 'Player Controls', 'all-in-one-video-gallery' ); ?></label>

	<div class="aiovg-widget-field aiovg-widget-field-playpause">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'playpause' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'playpause' ) ); ?>" class="aiovg-widget-input-playpause" value="1" <?php checked( 1, $instance['playpause'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'playpause' ) ); ?>"><?php esc_html_e( 'Play / Pause', 'all-in-one-video-gallery' ); ?></label>
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-current">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'current' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'current' ) ); ?>" class="aiovg-widget-input-current" value="1" <?php checked( 1, $instance['current'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'current' ) ); ?>"><?php esc_html_e( 'Current Time', 'all-in-one-video-gallery' ); ?></label>
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-progress">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'progress' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'progress' ) ); ?>" class="aiovg-widget-input-progress" value="1" <?php checked( 1, $instance['progress'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'progress' ) ); ?>"><?php esc_html_e( 'Progressbar', 'all-in-one-video-gallery' ); ?></label>
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-duration">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'duration' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'duration' ) ); ?>" class="aiovg-widget-input-duration" value="1" <?php checked( 1, $instance['duration'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'duration' ) ); ?>"><?php esc_html_e( 'Duration', 'all-in-one-video-gallery' ); ?></label>
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-tracks">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'tracks' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'tracks' ) ); ?>" class="aiovg-widget-input-tracks" value="1" <?php checked( 1, $instance['tracks'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'tracks' ) ); ?>"><?php esc_html_e( 'Subtitles', 'all-in-one-video-gallery' ); ?></label>
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-volume">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'volume' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'volume' ) ); ?>" class="aiovg-widget-input-volume" value="1" <?php checked( 1, $instance['volume'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'volume' ) ); ?>"><?php esc_html_e( 'Volume', 'all-in-one-video-gallery' ); ?></label>
	</div>

	<div class="aiovg-widget-field aiovg-widget-field-fullscreen">
		<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'fullscreen' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'fullscreen' ) ); ?>" class="aiovg-widget-input-fullscreen" value="1" <?php checked( 1, $instance['fullscreen'] ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'fullscreen' ) ); ?>"><?php esc_html_e( 'Fullscreen', 'all-in-one-video-gallery' ); ?></label>
	</div>
</div>