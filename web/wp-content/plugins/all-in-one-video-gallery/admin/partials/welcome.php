<?php

/**
 * Welcome page.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<div id="aiovg-welcome" class="wrap about-wrap full-width-layout aiovg-welcome">
	<h1><?php 
printf( esc_html__( 'All-in-One Video Gallery - %s', 'all-in-one-video-gallery' ), AIOVG_PLUGIN_VERSION );
?></h1>
    
    <p class="about-text">
        <?php 
esc_html_e( "The last video player & gallery plugin you'll ever need.", 'all-in-one-video-gallery' );
?>
    </p>

    <?php 
?>
        
	<div class="wp-badge aiovg-badge"><?php 
printf( esc_html__( 'Version %s', 'all-in-one-video-gallery' ), AIOVG_PLUGIN_VERSION );
?></div>
    
    <h2 class="nav-tab-wrapper wp-clearfix">
		<?php 
foreach ( $tabs as $tab => $title ) {
    $class = ( $tab == $active_tab ? 'nav-tab nav-tab-active' : 'nav-tab' );
    if ( 'aiovg_new' == $tab ) {
        $title .= '<span class="dashicons dashicons-info"></span>';
    }
    printf(
        '<a href="%s" class="%s">%s</a>',
        esc_url( admin_url( add_query_arg( 'page', $tab, 'index.php' ) ) ),
        $class,
        $title
    );
}
?>
    </h2>
    
    <?php 

if ( 'aiovg_welcome' == $active_tab ) {
    ?>
        <p class="about-description">
            <strong><?php 
    printf( esc_html__( 'Step #%d:', 'all-in-one-video-gallery' ), 0 );
    ?></strong> 
            &rarr;
            <?php 
    _e( 'Install & Activate <strong>All-in-One Video Gallery</strong>', 'all-in-one-video-gallery' );
    ?>
        </p>

        <p class="about-description">
            <strong><?php 
    printf( esc_html__( 'Step #%d:', 'all-in-one-video-gallery' ), 1 );
    ?></strong> 
            &rarr;
            <code><?php 
    esc_html_e( 'Optional', 'all-in-one-video-gallery' );
    ?></code>
            <a href="<?php 
    echo  esc_url( admin_url( 'edit-tags.php?taxonomy=aiovg_categories&post_type=aiovg_videos' ) ) ;
    ?>">
                <?php 
    esc_html_e( 'Add Categories', 'all-in-one-video-gallery' );
    ?>
            </a>
        </p>

        <p class="about-description">
            <strong><?php 
    printf( esc_html__( 'Step #%d:', 'all-in-one-video-gallery' ), 2 );
    ?></strong> 
            &rarr;
            <a href="<?php 
    echo  esc_url( admin_url( 'post-new.php?post_type=aiovg_videos' ) ) ;
    ?>">
                <?php 
    esc_html_e( 'Add Videos', 'all-in-one-video-gallery' );
    ?>
            </a>
        </p>

        <p class="about-description">
            <strong><?php 
    printf( esc_html__( 'Step #%d:', 'all-in-one-video-gallery' ), 3 );
    ?></strong>  
            &rarr;     
            <code><?php 
    esc_html_e( 'Optional', 'all-in-one-video-gallery' );
    ?></code>     
            <?php 
    printf( __( 'Add a Categories <a href="%s">Page</a> to your site front-end. Find step by step instructions <a href="%s" target="_blank">here</a>', 'all-in-one-video-gallery' ), esc_url( admin_url( 'post-new.php?post_type=page' ) ), 'https://plugins360.com/all-in-one-video-gallery/displaying-categories/' );
    ?>
        </p>

        <p class="about-description">
            <strong><?php 
    printf( esc_html__( 'Step #%d:', 'all-in-one-video-gallery' ), 4 );
    ?></strong>  
            &rarr;          
            <?php 
    printf( __( 'Add a Videos <a href="%s">Page</a> to your site front-end. Find step by step instructions <a href="%s" target="_blank">here</a>', 'all-in-one-video-gallery' ), esc_url( admin_url( 'post-new.php?post_type=page' ) ), 'https://plugins360.com/all-in-one-video-gallery/displaying-video-gallery/' );
    ?>
        </p>

        <p>
            <?php 
    printf( __( 'Please <a href="%s" target="_blank">refer</a> for more advanced tutorials.', 'all-in-one-video-gallery' ), 'https://plugins360.com/all-in-one-video-gallery/documentation/' );
    ?>
        </p>
    <?php 
}

?>
    
    <?php 

if ( 'aiovg_new' == $active_tab ) {
    ?>
        <p class="about-description"><span class="dashicons dashicons-awards"></span> <?php 
    esc_html_e( 'Introducing our new Automation tool', 'all-in-one-video-gallery' );
    ?></p>

        <p>
            <?php 
    printf(
        '%s <a href="%s" target="_blank">%s</a>',
        esc_html__( "Your site on Autopilot. Simply configure your YouTube channel, playlist or a search keyword and schedule it. The plugin will do the rest by auto importing videos from your YouTube account. Each time a new video is uploaded there, it'll be automatically imported to your site within the hour.", 'all-in-one-video-gallery' ),
        'https://plugins360.com/all-in-one-video-gallery/automations/',
        esc_html__( 'Learn more', 'all-in-one-video-gallery' )
    );
    ?>            
        </p>
    <?php 
}

?>

    <?php 

if ( 'aiovg_support' == $active_tab ) {
    ?>
    	<p class="about-description"><?php 
    esc_html_e( 'Need Help?', 'all-in-one-video-gallery' );
    ?></p>
        
        <div class="changelog">    
            <div class="two-col">
                <div class="col">
                	<h3><?php 
    esc_html_e( 'Phenomenal Support', 'all-in-one-video-gallery' );
    ?></h3>
                    
                    <p>
                        <?php 
    printf( __( 'We do our best to provide the best support we can. If you encounter a problem or have a question, simply submit your question using our <a href="%s" target="_blank">support form</a>.', 'all-in-one-video-gallery' ), 'https://wordpress.org/support/plugin/all-in-one-video-gallery' );
    ?>
                    </p>
                </div>
                
                <div class="col">
                	<h3><?php 
    esc_html_e( 'Need Even Faster Support?', 'all-in-one-video-gallery' );
    ?></h3>
                    
                    <p>
                        <?php 
    printf( __( 'Our <a href="%s" target="_blank">Priority Support</a> system is there for customers that need faster and/or more in-depth assistance.', 'all-in-one-video-gallery' ), 'https://plugins360.com/support/' );
    ?>
                    </p>
                </div>                
          	</div>
      	</div>
    <?php 
}

?>
</div>