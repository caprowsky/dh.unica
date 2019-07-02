<?php

/**
 * Shortcode Builder.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<div id="aiovg-shortcode-builder" class="aiovg-shortcode-builder mfp-hide">
    <div id="aiovg-shortcode-form" class="aiovg-shortcode-form">
        <p><?php esc_html_e( 'Use the form below to insert "All-in-One Video Gallery" plugin shortcodes.', 'all-in-one-video-gallery' ); ?></p>
        
        <!-- Shortcodes -->
        <div class="aiovg-shortcode-selector">
        	<label class="aiovg-shortcode-label" for="aiovg-shortcode-type"><?php esc_html_e( 'Shortcode Type', 'all-in-one-video-gallery' ); ?></label> 
            <select id="aiovg-shortcode-type" class="widefat aiovg-shortcode-type">
            	<?php
				foreach ( $shortcodes as $value => $label ) {
					printf( '<option value="%s">%s</option>', $value, $label );
				}
				?>
       		</select>
        </div>  
        
        <!-- Fields -->
        <?php foreach ( $shortcodes as $shortcode => $label ) : ?>
            <div id="aiovg-shortcode-type-<?php echo esc_attr( $shortcode ); ?>" class="aiovg-shortcode-type">
                <?php foreach ( $fields[ $shortcode ] as $key => $section ) : ?>
                    <div class="aiovg-shortcode-section aiovg-shortcode-section-<?php echo esc_attr( $key ); ?>">
                        <div class="aiovg-shortcode-section-header"><?php echo wp_kses_post( $section['title'] ); ?></div>
                            
                        <?php foreach ( $section['fields'] as $field ) : ?>
                            <div class="aiovg-shortcode-field aiovg-shortcode-field-<?php echo esc_attr( $field['name'] ); ?>">                           
                                <?php if ( 'category' == $field['type'] ) : ?>                            
                                    <label class="aiovg-shortcode-label"><?php echo esc_html( $field['label'] ); ?></label>
                                    <?php
                                    wp_dropdown_categories( array(
                                        'show_option_none'  => '-- ' . esc_html__( 'Top Categories', 'all-in-one-video-gallery' ) . ' --',
                                        'option_none_value' => 0,
                                        'taxonomy'          => 'aiovg_categories',
                                        'name' 			    => esc_attr( $field['name'] ),
                                        'class'             => "aiovg-shortcode-input widefat",
                                        'orderby'           => 'name',
                                        'hierarchical'      => true,
                                        'depth'             => 10,
                                        'show_count'        => false,
                                        'hide_empty'        => false,
                                    ) );
                                    ?>                            
                                <?php elseif ( 'categories' == $field['type'] ) : ?>                            
                                    <label class="aiovg-shortcode-label"><?php echo esc_html( $field['label'] ); ?></label>
                                    <ul name="<?php echo esc_attr( $field['name'] ); ?>" class="aiovg-shortcode-input aiovg-checklist widefat" data-default="">
                                        <?php
                                        $args = array(
                                        'taxonomy'      => 'aiovg_categories',
                                        'walker'        => null,
                                        'checked_ontop' => false
                                        ); 
                                    
                                        wp_terms_checklist( 0, $args );
                                        ?>
                                    </ul>  
                                <?php elseif ( 'video' == $field['type'] ) : ?>                            
                                    <label class="aiovg-shortcode-label"><?php echo esc_html( $field['label'] ); ?></label> 
                                    <select name="<?php echo esc_attr( $field['name'] ); ?>" class="aiovg-shortcode-input widefat" data-default="<?php echo esc_attr( $field['value'] ); ?>">
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
													selected( $post->ID, $field['value'], false ), 
													esc_html( $post->post_title )
												);
											}
										}
                                        ?>
                                    </select>                              
                                <?php elseif ( 'text' == $field['type'] || 'url' == $field['type'] || 'number' == $field['type'] ) : ?>                        
                                    <label class="aiovg-shortcode-label"><?php echo esc_html( $field['label'] ); ?></label>
                                    <input type="text" name="<?php echo esc_attr( $field['name'] ); ?>" class="aiovg-shortcode-input widefat" value="<?php echo esc_attr( $field['value'] ); ?>" data-default="<?php echo esc_attr( $field['value'] ); ?>" />                            
                                <?php elseif ( 'select' == $field['type'] ) : ?>                            
                                    <label class="aiovg-shortcode-label"><?php echo esc_html( $field['label'] ); ?></label> 
                                    <select name="<?php echo esc_attr( $field['name'] ); ?>" class="aiovg-shortcode-input widefat" data-default="<?php echo esc_attr( $field['value'] ); ?>">
                                        <?php
                                        foreach ( $field['options'] as $value => $label ) {
                                            printf( '<option value="%s"%s>%s</option>', esc_attr( $value ), selected( $value, $field['value'], false ), esc_html( $label ) );
                                        }
                                        ?>
                                    </select>                        
                                <?php elseif ( 'checkbox' == $field['type'] ) : ?>                        
                                    <label>				
                                        <input type="checkbox" name="<?php echo esc_attr( $field['name'] ); ?>" class="aiovg-shortcode-input" data-default="<?php echo esc_attr( $field['value'] ); ?>" value="1" <?php checked( $field['value'] ); ?> />
                                        <?php echo esc_html( $field['label'] ); ?>
                                    </label>                            
                                <?php elseif ( 'color' == $field['type'] ) : ?>                        
                                    <label class="aiovg-shortcode-label"><?php echo esc_html( $field['label'] ); ?></label>
                                    <input type="text" name="<?php echo esc_attr( $field['name'] ); ?>" class="aiovg-shortcode-input aiovg-color-picker-field widefat" value="<?php echo esc_attr( $field['value'] ); ?>" data-default="<?php echo esc_attr( $field['value'] ); ?>" />                        
                                <?php endif; ?>

                                <?php if ( ! empty( $field['description'] ) ) : // Description ?>
                                    <div class="aiovg-shortcode-field-description"><?php echo wp_kses_post( $field['description'] ); ?></div>
                                <?php endif; ?>                                            
                            </div>    
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>      
        
        <!-- Action Buttons -->
        <p class="submit">
            <input type="button" id="aiovg-insert-shortcode" class="button-primary" value="<?php esc_attr_e( 'Insert Shortcode', 'all-in-one-video-gallery' ); ?>" />
            <a id="aiovg-cancel-shortcode-insert" class="button-secondary"><?php esc_html_e( 'Cancel', 'all-in-one-video-gallery' ); ?></a>
        </p>       
    </div>
</div>