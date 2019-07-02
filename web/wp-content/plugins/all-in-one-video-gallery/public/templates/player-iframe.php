<?php

/**
 * Video Player: Iframe Embed Code.
 *
 * @link     https://plugins360.com
 * @since    1.6.0
 *
 * @package All_In_One_Video_Gallery
 */
 
$type = '';
$src  = '';

if ( ! empty( $post_meta ) ) {
    $type = $post_meta['type'][0];

    if ( 'embedcode' == $type ) {        
        $document = new DOMDocument();
        $document->loadHTML( $post_meta['embedcode'][0] );
        
        $iframes = $document->getElementsByTagName( 'iframe' ); 
        $src = $iframes->item(0)->getAttribute( 'src' );
	}
	
	aiovg_update_views_count( $post_id );
}

if ( 'embedcode' != $type ) {
    foreach ( $embedded_sources as $source ) {
        $is_src_found = 0;

        if ( ! empty( $post_meta ) ) {
			if ( $source == $type ) {
                $is_src_found = 1;
                $src = $post_meta[ $type ][0];
			}			
		} elseif ( isset( $_GET[ $source ] ) ) {
            $is_src_found = 1;
            $src = urldecode( $_GET[ $source ] );
        }
        
        if ( $is_src_found ) {            
            switch ( $source ) {
                case 'youtube':
                    $src = 'https://www.youtube.com/embed/' . aiovg_get_youtube_id_from_url( $src ) . '?showinfo=0&rel=0&iv_load_policy=3';					
                    break;
                case 'vimeo':
                    $src = 'https://player.vimeo.com/video/' . aiovg_get_vimeo_id_from_url( $src ) . '?title=0&byline=0&portrait=0';
                    break;				
                case 'dailymotion':
                    $src = 'https://www.dailymotion.com/embed/video/' . aiovg_get_dailymotion_id_from_url( $src ) . '?queue-autoplay-next=0&queue-enable=0&sharing-enable=0&ui-logo=0&ui-start-screen-info=0';
                    break;
                case 'facebook':
                    $src = 'https://www.facebook.com/plugins/video.php?href=' . urlencode( $src ) . '&width=560&height=315&show_text=false&appId';
                    break;
            }
    
            $features = array( 'playpause', 'current', 'progress', 'duration', 'volume', 'fullscreen' );
            $controls = array();
            
            foreach ( $features as $feature ) {	
                if ( isset( $_GET[ $feature ] ) ) {	
                    if ( 1 == (int) $_GET[ $feature ] ) {
                        $controls[] = $feature;
                    }		
                } else {	
                    if ( isset( $player_settings['controls'][ $feature ] ) ) {
                        $controls[] = $feature;
                    }		
                }	
            }
    
            if ( empty( $controls ) ) {
                $src = add_query_arg( 'controls', 0, $src );
            } else {
                if ( ! in_array( 'fullscreen', $controls ) ) {
                    $src = add_query_arg( 'fs', 0, $src );
                }
            }
    
            $autoplay = isset( $_GET[ 'autoplay' ] ) ? $_GET['autoplay'] : $player_settings['autoplay'];
            $src = add_query_arg( 'autoplay', (int) $autoplay, $src );
    
            $loop = isset( $_GET[ 'loop' ] ) ? $_GET['loop'] : $player_settings['loop'];
            $src = add_query_arg( 'loop', (int) $loop, $src );
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">      
    <?php if ( $post_id > 0 ) : ?>    
        <title><?php echo wp_kses_post( get_the_title( $post_id ) ); ?></title>    
        <link rel="canonical" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" />
        <meta property="og:url" content="<?php echo esc_url( get_permalink( $post_id ) ); ?>" />
    <?php endif; ?>
    
	<style type="text/css">
        html, 
        body, 
        iframe {
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important; 
            padding: 0 !important; 
            overflow: hidden;
        }
    </style>
</head>
<body>    
    <iframe width="560" height="315" src="<?php echo esc_url_raw( $src ); ?>" frameborder="0" scrolling="no" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
</body>
</html>