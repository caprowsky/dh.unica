<?php

/**
 * Categories: Grid Layout.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<div class="aiovg aiovg-categories aiovg-categories-template-grid">
	<?php
    // Display the title (if applicable)
    if ( ! empty( $attributes['title'] ) ) : ?>
        <h3 class="aiovg-header"><?php echo esc_html( $attributes['title'] ); ?></h3>
    <?php 
    endif;
    
    // Start the loop                
    foreach ( $terms as $key => $term ) {       
        if ( $key % $attributes['columns'] == 0 ) echo '<div class="aiovg-row">';
        ?>            
        <div class="aiovg-col aiovg-col-<?php echo esc_attr( $attributes['columns'] ); ?>">		
            <?php the_aiovg_category_thumbnail( $term, $attributes ); ?>		
        </div>                        
        <?php if ( 0 == ( $key + 1 ) % $attributes['columns'] || ( $key + 1 ) == count( $terms ) ) echo '</div>';        
    }
    ?>
</div>