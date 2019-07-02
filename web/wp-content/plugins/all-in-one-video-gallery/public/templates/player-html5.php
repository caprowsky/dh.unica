<?php

/**
 * Video Player: Mediaelementjs.
 *
 * @link     https://plugins360.com
 * @since    1.6.0
 *
 * @package All_In_One_Video_Gallery
 */

// Video Sources
$types = array(
	'all'         => array( 'mp4', 'webm', 'ogv', 'youtube', 'vimeo', 'dailymotion', 'facebook' ),
	'default'     => array( 'mp4', 'webm', 'ogv' ),
	'youtube'     => array( 'youtube' ),
	'vimeo'       => array( 'vimeo' ),
	'dailymotion' => array( 'dailymotion' ),
	'facebook'    => array( 'facebook' )
);

if ( ! empty( $post_meta ) ) {
	$types = array_key_exists( $post_meta['type'][0], $types ) ? $types[ $post_meta['type'][0] ] : array();	
} else {
	$types = $types['all'];
}

$sources = array();
$thirdparty_providers = array();

foreach ( $types as $type ) {
	if ( ! empty( $post_meta ) ) {
		$src = ! empty( $post_meta[ $type ][0] ) ? $post_meta[ $type ][0] : '';
	} else {
		$src = isset( $_GET[ $type ] ) ? sanitize_text_field( $_GET[ $type ] ) : '';
	}
	
	if ( ! empty( $src ) ) {		
		$mime = "video/{$type}";

		$sources[] = array(
			'type' => $mime,
			'src'  => $src
		);
		
		if ( in_array( $type, $embedded_sources ) ) {
			$thirdparty_providers[] = $type;	
		}
	}	
}

$sources = apply_filters( 'aiovg_video_sources', $sources );

// Video Attributes
$attributes = array( 
	'id'          => 'player',
	'playsinline' => ''
);

if ( wp_is_mobile() || empty( $sources ) || in_array( 'facebook', $thirdparty_providers ) ) {
	$autoplay = 0;
} else {
	$autoplay = isset( $_GET['autoplay'] ) ? (int) $_GET['autoplay'] : (int) $player_settings['autoplay'];
}

$loop = isset( $_GET['loop'] ) ? (int) $_GET['loop'] : (int) $player_settings['loop'];

if ( ! empty( $loop ) ) {
	$attributes['loop'] = true;
}

$attributes['preload'] = esc_attr( $player_settings['preload'] );

if ( isset( $_GET['poster'] ) ) {
	$attributes['poster'] = $_GET['poster'];
} elseif ( ! empty( $post_meta ) ) {
	$attributes['poster'] = aiovg_get_image_url( $post_meta['image_id'][0], 'large', $post_meta['image'][0], 'player' );
}

if ( ! empty( $attributes['poster'] ) ) {
	$attributes['poster'] = esc_url( $attributes['poster'] );
	
	if ( false !== strpos( $attributes['poster'], 'youtube' ) ) {
		$attributes['poster'] = str_replace( array( 'https:', 'http:' ), '', $attributes['poster'] );
	}
}

$attributes = apply_filters( 'aiovg_video_attributes', $attributes );

// Player Settings
$features = array( 'playpause', 'current', 'progress', 'duration', 'tracks', 'volume', 'fullscreen' );
$controls = array( 'aiovg' );

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

$settings = array(
	'pluginPath'            => AIOVG_PLUGIN_URL . 'public/assets/mediaelement/',
	'features'              => $controls,
	'autoplayRequested'     => $autoplay,
	'youtube'               => array( 'showinfo' => 0, 'rel' => 0, 'iv_load_policy' => 3 ),
	'showLogo'              => 0,
	'showCustomContextMenu' => 0
);

if ( ! empty( $brand_settings ) ) {
	$settings['showLogo']              = (int) $brand_settings['show_logo'];
	$settings['logoImage']             = esc_url_raw( $brand_settings['logo_image'] );
	$settings['logoLink']              = esc_url_raw( $brand_settings['logo_link'] );
	$settings['logoPosition']          = sanitize_text_field( $brand_settings['logo_position'] );
	$settings['logoMargin']            = (int) $brand_settings['logo_margin'];
	$settings['showCustomContextMenu'] = ! empty( $brand_settings['copyright_text'] ) ? 1 : 0;
}

$settings = apply_filters( 'aiovg_player_settings', $settings );

// Video Tracks
$tracks = array();

if ( in_array( 'tracks', $settings['features'] ) && ! empty( $post_meta['track'] ) ) {
	foreach ( $post_meta['track'] as $track ) {
		$tracks[] = unserialize( $track );
	}	
}

$tracks = apply_filters( 'aiovg_video_tracks', $tracks );
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
	<link rel="stylesheet" href="<?php echo includes_url( 'js/mediaelement/mediaelementplayer.min.css' ); ?>?v=4.2.9" />

	<?php do_action( 'aiovg_player_head' ); ?>

	<style type="text/css">
        html, 
        body, 
        video, 
        iframe {
            width: 100% !important;
            height: 100% !important;
            margin:0 !important; 
            padding:0 !important; 
            overflow: hidden;
        }
            
        video, 
        iframe {
            display: block;
        }
            
        .mejs__container, 
        .mejs__layer {
            width: 100% !important;
            height: 100% !important;
        }
        
        .mejs__captions-layer {
            pointer-events: none;
        }
		
		.mejs__logo {
			position: absolute;	
			width: auto !important;
			height: auto !important;
			max-width: 150px;
			z-index: 9;
			cursor: pointer;
		}
		
		.mejs__logo img {
			display: block;
			opacity: 0.5;
		}
		
		.mejs__logo:hover img {
			opacity: 1;
		}
		
		.mejs__logo-topleft {
			top: 0;
			left: 0;
		}
		
		.mejs__logo-topright {
			top: 0;
			right: 0;
		}
		
		.mejs__logo-bottomleft {
			bottom: 40px;
			left: 0;
		}
		
		.mejs__logo-bottomright {
			bottom: 40px;
			right: 0;
		}		
		
		.contextmenu {
            position: absolute;
            top: 0;
            left: 0;
            margin: 0;
            padding: 0;
            background: #fff;
			border-radius: 2px;
			box-shadow: 1px 1px 2px #333;
            z-index: 9999999999; /* make sure it shows on fullscreen */
        }
        
        .contextmenu-item {
            margin: 0;
            padding: 8px 12px;
            font-family: 'Helvetica', Arial, serif;
            font-size: 12px;
            color: #222;		
            white-space: nowrap;
            cursor: pointer;
        }

		.show-spinner .mejs__layers .mejs__overlay-play,
		.show-spinner .mejs__controls {
			display: none !important;
		}

		.show-spinner .mejs__layers .mejs__layer:nth-child(2) {
			display: flex !important;
		}
    </style>
</head>
<body id="body"<?php if ( $autoplay ) echo ' class="show-spinner"'; ?>>
    <video <?php the_aiovg_video_attributes( $attributes ); ?>>
        <?php 
		// Video Sources
		foreach ( $sources as $source ) {
			printf( '<source type="%s" src="%s" />', esc_attr( $source['type'] ), esc_url_raw( $source['src'] ) );
		}
		
		// Video Tracks
		foreach ( $tracks as $track ) {
        	printf( '<track src="%s" kind="subtitles" srclang="%s" label="%s">', esc_url_raw( $track['src'] ), esc_attr( $track['srclang'] ), esc_attr( $track['label'] ) );
		}
       ?>       
	</video>
    
    <?php if ( ! empty( $brand_settings['copyright_text'] ) ) : ?>
        <div id="contextmenu" class="contextmenu" style="display: none;">
            <div class="contextmenu-item"><?php echo esc_html( $brand_settings['copyright_text'] ); ?></div>
        </div>
    <?php endif; ?>
    
	<script src="<?php echo includes_url( 'js/mediaelement/mediaelement-and-player.min.js' ); ?>?v=4.2.9" type="text/javascript"></script>
    <?php if ( in_array( 'vimeo', $thirdparty_providers ) ) : ?>
        <script src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/mediaelement/renderers/vimeo.min.js?v=4.2.9" type="text/javascript"></script>
    <?php endif; ?>
    <?php if ( in_array( 'dailymotion', $thirdparty_providers ) ) : ?>
        <script src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/mediaelement/renderers/dailymotion.min.js?v=4.2.9" type="text/javascript"></script>
    <?php endif; ?>
    <?php if ( in_array( 'facebook', $thirdparty_providers ) ) : ?>
        <script src="<?php echo AIOVG_PLUGIN_URL; ?>public/assets/mediaelement/renderers/facebook.min.js?v=4.2.9" type="text/javascript"></script>
    <?php endif; ?>
    
    <?php do_action( 'aiovg_player_footer' ); ?>
    
    <script type="text/javascript">
		/**
		 * Check if HTML5 video autoplay is supported.
		 */
		(function () {
			'use strict';
					   
			var autoplayAllowed, autoplayRequiresMuted;
			
			var videoElement = document.createElement( 'video' );
			videoElement.id = 'aiovg-video-hidden';
			videoElement.src = "data:video/mp4;base64,AAAAFGZ0eXBNU05WAAACAE1TTlYAAAOUbW9vdgAAAGxtdmhkAAAAAM9ghv7PYIb+AAACWAAACu8AAQAAAQAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAnh0cmFrAAAAXHRraGQAAAAHz2CG/s9ghv4AAAABAAAAAAAACu8AAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAFAAAAA4AAAAAAHgbWRpYQAAACBtZGhkAAAAAM9ghv7PYIb+AAALuAAANq8AAAAAAAAAIWhkbHIAAAAAbWhscnZpZGVBVlMgAAAAAAABAB4AAAABl21pbmYAAAAUdm1oZAAAAAAAAAAAAAAAAAAAACRkaW5mAAAAHGRyZWYAAAAAAAAAAQAAAAx1cmwgAAAAAQAAAVdzdGJsAAAAp3N0c2QAAAAAAAAAAQAAAJdhdmMxAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAFAAOABIAAAASAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGP//AAAAEmNvbHJuY2xjAAEAAQABAAAAL2F2Y0MBTUAz/+EAGGdNQDOadCk/LgIgAAADACAAAAMA0eMGVAEABGjuPIAAAAAYc3R0cwAAAAAAAAABAAAADgAAA+gAAAAUc3RzcwAAAAAAAAABAAAAAQAAABxzdHNjAAAAAAAAAAEAAAABAAAADgAAAAEAAABMc3RzegAAAAAAAAAAAAAADgAAAE8AAAAOAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA4AAAAOAAAAFHN0Y28AAAAAAAAAAQAAA7AAAAA0dXVpZFVTTVQh0k/Ou4hpXPrJx0AAAAAcTVREVAABABIAAAAKVcQAAAAAAAEAAAAAAAAAqHV1aWRVU01UIdJPzruIaVz6ycdAAAAAkE1URFQABAAMAAAAC1XEAAACHAAeAAAABBXHAAEAQQBWAFMAIABNAGUAZABpAGEAAAAqAAAAASoOAAEAZABlAHQAZQBjAHQAXwBhAHUAdABvAHAAbABhAHkAAAAyAAAAA1XEAAEAMgAwADAANQBtAGUALwAwADcALwAwADYAMAA2ACAAMwA6ADUAOgAwAAABA21kYXQAAAAYZ01AM5p0KT8uAiAAAAMAIAAAAwDR4wZUAAAABGjuPIAAAAAnZYiAIAAR//eBLT+oL1eA2Nlb/edvwWZflzEVLlhlXtJvSAEGRA3ZAAAACkGaAQCyJ/8AFBAAAAAJQZoCATP/AOmBAAAACUGaAwGz/wDpgAAAAAlBmgQCM/8A6YEAAAAJQZoFArP/AOmBAAAACUGaBgMz/wDpgQAAAAlBmgcDs/8A6YEAAAAJQZoIBDP/AOmAAAAACUGaCQSz/wDpgAAAAAlBmgoFM/8A6YEAAAAJQZoLBbP/AOmAAAAACkGaDAYyJ/8AFBAAAAAKQZoNBrIv/4cMeQ==";    
			videoElement.autoplay = true;
			videoElement.style.position = 'fixed';
			videoElement.style.left = '5000px';

			document.getElementsByTagName( 'body' )[0].appendChild( videoElement );
			var videoContent = document.getElementById( 'aiovg-video-hidden' );
			
			function checkAutoplaySupport() {
				// Check if autoplay is supported.
				var playPromise = videoContent.play();
				if ( playPromise !== undefined ) {
					playPromise.then( onAutoplayWithSoundSuccess ).catch( onAutoplayWithSoundFail );
				} else {
					autoplayAllowed = false;
					autoplayRequiresMuted = false;
					autoplayChecksResolved();
				}
			}

			function onAutoplayWithSoundSuccess() {
				// If we make it here, unmuted autoplay works.
				videoContent.pause();
				autoplayAllowed = true;
				autoplayRequiresMuted = false;
				autoplayChecksResolved();
			}

			function onAutoplayWithSoundFail() {
				// Unmuted autoplay failed. Now try muted autoplay.
				checkMutedAutoplaySupport();
			}

			function checkMutedAutoplaySupport() {
				videoContent.volume = 0;
				videoContent.muted = true;
				var playPromise = videoContent.play();
				if ( playPromise !== undefined ) {
					playPromise.then( onMutedAutoplaySuccess ).catch( onMutedAutoplayFail );
				}
			}

			function onMutedAutoplaySuccess() {
				// If we make it here, muted autoplay works but unmuted autoplay does not.
				videoContent.pause();
				autoplayAllowed = true;
				autoplayRequiresMuted = true;
				autoplayChecksResolved();
			}

			function onMutedAutoplayFail() {
				// Both muted and unmuted autoplay failed. Fall back to click to play.
				videoContent.volume = 1;
				videoContent.muted = false;
				autoplayAllowed = false;
				autoplayRequiresMuted = false;
				autoplayChecksResolved();
			}
			
			function autoplayChecksResolved() {
				document.getElementsByTagName( 'body' )[0].removeChild( videoElement );
				
				// Announce to the World!
				window.aiovgAutoplayChecksResolved = true;
				window.aiovgAutoplayAllowed = autoplayAllowed;
				window.aiovgAutoplayRequiresMuted = autoplayRequiresMuted;
			};	
			
			// ...
			checkAutoplaySupport();	
		})();

		/**
		 * MediaElement.js Integration.
		 */
		(function() {
			'use strict';
			
			/**
			 *  Helper functions.
			 */

			var body = document.getElementById( 'body' );
			var initialized = 0;

			function showSpinner() {
				if ( ! initialized ) {
					mejs.Utils.addClass( body, 'show-spinner' );
				}				
			}

			function hideSpinner() {
				mejs.Utils.removeClass( body, 'show-spinner' );
			}
			
			/**
			 * A custom mediaelementjs plugin.
			 */			
			Object.assign(MediaElementPlayer.prototype, {
			
				buildaiovg: function buildaiovg( player, controls, layers, media ) {					
					var t = this;

					// Show the spinner immediately as soon as the play button is clicked
					var loadedmetadata = 0;

					media.addEventListener( 'loadedmetadata', function() {
						if ( ! loadedmetadata ) {
							loadedmetadata = 1;

							t.layers.querySelector( '.' + t.options.classPrefix + 'overlay-play' ).addEventListener( 'click', showSpinner );
							
							try {
								t.controls.querySelector( '.' + t.options.classPrefix + 'playpause-button' ).addEventListener( 'click', showSpinner );
							} catch( err ) {}							
						}						
					});	

					// Logo / Watermark
					if ( 1 == t.options.showLogo && '' != t.options.logoImage ) {					
						t.logoLayer = document.createElement( 'div' );
						t.logoLayer.className = t.options.classPrefix + 'logo ' + t.options.classPrefix + 'logo-' + t.options.logoPosition;
						t.logoLayer.style.margin = t.options.logoMargin + 'px';
						t.logoLayer.innerHTML = '<img src="' + t.options.logoImage + '" />';
							
						t.layers.appendChild( t.logoLayer );
						
						if ( '' != t.options.logoLink ) {
							t.logoLayer.addEventListener( 'click', function() {
								top.window.location.href = t.options.logoLink;
							});
						}
						
						t.container.addEventListener( 'controlsshown', function() {
							t.logoLayer.style.display = '';
						});
						
						t.container.addEventListener( 'controlshidden', function() {
							t.logoLayer.style.display = 'none';
						});						
					}					
					
					// Custom ContextMenu
					if ( 1 == t.options.showCustomContextMenu ) {					
						var contextmenu = document.getElementById( 'contextmenu' );
						var timeout_handler = '';
						
						document.addEventListener( 'contextmenu', function( e ) {						
							if ( 3 === e.keyCode || 3 === e.which ) {
								e.preventDefault();
								e.stopPropagation();
								
								var width = contextmenu.offsetWidth,
									height = contextmenu.offsetHeight,
									x = e.pageX,
									y = e.pageY,
									doc = document.documentElement,
									scrollLeft = ( window.pageXOffset || doc.scrollLeft ) - ( doc.clientLeft || 0 ),
									scrollTop = ( window.pageYOffset || doc.scrollTop ) - ( doc.clientTop || 0 ),
									left = x + width > window.innerWidth + scrollLeft ? x - width : x,
									top = y + height > window.innerHeight + scrollTop ? y - height : y;
						
								contextmenu.style.display = '';
								contextmenu.style.left = left + 'px';
								contextmenu.style.top = top + 'px';
								
								clearTimeout( timeout_handler );
								timeout_handler = setTimeout(function() {
									contextmenu.style.display = 'none';
								}, 1500 );				
							}														 
						});
						
						if ( '' != t.options.logoLink ) {
							contextmenu.addEventListener( 'click', function() {
								top.window.location.href = t.options.logoLink;
							});
						}
						
						document.addEventListener( 'click', function() {
							contextmenu.style.display = 'none';								 
						});						
					}							
				}
					
			});
			 
			/**
			 * Initialize the player.
			 */
			var settings = <?php echo json_encode( $settings ); ?>;
			
			settings.success = function( media ) {	
				// Autoplay
				if ( settings.autoplayRequested ) {					
					if ( window.aiovgAutoplayChecksResolved ) {
						if ( window.aiovgAutoplayAllowed && ! window.aiovgAutoplayRequiresMuted ) {
							media.play();
						} else {
							hideSpinner();
						}
					} else {
						var intervalHandler = setInterval(
							function() {
								if ( window.aiovgAutoplayChecksResolved ) {
									clearInterval( intervalHandler );
									if ( window.aiovgAutoplayAllowed && ! window.aiovgAutoplayRequiresMuted ) {
										media.play();
									} else {
										hideSpinner();
									}
								}
							},
							100 ); // every 100ms
					}
				}

				// Fired when the media is ready to start playing
				media.addEventListener( 'play', function( e ) {
					if ( ! initialized ) {
						initialized = 1;

						hideSpinner();

						var url = '<?php echo admin_url( 'admin-ajax.php' ); ?>?action=aiovg_update_views_count&post_id=<?php echo $post_id; ?>&security=<?php echo wp_create_nonce( 'aiovg_video_{$post_id}_views_nonce' ); ?>';
						mejs.Utils.ajax( url, 'json', function() {
							// Do nothing
						});
					};
				});					
			}
			
			var player = new MediaElementPlayer( 'player', settings );
		})();		
    </script>
</body>
</html>