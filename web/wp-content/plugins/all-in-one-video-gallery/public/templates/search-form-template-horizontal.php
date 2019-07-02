<?php

/**
 * Search Form: Horizontal Layout.
 *
 * @link    https://plugins360.com
 * @since   1.0.0
 *
 * @package All_In_One_Video_Gallery
 */
?>

<div class="aiovg aiovg-search-form aiovg-search-form-template-horizontal">
	<form method="get" action="<?php echo esc_url( aiovg_get_search_page_url() ); ?>">
    	<?php if ( ! get_option('permalink_structure') ) : ?>
       		<input type="hidden" name="page_id" value="<?php echo esc_attr( $attributes['search_page_id'] ); ?>" />
    	<?php endif; ?>        
              
		<div class="aiovg-form-group aiovg-field-keyword">
			<input type="text" name="vi" class="aiovg-form-control" placeholder="<?php esc_attr_e( 'Search videos by title', 'all-in-one-video-gallery' ); ?>" value="<?php echo isset( $_GET['vi'] ) ? esc_attr( $_GET['vi'] ) : ''; ?>" />
		</div>
		
		<?php if ( $attributes['has_category'] ) : ?>  
			<div class="aiovg-form-group aiovg-field-category">
				<?php
				wp_dropdown_categories( array(
					'show_option_none'  => '-- ' . esc_html__( 'Select a Category', 'all-in-one-video-gallery' ) . ' --',
					'option_none_value' => '',
					'taxonomy'          => 'aiovg_categories',
					'name' 			    => 'ca',
					'class'             => 'aiovg-form-control',
					'orderby'           => 'name',
					'selected'          => isset( $_GET['ca'] ) ? (int) $_GET['ca'] : '',
					'hierarchical'      => true,
					'depth'             => 10,
					'show_count'        => false,
					'hide_empty'        => false,
				) );
				?>
			</div>
		<?php endif; ?>
		
		<div class="aiovg-form-group aiovg-field-submit">
			<input type="submit" class="aiovg-button" value="<?php esc_attr_e( 'Search', 'all-in-one-video-gallery' ); ?>" /> 
		</div>          
	</form> 
</div>
