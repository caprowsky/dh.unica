<?php

/**
 * Video Thumbnail - Image positioned to the left side of the caption.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */

$post_meta = get_post_meta( $post->ID );
$image     = aiovg_get_image_url( $post_meta['image_id'][0], 'large', $post_meta['image'][0] );
?>

<div class="aiovg-thumbnail aiovg-thumbnail-style-image-left" data-id="<?php echo esc_attr( $post->ID ); ?>">
    <div class="aiovg-row">
        <div class="aiovg-col aiovg-col-p-40">
            <a href="<?php the_permalink(); ?>" class="aiovg-responsive-container" style="padding-bottom: <?php echo esc_attr( $attributes['ratio'] ); ?>;">
                <img src="<?php echo esc_url( $image ); ?>" class="aiovg-responsive-element" />                        
                
                <?php if ( $attributes['show_duration'] && ! empty( $post_meta['duration'][0] ) ) : ?>
                    <div class="aiovg-duration"><small><?php echo esc_html( $post_meta['duration'][0] ); ?></small></div>
                <?php endif; ?>
                
                <img src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/images/play.png" class="aiovg-play" />
            </a> 
        </div>   	
        
        <div class="aiovg-col aiovg-col-p-60">
            <div class="aiovg-caption">
                <div class="aiovg-title">
                    <a href="<?php the_permalink(); ?>" class="aiovg-link-title"><?php the_title(); ?></a>
                </div>

                <?php
                $meta = array();					

                if ( $attributes['show_date'] ) {
                    $meta[] = sprintf( esc_html__( '%s ago', 'all-in-one-video-gallery' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
                }
                        
                if ( $attributes['show_user'] ) {
                    $author_url = aiovg_get_user_videos_page_url( $post->post_author );
                    $meta[]     = sprintf( '%s <a href="%s" class="aiovg-link-author">%s</a>', esc_html__( 'by', 'all-in-one-video-gallery' ), esc_url( $author_url ), esc_html( get_the_author() ) );			
                }

                if ( count( $meta ) ) {
                    printf( '<div class="aiovg-user"><small>%s</small></div>', esc_html__( "Posted", 'all-in-one-video-gallery' ) . ' ' . implode( ' ', $meta ) );
                }
                ?>
                    
                <?php if ( $attributes['show_excerpt'] ) : ?>
                    <div class="aiovg-excerpt"><?php the_aiovg_excerpt( $attributes['excerpt_length'] ); ?></div>
                <?php endif; ?>
                
                <?php
                if ( $attributes['show_category'] ) {
                    $categories = get_the_terms( get_the_ID(), 'aiovg_categories' );
                    if ( ! empty( $categories ) ) {
                        $meta = array();
                        foreach ( $categories as $category ) {
                            $category_url = aiovg_get_category_page_url( $category );
                            $meta[]       = sprintf( '<a href="%s" class="aiovg-link-category">%s</a>', esc_url( $category_url ), esc_html( $category->name ) );
                        }
                        printf( '<div class="aiovg-category"><span class="aiovg-icon-folder-open"></span> %s</div>', implode( ', ', $meta ) );
                    }
                }
                ?>
                
                <?php if ( $attributes['show_views'] ) : ?>
                    <div class="aiovg-views aiovg-text-muted">
                        <span class="aiovg-icon-eye"></span> 
                        <?php printf( esc_html__( '%d views', 'all-in-one-video-gallery' ), $post_meta['views'][0] ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>    
    </div>
</div>