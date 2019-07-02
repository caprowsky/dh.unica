<?php

/**
 * Videos: Classic Template.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<div class="aiovg aiovg-videos aiovg-videos-template-classic">
	<?php
	// Display the videos count
    if ( ! empty( $attributes['show_count'] ) ) : ?>
    	<div class="aiovg-header">
			<?php printf( esc_html__( "%d video(s) found", 'all-in-one-video-gallery' ), $attributes['count'] ); ?>
        </div>
    <?php endif;
                    
    // Display the title (if applicable)
    if ( ! empty( $attributes['title'] ) ) : ?>
        <h3><?php echo esc_html( $attributes['title'] ); ?></h3>
    <?php 
    endif;
    
    // Start the loop
    $i = 0; 
        
    while ( $aiovg_query->have_posts() ) :        
        $aiovg_query->the_post();           
        if ( $i % $attributes['columns'] == 0 ) echo '<div class="aiovg-row">';
        ?>            
        <div class="aiovg-col aiovg-col-<?php echo (int) $attributes['columns']; ?>">
            <?php the_aiovg_video_thumbnail( $post, $attributes ); ?>            
        </div>                
        <?php 
        $i++;
        if ( 0 == $i % $attributes['columns'] || $i == $aiovg_query->post_count ) echo '</div>';             
    // End of the loop
    endwhile;
        
    // Use reset postdata to restore orginal query
    wp_reset_postdata();        
    
    if ( ! empty( $attributes['show_pagination'] ) ) { // Pagination
        the_aiovg_pagination( $aiovg_query->max_num_pages, "", $attributes['paged'] );
    } elseif ( ! empty( $attributes['show_more'] ) ) { // More button
        printf( 
            '<p class="aiovg-more aiovg-text-center"><button type="button" onclick="location.href=\'%s\'" class="aiovg-link-more">%s</button></p>', 
            esc_url( $attributes['more_link'] ), 
            esc_html( $attributes['more_label'] ) 
        );
    }
    ?>
</div>