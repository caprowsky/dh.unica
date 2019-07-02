<?php

/**
 * Single Video Page.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<div class="aiovg aiovg-single-video">
    <!-- Player -->
    <?php echo the_aiovg_player( $attributes['id'] ); ?>

    <!-- Meta informations -->
    <div class="aiovg-meta">
        <?php
        $meta = array();					
        
        // Author & Date
        $user_meta = array();
        
        if ( $attributes['show_date'] ) {
            $user_meta[] = sprintf( esc_html__( 'Posted %s ago', 'all-in-one-video-gallery' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
        }
                
        if ( $attributes['show_user'] ) {
			$author_url  = aiovg_get_user_videos_page_url( $post->post_author );
            $user_meta[] = sprintf( '<a href="%s">%s</a>', esc_url( $author_url ), get_the_author() );			
        }
        
        if ( count( $user_meta ) ) {
            $meta[] = sprintf( '<div class="aiovg-user"><small>%s</small></div>', implode( ' ' . esc_html__( "by", 'all-in-one-video-gallery' ) . ' ', $user_meta ) );
        }
        
        // Category(s)
        if ( $attributes['show_category'] && ! empty( $attributes['categories'] ) ) {
            $term_meta = array();
            foreach ( $attributes['categories'] as $category ) {
				$category_url = aiovg_get_category_page_url( $category );
                $term_meta[]  = sprintf( '<a class="aiovg-link-category" href="%s">%s</a>', esc_url( $category_url ), esc_html( $category->name ) );
            }
            $meta[] = sprintf( '<div class="aiovg-category"><span class="aiovg-icon-folder-open"></span> %s</div>', implode( ', ', $term_meta ) );
        }
        
        // ...
        if ( count( $meta ) ) {
            printf( '<div class="aiovg-pull-left">%s</div>', implode( '', $meta ) );
        }
        ?>  
        
        <!-- Views count -->
        <?php if ( $attributes['show_views'] ) : ?>
            <div class="aiovg-views aiovg-pull-right">
                <span class="aiovg-icon-eye"></span>
                <?php
                    $views_count = get_post_meta( get_the_ID(), 'views', true );
                    printf( esc_html__( '%d views', 'all-in-one-video-gallery' ), $views_count );
                ?>
            </div>
        <?php endif; ?>
        
        <div class="aiovg-clearfix"></div>
    </div>
    
    <!-- Description -->
    <div class="aiovg-description"><?php echo wp_kses_post( $content ); ?></div>
    
    <!-- Socialshare buttons -->
    <?php the_aiovg_socialshare_buttons(); ?>
</div>

<?php
// Related videos
if ( $attributes['related'] ) {
	$atts = array();
	
	$atts[] = 'title="' . esc_html__( 'You may also like', 'all-in-one-video-gallery' ) . '"';
	
	if ( ! empty( $attributes['categories'] ) ) {
		$ids = array();
		foreach ( $attributes['categories'] as $category ) {
			$ids[] = $category->term_id;
		}
		$atts[] = 'category="' . implode( ',', $ids ) . '"';
	}
	
	$atts[] = 'exclude="' . $attributes['id'] . '"';
	$atts[] = 'show_count="0"';

	$related_videos = do_shortcode( '[aiovg_videos ' . implode( ' ', $atts ) . ']' );
		
	if ( $related_videos != aiovg_get_message( 'empty' ) ) {
		echo $related_videos;
	} 
}